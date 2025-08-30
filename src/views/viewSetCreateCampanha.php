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

            <form id="waterform" method="post" action="actionCreateCampanha.php" enctype="multipart/form-data" >
                <?php
                    if(isset($_GET['msg'])){
                        echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
                    }
                ?>
                <label>Nome da campanha*</label>
                <input type="text" name="campanha" required="required" placeholder="Digite o nome da campanha" maxlength="50"/><br/>
                <label>Data de início*</label>
                <input id="date1" name="inicio" required="required" type="date">
                <label>Data de encerramento*</label>
                <input id="date2" name="encerramento" required="required" type="date">
                <input type="submit" value="Avançar" />
            </form>
        </div>

        <script>
            $("#waterform").submit((evt)=>{
                var dt1 = new Date($("#date1").val() + " 00:00");
                var dt2 = new Date();
                dt2.setHours(0,0,0,0);
                if(dt1 >= dt2.setTime(dt2.getTime()+86400000)){
                    alert("Você não pode cadastrar uma campanha para iniciar com uma data futura :(");
                    evt.preventDefault();
                    return false;
                }
            });
        </script>

    </body>
</html>