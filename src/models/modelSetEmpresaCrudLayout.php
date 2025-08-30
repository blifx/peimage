<?php
    $DataBase = new DataBase;
    $conn = $DataBase->connect();

    $sqlConsultEmpresas = "SELECT idempresas, nome FROM empresas";
    $queryEmpresas = $DataBase->query($sqlConsultEmpresas);

    header('Location: actionCrudLayout.php');


?>