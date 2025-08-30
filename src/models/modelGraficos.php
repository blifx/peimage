<?php
// Garanta que as sessões estão iniciadas (se ainda não estiverem)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclua sua classe DataBase aqui (se necessário)
// include('path/to/DataBase.php');

// --- Configuração Inicial e Tratamento de Input ---
error_reporting(E_ALL); // Recomenda-se para desenvolvimento
ini_set('display_errors', 0); // NÃO exiba erros em produção
ini_set('log_errors', 1); // Log erros em arquivo

header('Content-Type: application/json'); // Define o tipo de resposta

// Estabelece conexão com o banco de dados (usando sua classe)
$DataBase = new DataBase;
$conn = $DataBase->connect();

// Verifica erro de conexão
if ($conn->connect_error) {
    error_log("Database Connection Error: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno ao conectar ao banco de dados.']);
    exit;
}

// Obtém e sanitiza parâmetros de entrada
$origem = isset($_GET["origem"]) ? $_GET["origem"] : null;
$categoria = isset($_GET["categoria"]) && !empty($_GET["categoria"]) ? $_GET["categoria"] : null; // Ainda incluído, mas verifique se é usado
$campanha_param = isset($_GET["campanha"]) ? $_GET["campanha"] : null; // 'all', 'null', ou ID
$layout_param = isset($_GET["layout"]) ? $_GET["layout"] : null;     // 'all', 'other', ou ID
$periodo_param = isset($_GET["periodo"]) ? $_GET["periodo"] : null;    // '0' ou '1'
$data_ini = isset($_GET["ini"]) && !empty($_GET["ini"]) ? $_GET["ini"] : null;
$data_fim = isset($_GET["fim"]) && !empty($_GET["fim"]) ? $_GET["fim"] : null;
$id_empresa = isset($_SESSION["id"]) ? (int)$_SESSION["id"] : 0; // ID da empresa da sessão

// Validação básica de parâmetros essenciais
if ($origem === null || $id_empresa === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetros inválidos ou sessão expirada.']);
    $conn->close();
    exit;
}

// --- Construção da Query e Parâmetros ---
$sql = "";
$params = []; // Array para guardar os valores dos parâmetros
$types = "";  // String para guardar os tipos dos parâmetros (e.g., 'isssi')

// --- Lógica para Origem "0" (PEIMAGE) ---
if ($origem == "0") {

    // Base da query com UNION para incluir todos os usuários
    // **ATENÇÃO:** Verifique os joins e nomes de colunas (e.*, lc.*, l.*, c.*) conforme seu schema!
    // Assumindo que estatisticas (e) liga com layouts_campanha (lc) que liga com layouts (l) e campanhas (c)
    // Assumindo que estatisticas tem PK 'idestatisticas'
    $sql_base = '
        SELECT u.idusuarios, u.nome, COALESCE(SUM(t.total_stats), 0) AS total
        FROM usuarios u
        LEFT JOIN (
            SELECT
                e.fkusuarios,
                COUNT(DISTINCT e.idestatisticas) AS total_stats
            FROM estatisticas e
            LEFT JOIN layouts_campanha lc ON e.fklayouts_campanha = lc.idlayouts_campanha -- Join suspeito original, validar!
            LEFT JOIN layouts l ON lc.fklayouts = l.idlayouts
            LEFT JOIN temas tms ON e.fktemas = tms.idtemas -- Se houver ligação direta com temas
            LEFT JOIN campanhas c ON lc.fkcampanhas = c.idcampanhas
            WHERE 1=1 '; // Placeholder para adicionar condições AND

    $where_clauses = [];

    // Condição da empresa do usuário na subquery é redundante se já filtrado no join principal?
    // Aplicaremos no final para garantir

    // Condição de campanha
    if ($campanha_param !== null) {
        if ($campanha_param == "all") {
            $where_clauses[] = 'lc.fkcampanhas IS NOT NULL';
        } elseif ($campanha_param == "null") {
            $where_clauses[] = 'lc.fkcampanhas IS NULL';
             // Se campanha é NULL, layout não pode depender dela diretamente? Ajustar filtro de layout se necessário.
        } else { // ID específico
            $where_clauses[] = 'lc.fkcampanhas = ?';
            $params[] = $campanha_param;
            $types .= 'i'; // Assumindo que ID de campanha é inteiro
        }
    }

    // Condição de Layout/Material
    if ($layout_param !== null && $layout_param !== 'all' && $layout_param !== 'other') {
        // Filtra pelo ID do layout se um específico for selecionado
         // **VALIDAR:** Este filtro assume que a estatística está ligada ao layout via layouts_campanha
        $where_clauses[] = 'l.idlayouts = ?';
        $params[] = $layout_param;
        $types .= 'i'; // Assumindo que ID de layout é inteiro
    }
     // Adicionar lógica para layout='other' se aplicável para PEIMAGE?

    // Condição de Categoria (Ação) - Se ainda for relevante
    if ($categoria !== null) {
        $where_clauses[] = 'e.acao = ?'; // Validar nome da coluna 'acao'
        $params[] = $categoria;
        $types .= 's';
    }

    // Condição de Período
    if ($periodo_param == "1") { // Mês atual
        $where_clauses[] = 'e.dth_log >= DATE_FORMAT(NOW(), "%Y-%m-01 00:00:00")';
        $where_clauses[] = 'e.dth_log <= LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL 1 SECOND'; // Correção para incluir fim do dia
    } elseif ($periodo_param == "0") { // Período específico
        if ($data_ini !== null) {
            $where_clauses[] = 'e.dth_log >= ?';
            $params[] = $data_ini . " 00:00:00";
            $types .= 's';
        }
        if ($data_fim !== null) {
            $where_clauses[] = 'e.dth_log <= ?';
            $params[] = $data_fim . " 23:59:59";
            $types .= 's';
        }
    }

    // Finaliza a subquery
    $sql_sub = $sql_base;
    if (!empty($where_clauses)) {
        $sql_sub .= ' AND ' . implode(' AND ', $where_clauses);
    }
    $sql_sub .= ' GROUP BY e.fkusuarios ) t ON u.idusuarios = t.fkusuarios';

    // Condições da query principal (usuário)
    $sql_final_where = ' WHERE u.fkempresas = ? AND (u.tipo IS NULL OR u.tipo = "")';
    $params[] = $id_empresa; // Adiciona o ID da empresa para esta condição
    $types .= 'i';

    // Monta a query final
    $sql = $sql_sub . $sql_final_where . ' GROUP BY u.idusuarios, u.nome ORDER BY total DESC';


// --- Lógica para Origem != "0" (Agência/Equipe) ---
} else {

    // Query base para Agência (cálculo de percentual)
    $sql = '
        SELECT
            u.idusuarios,
            u.nome,
            COALESCE(ROUND((COUNT(DISTINCT estats.fkarquivos) / NULLIF(total_files.countArq, 0)) * 100), 0) AS total
        FROM usuarios u
        LEFT JOIN (
            -- Subquery para estatisticas filtradas por arquivos e período/campanha/layout
            SELECT DISTINCT e.fkusuarios, e.fkarquivos
            FROM estatisticas e
            INNER JOIN arquivos a ON e.fkarquivos = a.idarquivos -- Garante que o arquivo existe
            -- LEFT JOIN layouts l ON a.fklayouts = l.idlayouts -- Join para filtro de layout
            -- LEFT JOIN campanhas c ON a.fkcampanhas = c.idcampanhas -- Join para filtro de campanha (se necessário aqui)
            WHERE e.fkarquivos IS NOT NULL AND e.fktemas IS NULL -- Apenas estatísticas de ARQUIVOS
    ';

    $where_estatisticas = [];
    $params_estatisticas = [];
    $types_estatisticas = "";

    // Filtros dentro da subquery de estatísticas
    // Período
    if ($periodo_param == "1") {
        $where_estatisticas[] = 'e.dth_log >= DATE_FORMAT(NOW(), "%Y-%m-01 00:00:00")';
        $where_estatisticas[] = 'e.dth_log <= LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL 1 SECOND';
    } elseif ($periodo_param == "0") {
        if ($data_ini !== null) {
            $where_estatisticas[] = 'e.dth_log >= ?';
            $params_estatisticas[] = $data_ini . " 00:00:00";
            $types_estatisticas .= 's';
        }
        if ($data_fim !== null) {
            $where_estatisticas[] = 'e.dth_log <= ?';
            $params_estatisticas[] = $data_fim . " 23:59:59";
            $types_estatisticas .= 's';
        }
    }
    // Campanha (filtrando na tabela arquivos 'a' ou estatisticas 'e'?) - Assumindo filtro nos arquivos
    if ($campanha_param !== null && $campanha_param != 'all' && $campanha_param != 'null') {
         $where_estatisticas[] = 'a.fkcampanhas = ?'; // **VALIDAR** se fkcampanhas está em arquivos
         $params_estatisticas[] = $campanha_param;
         $types_estatisticas .= 'i';
    }
     // Layout (filtrando na tabela arquivos 'a')
    if ($layout_param !== null && $layout_param != 'all') {
        if($layout_param == "other"){
             $where_estatisticas[] = 'a.fklayouts IS NULL';
        } else {
             $where_estatisticas[] = 'a.fklayouts = ?';
             $params_estatisticas[] = $layout_param;
             $types_estatisticas .= 'i';
        }
    }

    // Adiciona cláusulas WHERE à subquery de estatísticas
    if (!empty($where_estatisticas)) {
        $sql .= ' AND ' . implode(' AND ', $where_estatisticas);
    }
    $sql .= ' ) estats ON u.idusuarios = estats.fkusuarios';

    // CROSS JOIN com subquery para contagem total de arquivos (denominador)
    $sql .= '
        CROSS JOIN (
            SELECT COUNT(a.idarquivos) AS countArq -- Corrigido DISTINCT COUNT(*)
            FROM arquivos a ';
            // -- INNER JOIN campanhas c ON a.fkcampanhas = c.idcampanhas -- Join necessário apenas se filtrar por campanha aqui
            // -- LEFT JOIN layouts l ON a.fklayouts = l.idlayouts -- Join necessário apenas se filtrar por layout aqui
    $sql .= ' WHERE a.fkempresas = ? '; // Filtro por empresa AQUI

    $where_arquivos = [];
    $params_arquivos = [$id_empresa]; // Primeiro parâmetro é o ID da empresa
    $types_arquivos = "i";

    // Filtros DENTRO da subquery de contagem total (devem espelhar os da outra subquery)
    // Campanha
    if ($campanha_param !== null && $campanha_param != 'all' && $campanha_param != 'null') {
         $where_arquivos[] = 'a.fkcampanhas = ?';
         $params_arquivos[] = $campanha_param;
         $types_arquivos .= 'i';
    }
    // Layout
    if ($layout_param !== null && $layout_param != 'all') {
        if($layout_param == "other"){
             $where_arquivos[] = 'a.fklayouts IS NULL';
        } else {
             $where_arquivos[] = 'a.fklayouts = ?';
             $params_arquivos[] = $layout_param;
             $types_arquivos .= 'i';
        }
    }

    // Adiciona cláusulas WHERE à subquery de contagem de arquivos
    if (!empty($where_arquivos)) {
        $sql .= ' AND ' . implode(' AND ', $where_arquivos);
    }
    $sql .= ' ) total_files';

    // Condições da query principal (usuário)
    $sql .= ' WHERE u.fkempresas = ? AND (u.tipo IS NULL OR u.tipo = "")';
    $params_final = [$id_empresa]; // ID da empresa para a condição principal de usuário
    $types_final = "i";

    // Agrupamento e Ordenação
    $sql .= ' GROUP BY u.idusuarios, u.nome, total_files.countArq ORDER BY total DESC';

    // Combina todos os parâmetros na ordem correta
    $params = array_merge($params_estatisticas, $params_arquivos, $params_final);
    $types = $types_estatisticas . $types_arquivos . $types_final;
}

// --- Execução da Query e Processamento dos Resultados ---
$und = [];
$tot = [];
$stmt = null;

if (!empty($sql)) {
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error . " SQL: " . $sql);
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno ao preparar a consulta.']);
        $conn->close();
        exit;
    }

    // Bind parameters se houver algum
    if (!empty($types) && !empty($params)) {
        if (!$stmt->bind_param($types, ...$params)) {
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno ao vincular parâmetros da consulta.']);
            $stmt->close();
            $conn->close();
            exit;
        }
    }

    // Executa a query
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno ao executar a consulta.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Obtém os resultados
    $result = $stmt->get_result();
    if ($result === false) {
         error_log("Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
         http_response_code(500);
         echo json_encode(['error' => 'Erro interno ao obter resultados.']);
    } else {
        // Processa os resultados
        while ($row = $result->fetch_assoc()) {
            $und[] = $row["nome"];
            $tot[] = is_numeric($row["total"]) ? $row["total"] : 0; // Garante que é numérico
        }
        $result->free(); // Libera memória do resultado
    }

    // Fecha o statement
    $stmt->close();

} else {
     error_log("SQL query string was empty for origem: " . $origem);
     http_response_code(400);
     echo json_encode(['error' => 'Não foi possível determinar a consulta para a origem fornecida.']);
}

// Fecha a conexão
$conn->close();

// Retorna os resultados em formato JSON
echo json_encode([$und, $tot]);
exit;

?>