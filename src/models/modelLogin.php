
<?php 

if(!empty($_POST)){ 

    // as variáveis login e senha recebem os dados digitados na página anterior
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $DataBase = new DataBase();
    $conn = $DataBase->connect();

    $sqlConsultLoginUser = "SELECT * FROM usuarios WHERE email = '$login' AND senha = '$senha'";
    $queryLoginUser = $DataBase->query($sqlConsultLoginUser);
    $user=mysqli_fetch_array($queryLoginUser);
    
    if(mysqli_num_rows ($queryLoginUser) > 0 ){
        $sqlConsultLoginEmpresa = "SELECT nome FROM empresas WHERE idempresas = '{$user['fkempresas']}'";
        $queryLoginEmpresa = $DataBase->query($sqlConsultLoginEmpresa);
        $company=mysqli_fetch_array($queryLoginEmpresa);

        $_SESSION['id']                 = $user['fkempresas']; 
        $_SESSION['user']               = $user['idusuarios']; 
        $_SESSION['usuario']            = $user['nome']; 
        $_SESSION['nome']               = $company['nome'];  
        $_SESSION['email']              = $login;
        $_SESSION['senha']              = $senha;
        $_SESSION['tipo']               = $user['tipo'];

        $_SESSION['fb_uid_usuario']     = $user['fb_uid_usuario'];
        $_SESSION['fb_token_extendido'] = $user['fb_token_extendido'];
        $_SESSION['fb_id_album']        = $user['fb_id_album'];
        $_SESSION['fb_nome_album']      = $user['fb_nome_album'];
        $_SESSION['fb_id_pagina']       = $user['fb_id_pagina'];
        $_SESSION['fb_nome_pagina']     = $user['fb_nome_pagina'];

        
        // if($user['status_email'] == 0 && $user['status_validacao'] == 0){
        //     header('location:actionPrimeiroAcesso.php');
        //     exit(1);
        // }else if($user['status_email'] == 1 && $user['status_validacao'] == 0 && $user['cod_validacao'] == 0){
        //     header('location:actionPrimeiroAcesso.php');
        //     exit(1);
        // }else if($user['status_email'] == 1 && $user['status_validacao'] == 0 && $user['cod_validacao'] != ''){
        //     header('location:actionValidarEmail.php');
        //     exit(1);
        // }
        header('location:../index.php');
        // exit(1);
    } else {
        unset ($_SESSION['email']);
        unset ($_SESSION['senha']);
        header('location:actionLogin.php?invalid=true');
    }

  }
?>