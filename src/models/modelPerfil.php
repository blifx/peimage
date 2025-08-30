<?php

$DataBase = new DataBase;
$conn = $DataBase->connect();

$sqlUsuarios= "SELECT * From usuarios WHERE fkempresas =  $idcompanie ";
$queryUsuarios = $DataBase->query($sqlUsuarios);
$row_usuario=mysqli_fetch_array($queryUsuarios);
$email = $row_usuario['email'];
$senha = $row_usuario['senha'];

$sqlEmpresas= "SELECT * From empresas WHERE idempresas =  $idcompanie ";
$queryEmpresas = $DataBase->query($sqlEmpresas);
$row_empresas=mysqli_fetch_array($queryEmpresas);
$empresa = $row_empresas['nome'];
$cnpj = $row_empresas['cnpj'];
$cor1 = $row_empresas['cor'];
$cor_texto1 = $row_empresas['cor_texto'];

if(!empty($_POST)){
    
    $sqlEmail= "SELECT * From usuarios WHERE email =  '$email1'";
    $queryEmail = $DataBase->query($sqlEmail);
    $total = mysqli_num_rows($queryEmail); 
    
    if($total>0){
        header('Location: actionPerfil.php?msg=Este e-mail já está cadastrado');
        exit(1);
    }

    if( ($senha1 == $senha2 && !empty($senha1)) )
    {
        $sqlUpdateSenha = "UPDATE usuarios SET  senha = '{$senha1}' WHERE idusuarios = $idusuarios";
        $DataBase->query($sqlUpdateSenha);
    }

    if( ($email1 == $email2 && !empty($email1)) )
    {
        $sqlUpdateEmail = "UPDATE usuarios SET  email = '{$email1}', senha = '{$senha1}' WHERE idusuarios = $idusuarios";
        $DataBase->query($sqlUpdateEmail);
    }    
        //Insere a campanha no banco de dados
        $sqlCor = "UPDATE empresas SET  cor = '$cor' WHERE idempresas = $idcompanie";
        $sqlTexto = "UPDATE empresas SET  cor_texto = '$cor_texto' WHERE idempresas = $idcompanie";
        $DataBase->query($sqlCor);
        $DataBase->query($sqlTexto);
        header('Location: actionPerfil.php');   
}


?>