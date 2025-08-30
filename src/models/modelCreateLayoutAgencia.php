<?php
    $DataBase = new DataBase();
    $conn = $DataBase->connect();

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $email = $_SESSION['email'];
    $empresa = $_SESSION['id'];
    $empresaNome = $_SESSION['nome'];

    //select option campanha de marketing
    //tras todas campanhas que possuam ao menos um layout
    $sqlConsultCampanha = "
        SELECT idcampanhas, nome 
        FROM campanhas 
        WHERE idcampanhas IN(
            SELECT idcampanhas
                FROM campanhas 
                LEFT JOIN layouts_campanha lc ON lc.fkcampanhas     = idcampanhas
                LEFT JOIN temas               ON fklayouts_campanha = idlayouts_campanha
                LEFT JOIN arquivos ar         ON ar.fkcampanhas     = idcampanhas
            WHERE 
                fkempresas = '{$empresa}'
                AND (NOW() >= dt_inicio AND NOW() <= dt_encerramento) 
                AND (
                    idarquivos IS NOT NULL
                    OR temas.desativacao IS NOT TRUE AND idtemas IS NOT NULL
                )
        ) 
        ORDER BY dt_inicio DESC, idcampanhas DESC
    ";
    //die($sqlConsultCampanha);
    
    $queryCampanhas = $DataBase->query($sqlConsultCampanha);
    $layoutOptions = array(); //json para layouts (select options)
    $sqlConsultaLayouts = "
        SELECT
            fkcampanhas,
            idlayouts,
            status_teste,
            CASE 
                WHEN status_teste IS TRUE THEN
                    CONCAT('&#10004; ', layouts.nome)
                ELSE
                    CONCAT('&#10006; ', layouts.nome)
            END AS nome,
            arquivo,
            layouts_empresa.fkempresas
        FROM empresas
            LEFT JOIN layouts_empresa     ON fkempresas           = idempresas
            LEFT JOIN layouts             ON idlayouts            = layouts_empresa.fklayouts
            LEFT JOIN layouts_campanha lc ON lc.fklayouts         = idlayouts
            LEFT JOIN campanhas           ON idcampanhas          = fkcampanhas
            LEFT JOIN temas               ON fklayouts_campanha   = idlayouts_campanha 
        WHERE
            idempresas = '{$empresa}'
            AND temas.desativacao IS NOT TRUE
            AND layouts.desativacao IS NOT TRUE
            AND fkcampanhas IS NOT NULL 
            AND status_campanha = 1 
            AND (NOW() >= dt_inicio AND NOW() <= dt_encerramento)
        ORDER BY status_teste DESC, idlayouts DESC
    ";
    //die($sqlConsultaLayouts);

    $queryLayouts = $DataBase->query($sqlConsultaLayouts);
    while($row = mysqli_fetch_array($queryLayouts)){
        $layoutOptions[ $row["fkcampanhas"] ][ $row["idlayouts"] ] = array(
            "nome"      => $row["nome"],
            "arquivo"   => $row["arquivo"],
            "fkempresa" => $row["fkempresas"],
            "testado"   => $row["status_teste"]
        );
    }
    $layoutOptions = json_encode($layoutOptions);



    //json para botao de ver galeria que possuam arquivos
    $sql = "
        SELECT DISTINCT fkcampanhas
        FROM campanhas
        INNER JOIN arquivos ON fkcampanhas = idcampanhas
        WHERE fkempresas = {$_SESSION["id"]}
    ";
    $query = $DataBase->query($sql);
    $whileResult = array();
    while($result = mysqli_fetch_assoc($query)){
        $whileResult[] = $result["fkcampanhas"];
    }
    $json = json_encode($whileResult);

?>