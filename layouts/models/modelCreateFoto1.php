<?php
$DataBase = new DataBase;
$conn = $DataBase->connect();


if(!empty($_POST['layout'])){
    $layout = $_POST['layout'];
    $fkusuario = $idusuarios;
        //Insere a campanha no banco de dados
/*         $sqlInsertEmpresas = "INSERT INTO estatisticas (tipo, fkusuarios, dataLog) VALUES ('$layout', $fkusuario, CURRENT_TIMESTAMP)";
        $DataBase->query($sqlInsertEmpresas); */
}

?>