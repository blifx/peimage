<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset','UTF-8');
include('../config.php');

$DataBase = new DataBase;
$conn = $DataBase->connect();

function isEmailValido($email){
    $conta = "/[a-zA-Z0-9\._-]+@";
    $domino = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$/";
    $pattern = $conta.$domino.$extensao;
 
    if (preg_match($pattern, $email))
        return true;
    else
        return false;
}

if(isset($_POST['email'])){
    $destinatario = $_POST['email'];

    if(!isEmailValido($destinatario)){
        header('location:actionEsqueciSenha.php?msg=Por favor, insira um e-mail válido.');
        exit(1);
    }

    $sqlConsultUsuarios = "SELECT email FROM usuarios WHERE email = '{$destinatario}' AND status_email = 1";
    $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
    $total = mysqli_num_rows($queryUsuarios); 

    if($total == 0){
        header('Location: actionEsqueciSenha.php?msg=E-mail não cadastrado. Insira um e-mail válido.');
        exit(1);
    }

    $sqlConsultUsuarios = "SELECT tentativa_rec_senha FROM usuarios WHERE email = '{$destinatario}'";
    $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
    $row=mysqli_fetch_array($queryUsuarios);
    $tentativa_rec_senha = $row['tentativa_rec_senha'];

    if($tentativa_rec_senha == 3){
        header('location:actionEsqueciSenha.php?msg=Você excedeu o número máximo de tentativas para redefinição de senha. Entre em contato com oadministrador do seu sistema.');
        exit(1);
    }

    $sqlConsultUsuarios = "SELECT nome FROM usuarios WHERE email = '$destinatario' ";
    $queryUsuarios = $DataBase->query($sqlConsultUsuarios);


    $row=mysqli_fetch_array($queryUsuarios);
    $nome = $row['nome'];

    $str = 'abcdef123456789';
    $senha = str_shuffle($str);

  

    $texto = "<p><a href=".$__HTTP_HOST."/src/actionLogin.php?loginOne=".$destinatario."&senhaOne=".$senha.">Clique aqui para redefinir sua senha.</a></p>
    <p>Caso prefira, você também pode colar o link abaixo no seu navegador para redefinir sua senha utilizando os seguintes dados de usuário e senha:</p>".$__HTTP_HOST."</p>
    <p>E-mail: ".$destinatario."<br/>Senha: $senha</p>";

    $sqlUpdateEmpresas = "UPDATE usuarios SET senha = '{$senha}', cod_validacao = 0, status_validacao = 0 WHERE email = '$destinatario'";
$envio = enviaEmail($nome, $destinatario, 'Link para redefinição de senha', $texto);
    //$data = array_map("utf8_encode", $data);
    if($DataBase->query($sqlUpdateEmpresas)){
        $envio = enviaEmail($nome, $destinatario, 'Link para redefinição de senha', $texto);
    }
    $sqlUpdateTentativas = "UPDATE usuarios SET tentativa_rec_senha = tentativa_rec_senha + 1 WHERE email = '$destinatario'";
    $DataBase->query($sqlUpdateTentativas);

    header('location:actionEsqueciSenha.php?msg=Verifique seu e-mail para concluir sua redefinição de senha.');   
    exit(1);
}



?>