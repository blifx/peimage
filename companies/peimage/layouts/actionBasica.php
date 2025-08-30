<?php
date_default_timezone_set('America/Sao_Paulo');

require_once('../../../libs/peimageLib.php');
require_once('../../../libs/dataBaseClass.php');
require_once('../../../libs/wideimage/WideImage.php');
require_once('../../../libs/sizeCenters.php');



if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
    
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:../../../src/actionLogin.php');
}

$idcompanie = $_SESSION['id'];
$idusuarios = $_SESSION['user'];
$tipo = $_SESSION['tipo'];

$DataBase = new DataBase;
    $conn = $DataBase->connect();
    $sqlConsultCompanie = "SELECT nome FROM empresas 
    WHERE idempresas = '$idcompanie'";
    $queryCampanie = $DataBase->query($sqlConsultCompanie);
    $row=mysqli_fetch_array($queryCampanie);
    $companie = $row['nome'];


?>