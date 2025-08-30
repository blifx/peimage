<?php
include('../config.php');

if(!empty($_POST)){    
        $DataBase = new DataBase;
        $conn = $DataBase->connect();
        $nome = acentoUpload($_POST['nome']);
        $email = $_POST['email'];

        $sqlUsuarioName= "SELECT email From usuarios WHERE email =  '$email'";
        $queryUsuarios = $DataBase->query($sqlUsuarioName);
        $total = mysqli_num_rows($queryUsuarios); 

        if($total>0){
            header('Location: actionCreateUsuario.php?msg=Este e-mail já está cadastrado');
            exit(1);
        }
        $str = 'abcdef123456789';
        $senha = str_shuffle($str);
        $sqlInsertEmpresas = "INSERT INTO usuarios (fkempresas, tipo, nome, email, senha, status_email, cod_validacao, status_validacao) VALUES ('{$idcompanie}', '', '{$nome}', '{$email}', '{$senha}', 1, 0, 0)";
        if($DataBase->query($sqlInsertEmpresas)){
            if($_POST['envio_email'] == 'sim'){
                $texto = "<p><a href=".$__HTTP_HOST."/src/actionLogin.php?loginOne=".$email."&senhaOne=".$senha.">Clique aqui para realizar o seu primeiro acesso.</a></p>
                <p>Caso prefira, você também pode colar o link abaixo no seu navegador para realizar o primeiro acesso utilizando os seguintes dados de usuário e senha:</p>".$__HTTP_HOST."</p>
                <p>E-mail: ".$email."<br/>Senha: $senha</p>";
                $envio = enviaEmail($nome, $email, 'Link para primeiro acesso Peimage',$texto);
            }
        }
}
?>
