<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset','UTF-8');
include('../config.php');

$DataBase = new DataBase;
$conn = $DataBase->connect();




if(!empty($_GET['envia'])){        
    $cod_validacao = rand ( 100000 , 999999 );   
 
    $sqlUpdateUsuario = "UPDATE usuarios SET cod_validacao = $cod_validacao WHERE idusuarios = $idusuarios";
    if($DataBase->query($sqlUpdateUsuario)){
        $sqlConsultUsuarios = "SELECT * FROM usuarios WHERE idusuarios = $idusuarios";
        $queryUsuarios = $DataBase->query($sqlConsultUsuarios);

            $row=mysqli_fetch_array($queryUsuarios);
            $email = $row['email'];
            $nome = $row['nome'];
            $envio = enviaEmail($nome, $email, 'Validação de e-mail Peimage', '<p>O seu código de validação é '.$cod_validacao.'</p>', 'Olá '.$nome.'!');
    }
    header('location:actionValidarEmail.php?msg=Verifique seu e-mail');
    exit(1);
}

if(isset($_POST['validar'])){
    $sqlConsultUsuarios = "SELECT cod_validacao FROM usuarios WHERE idusuarios = $idusuarios";
    $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
    $row=mysqli_fetch_array($queryUsuarios);
    $codigo = $row['cod_validacao'];

    if($codigo == $_POST['codigo']){
        $sqlUpdateUsuario = "UPDATE usuarios SET status_validacao = 1 WHERE idusuarios = $idusuarios";
        $DataBase->query($sqlUpdateUsuario);
        header('location:../index.php'); 
        exit(1);
    }else{
        header('Location: actionValidarEmail.php?msg=Código inválido');
        exit(1);
    }
}

if(isset($_POST['continuar'])){
    header('location:../index.php'); 
}

?>