<?php
$DataBase = new DataBase;
$conn = $DataBase->connect();

if(empty($_POST)){
    $sqlConsultUsuarios = "SELECT * FROM usuarios WHERE idusuarios = $idusuarios";
    $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
    $row=mysqli_fetch_array($queryUsuarios);
    $email = $row['email'];
    $statusEmail = $row['status_email'];
    $cod_validacao = $row['cod_validacao'];
}else{
    if(($_POST['email1'] == $_POST['email2']) && ($_POST['senha1'] == $_POST['senha2'])){
        $remetente = "tiagoduarte@peimage.com.br";
        $destinatario = $_POST['email1'];

        $sqlConsultUsuarios = "SELECT email FROM usuarios WHERE email = '{$destinatario}'";
        $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
        $total = mysqli_num_rows($queryUsuarios); 

        if($total>0){
            header('Location: actionPrimeiroAcesso.php?msg=Este e-mail já está cadastrado');
            exit(1);
        }

        $sqlConsultUsuarios = "SELECT * FROM usuarios WHERE idusuarios = $idusuarios";
        $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
        $row=mysqli_fetch_array($queryUsuarios);
        $nome = $row['nome'];

        $cod_validacao = rand ( 100000 , 999999 ); 
        $senha = $_POST['senha1'];  

        $sqlUpdateEmpresas = "UPDATE usuarios SET email = '{$destinatario}', senha = '{$senha}', status_email = 1, cod_validacao = $cod_validacao WHERE idusuarios = $idusuarios";
        if($DataBase->query($sqlUpdateEmpresas)){
            $envio = enviaEmail($nome, $destinatario, 'Validação de e-mail Peimage', '<p>O seu código de validação é '.$cod_validacao.'</p>', 'Olá '.$nome.'!');
        }  
        header('location:actionValidarEmail.php?email='.$destinatario);   
        exit(1);
        
        }else if(($_POST['email2'] == 'email') && ($_POST['senha1'] == $_POST['senha2'])){
            $destinatario = $_POST['email1'];
            $senha = $_POST['senha1'];  

            $sqlUpdateEmpresas = "UPDATE usuarios SET email = '{$destinatario}', senha = '{$senha}', status_email = 1, status_validacao = 1 WHERE idusuarios = $idusuarios";
            $DataBase->query($sqlUpdateEmpresas); 
            header('Location: ../index.php');
            exit(1);
        }else{
            header('Location: actionPrimeiroAcesso.php?msg=E-mails ou senhas não coincidem');
            exit(1);
        }

}

?>