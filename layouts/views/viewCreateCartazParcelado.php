<?php
if(!empty($_GET['layout'])){
    $layout = $_GET['layout'];
    $idlayout = $_GET['idlayout'];
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $typeThemes = 'cartaz';
    $dirCompanie = '../companies/'.$companie.'/';
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

            <title>Peimage - Cartaz Retrato</title>
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
                <form id="waterform" method="post" action="actionCreateCartazParcelado.php" enctype="multipart/form-data" target="_blank">
                    <label id="teste">Título Produto*</label>
                    <input type="text" id="name" maxlength="32" name="titulo" required="required" /><br/>
                    <label for="message">Descrição Produto*</label>
                    <input id="message" maxlength="40" name="desc" />
                    <label>Imagem Produto</label>
                    <input id="produto" type="file" name="fileUpload" accept="image/png,.jpeg,.jpg" />
                    <label>Tamanho Produto (%)</label>
                    <input type="number" id="name" name="sizeProduct" value="100"/>
                    <label>Girar Foto</label><br/>
                    <select id="social" name="rotacao" required="required">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                    </select><br/> 
                    <input type="hidden" name="font" value="peimage" /> 
                    <label>Preço à vista*</label>
                    <input type="text" id="name" name="preco" placeholder="ex: 149,90" required="required" value="" />
                    <label>Preço parcelado</label>
                    <input type="text" placeholder="ex: 199,90" id="name" name="parcelado" value="" />
                    <label>N° Parcelas*</label><br/>
                    <select id="social" name="parcela" required="required">
                        <option value="2x">2x</option>
                        <option value="3">3x</option>
                        <option value="4">4x</option>
                        <option value="5">5x</option>
                        <option value="6">6x</option>
                        <option value="7">7x</option>
                        <option value="8">8x</option>
                        <option value="9">9x</option>
                        <option value="10">10x</option>
                        <option value="11">11x</option>
                        <option value="12">12x</option>
                    </select><br/>
                    <label>Válidade da Propaganda</label>
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
