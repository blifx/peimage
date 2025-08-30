<?php
include("../config.php");

//se usuario nao usa o chrome ele sera encaminhado para o login
if(!preg_match('/(Chrome|CriOS)\//i',$_SERVER['HTTP_USER_AGENT'])
    && !preg_match('/(Aviator|ChromePlus|coc_|Dragon|Edge|Flock|Iron|Kinza|Maxthon|MxNitro|Nichrome|OPR|Perk|Rockmelt|Seznam|Sleipnir|Spark|UBrowser|Vivaldi|WebExplorer|YaBrowser)/i', $_SERVER['HTTP_USER_AGENT'])){
    require_once("actionLogout.php");
}

date_default_timezone_set('America/Sao_Paulo');

$path_absolute = $_SERVER['DOCUMENT_ROOT'];

require_once($__BASE_DIR.'/libs/peimageLib.php');
require_once($__BASE_DIR.'/libs/dataBaseClass.php');
require_once($__BASE_DIR.'/libs/wideimage/WideImage.php');
require_once($__BASE_DIR.'/libs/sizeCenters.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
    
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:../src/actionLogin.php');
}

$idcompanie = $_SESSION['id'];
$idusuarios = $_SESSION['user'];
$tipo = $_SESSION['tipo'];
$companie = $_SESSION['nome'];

$DataBase = new DataBase;
    $conn = $DataBase->connect();
    $sqlConsultCompanie = "SELECT nome FROM empresas 
    WHERE idempresas = '$idcompanie'";
    $queryCampanie = $DataBase->query($sqlConsultCompanie);
    $row=mysqli_fetch_array($queryCampanie);
    $companie = $row['nome'];


?>