<?php

$DataBase = new DataBase;
$conn = $DataBase->connect();

/* $idcompanie =  $_POST['idempresa'];     

$sqlConsultEmpresa = "SELECT idempresas, nome FROM empresas WHERE idempresas = $idcompanie";
$queryEmpresa = $DataBase->query($sqlConsultEmpresa);
$rowEmpresa=mysqli_fetch_array($queryEmpresa);
*/
if(!empty($_POST['nomeLayout'])){

    $nomeLayout = strtolower ($_POST['nomeLayout']);
    $largura_layout = strtolower ($_POST['largura_layout']);
    $altura_layout = strtolower ($_POST['altura_layout']);
    $nomeArquivoLayout = $_POST['nomeArquivoLayout'];
    $status_campanha = strtolower ($_POST['status_campanha']);

    $DataBase = new DataBase;
    $conn = $DataBase->connect();
    
    $sqlInsertLayout = "INSERT INTO layouts (nome, arquivo, altura, largura, status_campanha, desativacao) 
    VALUES ('$nomeLayout', '$nomeArquivoLayout', '$largura_layout', '$altura_layout', $status_campanha, '0')";
    $DataBase->query($sqlInsertLayout);

} 

?>
