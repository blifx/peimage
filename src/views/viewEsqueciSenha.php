<?php
$caminhoLogo = '../images/logo.png';
    list($largura, $altura) = getimagesize('../images/logo.png');

    include('../config.php');

?>
    <!DOCTYPE html>
    <html lang="pt-br" >
        <head>
            <meta charset="UTF-8">
            <meta name="format-detection" content="telephone=no">
            <meta name="msapplication-tap-highlight" content="no">
            <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
            
            <title>Peimage - Redefinição de senha</title>
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
            <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">

            <style>
                #box-suport-fb{
                    margin-top: 45px;
                    margin-bottom: 15px;
                    background: #77bde0;
                    padding: 10px 0 10px 0;
                    text-align: center;
                    border: 2px solid #98d5f4;
                }
                #box-suport-fb a{
                    font-size: 1.29em;
                    color: white;
                }
                #msg-callback{
                    border: solid 3px #98d4f3;
                    color:#FFF;
                    margin-top:10px;
                    background-color:#77bde0;
                    padding:15px;
                    text-align:center;
                    text-shadow: 1px 1px 2px #3c3c3c;
                }
            </style>
        </head>
        <body>
            <header>
                <a href="<?=$__HTTP_HOST?>" title="Voltar para tela inicial">
                    <div id="logoCompany">
                        <?php
                            echo "<img src='{$caminhoLogo}' style='max-width:{$largura}px' />";
                        ?>
                    </div>
                </a>
            </header>
            <div id="content"  autocomplete="off">
                <div class="fish" id="fish"></div>
                <div class="fish" id="fish2"></div>
                <div class="fish" id="fish3"></div>
                <div class="fish" id="fish4"></div>
                <form id="waterform" method="post" action="actionEsqueciSenha.php" enctype="multipart/form-data">
                <?php
                    if(isset($_GET['msg'])){
                        echo '<div id="msg-callback"> '.$_GET['msg'].'</div>';
                    }
                    ?>
                    <label>E-mail</label>
                    <input type="email" maxlength="50" name="email" required="required" placeholder="Digite seu e-mail cadastrado no Peimage"/><br/>
                    <input type="submit" value="Redefinir minha senha" />
                    <div id="box-suport-fb">
                        <label>Você ainda continua com problemas?</label> <br/>
                        <a href='<?=$__HTTP_HOST?>/src/views/viewContatoSuporte.php'>Utilize nosso suporte técnico</a>
                    </div>
                </form>
            </div>
        </body>
    </html>
