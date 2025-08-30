<?php
if(!empty($_GET['campanha'])){ 
    $idcampaign = $_GET['campanha'];
    $idlayout = $_GET['layout'];
    $namelayout = $_GET['namelayout'];
    $logo = '../../../images/logoPeimage.png';
    $imageMenu = '../../../images/menu.png';
    $typeThemes = $_GET['namelayout'];
    $dirCompanie = '../../../companies/'.$companie.'/';
    $dirThemes = '../campaigns/'.$idcampaign.'/'.$typeThemes.'/';
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    include('../../../config.php');
?>

    <!DOCTYPE html>
    <html lang="pt-br" >
        <head>
            <meta charset="UTF-8">
            <meta name="format-detection" content="telephone=no">
            <meta name="msapplication-tap-highlight" content="no">
            <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
            
            <title>Peimage - Post </title>
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
            <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
            <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
            <script>
                $(function(){
                    $("#tema").change(function(){
                        $("#img_theme img").attr("src", "<?php echo $dirThemes; ?>" + this.value);
                    });
                });
            </script>
        </head>
        <body>
            <?php menu($logo, $imageMenu); ?>
            <header>
                <div id="logoCompany">
                <?php
                    if(file_exists($dirCompanie.'logo.png')){ 
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
                <form id="waterform" method="post" action="actionCreateStories.php" enctype="multipart/form-data" target="_blank">
                    <label id="name">Título*</label>
                    <input type="text" id="name" name="titulo" required="required" maxlength="30"/><br/> 
                    <label for="tema">Temas*</label><br>
                    <select id="tema" name="tema" required="required">
                    <?php 
                    $i=0;
                    $j=0;
                    while($row=mysqli_fetch_array($queryTemas)){
                        $i++;
                        if ($j==0){
                            $primaryTheme = $row['nome_arquivo'];
                            $j++;
                        }    
                        echo '<option value="'.$row['nome_arquivo'].'">Tema '.$i.'</option>';
                    }
                    ?>
                    </select><br/>
                    <div id="img_theme">
                        <img src="<?php echo $dirThemes.$primaryTheme; ?>" width="132" height="234"/>
                    </div>
                    <label>Produto*</label>
                    <input id="produto" type="file" name="fileUpload" accept="image/png,.jpeg,.jpg" required="required"/>
                    <label>Ajuste Rotação</label><br/>
                    <select id="social" name="rotacao" required="required">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                    </select><br/>
                    <label for="message">Descrição*</label>
                    <textarea step="any" id="message" name="desc" required="required" maxlength="30"></textarea>
<!--                     <label for="tema">Posição do texto</label><br>
                    <select id="tema" name="positionText" required="required">
                        <option value="abaixo">Abaixo</option>
                        <option value="acima">Acima</option>
                    </select><br/> -->
                    <label>Preço*</label>
                    <input type="text" id="name" name="preco" placeholder="ex: 99,90" required="required" value="" />
                    <label>Promoção</label>
                    <input type="text" placeholder="ex: 99,90" id="name" name="promo" value="" />
<!--                     <label>Parcelado</label><br/>
                    <select id="social" name="parcela" required="required">
                    <?php
                        $i=1;
                        while($i<=10){ 
                            echo '<option value='.$i.'>'.$i.'X</option>';
                            $i++;  
                        }              
                    ?>
                    </select><br/> -->
                    <label>Observação</label>
                    <input type="text" id="name" name="obs" value="" maxlength="63"/>
                    <div id="ajustes">
                        <label>Tamanho Imagem Produto (%)</label>
                        <input type="number" id="name" name="sizeProduct" value="100"/>
                        <label>Horizontal (Cm)</label><input type="number"placeholder="(+) Direita / (-) Esquerda" name="horizontalProduct" />
                        <label>Vertical (Cm)</label><input type="number" placeholder="(+) Baixo / (-) Cima" name="verticalProduct" />
                    </div>
                    <input type="submit" value="Visualizar" />
                    <input type="hidden" name="campanha" value=<?php echo "'$campaign'"; ?> />
                    <input type="hidden" name="idcampanha" value=<?php echo "'$idcampaign'"; ?> />
                    <input type="hidden" name="idlayout" value=<?php echo "'$idlayout'"; ?> />
                    <input type="hidden" name="namelayout" value=<?php echo "'$namelayout'"; ?> />
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