<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    $dirLogo = '../companies/'.$companie.'/';
    $caminhoLogo = $dirCompanie.'logo.png';
    if(file_exists($dirLogo.'logo.png')){
        list($largura, $altura) = getimagesize($dirLogo.'logo.png');
    }

    $dirCompanieClear = 'companies/'.$companie.'/';
    $pathDownloads = $dirCompanieClear.'downloads/';
    $pathUploads = $dirCompanieClear.'uploads/';
    clearImages($pathDownloads, 'png', '-60');
    clearImages($pathDownloads, 'jpg', '-60');
    clearImages($pathUploads, 'jpg', '-60');
    clearImages($pathUploads, 'png', '-60');

    include('../config.php');
?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Layouts</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />

    </head>

    <body>
        <?php menu($logo, $imageMenu); ?>
        
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
        
        <div id="content" >
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post" action="actionAgencia.php" >
                <input type="submit" style="margin-top:5px;" name='button' value="Visualizar campanhas" />
                <input type="submit" style="margin-top:5px;" name='button' value="Criar campanha" />
                <input type="submit" style="margin-top:5px;" name='button' value="Alterar campanhas" />
                <input type="submit" style="margin-top:5px;" name='button' value="Adicionar arquivos" />
                <input type="submit" style="margin-top:5px;" name='button' value="Perfil agência" />
            </form>
        </div>
    </body>
</html>

<?php

?>