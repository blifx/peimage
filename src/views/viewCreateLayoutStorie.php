
<?php
if ($_GET['layout'] == "cartazA4"){
    $layoutJs = "createLayout.js";
}else if($_GET['layout'] =="storie"){
    $layoutJs = "createLayoutStorie.js";
}

?>

<html>
    <head>

        <link rel="icon" href="<?=$__HTTP_HOST ?>/images/favicon.png" />

        <meta charset="utf-8"/>
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Layouts</title>

        <link rel="stylesheet" href="<?=$__HTTP_HOST ?>/css/reset.css?v=1">
        <link rel="stylesheet" href="<?=$__HTTP_HOST ?>/css/menu.css?v=1">
        <link rel="stylesheet" href="<?=$__HTTP_HOST ?>/css/print.min.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST ?>/css/createLayout.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST ?>/css/jquery.loadingModal.css">
        <link rel="stylesheet" href="<?=$__PATH_CSS_GENERATOR?>">

        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/dom-to-image.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/utils.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/interact.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/FileSaver.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/jquery.maskMoney.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/validate.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/jquery.loadingModal.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/dexie.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST ?>/js/jszip.min.js"></script>

        <style>
            #cssmenu li > a:hover, #cssmenu ul li:hover > a {
                width: 200px;
            }
            #cssmenu li ul a {
                height: 50px;
            }
        </style>

        <script>
            __AUTH_TOKEN_FB = '<?=$_SESSION["fb_token_extendido"]?>';
            __ID_LAYOUT = '<?=$idlayout?>';
            __ID_CAMPAIGN = '<?=$idcampanha?>';
            __DIR_LAYOUT = '<?=$dirThemes?>';
            __TYPE_LAYOUT = '<?=$__TYPE_LAYOUT?>';
            __LAYOUT_FEATURE = <?php echo empty($themes[0]["caracteristicas"]) ? "{}" : $themes[0]["caracteristicas"]?>;
            __IDS_ACTIVE_CAMPAIGN = <?=json_encode($idsCampanha)?>;
        </script>

</head>

<body>

    <?php menu($logo, $imageMenu); ?>

    <div id="content">

        <div id="content-form">

            <div id="header-form">
                <div id="wave"></div>
                <div class="tab">
                    <div id="tab-form" class="tab-item tab-selected">Material</div>
                    <div id="tab-list" class="tab-item">
                        Lista
                        <span id="counter-list"></span>
                    </div>
                </div>
            </div>

            <div id="scroll-form">
                <?php
                    require_once($__PATH_FILE_MODE_LAYOUT);
                    $__HTTP_HOST = "..";
                ?>

                <div id="list-gallery">
                    <div id="msg-null-list">Nenhum item incluído na lista.</div>
                </div>

            </div>

        </div>
        
        <div id="buttons">

            <?php

                //layout de geracao
                if($__TYPE_LAYOUT == "edit"){

                    $utilizacao = $themes[0]["utilizacao"];
                    if($_SESSION['tipo'] != 'admin' || $_SESSION['tipo'] != 'agencia'){
                        
/*                         if ($utilizacao == "postavel" || $utilizacao == "sem_restricao"){
                            echo '
                                <div id="post-fb" class="buttons-tool button-form">
                                    <img src="'.$__HTTP_HOST.'/images/facebook_black.png"/>
                                    <div class="buttons-tool-text">Postar</div>
                                </div>
                            ';
                        } */

                        if($utilizacao == "download" || $utilizacao == "sem_restricao"){
                            echo '
                                <div id="download" class="buttons-tool button-form" blocked-evt="false">
                                    <img src="'.$__HTTP_HOST.'/images/download.png"/>
                                    <div class="buttons-tool-text">Baixar</div>
                                </div>
                            ';
                        }

                    }
/*
                    <div id="edit-layout-list" class="buttons-tool button-list">
                        <img src="'.$__HTTP_HOST.'/images/edit.png"/>
                        <div class="buttons-tool-text">Editar</div>
                    </div>
*/

                echo '

                    <div id="generate-pdf" style="display:none" class="buttons-tool">
                        <img src="'.$__HTTP_HOST.'/images/print.png"/>
                        <div class="buttons-tool-text">Gerar</div>
                    </div>

                    <div id="reset-form" class="buttons-tool button-form">
                        <img src="'.$__HTTP_HOST.'/images/document.png"/>
                        <div class="buttons-tool-text">Novo</div>
                    </div>

                    <div id="add-list" class="buttons-tool button-form" blocked-evt="false">
                        <img style="filter:invert(1)" src="'.$__HTTP_HOST.'/images/add.png"/>
                        <div class="buttons-tool-text">Adicionar</div>
                    </div>

                    <div id="save-list" class="buttons-tool button-form" blocked-evt="false">
                        <img style="filter:invert(1)" src="'.$__HTTP_HOST.'/images/save.png"/>
                        <div class="buttons-tool-text">Salvar</div>
                    </div>

                    <div id="remove-layout-list" class="buttons-tool button-list">
                        <img src="'.$__HTTP_HOST.'/images/trash.png"/>
                        <div class="buttons-tool-text">Excluir</div>
                    </div>

                    <div id="erase-all-layout-list" class="buttons-tool button-list">
                        <img src="'.$__HTTP_HOST.'/images/paintbrush.png"/>
                        <div class="buttons-tool-text">Limpar tudo</div>
                    </div>             

                    <div id="download-all-list" class="buttons-tool button-list">
                        <img src="'.$__HTTP_HOST.'/images/zip_download.png"/>
                        <div class="buttons-tool-text">Baixar</div>
                    </div>
                    
                ';

                } else {

                    //layout apenas de configuracao
                    echo '
                        <div id="status-test" class="buttons-tool button-form">
                            <img src="">
                            <div class="buttons-tool-text"></div>
                        </div>
                
                        <div id="save-config" class="buttons-tool button-form">
                            <img src="'.$__HTTP_HOST.'/images/save.png"/>
                            <div class="buttons-tool-text">Salvar</div>
                        </div>
                    ';
                }
            ?>

        </div>

        <div id="content-img-generate">
            <?php require_once($__PATH_PHP_FORM_LAYOUT)?>
        </div>

    </div>

    <script type="text/javascript" src="<?=$__PATH_JS_GENERATOR?>"></script>
    <script type="text/javascript" src="<?=$__HTTP_HOST?>/js/<?=$layoutJs?>"></script>

    <div id="progress">
        <div id="area-progress-bar">
            <label id="progress-msg">Processando lista...</label>
            <div id="progress-bar">
                <div id="color-progress-bar">
                    <div id="text-progress-bar"></div>
                </div>
            </div>
        </div>
    </div>

    
    <iframe id="printf" name="printf"  width="0" height="0" frameborder="0">
    </iframe>

</body>

<script>

function synchronizeCssStyles(src, destination, recursively) {

    // if recursively = true, then we assume the src dom structure and destination dom structure are identical (ie: cloneNode was used)

    // window.getComputedStyle vs document.defaultView.getComputedStyle 
    // @TBD: also check for compatibility on IE/Edge 
    destination.style.cssText = document.defaultView.getComputedStyle(src, "").cssText;

    if (recursively) {
        var vSrcElements = src.getElementsByTagName("*");
        var vDstElements = destination.getElementsByTagName("*");

        for (var i = vSrcElements.length; i--;) {
            var vSrcElement = vSrcElements[i];
            var vDstElement = vDstElements[i];
            //console.log(i + " >> " + vSrcElement + " :: " + vDstElement);
            vDstElement.style.cssText = document.defaultView.getComputedStyle(vSrcElement, "").cssText;
        }
    }
}
/*
function printWithSpecialFileName(){
    var tempTitle = document.title;
    document.title = "Convite digital.pdf";
    window.print();
    document.title = tempTitle;
}

function(){}
    var tempTitle = document.title;
    document.title = "Convite digital.pdf";
    window.print();
    document.title = tempTitle;
}()
*/

function printPeimage(){

    var element = $('#capture')[0];
    var clone = element.cloneNode(true);
    synchronizeCssStyles(element, clone, true);

    var newWin = window.frames["printf"];
    
    newWin.document.write('<head><link rel="stylesheet" href="<?=$__PATH_CSS_GENERATOR?>"></head><body style="margin:0;padding:0;line-height:1em;" onload="window.print()"></body>');

    $(clone).css({
        "transform" : "scale(1)",
        "zoom" : "0.4",
        "position": "absolute",
        "top" : "0",
        "left" : "0"
    });

    $('#printf').contents().find("body").append( $(clone) );
    newWin.document.close();

}

if(getParamURL("layout") == "digitalInviteCDL"){
    $("#add-list, #print-page, #download, #header-form").hide();
    $("#scroll-form").css("height", "calc(100% - 20px)");
    $("#generate-pdf").show()
    $("#generate-pdf").click(function(){
        printPeimage();
    });
}else {
    $("#printf, #generate-pdf").hide();
}


</script>

</html>