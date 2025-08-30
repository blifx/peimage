<?php
$logo = '../images/logoPeimage.png';
$imageMenu = '../images/menu.png';
$dirCompanie = '../companies/'.$companie.'/';
$dirLogo = '../companies/'.$companie.'/';
$caminhoLogo = $dirCompanie.'logo.png';
if(file_exists($caminhoLogo)){
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
}else{
    $caminhoLogo = '';   
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

        <title>Peimage - Empresas</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
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
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post" action="actionPerfil.php" enctype="multipart/form-data" autocomplete="off">
            <?php
            if(isset($_GET['msg'])){
                echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
            }
            ?>
                <label>Nome/Razão Social</label>
                <input style = 'background-color:#D8D8D8' type="text"  name="nome" value='<?php echo ucfirst($empresa);?>' required="required" readonly /><br /> 
                <label>Cnpj/Cpf</label><br />
                <input style = 'background-color:#D8D8D8' type="text"  name="cnpj" value='<?php echo $cnpj;?>' required="required" readonly /><br/>
                <label>E-mail</label>
                <input style = 'background-color:#D8D8D8' type="text"  name="email" value='<?php echo $email;?>' required="required" readonly/><br/>
                <label>Novo E-mail</label> 
                <input type="text"  placeholder="Digite seu e-mail" name="email1" value=''  autocomplete="off"/><br/>
                <input type="text"  placeholder="Repita seu e-mail" name="email2" value='' autocomplete="off"/><br/> 
                <label>Senha</label>
                <input type="hidden" style = 'background-color:#D8D8D8' type="password"  name="senha1" value='<?php echo $senha;?>' required="required" readonly /> 
                <label>Nova Senha</label>
                <input type="text" id="senha" placeholder="Digite sua senha"  name="senha1" value="" pattern="(?=.*[a-z]).{6,15}" autocomplete="off"/> 
                <input type="text" id="senha" placeholder="Repita a senha"  name="senha2" value=""  pattern="(?=.*[a-z]).{6,15}" autocomplete="off"/> 
                <div style="padding-left:7px;padding-right:1px;font-size:15px;text-shadow: 1px 1px 3px #3c3c3c;" >Sua senha deve conter pelo menos 6 caracteres com no mínimo um número e uma letra*</div> 
                <label>Logo</label>
                <input  id="paper" type="file" name="arquivo" accept="image/png" /> 
                <?php if($caminhoLogo != ""){?>
                <div style='text-align:center; margin-top:10px'>
                <img src='<?php echo $caminhoLogo;?>'><br />
                </div>
                <?php }?>
                <label>Cor Empresa</label>
                <input style="padding:0; height:35px; width:60px" type="color" value='<?php echo $cor1;?>' id="cor1" name="cor" /><br />
                <label>Cor Texto</label>
                <input style="padding:0; height:35px; width:60px" type="color" value='<?php echo $cor_texto1;?>' id="cor" name="cor_texto" /><br />
                <input type="hidden" name="plano" value='pro' />
                <input type="submit" value="Atualizar" />
            </form>
        </div>
    </body>
</html>