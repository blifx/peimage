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
                max-width: 500px;
            }
            .dropzone .dz-message {
            margin: 3em 0;
            }
            .dropzone {
                text-align: center;
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
            .btn-div{
                background-color: #006064;
                color: white;
                height: 50px;
                cursor: pointer;
                margin-top: 30px;
                font-size: 1.29em;
                font-family: 'Sniglet', cursive;
                -webkit-transition: background-color 0.5s;
                -moz-transition: background-color 0.5s;
                -o-transition: background-color 0.5s;
                transition: background-color 0.5s;
                text-align: center;
                line-height:50px;
            }
            

        </style>

        <script>
            //Dropzone Configuration
            Dropzone.autoDiscover = false;

            $(document).ready(function(){

                //$("#rolling").hide();
                var myDropzone = new Dropzone('#uploads-file', {
                    autoProcessQueue: false,
                    url: "actionEnvioEmailsPlanilha.php?idempresa="+$("#idempresa").val(),
                    maxFilesize:30000,
                    maxFiles:1,
                    maxThumbnailFilesize:30000,
                    timeout:300000000000,
                    paramName: "fileToUpload", 
                    addRemoveLinks: true,
                    acceptedFiles: ".csv",
                    dictDefaultMessage: "Clique aqui para carregar seu arquivo",
                    dictCancelUploadConfirmation: "Você tem certeza que deseja cancelar este upload?",
                    dictFallbackMessage: "Seu browser não suporta função de arrastar soltar para uploads.",
                    dictInvalidFileType: "Arquivo inválido, você deve carregar um arquivo com a extensão .csv",
                    dictMaxFilesExceeded: "Você pode fazer o upload apenas de uma arquivo.",
                    dictRemoveFile: "Remover",
                    dictResponseError: "Ops, ocorreu algum problema com o servidor.",
                    dictUploadCanceled: "Cancelar envio",
                    dictCancelUpload: "Cancelar upload", 

                    init: function() {
                        this.on("success", function(file,responseText) {
                            if(responseText == '1'){
                                $("#texto").show();
                                $('#texto').css({ backgroundColor: '#00BBD4' });
                                $("#texto").html("<div style='padding:10px;'>Usuários criados com sucesso!</div>");

                                setTimeout(function(){ 
                                    $("#texto").hide();
                                }, 3000);                       
                            }else{
                                $('#texto').css({ backgroundColor: '#D52D2D' });
                                $("#texto").html("<div style='padding:10px;'>"+responseText+"</div>");
                                $("#texto").show();
                            }                      
                        });
                    },                
                });

                $("#submit").click(function(){
                    var acceptedFiles = myDropzone.getAcceptedFiles();
                        for (let i = 0; i < acceptedFiles.length; i++){
                            myDropzone.processFile(acceptedFiles[i]); 
                        }
      
                        $('html, body').scrollTop(0);
                });
                   
            });
            </script>

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
        <div id="content" style="padding-bottom:0px;height:100%;">
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post"  enctype="multipart/form-data" >
            <div id='texto' style="text-align:center;margin-top:15px; width:100%; background-color:#D52D2D;"></div>
            <?php
                echo "<label for='Empresa'>Empresa</label><br>";
                        echo '<input type="text" name="empresa" readonly value="'.ucfirst($empresa).'"/>';
                        echo '<input type="hidden" id="idempresa" name="idempresa" value="'.$idempresa.'">';
            ?>
                <label for='arquivos'>Planilha de usuários</label><br>
                <div id="uploads-file" class="dropzone upload message" ></div> 
                <div class="btn-div" id="submit">
                    <div>Enviar</div>
                </div>
            </form>
        </div>
    </body>
</html>