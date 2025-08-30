<?php
require_once("libs/dataBaseClass.php");

$DataBase = new DataBase;
$conn = $DataBase->connect();

$sqlConsultConfigs = "
        SELECT
            base_url,
            base_dir
        FROM configs 
";
$queryConfigs = $DataBase->query($sqlConsultConfigs);
$row = mysqli_fetch_array($queryConfigs);

$__HTTP_HOST = $row['base_url'];
$__BASE_DIR = $row['base_dir'];
?>