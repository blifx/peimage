<?php
    $dirCompanie = '../companies/'.$companie.'/';
    $layout = $_GET['layout'];
    $idlayout = $_GET['idlayout'];
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
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
        <title>Peimage - Foto</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
        <script>
            $(function(){
                $("#tema").change(function(){
                    if($('#tema').val() == "1"){
                        $("#img_theme img").attr("src", "controllers/temasFoto/tema2.png");
                        $("#descricao").hide();                        
                    }else{
                        $("#img_theme img").attr("src", "controllers/temasFoto/tema1.png");
                        $("#descricao").show();
                    }
                });
            });
        </script>
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
            <form id="waterform" method="post" action="actionCreateFoto.php" enctype="multipart/form-data" target="_blank">
            <label for="cars">Temas:</label>
                <select name="tema" id="tema">
                <option value="1">Tema 1</option>
                <option value="2">Tema 2</option>
                </select><br/>
                <div id="img_theme">
                    <img src="controllers/temasFoto/tema2.png" width="158" height="120"/>
                </div>
                <label>Foto</label>
                <input id="produto" type="file" name="fileUpload" accept="image/png,.jpeg,.jpg" required="required" />
                <label id="teste">Título do Produto*</label>
                <input type="text" id="name" name="titulo" required="required" placeholder="ex: Caneta Hidrográfica"/><br/>
                <label for="message">Subtítulo do Produto*</label>
                <input step="any" id="message"  name="subtitulo" required="required" placeholder="ex: Regular 12 Cores"/>
                <div id="descricao" style='display: none;'>
                    <label for="message">Descrição do Produto*</label>
                    <input step="any" id="message" name="desc" placeholder="ex: Faber Castell - COD1567809"/>  
                </div> 
                <label>Preço*</label>
                <input type="text" id="name" name="preco" placeholder="ex: 149,90" required="required" value="" />
                <label>Preço promocional</label>
                <input type="text" placeholder="ex: 99,90" id="name" name="promo" value="" />
                <label>Deslocar Horizontal (Cm)</label><input type="number"placeholder="(+) Direita / (-) Esquerda" name="horizontalProduct" />
                <label>Deslocar Vertical (Cm)</label><input type="number" placeholder="(+) Baixo / (-) Cima" name="verticalProduct" />
                <label for="Estilo">Posição Logo</label><br>
                    <select id="social" name="plogo" required="required">
                    <option value='superior'>Superior</option>
                    <option value='inferior'>Inferior</option>
                </select>
                <select id="social" name="plogo_hor" required="required">
                    <option value='direita'>Direita</option>
                    <option value='esquerda'>Esquerda</option>
                </select><br/>
                <label for="message">Girar Foto</label><br/>
                <select id="social" name="rotacao" required="required">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                </select><br/>
                <label>Observação</label>
                <input type="text" id="name" name="obs" value="" />
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
