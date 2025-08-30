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

        <title>Peimage - Campanhas</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
        </div>
        </header>
        <div id="content">
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post" action="actionAlterUsuario.php" enctype="multipart/form-data" >
                <?php echo '<input type="hidden" id="name" name="id" value="'.$id.'" required="required" /><br/>'; ?>
                <?php echo '<input type="hidden" id="name" name="emailOld" value="'.$email.'" required="required" /><br/>'; ?>
            <label>Nome</label>
                <?php echo '<input type="text" id="name" name="nome" value="'.$nome.'" required="required" /><br/>'; ?> 
                <label>E-mail</label>
                <?php echo '<input type="email" id="name" name="email" value="'.$email.'" required="required" /><br/>'; ?>  
                <label>Senha</label>
                <input type="password" placeholder="Digite sua nova senha" id="name" name="senha1" value="" required="required" /> 
                <input type="password" placeholder="Repita a senha" id="name" name="senha2" value="" required="required" /> 
                <input type="submit" name='button' value="Alterar Usuário" />
            </form>
        </div>
    </body>
</html>