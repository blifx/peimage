<?php


$DataBase = new DataBase;
    $conn = $DataBase->connect();

    $idempresa = $_POST['idempresa'];

    $sqlConsultEmpresa = "SELECT idempresas, nome FROM empresas WHERE idempresas = '$idempresa' ";
    $queryEmpresa = $DataBase->query($sqlConsultEmpresa);
    $row=mysqli_fetch_array($queryEmpresa);
    $empresa = $row['nome'];
    $idempresa = $row['idempresas'];

?>