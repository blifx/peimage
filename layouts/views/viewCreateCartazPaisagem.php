<?php
if(!empty($_GET['layout'])){
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $typeThemes = 'cartaz';
    $dirCompanie = '../companies/'.$companie.'/';
    $layout = $_GET['layout'];
    $idlayout = $_GET['idlayout'];
    $caminhoLogo = $dirCompanie.'logo.png';
    if(file_exists($dirCompanie.'logo.png')){
        list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
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
            
            <title>Peimage - Cartaz Paisagem</title>
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
            <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        </head>
        <body>
            <?php menu($logo, $imageMenu); ?>
            <header>
                <div id="logoCompany">
                <?php
                    if(file_exists($caminhoLogo)){ 
                        echo "<img src='{$dirCompanie}logo.png' style='max-width:{$largura}px' />";
                    } else {
                        echo "<h1><a href='src/actionPerfil.php'>Clique aqui para adicionar seu logo</a></h1>";
                    }
                ?>
                </div>
            </header>
            <div id="content">
                <div class="fish" id="fish"></div>
                <div class="fish" id="fish2"></div>
                <div class="fish" id="fish3"></div>
                <div class="fish" id="fish4"></div>
                <form id="waterform" method="post" action="actionCreateCartazPaisagem.php" enctype="multipart/form-data" target="_blank">
                <label>Cabeçalho*</label><br/>
                    <select id="social" name="cabecalho" required="required">
                        <option value="Promoção">Promoção</option>
                        <option value="Oferta">Oferta</option>
                        <option value="Ofertaço">Ofertaço</option>
                        <option value="Bombástica">Bombástica</option>
                        <option value="Megaoferta">MegaOferta</option>
                    </select><br/>
                    <label id="teste">Título Produto*</label>
                    <input type="text" id="name" maxlength="32" name="titulo" required="required" /><br/>
                    <label id="teste">Subtítulo Produto*</label>
                    <input type="text" id="name" maxlength="32" name="subtitulo" required="required" /><br/>
                    <label id="teste">Descrição Produto*</label><br/>
                    <input type="text" id="name" maxlength="32" name="desc" required="required" /><br/>
                    <label>Preço*</label>
                    <input type="text" id="name" name="preco" placeholder="ex: 149,90" required="required" value="" />
                    <label>Promoção</label>
                    <input type="text" placeholder="ex: 99,90" id="name" name="promo" value="" /> 
                    <label>Válidade</label>
                    <input type="date" id="name" name="validade" />
                    <input type="hidden" name="layout" value=<?php echo "'$layout'"; ?> />
                    <input type="hidden" name="idlayout" value=<?php echo "'$idlayout'"; ?> />
                    <?php if($companie == 'rede clip'){
                        echo "<input type='hidden' name='font' value= 'clip' />";
                    }else{
                        echo "<input type='hidden' name='font' value= 'peimage' />";
                    }
                    ?>
                    <input type="submit" value="Visualizar" />
                    <br/>
                    <div id="link-support">
                        <a href="<?=$__HTTP_HOST;?>/src/actionEmailMensagem.php" target="_blank">Sugestões, reclamações ou dúvidas?</a>
                    </div>
                </form>
            </div>
        </body>
    </html>
<?php
}
?>
