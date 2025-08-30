<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';

    $download = $_GET['download'];
    $link = $dirCompanie.'downloads/'.$download.".png";
    
    if(isset($_GET['size'])){
        $sizePhoto = $_GET['size'];
    }
    
    include('../config.php');

    $db = new DataBase();
    $conn = $DataBase->connect();

    $utilizacao = "sem_restricao";

    if(isset($_GET["tema"]) && is_numeric($_GET["tema"])){
        //consulta utilizada tanto para agencia quanto para usuarios comuns
        //por isso tras utilizacao e status_teste
        $sql = "
        SELECT CASE WHEN utilizacao = 1 THEN 'sem_restricao' 
                WHEN utilizacao = 2 THEN 'postavel' 
                ELSE 'download' 
                END AS utilizacao, 
                status_teste FROM temas 
                INNER JOIN layouts_campanha ON idlayouts_campanha = fklayouts_campanha 
                INNER JOIN layouts          ON idlayouts = layouts_campanha.fklayouts
                INNER JOIN layouts_empresa  ON layouts_empresa.fklayouts = layouts.idlayouts 
            WHERE
                idtemas = {$_GET["tema"]}
            LIMIT 1
        ";

        $query = $conn->query($sql);
        $response = mysqli_fetch_assoc($query);
        $active = 0;
        if(!empty($response["status_teste"])){
            $active = $response["status_teste"];
        }
        $utilizacao = $response["utilizacao"];
    }

?>

<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Download</title>
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />

        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">

        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script>
            var __DATA_FB = {
                id_album: '<?=$_SESSION["fb_id_album"]?>',
                token: '<?=$_SESSION["fb_token_extendido"]?>',
            };
        </script>
        <script type="text/javascript" src="../js/post-fb.js?v=3"></script>


        <?php
            //caso seja agencia nao carregamos scripts do face
            if($_SESSION["fb_token_extendido"] != ''){
                echo "<link rel=\"stylesheet\" href=\"{$__HTTP_HOST}/css/jquery.loadingModal.css\">";
                echo '<script type="text/javascript" src="../js/jquery.loadingModal.js"></script>';
            }
        ?>

        <script>

            function getParamURL(pName){
                var url = new URL(window.location.href);
                return url.searchParams.get(pName);
            }
    
            //remove click button rigth
            document.addEventListener('contextmenu', event => event.preventDefault());

            $(function(){

                if($("#active-layout-button").length){
                    //carrega a conf do select de ativacao do layout
                    $("#active-layout option[value='<?php if(isset($active)) echo $active;?>']").attr("selected", "selected");

                    $("#active-layout").change(function(){
                        $("#active-layout-button").text(
                            this.value == 1 ? "Ativar layout" : "Desativar layout"
                        )
                    });

                    $("#active-layout-button").click(function(){
                        $.ajax({
                            type: "post",
                            url: <?=  "' {$__HTTP_HOST}/src/actionDownload.php '" ?>,
                            data:{
                                act: "status",
                                status: $("#active-layout").val(),
                                tema: '<?php if(isset($_GET["tema"])) echo $_GET["tema"];?>'
                            },
                            timeout:5000,
                            dataType:'text'
                        })
                        .done(function(response){
                            if(response == '1'){
                                if($("#active-layout").val() == '1'){
                                    alert("Layout ativado com sucesso.");
                                } else {
                                    alert("Layout desativado com sucesso.");
                                }
                                $("#active-layout-button").text("Salvar");
                            } else {
                                alert("Houve um erro ao salvar modificações.");
                            }
                        })
                        .fail(function(){
                            alert("Verifique sua conexão com a internet ou tente novamente mais tarde.");
                        });
                    });
                }

                $("#print").click(function(){
                    var usuario = getParamURL('usuario');
                    var tema = getParamURL('tema');
                    var layout = getParamURL('idlayout');
            
                    $.get( "actionDownloads.php", { acao: "p", usuario: usuario, tema: tema, layout: layout} );

                    var newWin = window.frames["printf"];
                    newWin.document.write(
                        '<head>'
                        +'<style>'
                        +'@page{margin: 0;};' 
                        +'section{width:100vw; height: 100vh; page-break-after: always;}'
                        + 'body{margin:0;padding:0;line-height:1em;}'
                        +'</style>'
                        +'</head><body onload="window.print()">'
                        +'</body>'
                    );

                    var img = $("<img/>").attr("src", $("#img-print").attr("src"));
                    $(img).css({
                        "transform" : "scale(1)",
                        "width" : "100%",
                        "heigth" : "100%"
                    });
                    $('#printf').contents().find("body").append( $("<section>").append(img) );
                    
                    newWin.document.close();
                });

                $("#download-button").click(function(){
                    var usuario = getParamURL('usuario');
                    var tema = getParamURL('tema');
                    var layout = getParamURL('idlayout');
            
                    $.get( "actionDownloads.php", { acao: "d", usuario: usuario, tema: tema, layout: layout} );
                });
                
            });
        </script>

        <style>
            #desc-post{
                color: #373435;
                text-align: left;
                display:none;
            }
            #message-fb{
                line-height: 21px;
                height: 67px;
                display:none;
            }
            form{
                width: 100%;
            }
            .button{
                margin-top: 5px;
                margin-bottom: 0;
            }
            #form label{
                color: #373435;
            }
            #form-agencia select{
                margin-bottom:10px;
            }
            #form-agencia {
                padding-bottom: 1em;
            }
        </style>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <div style="text-align: center; margin-top:20px;">

<?php
            if(file_exists($link)){

                echo "
                <div style='max-width:500px; margin: 0 auto; padding-bottom: 20px;'>
                    <img src='{$link}' id='img-print' style='padding-bottom:20px; width:100%; max-width:500px' height='auto'/>
                ";
                if($_SESSION['tipo'] == 'agencia' || $_SESSION['tipo'] == 'admin'){
                    echo "
                    <form id='form-agencia'>
                        <select id='active-layout'>
                            <option disabled readonly>Configuração do layout</option>
                            <option value='1'>Layout ativado</option>
                            <option value='0'>Layout desativado</option>
                        </select>
                        <br/>
                        <a class='button' id='active-layout-button'>Salvar</a>
                    </form>
                    ";
                } else if($_SESSION['tipo'] != 'admin' || $_SESSION['tipo'] != 'agencia'){
                    
                    //verifica qual tipo de utilizacao pro layout
                    //se pode ser postado em rede social ou ser baixado
/*                     if ($utilizacao == "postavel" || $utilizacao == "sem_restricao"){
                        echo "
                        <form>
                            <div id='desc-post'>
                                Mensagem do post (opcional):
                            </div>
                            <textarea id='message-fb' placeholder='Página: {$_SESSION["fb_nome_pagina"]}\nLinha do tempo'></textarea>
                            <a class='button' style='cursor:pointer;' id='post-photo-fb-button'>Postar no Facebook</a>
                        </form>
                        ";
                        //<!--\nÁlbum: {$_SESSION["fb_nome_album"]}'>-->
                    } */
                    if($utilizacao == "download" || $utilizacao == "sem_restricao"){
                        echo "<a class='button' href='{$link}' download='peimage' id='download-button'>Download</a>";
                    }
                    echo "<a class='button' id='print'>Imprimir</a>";
                }
                echo "</div>";

            } else {
                echo "
                <div style='display:grid; align-items:center; height:300px;'>
                    Ops! Esta imagem expirou ou não pode ser encontrada nos nossos servidores...<br/>
                    Tente gerar novamente uma nova imagem para resolver o problema.
                </div>
                ";
            }
?>
        </div>

        <iframe id="printf" name="printf" width="0" height="0" frameborder="0">
        </iframe>

    </body>
</html>