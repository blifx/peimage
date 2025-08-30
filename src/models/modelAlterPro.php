<?php

if(!empty($_POST)){
$idcampanha = $_POST['idcampanha'];
$nome = $_POST['nome'];

$DataBase = new DataBase;
$conn = $DataBase->connect();

        $sqlUpdateUsuarios = "UPDATE campanhas SET  nome = '{$nome}' WHERE idcampanhas = '{$idcampanha}'";
        $DataBase->query($sqlUpdateUsuarios);
        
        header('Location: actionCrudCampanha.php');

}
?>