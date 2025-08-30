<?php
    if(empty($_POST)){
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
        <div id="content" >
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
 
            <form id="waterform" method="post" action="actionCrudUsuario.php" enctype="multipart/form-data" >
            <?php
            if(isset($_GET['msg'])){
                echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
            }
            ?>
            <label for="Campanha">Usuários</label><br>
                <select id="social" name="idusuarios" required="required">
                    <?php 
                    while($row=mysqli_fetch_array($queryCampanhas)){
                        echo '<option value="'.$row['idusuarios'].'">'.ucwords($row['nome']).'</option>';
                    }
                    ?>
                </select><br/>
                <input type="submit" name='alterar' value="Alterar Usuário" />
                <input type="submit" name='excluir' value="Excluir Usuário" />
            </form>
        </div>
    </body>
</html>
<?php
}else
{

    require_once('viewAlterUsuario.php');
   
}
?>