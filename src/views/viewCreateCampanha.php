<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
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
        
        <title>Peimage - Campanhas</title>
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

        <script>
            //Dropzone Configuration
            Dropzone.autoDiscover = false;
            var totalSize = 0, queuecomplete = false;
            var status = 0;
            var sizeDirectory = <?php echo round(GetDirectorySize($dirCompanie));?>;
            var limitSizeDirectory = <?php echo $limitSizeDirectory;?>;
            var flagRemove = true;

            $(document).ready(function(){

                //$("#rolling").hide();
                var myDropzone = new Dropzone('#uploads-file', {
                    autoProcessQueue: false,
                    url: "actionCreateCampanha.php",
                    maxFilesize:30000,
                    maxThumbnailFilesize:30000,
                    timeout:300000000000,
                    paramName: "fileToUpload", 
                    addRemoveLinks: true,
                    acceptedFiles: "image/png",
                    dictDefaultMessage: "Arraste ou carregue seus arquivos aqui",
                    dictCancelUploadConfirmation: "Você tem certeza que deseja cancelar este upload?",
                    dictFallbackMessage: "Seu browser não suporta função de arrastar soltar para uploads.",
                    dictInvalidFileType: "Você pode enviar apenas arquivos no formato PNG.",
                    dictMaxFilesExceeded: "Você não pode fazer o upload de mais de 50 arquivos por envio.",
                    dictRemoveFile: "Remover",
                    dictResponseError: "Ops, ocorreu algum problema com o servidor.",
                    dictUploadCanceled: "Cancelar envio",
                    dictCancelUpload: "Cancelar upload",

                    init: function() {
                        this.on('thumbnail', function(file) {
                            let el = $("#uploads-select option:selected");
                            if ( file.width != el.attr("w") || file.height != el.attr("h") ) {
                                file.rejectDimensions();
                            } else {
                                file.acceptDimensions();
                            }
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
                        file.acceptDimensions = done;
                        file.rejectDimensions = function(){
                            done('Dimensões inválidas');
                        };
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
                    limitSizeDirectory=20480; //forçando o valor de 20GB
                    $("#busySize").html("Espaço utilizado ("+((percent+autoSize)/1024).toFixed(1)+"/"+(limitSizeDirectory/1024).toFixed(1)+"GB)");
                    
                }
                addPercent(limitSizeDirectory, totalSize);

                setInterval(function(){
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
                    myDropzone.removeAllFiles();
                    reset();
                    addPercent(limitSizeDirectory, totalSize);
                });


                $("#submit").click(function(){
                    var countDz = 0;
                    $(".dz-image img").each(function(k,e){
                        if(!$(e).attr("alt")) countDz++
                    });
                    if(countDz > 0){
                        alert("Aguarde, seus arquivos estão sendo carregados.");
                        return;
                    }        

                    let el = $("#uploads-select option:selected");
                    
                    myDropzone.options.url = 
                        "actionCreateCampanha.php?campanha="
                        + $("#campanha").val()
                        + "&width="+el.attr("w")
                        + "&height="+el.attr("h")
                        + "&tipo="+el.attr("tipo")
                        + "&idlayout="+el.val()
                        + "&idcampanha="+$("#idcampanha").val();
                    
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
            });
            </script>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
        </div>
        </header>
        <div id="content">
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>


            <form id="waterform" method="post" action="actionCreateCampanha.php" enctype="multipart/form-data" >
            <?php
            if(isset($_GET['msg'])){
                echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
            }
            ?>

            <label for='Campanha'><div id='busySize'></div></label>
            <div id="progress-bar">
                <div  id="color-progress-bar">
                    <div id="text-progress-bar"></div>
                </div>
            </div>


            <label>Campanha</label>
            <input type="text" readonly id="campanha" value="<?php echo ucfirst($_POST['campanha']) ?>" name="campanha" required="required" maxlength="50"/>
            <input type="hidden" id="idcampanha" name="idcampanha" value="<?php echo $idcampanha ?>" name="campanha" required="required" maxlength="50"/><br/>
            <label>Início</label>
            <input type="date" readonly id="name" name="inicio" value="<?php echo $_POST['inicio'] ?>" name="campanha" required="required" /><br/>
            <label>Encerramento</label>
            <input type="date" readonly id="name" name="encerramento" value="<?php echo $_POST['encerramento'] ?>" name="campanha" required="required"/><br/>

                <label for='arquivos'>Adicionar temas</label><br>
                <div id="uploads-file" class="dropzone upload message" >
                    <select id='uploads-select' name='uploads-select' required='required'>
                    <?php
                        while($row=mysqli_fetch_array($queryLayouts)){
                        echo '<option w="'.$row['largura'].'" h="'.$row['altura'].'" value="'.$row['idlayouts'].'" tipo="'.$row['nome'].'">'.ucfirst($row['nome']).' ('.$row['largura'].'x'.$row['altura'].'px)</option>';
                        }
                    ?>
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
            </form>
        </div>
    </body>
</html>