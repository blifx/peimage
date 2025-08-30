<?php
$DataBase = new DataBase;
$conn = $DataBase->connect();


if(!empty($_POST['layout'])){
    $layout = $_POST['layout'];
    $fkusuario = $idusuarios;

    //Insere a campanha no banco de dados
/*     $sqlInsertEmpresas = "INSERT INTO estatisticas (tipo, fkusuarios, dataLog) VALUES ('$layout', $fkusuario, CURRENT_TIMESTAMP)";
    $DataBase->query($sqlInsertEmpresas); */
    

    $sqlConsultEmpresas = "SELECT cor FROM empresas WHERE idempresas = $idcompanie ";
    $queryEmpresas = $DataBase->query($sqlConsultEmpresas);
    $row=mysqli_fetch_array($queryEmpresas);
    $colorEmpresa = $row['cor']; 
    $colorEmpresa= hexrgb($colorEmpresa);//cor da empresa

    $layout = $_POST['layout'];
    $idlayout = $_POST['idlayout'];
    $fkusuario = $idusuarios;

}

?>