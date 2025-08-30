<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    include('../config.php');
?>

<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
        
        <title>Peimage - Campanhas</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#layout").change(function(){
                    var __HTTP_HOST = <?php $__HTTP_HOST ?>
                    $.ajax({
                        type: "GET",
                        url: __HTTP_HOST+"/../models/modelCrudLayout.php",
                        data:{
                            act:"atualizaLayout",
                            layout:$('#layout').val()
                        },
                        timeout:10000,
                        dataType:'json'
                    })
                    .done(function(json){
                        for(var i in json){
                            $('#nomeLayout').val(json[i].nome);
                            $('#largura_layout').val(json[i].largura);
                            $('#altura_layout').val(json[i].altura);
                            $('#nomeArquivoLayout').val(json[i].arquivo);

                            if(json[i].status_campanha == 0){
                                $("#status_campanha option[value='0']").prop('selected', 'selected');
                                $('#dimensoes').hide();
                                $('#altura_layout').removeAttr('required');
                                $('#largura_layout').removeAttr('required');
                            }else{
                                $("#status_campanha option[value='1']").prop('selected', 'selected');
                                $('#altura_layout').attr('required', 'required');
                                $('#largura_layout').attr('required','required');
                                $('#dimensoes').show();
                            }

                            if(json[i].utilizacao == 'postavel'){
                                $("#utilizacao_layout option[value='postavel']").prop('selected', 'selected');
                            }else if(json[i].utilizacao == 'download'){
                                $("#utilizacao_layout option[value='download']").prop('selected', 'selected');
                            }else if(json[i].utilizacao == 'sem_restricao'){
                                $("#utilizacao_layout option[value='sem_restricao']").prop('selected', 'selected');
                            }
                        }         
                    })
                    .fail(function(){
                        alert("Ops, algo deu errado, tente novamente mais tarde");
                    });
                });
                
                $("#status_campanha").change(function(){
                    if($('#status_campanha').val() == '1'){
                        $('#dimensoes').show();
                        $('#altura_layout').attr('required', 'required');
                        $('#largura_layout').attr('required','required');
                    }else if($('#status_campanha').val() == '0'){
                        $('#dimensoes').hide();
                        $('#altura_layout').val('');
                        $('#largura_layout').val('');
                        $('#altura_layout').removeAttr('required');
                        $('#largura_layout').removeAttr('required');
                    } 
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

            <form id="waterform" method="post" action="actionCrudLayout.php" enctype="multipart/form-data" >
            <?php
            if(isset($_GET['msg'])){
                echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
            }
            ?>
                <label for="Estilo">Seleção de layouts</label><br>
                <select id="layout" name="idLayout" required="required">
                    <?php
                    while($row=mysqli_fetch_array($queryLayouts)){                     
                        echo '<option value="'.$row['idlayouts'].'">'.ucwords($row['nome']).'</option>';
                    }
                    ?>
                </select><br/> 
                    <label >Nome Layout*</label>
                    <input type="text" id="nomeLayout" value="<?php echo ucwords($rowInit['nome']); ?>" name="nomeLayout" required="required" maxlength="50"/><br/>
                    <div id="dimensoes" <?php echo $rowInit['status_campanha'] == '0' ? "style='display:none'" : "";?>>
                        <label>Largura(px)*</label>
                        <input type="text" id="largura_layout" value="<?php echo $rowInit['largura'] ?>" <?php echo $rowInit['status_campanha'] == '1' ? "required='required'" : "";?> maxlength="4" name="largura_layout" value="" />
                        <label>Altura(px)*</label>
                        <input type="text" id="altura_layout" value="<?php echo $rowInit['altura'] ?>" id="name" maxlength="4" name="altura_layout" <?php echo $rowInit['status_campanha'] == '1' ? "required='required'" : "";?> value="" />
                    </div>
                    <label for="Estilo">Participa de campanhas</label><br>
                    <select id="status_campanha" name="status_campanha" required="required">
                        <option value="0" <?php echo $rowInit['status_campanha'] == '0' ? "selected='selected'" : "";?>>Não</option>
                        <option value="1" <?php echo $rowInit['status_campanha'] == '1'? "selected='selected'" : "";?>>Sim</option>>
                    </select><br/>
                    <label >Nome arquivo*</label>
                    <input type="text" value="<?php echo $rowInit['arquivo'] ?>" id="nomeArquivoLayout" name="nomeArquivoLayout" required="required" maxlength="50"/><br/>
                    <input type="submit" value="Salvar" name="Salvar" />
                    <input style="margin-top:5px" type="submit" value="Excluir" name="Excluir" />
            
            </form>
        </div>
    </body>
</html>