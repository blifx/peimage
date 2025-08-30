<?php
    $DataBase = new DataBase();
    $conn = $DataBase->connect();

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    
    $email = $_SESSION['email'];
    $empresa = $_SESSION['id'];

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
                AND (
                    ((NOW() >= dt_inicio AND NOW() <= dt_encerramento)
                    AND temas.desativacao IS NOT TRUE
                    AND status_teste IS TRUE)
                    OR idarquivos IS NOT NULL
                )
        ) 
        ORDER BY dt_inicio DESC, idcampanhas DESC
    ";
    //die($sqlConsultCampanha);
    $queryCampanhas = $DataBase->query($sqlConsultCampanha);


    //json para layouts (select options)
    $layoutOptions = array();
    $sqlConsultaLayouts = "
        SELECT
            fkcampanhas,
            idlayouts,
            layouts.nome,
            arquivo,
            layouts_empresa.fkempresas
        FROM empresas
            LEFT JOIN layouts_empresa     ON fkempresas         = idempresas
            LEFT JOIN layouts             ON idlayouts          = layouts_empresa.fklayouts
            LEFT JOIN layouts_campanha lc ON lc.fklayouts       = idlayouts
            LEFT JOIN campanhas           ON idcampanhas        = fkcampanhas
            LEFT JOIN temas               ON fklayouts_campanha = idlayouts_campanha 
        WHERE 
            idempresas = '{$empresa}'
            AND ((
                temas.desativacao IS NOT TRUE 
                AND layouts.desativacao  IS NOT TRUE
                AND status_campanha = 1 
                AND status_teste IS TRUE 
				AND (NOW() >= dt_inicio AND NOW() <= dt_encerramento)
            )
			OR (
                fkcampanhas is null 
                AND status_campanha = 0
            ))
            GROUP BY idlayouts, fkcampanhas
            ORDER BY idlayouts DESC
    ";
    //die($sqlConsultaLayouts);


    $queryLayouts = $DataBase->query($sqlConsultaLayouts);
    while($row = mysqli_fetch_array($queryLayouts)){
        $layoutOptions[ $row["fkcampanhas"] ][ $row["idlayouts"] ] = array(
            "nome"    => $row["nome"],
            "arquivo" => $row["arquivo"],
            "fkempresa" => $row["fkempresas"]          
        );
    }
    
    $layoutOptions = json_encode($layoutOptions);

    //json para botao de ver galeria que possuam arquivos
    $sql = "
        SELECT DISTINCT fkcampanhas 
        FROM campanhas
        INNER JOIN arquivos ON fkcampanhas = idcampanhas
        WHERE 
            fkempresas = {$_SESSION["id"]}
            AND campanhas.desativacao IS NOT TRUE
    ";
    //die($sql);

    $query = $DataBase->query($sql);
    $whileResult = array();
    while($result = mysqli_fetch_assoc($query)){
        $whileResult[] = $result["fkcampanhas"];
    }
    $json = json_encode($whileResult);

?>