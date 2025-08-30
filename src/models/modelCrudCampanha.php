<?php

$DataBase = new DataBase;
$conn = $DataBase->connect();

// define o tamanho do espaco do cliente pelo numero de usuarios
$sqlConsultUsuarios = "
    SELECT COUNT(idusuarios) AS n_usuarios
    FROM usuarios 
    WHERE fkempresas = $idcompanie
";
$queryUsuarios = $DataBase->query($sqlConsultUsuarios);
$row = mysqli_fetch_array($queryUsuarios);
$numUsuarios = $row['n_usuarios'];


$sqlConsultCampanhaSelect = "
        SELECT
            idcampanhas,
            nome,
            dt_inicio,
            dt_encerramento
        FROM campanhas 
        WHERE fkempresas = $idcompanie AND desativacao = 0
    ORDER BY dt_inicio DESC, idcampanhas DESC
";
$queryCampanhaSelect = $DataBase->query($sqlConsultCampanhaSelect);


$sqlConsultCampanha = "
    SELECT
        idcampanhas,
        nome,
        dt_inicio,
        dt_encerramento
    FROM campanhas 
    WHERE fkempresas = $idcompanie AND desativacao = 0
    ORDER BY dt_inicio DESC, idcampanhas DESC
";
$queryCampanhas = $DataBase->query($sqlConsultCampanha);
$numCampanhas = $queryCampanhas->num_rows;
$rowsCampanha = mysqli_fetch_array($queryCampanhas);


$sqlLayouts = "
    SELECT 
        idlayouts, 
        nome,
        largura,
        altura
    FROM layouts
    INNER JOIN layouts_empresa ON fklayouts = idlayouts 
    WHERE 
        (layouts_empresa.fkempresas = '$idcompanie' AND status_campanha = 1) 
        AND desativacao IS NOT TRUE
    ORDER BY idlayouts ASC
";
$queryLayouts = $DataBase->query($sqlLayouts);

?>
