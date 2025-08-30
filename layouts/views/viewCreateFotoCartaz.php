<?php
if(!empty($_GET['layout'])){
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $typeThemes = 'cartaz';
    $dirCompanie = '../companies/'.$companie.'/';
    $layout = $_GET['layout'];
    $idlayout = $_GET['idlayout'];
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
            
            <title>Peimage - Cartaz Paisagem</title>
            <link rel="stylesheet" href="../css/dropzone.css" />
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../images/favicon.png" />
            <link rel="stylesheet" href="../css/menu.css">
            <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" src="../js/dropzone.js"></script>

            <style>
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
            </style>

            <script>
            //Dropzone Configuration
            Dropzone.autoDiscover = false;
            $(document).ready(function(){
                
                var layout   = <?php echo $idlayout ?>;
                var usuario = <?php echo $idusuarios ?>;

                var myDropzone = new Dropzone('#uploads-file', {
                    autoProcessQueue: false,
                    url: "actionCreateFotoCartaz.php",
                    maxFilesize:30000,
                    maxFiles:1,
                    maxThumbnailFilesize:30000,
                    timeout:300000000000,
                    paramName: "fileToUpload", 
                    addRemoveLinks: true,
                    acceptedFiles: "image/png, .jpg, .jpeg",
                    dictDefaultMessage: "Clique aqui e tire uma foto em formato quadrado.",
                    dictCancelUploadConfirmation: "Você tem certeza que deseja cancelar este upload?",
                    dictFallbackMessage: "Seu browser não suporta função de arrastar soltar para uploads.",
                    dictInvalidFileType: "Você pode enviar apenas arquivos no formato PNG.",
                    dictMaxFilesExceeded: "Você pode fazer o upload apenas de uma arquivo.",
                    dictRemoveFile: "Remover",
                    dictResponseError: "Ops, ocorreu algum problema com o servidor.",
                    dictUploadCanceled: "Cancelar envio",
                    dictCancelUpload: "Cancelar upload",

                    init: function() {
                        this.on('thumbnail', function(file) {
                            if ( file.width == file.height ) {
                                file.acceptDimensions();
                            } else {
                                file.rejectDimensions();
                            }
                        });

                        this.on("addedfile", function(file) { 
                            if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                            }
                        });

                        this.on("removedfile", function(file) {

                        });

                        this.on("canceled", function(file) {

                        });

                        this.on("error", function(file) {

                        });
                        this.on("success", function(file,responseText) {
                            window.open("../src/actionDownloads.php?download="+responseText+"&estilo=fotoCartaz'&usuario="+usuario+"&idlayout="+layout, "_blank");
                        });
                    },
                    accept: function(file, done) {
                        file.acceptDimensions = done;
                        file.rejectDimensions = function(){
                            done('Dimensões inválidas: A foto precisa ser quadrada.');
                        };   
                    },

                });


                $("#waterform").submit(function(e){
                    
                e.preventDefault();
                myDropzone.options.url = 
                    "actionCreateFotoCartaz.php?"
                    + "&layout="+$("#layout").val()
                    + "&parcela="+$("#parcela").val()
                    + "&titulo="+$("#titulo").val()
                    + "&subtitulo="+$("#subtitulo").val()
                    + "&desc="+$("#desc").val()
                    + "&preco="+$("#preco").val()
                    + "&promo="+$("#promo").val()
                    + "&rotacao="+$("#rotacao").val()
                    + "&font="+$("#font").val();

                        var acceptedFiles = myDropzone.getAcceptedFiles();
                        for (let i = 0; i < acceptedFiles.length; i++) {
                            myDropzone.processFile(acceptedFiles[i]); 
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
                <form id="waterform" method="post" enctype="multipart/form-data" target="_blank">
                    <label>Título Produto*</label>
                    <input type="text" id="titulo" maxlength="24" name="titulo" required="required" /><br/>
                    <label>Descrição Produto*</label><br/>
                    <input id="desc" maxlength="20" name="desc"  /><br/>
                    <label>Foto</label><br>
                    <div id="uploads-file" class="dropzone upload message" ></div>
                    <label for="message">Girar Foto</label><br/>
                    <select id="rotacao" name="rotacao" required="required">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                    </select><br/>  
                    <label>Preço*</label>
                    <input type="text" id="preco" name="preco" maxlength="7" placeholder="ex: 149,90" required="required" value="" />
                    <label>Promoção</label>
                    <input type="text" placeholder="ex: 99,90" maxlength="7" id="promo" name="promo" value="" /> 
                    <label>Forma de pagamento</label><br/>
                    <select id="parcela" name="parcela" required="required">
                    <?php
                        $i=1;
                        while($i<=10){ 
                            echo '<option value='.$i.'>'.$i.'X</option>';
                            $i++;  
                        }              
                    ?>
                    </select><br/>
                    <input type="hidden" id="layout" name="layout" value=<?php echo "'$layout'"; ?> />
                    <?php if($companie == 'rede clip'){
                        echo "<input id='font' type='hidden' name='font' value= 'clip' />";
                    }else{
                        echo "<input id='font' type='hidden' name='font' value= 'peimage' />";
                    }
                    ?>
                    <input id="submit" type="submit" value="Visualizar" />
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
