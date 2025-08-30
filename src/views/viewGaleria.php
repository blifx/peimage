<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    $dirLogo = '../companies/'.$companie.'/';
    $caminhoLogo = $dirCompanie.'logo.png';
    if(file_exists($caminhoLogo)){
        list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    } else {
        $caminhoLogo = '';   
    }

    include('../config.php');

    $act = "";
    if(!empty($_GET['act']))
        $act = $_GET['act'];

?>

<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Galeria</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/jquery.loadingModal.css">

        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery.loadingModal.js"></script>
        <script type="text/javascript" src="../js/jquery.fileDownload.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/utils.js"></script>

        <script>
            var __HTTP_HOST = "<?php echo $__HTTP_HOST ?>"+"/"; 
            var __DATA_FB = {
                id_album: '<?=$_SESSION["fb_id_album"]?>',
                token: '<?=$_SESSION["fb_token_extendido"]?>',
            };

            $(function(){

                let tema = "<?php echo $act ?>"; 
                if(tema == "tema")
                    $("#download").hide();


/*
    $.ajaxSetup({ cache: true });
    $.getScript('https://connect.facebook.net/pt_BR/sdk.js', function(){

        FB.init({
            appId   : '376199693057711',
            cookie  : true,
            xfbml   : true,
            version : 'v4.0'
        });

        var errorAlbum = {
            321:	'O álbum selecionado para sua postagem atingiu seu limite máximo de imagens e está cheio. Selecione outro álbum em suas configurações.',
            200:	'Erro de permissão: Suas permissões de acesso são insuficientes.',
            2010:	'As chamadas de fotos foram temporariamente desativadas para o Peimage.',
            100:	'Ops, houve um erro. Verifique se suas configurações de rede sociais são válidas.',
            120:	'ID do álbum inválido, isso pode ter sido ocasionado devido a exclusão do álbum. Configure novamente sua conta do Facebook no Peimage.',
            368:	'A ação tentada foi considerada abusiva ou não é permitida.',
            220:	'O álbum que você está tentando utilizar não é válido para postagens ou foi excluído.',
            80001:  'Houve muitas chamadas para esta conta da página. Espere um pouco e tente mais tarde novamente. Para mais informações, consulte https://developers.facebook.com/docs/graph-api/overview/rate-limiting.',
        };

        function redirectConf(){
            window.location = "../src/actionRedeSocial.php?redirect="+window.location.href;
        }

        $("#post-fb").click(function(){
            if(__DATA_FB.token == ''){
                if(confirm("Deseja configurar sua conta do Facebook agora?\nVocê será encaminhado para a página de configuração.")){
                    redirectConf();
                }
                return;
            }

            $("#bg-modal").show();

            var arrayImg = $(".content-img").map(function(){
                return !$(this).children(".checkbox-peimage").hasClass("no-checked") 
                    ? $("img", this).not("post-fb")
                    : null;
            }).toArray();
            if(arrayImg.length > 0){
                postPhotoFacebook(arrayImg);
            }
        });

        function postPhotoFacebook(imgToPost){

            var nextImg = imgToPost.shift();
            
            if(nextImg != undefined){
                var options = {
                    //caption: $("#message-fb").val(),
                    url: nextImg.src,//TODO
                    access_token : __DATA_FB.token
                };

                FB.api(
                    "/"+ __DATA_FB.id_album +"/photos", 
                    "post", 
                    options, 
                    function(response){

                        if(response && response.id && response.post_id){

                            postPhotoFacebook(imgToPost);

                        } else {
                            $('body').loadingModal('hide');
                            if(response.error && response.error.code){

                                if(response.error.code == 190){//token invalid
                                    saveInvalidToken();
                                } else if(errorAlbum[response.error.code] != undefined){
                                    alert(errorAlbum[response.error.code]);
                                } else {
                                    alert("Ocorreu algum erro, tente novamente mais tarde."+
                                    "\nPor favor, se o erro persistir tente reconfigurar sua conta do Peimage associada ao Facebook.");
                                }

                            }
                        }
                    }
                );

            } else {
                alert("Imagens postadas com sucesso");
            }

            
        }
    });
    */
    if($(".gallery-img").length == 0){
        $("#enviarLimpar").hide();
    }

   //outro modo possível de carregar galeria (a ser desenvolvido) que permite barra de status. Ver link:
   //https://stackoverflow.com/questions/11071314/javascript-execute-after-all-images-have-loaded
    if(document.readyState != "complete"){
        $('body').loadingModal({
            text: 'Carregando galeria...',
            animation: 'threeBounce',
            backgroundColor: 'black'
        });
    } else {
        setResolutionSettings();
    }

    var widthWindows = $(window).width();
    var heightWindows = $(window).height();

    function setResolutionSettings(){
        widthWindows = $(window).width();
        heightWindows = $(window).height();
        if(widthWindows <= 768){
            $(".gallery-img img").css("max-width", ((widthWindows/2)-36) + "px");
            $("#peimage-modal img").css("max-width", widthWindows + "px");
            $("#gallery-peimage").css("width", ($(".content-img").width() * 2 + 20)  + "px");
        } else {
            $("#gallery-peimage").css("width", ($(".content-img").width() * (parseInt(widthWindows / 200) - 1) + (parseInt(widthWindows / 200) * 7))  + "px");
            $(".gallery-img img").css("max-width", "200px");
        }
        $("#peimage-modal").css("margin-left", "-" + ($("#peimage-modal img").width()/2) + "px");
    }

    $(window).bind("load", function() {
        $('body').loadingModal('hide');
        $("#gallery-peimage").show();
        setResolutionSettings();
    });

    $(window).resize(function(){
        setResolutionSettings();
    });

    $(".gallery-img").click(function(){
        $("html").css("overflow-y", "hidden");
        var img = $(this).find("img")[0];
        var ext = $(img).attr("ext");
        var imgModal = $("#peimage-modal img");
        var src = img.src.replace("_thumb.jpg", ext);

        var imageToLoad = new Image();
        imageToLoad.onload = function() {

            $(imgModal).attr("src", src);

            $('body').loadingModal("hide");

            $("#bg-modal, #peimage-modal, #close-modal").show();
            imgModal.css("max-height", (heightWindows - 50) + "px");

            var marginTop = parseInt( (heightWindows - imgModal.height()) / 2);
            $("#peimage-modal").css("top", ($(window).scrollTop() + marginTop) + "px");
            $("#peimage-modal").css("margin-left", "-" + parseInt(imgModal.width() / 2) + "px");

        };
        
        imageToLoad.src = src;

        $('body').loadingModal("destroy");
        $('body').loadingModal({
            text: 'Carregando imagem...',
            animation: 'threeBounce',
            backgroundColor: '#8a8a8aa6'
        });
        $('body').loadingModal("show");
        
    });

    $("#close-modal, #bg-modal").click(function(){
        $("html").css("overflow-y", "auto");
        $("#bg-modal, #peimage-modal, #close-modal").hide();
        $("body").css("height", "100%");
    });

    $(".checkbox-peimage").click(function(){
        var img = $("img", $(this).closest(".content-img"))[0];
        if($(this).hasClass("no-checked")){
            $(this).removeClass("no-checked");
            $(img).addClass("img-selected");
        } else {
            $(this).addClass("no-checked");
            $(img).removeClass("img-selected");
        }
        if($(".no-checked").length != $(".checkbox-peimage").length){
            $("#download").children("div").html("Baixar selecionados");
            $("#delete").children("div").html("Remover selecionados");
        } else {
            $("#download").children("div").html("Baixar todos");
            $("#delete").children("div").html("Remover todos");
        }
    });

    function getIdsImgSelected(){
        return $(".content-img").map(function(){
            return !$(this).children(".checkbox-peimage").hasClass("no-checked") 
                    ? $(this).attr("id") : null;
        }).toArray();
    }

    function getInfoForRequestPath(){
        var response = {
            mkt : '',
            tp : '',
            cp : '<?php if(isset($_GET["campanha"])) echo $_GET["campanha"]; ?>',
            ly : '<?php if(isset($_GET["layout"])) echo $_GET["layout"]; ?>'
        },
        dir = $(".content-img img").not(".face-post")[0].src.split("/");
        response.mkt = dir[ dir.indexOf("campaigns") + 1];
        <?php
            if(isset($_GET["act"])){
                echo  'response.tp = dir[ dir.length - 2 ];';
            } else {
                echo 'response.tp = dir[ dir.indexOf("files") + 1];';
            }
        ?>
        return response;
    }

    $("#download").click(function(){
        //antes de tudo remove cookie que controle o status do download
        //deleteCookie("fileDownload");

        var ids = getIdsImgSelected();
        var path = getInfoForRequestPath();

        $.fileDownload(
            __HTTP_HOST + 'src/actionGaleria.php?act=download'
            + '&ids=' + JSON.stringify(ids)
            + '&tp='  + path.tp
            + '&mkt=' + path.mkt
            + '&cp='  + path.cp
            + '&ly='  + path.ly, {

            cookiePath: __HTTP_HOST,
            prepareCallback : function(){
                $('body').loadingModal("destroy");
                $('body').loadingModal({
                    text: 'Processando download...',
                    animation: 'threeBounce',
                    backgroundColor: 'black'
                });
                $('body').loadingModal('show');
            },
            successCallback : function () {
                $('body').loadingModal('hide');
            },
            failCallback : function(){
                $('body').loadingModal('hide');
                alert("Ocorreu uma falha ao realizar o download.");
            }
        });

    });

    $("#delete").click(function(){

        var idsRemove = getIdsImgSelected();
        let msg = "Tem certeza que deseja excluir todas as imagens?";
        if(idsRemove.length)
            msg = "Tem certeza que deseja excluir as imagens selecionadas?";

        if(confirm(msg)){
            var path = getInfoForRequestPath();

            $('body').loadingModal("destroy");
            $('body').loadingModal({
                text: 'Aguarde, removendo arquivos...',
                animation: 'threeBounce',
                backgroundColor: 'black'
            });
            $('body').loadingModal('show');
            
            $.ajax({
                type: "get",
                url: __HTTP_HOST + "src/actionGaleria.php",
                data:{
                    act: '<?php echo (isset($_GET["act"]) ? "removeTheme" : "remove"); ?>',
                    ids: JSON.stringify(idsRemove),
                    tp: path.tp,
                    mkt: path.mkt,
                    idcampanha: getParamURL("campanha"),
                    idlayout: getParamURL("layout"),
                },
                timeout:15000,//15s
                dataType:'text'
            })
            .done(function(result){
                if(result == "tudo"){
                    $('body').loadingModal('hide');
                    $(".gallery-img, .content-img").remove();
                    $("#enviarLimpar").hide();
                    $("#null-msg").show();
                    alert("Arquivos excluídos com sucesso.");
                    return;
                }
                if(parseInt(result)){
                    for(var id in idsRemove){
                        $("#"+idsRemove[id]).remove();
                    }
                    $('body').loadingModal('hide');
                    alert("Arquivos excluídos com sucesso.");
                    $("#delete").children("div").html("Remover todos");
                    if($(".gallery-img").length == 0){
                        $("#null-msg").show();
                        $("#enviarLimpar").hide();
                    }
                } else {
                    alert("Houve um erro ao excluir seus arquivos.");
                    $('body').loadingModal('hide');
                }
            })
            .fail(function(){
                alert("Ocorreu um erro durante sua requisição ao servidor.");
                $('body').loadingModal('hide');
            });
        }
    });

});

        </script>

        <style>

            body{
                background-color: #98d5f4;
            }
            #content{
                height: auto;
                position:initial;
            }
            #gallery-peimage{
                margin: 0 auto;
                position: relative;
                top: 40px;
                padding-bottom: 80px;
                display:none;/*inicializa invisivel ate o carregamento completo*/
            }

            #close-moda, .content-img, .btn-div{
                /* disable selection image*/
                -webkit-touch-callout: none; /* iOS Safari */
                -webkit-user-select: none; /* Safari */
                -khtml-user-select: none; /* Konqueror HTML */
                -moz-user-select: none; /* Old versions of Firefox */
                -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently supported by Chrome, Opera and Firefox */
            }

            .content-img {
                position: relative;
                display: inline-block;
                margin: 4px;  
            }

            .content-img [type='checkbox'] {
                float: right;
            }

            .gallery-img img {
                max-width: 200px;
                height: auto;
                background: white;
                padding: 6px;
                border: 1px solid #a2a2a2;
            }

            .img-selected{
                background: #006064 !important;
            }

            .post-fb{
                /*opacity: 0;*/
                z-index: 500;
                position: absolute;
                display: block;
                top: 50%;
                left: 50%;
                margin-left: -16px;
                margin-top: -16px;
                box-shadow: 1px 1px 14px 4px #929292;
                border-radius: 50%;
            }

            #bg-modal{
                width: 100%;
                height: 100%;
                background: #8a8a8aa6;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 99999;
                display: none;
            }

            #close-modal{
                font-size: 36px;
                color: white;
                border-radius: 50%;
                background: #006064;
                width: 52px;
                height: 52px;
                right: 0;
                top: 0;
                padding: 0px;
                margin-right: -20px;
                margin-top: -20px;
                position: absolute;
                text-align: center;
                display: none;
                cursor: pointer;
            }

            #peimage-modal{
                position: absolute;
                left: 50%;
                z-index: 999999;
            }

            .checkbox-peimage{
                border: 1px solid #717171;
                width: 25px;
                height: 25px;
                background: #006064;
                display: flex;
                align-items: center;
                position: absolute;
                right: 7px;
                top: 7px;
            }

            .checkbox-checked{
                margin: 0 auto;
                width: 4px;
                height: 9px;
                border-style: solid;
                border-color: #e0e0e0;
                border-width: 0 2px 2px 0;
                transform: rotate(45deg);
            }

            .no-checked{
                background: #e0e0e0;
            }

            #nav-bottom-fixed {
                position: fixed;
                bottom: 0;
                background-color: #006064;
                height: 42px;
                width: 100%;
                z-index: 9999;
                display: none;
            }

            #sub-nav-bottom-fixed {
                display: flex;
                justify-content: center;
                align-items: center;
                height: auto;
                margin: 0 auto;
                z-index: 9999;
            }

            /** TODO PADRONIZAR CSS */
            #enviarLimpar {
                position: fixed;
                bottom: 0;
                background-color: #006064;
                height: 42px;
                width: 100%;
                z-index: 9999;
                display: none;
            }

            #subEnviarLimpar {
                display: flex;
                justify-content: center;
                align-items: center;
                height: auto;
                margin: 0 auto;
                z-index: 9999;
            }

            .btn-div {
                height: 35px !important;
                padding: 0px !important;
                border: solid 1px #FFFFFF !important;
                width: 35% !important;
                min-width: 160px;
                color: white;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 2px;
                cursor: pointer;
            }

            #null-msg{
                text-align: center;
                margin-top: 10%;
            }

        </style>
    </head>

    <body>
        <?php menu($logo, $imageMenu); ?>

        <!--
        <label id="sendMsg">Postando no Facebook...</label>
        <div id="progress-bar">
            <div  id="color-send-bar">
                <div id="text-send-bar"></div>
            </div>
        </div>
        -->
        <div id="content">

            <div id="gallery-peimage">

                <?php
                foreach($files as $key => $value){
                    echo "<div id='{$key}' class='content-img'>";

                        echo "
                        <div class='checkbox-peimage no-checked'>
                            <div class='checkbox-checked'></div>
                        </div>
                        <div class='gallery-img'>
                            <img ext='{$value["ext"]}' src='{$value["path"]}'/>
                        </div>";
/*
//TODO postagem do facebook
                        if($value["postado_fb"]){
                            echo "<img class='post-fb' src='facebook.png'/>";
                        }
*/                      
                    echo"</div>";
                }
                $visible = count($files) == 0 ? "block" : "none"; 
                echo "<div id='null-msg' style='display:{$visible}'>Nenhuma imagem disponível na galeria.</div>";
                
                ?>

            </div>

                <div id="bg-modal"></div>
                <div id="peimage-modal">
                    <div id="close-modal">&#10005;</div>
                    <img src="">
                </div>

        </div>

        <div id="enviarLimpar" style="display: block;">
            <div id="subEnviarLimpar">
                <!--
                <div class="btn-div" id="post-fb">
                    <div>Postar no Facebook</div>
                </div>
                -->

                <?php
                    if($_SESSION['tipo'] == "agencia" || $_SESSION['tipo'] == "admin"){
                        echo '
                        <div class="btn-div" id="download">
                            <div>Baixar todos</div>
                        </div>

                        <div class="btn-div" id="delete">
                            <div>Remover todos</div>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="btn-div" id="download">
                            <div>Baixar todas imagens</div>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>

    </body>
</html>