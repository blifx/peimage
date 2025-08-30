<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../images/';
    include('../config.php');
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Empresas</title>
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
        <div id="content" >
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post" action="actionCreateEmpresa.php" enctype="multipart/form-data" autocomplete="off">
                <?php
                if(isset($_GET['msg'])){
                    echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
                }
                ?>
                <label>Nome/Razão Social</label>
                <input type="text" id="name" name="nome" value="" required="required" /><br /> 
  
                <label>Cnpj/Cpf</label><br />
                <input type="text" id="name" name="cnpj" value="" required="required" /><br/>
                <label>E-mail</label>
                <input type="email" id="name" name="email" value="" required="required" /><br/> 
                <label>Senha</label>
                <input type="password" placeholder="Digite sua senha" id="name" name="senha1" value="" required="required" /> 
                <input type="password" placeholder="Repita a senha" id="name" name="senha2" value="" required="required" /> 
<!--                 <label>Rodapé</label></label>
                <input id="paper" type="file" name="rodape" accept="image/png" /> -->
                <label>Logo</label>
                <input id="paper" type="file" name="arquivo" accept="image/png" required="required"/>
                <label>Cor Empresa</label>
                <input style="padding:0; height:35px; width:60px" type="color" id="cor" name="cor" value="" required="required" placeholder="Hexadecimal"/><br />
                <input type="hidden" name="plano" value='pro' />
                <input type="submit" value="Cadastrar" />
            </form>
        </div>
    </body>
</html>