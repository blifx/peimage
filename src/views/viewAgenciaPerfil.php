<?php
$logo = '../images/logoPeimage.png';
$imageMenu = '../images/menu.png';
$dirCompanie = '../companies/'.$companie.'/';
$dirLogo = '../companies/'.$companie.'/';
$caminhoLogo = $dirCompanie.'logo.png';
if(file_exists($dirLogo.'logo.png')){
list($largura, $altura) = getimagesize($dirLogo.'logo.png');
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

        <title>Peimage - Layouts</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/dropzone.css" />
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/dropzone.js"></script>
    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
            <div id="logoCompany">
            <?php
                if(file_exists($dirLogo.'logo.png')){ 
                    echo "<img src='{$dirCompanie}logo.png' style='max-width:{$largura}px' />";
                } else {
                    echo "<h1><a href='src/actionPerfil.php'>Clique aqui para adicionar seu logo</a></h1>";
                }
            ?>
            </div>
        </header>
        <div id="content" >
            <form id="waterform" method="post" action="actionAgenciaPerfil.php" enctype="multipart/form-data" autocomplete="off">
                <?php if( $email <> '' ){ ?>
                <label>Seu e-mail</label>
                <input style = 'background-color:#D8D8D8' type="text" id="name" name="email" value='<?php echo $email;?>' required="required" readonly/><br/>
                <?php } ?>
                <label>Novo e-mail</label> 
                <input type="text" id="name" placeholder="Digite seu e-mail" name="email1" value=''  /><br/>
                <input type="text" id="name" placeholder="Repita seu e-mail" name="email2" value='' /><br/> 
                <label>Nova senha</label>
                <input type="password" placeholder="Digite sua senha" id="name" name="senha1" value="" /> 
                <input type="password" placeholder="Repita a senha" id="name" name="senha2" value=""  /> 
                <input type="submit" value="Atualizar" />
            </form>
        </div>
    </body>
</html>