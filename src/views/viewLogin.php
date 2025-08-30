<?php

//$__EM_MANUTENCAO = true;

$logo = '../images/logoPeimage.png';
$imageMenu = '../images/menu.png';
$dirCompanie = '../images/';
list($largura, $altura) = getimagesize($dirCompanie.'logo.png');

if (!empty($_GET['login'])) {
    $log = 'teste@peimage.com.br'; 
    $sen = '12345';
} else if (!empty($_GET['loginOne'])) {
    $log = $_GET['loginOne']; 
    $sen = $_GET['senhaOne'];
}

include('../config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
    <title>Peimage - Login</title>
    <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css?v=2">
    <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css?v=1">
    <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
    <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
    <style>
        #group-link {
            text-align: center;
            color: #006064;
        }
        .link {
            text-decoration:none;
        }
        .link:hover {
            text-decoration: underline;
        }
        .box-suport-fb {
            margin-top: 15px;
            margin-bottom: 15px;
            background: #77bde0;
            padding: 10px;
            text-align: center;
            border: 2px solid #98d5f4;
            font-size:15px;
            text-shadow: 1px 1px 3px #3c3c3c;
        }
        .box-suport-fb a {
            font-size: 22px;
            color: white;
        }
        #msg-invalid-login {
            margin-top: 7px;
            padding-left: 4px;
            color: #ffffff;
            text-shadow: 1px 1px 2px #3c3c3c;
            text-align: center;
        }
        #box-suport-fb {
            margin-top: 13px;
            background: #77bde0;
            padding: 10px 0 10px 0;
            text-align: center;
            border: 2px solid #98d5f4;
            text-align: justify;
            padding: 0px 12px 8px 12px;
            line-height: 1.4;
        }
    </style>
    <script>
        $(document).ready(function(){
            $("#primeiro_acesso").trigger("click");
        });
    </script>
</head>
<body>
    <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:90%" />
        </div>
    </header>
    <div id="content">
        <div class="fish" id="fish"></div>
        <div class="fish" id="fish2"></div>
        <div class="fish" id="fish3"></div>
        <div class="fish" id="fish4"></div>
        <form id="waterform" method="post" action="actionLogin.php" enctype="multipart/form-data">
            <?php
            /*
            if ($__EM_MANUTENCAO) {
                echo '
                <div class="box-suport-fb" style="text-align: justify; margin-top:100px">
                    Estamos em manutenção, mas não se preocupe. Daqui a pouco estamos de volta.
                </div>
                ';
            } else {
            */
                if (preg_match('/(Chrome|CriOS)\//i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/(Aviator|ChromePlus|coc_|Dragon|Edge|Flock|Iron|Kinza|Maxthon|MxNitro|Nichrome|OPR|Perk|Rockmelt|Seznam|Sleipnir|Spark|UBrowser|Vivaldi|WebExplorer|YaBrowser)/i', $_SERVER['HTTP_USER_AGENT'])) {
                    if (!empty($_GET['login']) != !empty($_GET['loginOne'])) {
                        echo " <label for='name'>E-mail</label>";
                        echo " <input type='email'  name='login' value='$log' required='required' placeholder='Digite seu e-mail' autocomplete='username' readonly />";
                        echo " <label for='name'>Senha</label>";
                        echo " <input type='password' name='senha' value='$sen'  required='required' placeholder='Digite sua senha' autocomplete='current-password' readonly />";
                        if (isset($_GET["invalid"])) {
                            echo "<div id='box-suport-fb'>";
                            echo "<div id='msg-invalid-login'>Usuário ou senha inválidos</div>";
                            echo "</div>";
                        }
                        echo " <input id='primeiro_acesso' type='submit' value='Entrar' />";
                    } else {
                        echo " <label for='name'>E-mail</label>";
                        echo " <input type='email' name='login' value='' required='required' placeholder='Digite seu e-mail' autocomplete='username'/>";
                        echo " <label for='name'>Senha</label>";
                        echo " <input type='password' name='senha' value=''  required='required' placeholder='Digite sua senha' autocomplete='current-password'/>";
                        if (isset($_GET["invalid"])) {
                            echo "<div id='box-suport-fb'>";
                            echo "<div id='msg-invalid-login'>Usuário ou senha inválidos, tente novamente.</div>";
                            echo "</div>";
                        }
                        echo " <input type='submit' value='Entrar' />";
                        echo '<div id="group-link"><br>
                        <a class="link" href="'.$__HTTP_HOST.'/src/views/viewContatoSuporte.php">Esqueci minha senha</a>
                        |
                        <a class="link" href="'.$__HTTP_HOST.'/src/views/viewContatoSuporte.php">Suporte técnico</a>
                        </div>';
                        //<a class="link" href="'.$__HTTP_HOST.'/src/actionEsqueciSenha.php">Esqueci minha senha</a>
                    }
                } else {
                    echo '
                    <div class="box-suport-fb" style="text-align: justify;">
                        Para utilizar o Peimage você precisa ter instalado o navegador Google Chrome em seu computador ou celular. Se você ainda não instalou acesse o link abaixo.
                    </div>
                    <div class="box-suport-fb" style="background: #006064;">
                        <a href="https://www.google.com/intl/pt-BR/chrome/">Baixar Google Chrome</a>
                    </div>
                    ';
                }
            //}
            ?>
        </form>
    </div>
</body>
</html>
