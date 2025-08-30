<?php
  
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.

    $logo = 'images/logoPeimage.png';
    $imageMenu = 'images/menu.png';
    $dirCompanie = 'companies/'.$companie.'/';
    $dirLogo = 'companies/'.$companie.'/';
    $caminhoLogo = $dirCompanie.'logo.png';
    if(file_exists($dirLogo.'logo.png')){
        list($largura, $altura) = getimagesize($dirLogo.'logo.png');
    }

    $dirCompanieClear = 'companies/'.$companie.'/';
    $pathDownloads = $dirCompanieClear.'downloads/';
    $pathUploads = $dirCompanieClear.'uploads/';
    clearImages($pathDownloads, 'png', '-60');
    clearImages($pathDownloads, 'jpg', '-60');
    clearImages($pathUploads, 'jpg', '-60');
    clearImages($pathUploads, 'png', '-60');

    include('config.php');

?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Layouts</title>
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />

        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">

        <style>
            #waterform{
                display: none;
            }
            #msg-null a{
                color: #ffffff;
                text-shadow: 1px 1px 2px #3c3c3c;
            }
            #msg-null{
                text-align: center;
            }
            #null-campaign {
                background: #77bde0;
                padding: 10px;
                border: 2px solid #98d5f4;
                margin: 100px 0 0 0;
                display: none;
            }
        </style>
        
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>

        <script>
            $(function(){
                var checkEnableButtonGallery = <?=$json?>, layoutOptions = <?=$layoutOptions?>;

                if(Object.keys(layoutOptions).length == 0){
                    $("#waterform").children().not("#null-campaign, #link-support").hide();
                    $("#null-campaign").show();
                }
                $("#waterform").show();

                function isEnableButton(campaign, layout){
                    if(checkEnableButtonGallery.indexOf(campaign+"") != -1){
                        $("#btn-view-gallery").removeClass("button-disabled").val("Acessar arquivos");
                    } else {
                        $("#btn-view-gallery").addClass("button-disabled").val("Nenhum arquivo");
                    }
                }

                function checkEnable(){
                    var selected = $("#layout option:selected");
                    if(selected.attr("tested") != '1'){
                        $("#create-layout").val("Ativar layout");
                    } else {
                        $("#create-layout").val("Configurar layout");
                    }
                    isEnableButton($("#campaign").val(), selected.attr("uidlayout"));
                    $("#fkempresa").val(selected.attr("fkempresa"));
                    $("#idlayout").val(selected.attr("uidlayout"));
                    $("#namelayout").val(selected.text().replace("✖ ", "").replace("✔ ", ""));
                }

                $("#btn-view-gallery").click(function(){
                    if( !$(this).hasClass("button-disabled") )
                    window.location = "<?=$__HTTP_HOST;?>/src/actionArquivos.php?idcampanha="+
                        $("#campaign").val()+"&campanha="+$("#campaign option:selected").text();
                });

                function changeCampanha(){
                    $("#layout option").remove();
                    var idCampaing = $("#campaign").val(); 
                    if(layoutOptions[idCampaing] != undefined){
                        let layouts = layoutOptions[idCampaing];
                        for(var i in layouts){
                            $("#layout").append('<option tested="'+layouts[i].testado+'" uidlayout="'+i+'" fkempresa="'+layouts[i].fkempresa+'" value="'+layouts[i].arquivo+'">'+layouts[i].nome+'</option>');
                        }

                        $("#waterform label").last().show();
                        $("#layout, #waterform input[type='submit']").show();
                        $("#btn-view-gallery").css({
                            marginTop:'0px'
                        });

                    } else {
                        $("#waterform label").last().hide();
                        $("#layout, #waterform input[type='submit']").hide();
                        $("#btn-view-gallery").css({
                            marginTop:'10px'
                        });
                    }
                    checkEnable();
                }

                changeCampanha();

                $("#campaign").change(changeCampanha);
                $("#layout").change(checkEnable);

            });
        </script>
    </head>

    <body>
        <?php menu($logo, $imageMenu); ?>
        
        <header>
            <div id="logoCompany">
            <?php
                if(file_exists($caminhoLogo)){ 
                    echo "<img src='{$caminhoLogo}' style='max-width:{$largura}px' />";
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

            <form id="waterform" method="post" action="index.php" enctype="multipart/form-data" >

                <div id="null-campaign">
                    <div id="msg-null">
                        Nenhuma campanha ou layout cadastrados.
                    </div>
                </div>
            
            <?php
                echo "<label for='Campanha'>Campanha de marketing</label><br>";
                echo "<select id='campaign' name='idcampanha'>";
                    while($row=mysqli_fetch_array($queryCampanhas)){
                        echo '<option value="'.$row['idcampanhas'].'">'.ucwords($row['nome']).'</option>';
                    }
                echo "</select>";
            ?>

                <label for="Estilo">Layout</label><br>
                <select id="layout" name="layout" required="required">
                </select>
                <input type="hidden" id="fkempresa" name="fkempresa" />
                <input type="hidden" id="idlayout" name="idlayout" />
                <input type="hidden" id="namelayout" name="namelayout" />
                <input type="submit" id="create-layout" value="Configurar layout" />
                <input type="button" id="btn-view-gallery" value="Arquivos"/>
                <div id="link-support">
                    <a href="<?=$__HTTP_HOST;?>/src/actionEmailMensagem.php" target="_blank">Sugestões, reclamações ou dúvidas?</a>
                </div>

            </form>
    </body>
</html>