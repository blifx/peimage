<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    $dirLogo = '../companies/'.$companie.'/';
    list($largura, $altura) = getimagesize($dirLogo.'logo.png');
    include('../config.php');
?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
        
        <title>Peimage - Usuário</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
            <div id="logoCompany">
                <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
            </div>
        </header>
        <div id="content"  >
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post" action="actionCreateUsuario.php" enctype="multipart/form-data" >
            <?php
            if(isset($_GET['msg'])){
                echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
            }
            ?>
                <label>Nome</label>
                <input type="text" name="nome" value="" placeholder="Digite o nome da unidade/fraqueado" required="required" /><br/> 
                <label>E-mail</label>
                <input type="email" name="email" value="" placeholder="Digite um e-mail para o usuário" required="required" /><br/>
                <label>Enviar Acesso</label>
                <select name="envio_email" required="required">
                    <option value='sim'>Sim</option>
                    <option value='nao'>Não</option>
                </select><br/> 
                <input type="submit" value="Cadastrar" />
            </form>
        </div>
    </body>
</html>