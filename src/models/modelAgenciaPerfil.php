<?php

$DataBase = new DataBase;
$conn = $DataBase->connect();

$sqlUsuarios= "SELECT * From usuarios WHERE fkempresas =  $idcompanie AND tipo = 'agencia' ";
$queryUsuarios = $DataBase->query($sqlUsuarios);
$row_usuario=mysqli_fetch_array($queryUsuarios);
$email = $row_usuario['email'];

if(!empty($_POST)){  
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];

    $erros = '';
    $senhaStatus = 0;
    $senhaStatus = 0;

    if( ($senha1 == $senha2 && !empty($senha1)) ){
        $senhaStatus = 1;
    }else{
        $erros = '*Os campos de senhas não coincidem </br>';
    }

    if( ($email1 == $email2 && !empty($email1)) ){
        $emailStatus = 1;  
    }else{
        $erros = $erros.'*Os campos de e-mails não coincidem </br>';
    }


    if(mysqli_num_rows ($queryUsuarios) > 0 ){
        $sqlUsuarios= "SELECT * From usuarios WHERE fkempresas =  $idcompanie AND tipo = 'agencia' ";
        if($senhaStatus == 1 &&  $emailStatus == 1){
            $sqlUpdateSenha = "UPDATE usuarios SET  senha = '{$senha1}', email = '{$email1}', status_validacao = 1, status_email = 1 WHERE fkempresas = $idcompanie AND tipo = 'agencia' ";
            $DataBase->query($sqlUpdateSenha);
        }
    }else{
        if($senhaStatus == 1 &&  $emailStatus == 1){
            $sqlInsert = "INSERT INTO usuarios (idusuarios, fkempresas, nome, email, senha, tipo, status_validacao, status_email) VALUES (NULL, '3', 'Agencia', '{$email1}', '{$senha1}', 'agencia', 1, 1)";
            $DataBase->query($sqlInsert);
        }
    }

    if($erros != '' ){
        header('Location: actionAgenciaPerfil.php?msg='.$erros);
        exit(1);
    }
    

    header('Location: actionAgenciaPerfil.php');
       
}


?>