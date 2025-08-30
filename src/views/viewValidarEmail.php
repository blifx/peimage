<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $typeThemes = 'cartaz';
    $dirCompanie = '../companies/'.$companie.'/';
    $caminhoLogo = $dirCompanie.'logo.png';
    if(file_exists($dirCompanie.'logo.png')){
        list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    }

    include('../config.php');

?>
    <!DOCTYPE html>
    <html lang="pt-br" >
        <head>
            <meta charset="UTF-8">
            <meta name="format-detection" content="telephone=no">
            <meta name="msapplication-tap-highlight" content="no">
            <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
            
            <title>Peimage - Verifição de E-mail</title>
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
            <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">

            <style>
                #box-suport-fb{
                    margin-top: 15px;
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
            </style>
        </head>
        <body>
            <header>
                <div id="logoCompany">
                <?php
                    if(file_exists($caminhoLogo)){ 
                        echo "<img src='{$caminhoLogo}' style='max-width:{$largura}px' />";
                    } else {
                        echo "<h1><a href='src/actionPerfil.php'>Clique aqui para adicionar seu logo</a></h1>";
                    }
                ?>
                </div>
            </header>
            <div id="content" style="padding-bottom: 72px !important;">
                <div class="fish" id="fish"></div>
                <div class="fish" id="fish2"></div>
                <div class="fish" id="fish3"></div>
                <div class="fish" id="fish4"></div>
                <form id="waterform" method="post" action="actionValidarEmail.php" enctype="multipart/form-data">
                    <?php
                    if(isset($_GET['msg'])){
                        echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
                    }
                    ?>
                    <div>
                        <div id="box-suport-fb" style="background-color:#E32F2F">
                            <label>Em breve sua conta será desativada. Por favor, valide seu e-mail</label>
                        </div>
                            <input type="number" placeholder="Digite o código recebido por e-mail" name="codigo" value='' maxlength="6"/> 
                            <input type="submit" name="validar" style="margin-top: 5px;" value="Validar" />
                            <input type="submit" name="continuar" style="margin-top: 5px;" value="Continuar depois" />
                            <br/>
                            <div style='text-align: center;'>
                                <a href="<?=$__HTTP_HOST;?>/src/actionValidarEmail.php?envia='cod'" style="text-decoration: none">Reenviar código</a>
                            </div>
                    <div id="box-suport-fb">
                        <label>Você está com problemas?</label> <br/>
                        <?php echo "<a href='$__HTTP_HOST/src/actionEmailMensagem.php'>Contatar suporte"?>
                    </div>
                </form>
            </div>
        </body>
    </html>
