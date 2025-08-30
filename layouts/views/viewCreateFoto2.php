<?php
$layout = $_GET['layout'];
$logo = '../images/logoPeimage.png';
$imageMenu = '../images/menu.png';
$dirCompanie = '../companies/'.$companie.'/';
list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
include('../config.php'); 
?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
            
        <title>Peimage - Foto</title>
        <link rel="stylesheet" href="../../../css/style.css">
        <link rel="icon" href="../../../images/favicon.png" />
        <link rel="stylesheet" href="../../../css/menu.css">
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
            <form id="waterform" method="post" action="actionCreateFoto2.php" enctype="multipart/form-data" target="_blank">
                <label id="teste">Título*</label>
                <input type="text" id="name" maxlength="22" name="titulo" required="required" /><br/>
                <label>Foto</label>
                <input id="produto" type="file" name="fileUpload" accept="image/png, .jpg, .jpeg" required="required"/>
                <label for="message">Girar Foto</label><br/>
                    <select id="rotacao" name="rotacao" required="required">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                    </select><br/> 
                <label for="message">Descrição*</label>
                <textarea step="any" id="message" maxlength="28" name="desc" required="required"></textarea>
                <label>Preço*</label>
                <input type="text" id="name" name="preco" placeholder="ex: 99,90" required="required" value="" />
                <label>Promoção*</label>
                <input type="text" placeholder="ex: 99,90" id="name" name="promo" value="" /> 
                <label>Observação</label>
                <input type="text" id="name" name="obs" value="" />
                <input type="hidden" name="layout" value=<?php echo "'$layout'"; ?> />
                <input type="submit" value="Visualizar" />
                <br/><div style='text-align: center; '>
                <a href="<?=$__HTTP_HOST;?>/src/actionEmailMensagem.php" target="_blank">Sugestões, reclamações ou dúvidas?</a>
        </div>
    </body>
</html>
