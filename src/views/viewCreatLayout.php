<?php
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
        
        <title>Peimage - Campanhas</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css?v=1">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css?v=1">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <?php
            if(isset($_GET['msg'])){
                echo '<div style="color:#006064;margin-top:10px;margin-left:10px;background-color:#98d4f3; width:270px;padding:5px;text-align:center;";
                >* Campanha não pode ser inserida </br>'.$_GET['msg'].'</div>';
            }
        ?>
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

            <form id="waterform" method="post" action="actionCreatLayout.php" enctype="multipart/form-data" >                
                <label >Nome Layout*</label>
                <input type="text" id="name" name="nomeLayout" required="required" maxlength="50"/><br/>
                <label>Largura(px)*</label>
                <input type="text" maxlength="4" name="largura_layout" value="" />
                <label>Altura(px)*</label>
                <input type="text"  id="name" maxlength="4" name="altura_layout" value="" />
                <label for="Estilo">Participa de campanhas</label><br>
                <select id="social" name="status_campanha" required="required">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select><br/>
                <label >Nome arquivo*</label>
                <input type="text" id="name" name="nomeArquivoLayout" required="required" maxlength="50"/><br/>
                <input type="submit" value="Enviar" />
            </form>
        </div>
    </body>
</html>