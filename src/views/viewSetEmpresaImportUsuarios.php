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
        
        <title>Peimage - Escolha Empresa</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
        </div>
        </header>
        <div id="content" >
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>

            <form id="waterform" method="post" action="actionImportUsuarios.php" enctype="multipart/form-data" >

            <label>Empresas</label><br>
            <select id="empresa" name="idempresa" required="required">
                <?php
                while($row=mysqli_fetch_array($queryEmpresas)){                     
                    echo '<option value="'.$row['idempresas'].'">'.ucwords($row['nome']).'</option>';
                }
                ?>
            </select><br/> 
                <input type="submit" value="Avançar" />
            </form>
        </div>
    </body>
</html>