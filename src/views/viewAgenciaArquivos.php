<?php
$logo = '../images/logoPeimage.png';
$imageMenu = '../images/menu.png';
$dirCompanie = '../companies/'.$companie.'/';
$dirLogo = '../companies/'.$companie.'/';
$caminhoLogo = $dirCompanie.'logo.png';
if(file_exists($dirLogo.'logo.png')){
list($largura, $altura) = getimagesize($dirLogo.'logo.png');
}
include('../config.php');

if(($numUsuarios*75)<500){
    $limitSizeDirectory = 500;
}else{
    $limitSizeDirectory = $numUsuarios*75;
}
?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Layouts</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/dropzone.css" />
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/dropzone.js"></script>

        <style type="text/css">
            form {
                max-width: 70%;
            }
            .dropzone .dz-message {
                margin: 5em 0;
            }

            .dropzone .dz-preview .dz-image {
                border-radius: 0;
            }
            .dropzone .dz-preview .dz-error-message {
                border-radius: 0;
                top: 0;
                left: 0;
                text-align: center;
                width: auto;
                text-shadow: 1px 1px 2px #3c3c3c;
                background: #d52f2f;
                padding: 4px;
            }

            .dz-error-mark svg g g {
                fill: #c00;
            }

            .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
                background: rgba(255, 255, 255, 0.4);
            }

            .dropzone .dz-preview .dz-error-message:after {
                display: none;
            }

            #progress-bar{
                height: 48px;
                width: 100%;
                min-width: 70%;
                margin-top: 5px;
                outline: none;
                border: solid 3px #ffffff !important;
                box-sizing: border-box;
                background-image: -webkit-linear-gradient(135deg, rgba(255,255,255,0.125) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.125) 50%, rgba(255,255,255,0.125) 75%, transparent 75%, transparent);
                background-image: linear-gradient(-45deg, rgba(255,255,255,0.125) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.125) 50%, rgba(255,255,255,0.125) 75%, transparent 75%, transparent);
                background-size: 35px 35px;
            }

            #color-progress-bar{
                align-items: center; 
                display: flex;
                height:42px;  
                max-width: 100%; 
                background-color: #0097a7;
                width: 0%;  
                outline: none;
                box-sizing: border-box;      
            }

            #text-progress-bar{
                margin:auto; 
                text-align:left;
            }

            #color-send-bar{
                align-items: center; 
                display: flex;
                height:42px;  
                max-width: 100%; 
                background-color:#006064;
                width: 0%;
                
            }

            #text-send-bar{
                margin:auto; 
                text-align:left;
            }

            #enviarLimpar{
                position: fixed;
                bottom:0;
                background-color:#006064;
                height: 42px;
                width: 100%;
                z-index: 9999;
                display:none;
            }

            #subEnviarLimpar{
                display: flex;
                justify-content: center;
                align-items: center;
                height: auto;
                margin: 0 auto;
                z-index: 9999;
            }

            .buttonEnviarLimpar{
                margin-top:-5px !important; 
                height:35px !important; 
                padding: 0px !important; 
                border: solid 1px #FFFFFF !important;  
                width:40% !important;
                min-width:200px;
            }

            .btn-div{
                height: 35px !important;
                padding: 0px !important;
                border: solid 1px #FFFFFF !important;
                width: 35% !important;
                min-width: 200px;
                color: white;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 2px;
                cursor: pointer;
            }
            .btn-div img {
                padding: 6px;
            }

        .jquery-loading-modal__bg {
            position: absolute;
            z-index: 1;
            width: 100%;
            height: 100%;
            opacity: 0.7;
            background-color: #000;
            -webkit-transition: background-color 1s ease-in;
            transition: background-color 1s ease-in;
        }


        .jquery-loading-modal {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 9999;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            top: 0;
            left: 0;
        }

        </style>



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
            <form id="waterform" method="post"  enctype="multipart/form-data" >

            <?php
            if($numCampanhas == 0){
                echo "
                    <div style='text-align:center; margin-top:30px;'>
                        <label>Nenhuma campanha disponível.</label> <br/>
                        <a href='actionSetCreateCampanha.php'>Criar nova campanha</a>
                    </div>
                ";
            } else {
        ?>
               
            <label for='Campanha'><div id='busySize'></div></label>
            <div id="progress-bar">
                <div  id="color-progress-bar">
                    <div id="text-progress-bar"></div>
                </div>
            </div>

            <?php
                echo "<label for='Campanha'>Campanha</label><br>";
                echo "<select id='campanha' name='idcampanha' required='required'>";
                    while($row=mysqli_fetch_array($queryCampanhas)){
                        echo '<option value="'.$row['idcampanhas'].'">'.ucwords($row['nome']).'</option>';
                    }
                echo "</select><br/>";
            ?>
                <label for='arquivos'>Adicionar Arquivos</label><br>
                <div id="uploads-file" class="dropzone upload message" >
                   <select id='uploads-select' name='uploads-select' required='required'>
                    </select><br/>
                </div>                  
            </form>
        </div>

        <div id='send' class="jquery-loading-modal jquery-loading-modal--visible" style="display:none;">
            <div class="jquery-loading-modal__bg" style="background-color: black; opacity: 0.7;"></div>
                <div class="jquery-loading-modal__text" style="color: rgb(255, 255, 255); z-index: 2; width: 50%;">
                    <div style='z-index:10'>
                        <label id="sendMsg">Enviando...</label>
                        <div id="progress-bar">
                            <div  id="color-send-bar">
                                <div id="text-send-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div id="enviarLimpar">
            <div id="subEnviarLimpar">

                <div class="btn-div" id="loadingSubmit">
                    <div class="align"><img src="<?=$__HTTP_HOST;?>/images/rolling.gif" width="25" height="25"></div>
                    <div class="align">Carregando...</div>
                </div>

                <div class="btn-div" id="submit">
                    <div>Enviar</div>
                </div>
                
                <div class="btn-div" id="clear">
                    <div>Limpar</div>
                </div>
            </div>
        </div>

        <script>
            //Dropzone Configuration
            Dropzone.autoDiscover = false;
            var totalSize = 0, queuecomplete = false;
            var status = 0;
            var sizeDirectory = <?php echo round(GetDirectorySize($dirCompanie));?>;
            var limitSizeDirectory = <?php echo $limitSizeDirectory;?>;
            var flagRemove = true;

            //$(document).ready(function(){

                //$("#rolling").hide();
                var myDropzone = new Dropzone('#uploads-file', {
                    autoProcessQueue: false,
                    url: "actionAgenciaArquivos.php",
                    maxFilesize:30000,
                    maxThumbnailFilesize:30000,
                    timeout:300000000000,
                    paramName: "fileToUpload", 
                    acceptedFiles: "image/png",
                    addRemoveLinks: true,
                    dictDefaultMessage: "Arraste ou carregue seus arquivos aqui",
                    dictCancelUploadConfirmation: "Você tem certeza que deseja cancelar este upload?",
                    dictFallbackMessage: "Seu browser não suporta função de arrastar soltar para uploads.",
                    dictInvalidFileType: "Você pode enviar apenas arquivos no formato PNG.",
                    dictMaxFilesExceeded: "Você não pode fazer o upload de mais de 50 arquivos por envio.",
                    dictRemoveFile: "Remover",
                    dictResponseError: "Ops, ocorreu algum problema com o servidor.",
                    dictUploadCanceled: "Cancelar envio",
                    dictCancelUpload: "Cancelar upload",
                    //resizeWidth: 960, 
                    //resizeHeight: 960,
                    resizeMethod: 'contain', 
                    resizeQuality: 1.0,

                    init: function() {
                        this.on('thumbnail', function(file) {
/*                             let el = $("#uploads-select option:selected");
                            if ( file.width != el.attr("w") || file.height != el.attr("h") ) {
                                file.rejectDimensions();
                            } else {
                                file.acceptDimensions();
                            } */
                            //file.acceptDimensions();
                        });

                        this.on("addedfile", function(file) { 
                            totalSize += parseFloat((file.size / (1024*1024)));
                            addPercent(limitSizeDirectory, totalSize);
                            if( (totalSize+sizeDirectory) > limitSizeDirectory ){
                                myDropzone.removeFile(file);
                                if(status == 0){
                                    status = 1;
                                    alert("Você antigiu o limite de armazenamento. Algum arquivo pode não ter sido carregado para o upload.");
                                }
                            } else {
                                status = 0;
                            }
                            $("#enviarLimpar").show();
                            $("#content").css({
                                'margin-bottom': '30px',
                            });
                        });

                        this.on("removedfile", function(file) {
                            if(flagRemove){
                                totalSize -= parseFloat((file.size / (1024*1024)));
                                addPercent(limitSizeDirectory, totalSize);
                            }
                            var acceptedFiles = myDropzone.getAcceptedFiles();
                            if(acceptedFiles.length == 0){
                                reset();
                            }
                        });

                        this.on("canceled", function(file) {
                            totalSize -= parseFloat((file.size / (1024*1024)));
                            addPercent(limitSizeDirectory, totalSize);
                        });

                        this.on("error", function(file) {
                            totalSize -= parseFloat((file.size / (1024*1024)));
                            addPercent(limitSizeDirectory, totalSize);
                        });
                    },
                    accept: function(file, done) {
         /*                file.acceptDimensions = done;
                        file.rejectDimensions = function(){
                            done('Dimensões inválidas');
                        }; */

                        var ext = (file.name).split('.')[1]; // get extension from file name
                        //this.hiddenFileInput.accept
                        
                        //if (ext == 'mp4' || ext == 'png') {
                        //done(); // error message for user
                        //}
                        //else { done("Dont like those extension"); } // accept file



                        done();


                    }
                });

                function addPercent(limitSizeDirectory, autoSize){            
                    percent = <?php echo round(GetDirectorySize($dirCompanie));?>;
                    busy = Math.round(100*(percent+autoSize)/limitSizeDirectory);
                    if(busy > 0){
                        $("#text-progress-bar").html(busy+"%");
                        $("#color-progress-bar").show();
                        $("#color-progress-bar").css({
                            'width': busy+"%",
                            'min-width': '30px',
                        });
                    }else{
                        $("#color-progress-bar").hide();
                        percent = 0; 
                        autoSize = 0;
                    }
                    $("#busySize").html("Espaço utilizado ("+((percent+autoSize)/1024).toFixed(1)+"/"+(limitSizeDirectory/1024).toFixed(1)+"GB)");
                    
                }
                addPercent(limitSizeDirectory, totalSize);
                


                    setInterval(function(){
                        let el = $("#uploads-select option:selected");
                        if(el.attr("w") > 0 && el.attr("h") > 0){
                        var countDz = 0;
                        var countDzError = 0
                        $(".dz-error-message span").each(function(k,e){
                            if($(e).text() != '') countDzError++
                        });
                        if(countDzError == 0){
                            $(".dz-image img").each(function(k,e){
                                if(!$(e).attr("alt")) countDz++
                            });
                            if(countDz > 0){
                                $("#submit").hide();
                                $("#loadingSubmit").show();
                                return;
                            }
                        }
                        $("#loadingSubmit").hide();
                        $("#submit").show();
                    }else{
                    $("#loadingSubmit").hide();
                    }
                    }, 1000);
                
                
                function reset(){
                    $("#sendMsg").html("Enviando...");
                    $("#send").hide();
                    $("#enviarLimpar").hide();
                    $("#content").css({
                        'margin-bottom': '0',
                    });
                }

                $("#uploads-select").change(function(){
                    let el = $("#uploads-select option:selected");
                    let cl = $(".dz-hidden-input");
                    
                    if($("#uploads-select option:selected").text() != "Outros"){
                        myDropzone.options.acceptedFiles = "image/png";
                        cl.attr("accept", "image/png");
                    }else{
                        myDropzone.options.acceptedFiles = "";
                        cl.attr("accept", "*");

                    }
                    

            
/*                     if(el.attr("w") > 0 && el.attr("h") > 0){
                        myDropzone.options.acceptedFiles = "image/png, .jpg, .jpeg";
                        cl.attr("accept", "image/png, .jpg, .jpeg");
                    
                    }else{
                       myDropzone.options.acceptedFiles = null;
                       cl.attr("accept", "*");
                    }  */

                    myDropzone.removeAllFiles();
                    reset();
                    addPercent(limitSizeDirectory, totalSize);
                });

                $("#campanha").change(function(){
                    myDropzone.removeAllFiles();
                    reset();
                    addPercent(limitSizeDirectory, totalSize);
                });

                $("#submit").click(function(){
                    let el = $("#uploads-select option:selected");
                    let elCampanha = $("#campanha option:selected");
                    if(el.attr("w") > 0 && el.attr("h") > 0){
                        var countDz = 0;
                        $(".dz-image img").each(function(k,e){
                            if(!$(e).attr("alt")) countDz++
                        });
                        if(countDz > 0){
                            alert("Aguarde, seus arquivos estão sendo carregados.");
                            return;
                        } 
                    }          

                    myDropzone.options.url = 
                        "actionAgenciaArquivos.php?campanha="
                        + $("#campanha option:selected").text()
                        + "&width="+el.attr("w")
                        + "&height="+el.attr("h")
                        + "&tipo="+el.attr("tipo")
                        + "&idlayout="+el.val()
                        + "&idcampanha="+elCampanha.val();
                    
                    if(el.attr("w") > 0 && el.attr("h") > 0){
                        myDropzone.options.resizeWidth = el.attr("w");
                        myDropzone.options.resizeHeight = el.attr("h");
                    }

                    if( (totalSize+sizeDirectory) < limitSizeDirectory ){
                        if(myDropzone.getRejectedFiles() == ''){
                            $("#send").show();
                            $("#enviarLimpar").hide();
                            $("#content").css({
                                'margin-bottom': '30px',
                            });

                            var acceptedFiles = myDropzone.getAcceptedFiles();
                            for (let i = 0; i < acceptedFiles.length; i++) {
                                myDropzone.processFile(acceptedFiles[i]); 
                            }

                            var j=1,
                            percentFilesProgress = 0,
                            nAcceptFiles = myDropzone.getAcceptedFiles().length;
                                
                            myDropzone.on("complete", function(file) {
                                percentFilesProgress = Math.round(100*(j++)/nAcceptFiles).toFixed(0);
                                $("#text-send-bar").html(percentFilesProgress+"%");
                                $("#color-send-bar").css({
                                    'width': percentFilesProgress+"%",
                                    'min-width': '10%',
                                });
                                
                                if(percentFilesProgress == 100){
                                    $("#sendMsg").html("Envio concluído com sucesso");
                                    setTimeout(function(){
                                        reset();
                                        flagRemove = false;
                                        myDropzone.removeAllFiles();
                                        flagRemove = true;
                                    }, 2000);
                                }
                            });

                        } else {
                            alert("O upload não pode ser iniciado, existe algum arquivo inválido.");
                        }
                    } else {
                        alert("Limite de armazenamento excedido.");
                    }
                });

                $("#clear").click(function(){
                    myDropzone.removeAllFiles();
                    reset();
                });

                var checkEnableButtonGallery = <?=$json?>, layoutOptions = <?=$layoutOptions?>;
                function changeCampanha(){
                    $("#uploads-select option").remove();
                    var idCampaing = $("#campanha").val(); 
                    if(layoutOptions[idCampaing] != undefined){
                        let layouts = layoutOptions[idCampaing];
                        for(var i in layouts){
                            var nomeLayout = layouts[i].nome.substr(0,1).toUpperCase(); 
                            nomeLayout = nomeLayout + layouts[i].nome.substr(1);
                            $("#uploads-select").append('<option uidlayout="'+i+'" value="'+layouts[i].idlayout+'" tipo="'+layouts[i].nome+'" w="'+layouts[i].largura+'" h="'+layouts[i].altura+'">'+nomeLayout+' ('+layouts[i].largura+'x'+layouts[i].altura+'px)</option>');
                        }        
                    }
                    $("#uploads-select").append('<option uidlayout="0" value="outros" tipo="outros" w="0" h="0">Outros</option>');
                }

                changeCampanha();
                $("#campanha").change(changeCampanha);
            //});
            </script>
    <?php
        }
    ?>
    </body>
</html>