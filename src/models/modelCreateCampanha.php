<?php
include('../config.php');

$DataBase = new DataBase;
$conn = $DataBase->connect();

$sqlConsultCampanha = "
        SELECT idcampanhas, nome
        FROM campanhas
        WHERE fkempresas = $idcompanie
        ORDER BY dt_inicio DESC, idcampanhas DESC
";

$queryCampanhas = $DataBase->query($sqlConsultCampanha);
$numCampanhas = mysqli_num_rows($queryCampanhas);


$sqlConsultUsuarios = "SELECT COUNT(idusuarios) AS n_usuarios FROM usuarios WHERE fkempresas = $idcompanie";
$queryUsuarios = $DataBase->query($sqlConsultUsuarios);
$row=mysqli_fetch_array($queryUsuarios);
$numUsuarios = $row['n_usuarios'];


$sqlLayouts = "SELECT idlayouts,
                nome,
                largura,
                altura
                FROM layouts 
                INNER JOIN layouts_empresa ON fklayouts = idlayouts
                WHERE (layouts_empresa.fkempresas = $idcompanie)
                        AND status_campanha = 1
                        AND desativacao IS NOT TRUE
                GROUP BY idlayouts";
$queryLayouts = $DataBase->query($sqlLayouts);

$campanha = strtolower(trim(acentoUpload($_POST['campanha'])));
$dt_inicio = $_POST['inicio']; 
$dt_encerramento = $_POST['encerramento'];


$sqlConsultCampanha = "
        SELECT COUNT(idcampanhas) AS n_campanhas
        FROM campanhas
        WHERE
        nome = '$campanha'
        AND fkempresas = $idcompanie
        AND desativacao IS NOT TRUE 
        AND (NOW() >= dt_inicio AND NOW() <= dt_encerramento)
";

//die($sqlConsultCampanha);

$queryCampanha = $DataBase->query($sqlConsultCampanha);
$rowConsultCampanha=mysqli_fetch_array($queryCampanha);
$numCampanhas = $rowConsultCampanha['n_campanhas'];

if($dt_inicio >= $dt_encerramento){
        header('Location: '.$__HTTP_HOST.'/src/actionSetCreateCampanha.php?msg=As datas de início e encerramento </br>da campanha estão incorretas.');
        exit(1);
}


if($numCampanhas == 0){
        $sqlInsertCampanha = "INSERT INTO campanhas (fkempresas, nome, dt_inicio, dt_encerramento, desativacao ) 
        VALUES ($idcompanie, '{$campanha}', '$dt_inicio', '$dt_encerramento', '0')";
        //die($sqlInsertCampanha);
        $queryCampanha = $DataBase->query($sqlInsertCampanha);
        $idcampanha = $conn->insert_id;
}else{
        header('Location: '.$__HTTP_HOST.'/src/actionSetCreateCampanha.php?msg=Nome de campanha já existente.');
        exit(1);
}






?>