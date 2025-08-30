<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    $campanha = strtolower($_GET['campanha']);
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    include('../config.php');

    function fileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}


?>


<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
        
        <title>Peimage - Outros Arquivos</title>
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/jquery.loadingModal.css">
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery.loadingModal.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/utils.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery.fileDownload.js"></script>

    <script>
        $(function(){

            if($(".checkbox").length == 0){
                $("#button,#title-header-form,#cabecalho").hide();
                $("#null-arquivos").show();
            }

            function getIdsSelected(){
                return $(".checkbox").map(function(){
                    return $(this).is(":checked") ? $(this).attr("id") : null;
                }).toArray();
            }

            $(".checkbox").click(function(){
                if($(".checkbox:checked").length > 0){
                    $(".download-tudo").html("Baixar selecionados");
                    $(".remover").html("Remover selecionados");
                } else {
                    $(".download-tudo").html("Baixar todos");
                    $(".remover").html("Remover todos");
                }
            });


            $(".download").click(function(){

                let act = "downloadAll";
                if($(".checkbox:checked").length > 0)
                    act = "downloadOutros";
                if($(this).attr("action") == "delete")
                    act = "remove";

                let ids = getIdsSelected();
                let requestUrl = __HTTP_HOST 
                    + "src/actionOutros.php?campanha="+getParamURL("campanha")
                    + "&act="+act
                    + "&nameCampanha="+getParamURL("nameCampanha").toLowerCase()
                    + "&ids=" + JSON.stringify(ids);
                   
                if(act != "remove" ){

                    $.fileDownload(
                        requestUrl, {
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

                } else {


                    let msg = "Tem certeza que deseja excluir todos arquivos?";
                    if(ids.length)
                        msg = "Tem certeza que deseja excluir os arquivos selecionados?";

                    if(confirm(msg)){  
                        $.ajax({
                            url: requestUrl,
                            dataType: 'text',
                        })
                        .done(function(result){
                            if(result == '1'){
                                alert("Exclusão realizada com sucessso.");
                                location.reload();
                            }else{
                                alert("Ocorreu algum problema, tente esta exclusão mais tarde");
                                location.reload();
                            }
                        });
                    }
 
                }

            });
        });
    </script>

    <style>
        .box {
            border-top: 1px solid #ffffff;
            left: 0;
            bottom: 0;
            display: flex;
        }

        .box:last-child {
            border-bottom:1px solid white;
        }

        input[type="checkbox"]{
            width: 20px !important;
            height: 20px;
        }

        .sub-box-layout {
            display: flex;
            align-items: center;
            color: rgb(97, 97, 97);
            cursor: pointer;
            margin: 0px auto;
            width:370px;
        }
        .sub-box-layout a{
            text-decoration:none;
            color:#616161
        }

        .download {
            display: flex;
            align-items: center;
            color: rgb(97, 97, 97);
            cursor: pointer;
            margin: 0px auto;
        }

        .sub-box-text {
            margin: 0;
            padding: 5px;
            outline: none;
            line-height: 2;
            text-align: right;
        }
        

        .download-tudo{
            height: 35px !important;
            padding: 0px !important;
            width: 100% !important;
            min-width: 160px;
            max-width: 500px;
            color: white;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px;
            cursor: pointer;
            background: #006064;
        } 

        #button{
            position: fixed;
            bottom: 0;
            background-color: #006064;
            height: 42px;
            width: 100%;
            z-index: 9999;
        }  

        #sub-button{
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            margin: 0 auto;
            z-index: 9999;
        }

        .btn{
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

        #null-arquivos{
            display:none;
            text-align: center;
            margin-top: 5%;
        }

        #cabecalho{
            left: 0;
            bottom: 0;
            display: flex;
            text-shadow: 1px 1px 2px #3c3c3c;
            font-size: 1.29em;
            padding: 2px;         
        }

        #nome-arquivo{
            display: flex;
            width: 364px;
            padding-left: 38px;
            padding-bottom: 2px;
        }

        #title-header-form{
            background-color:#77bde0;
            color: #FFF;
            text-align: center;
            height: 50px;
            font-size: 1.29em;
            margin-bottom:10px;
        }


    </style>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
        </div>
        </header>
        <div id="content" style="margin-top: 20px; padding-bottom: 50px;">
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>

            <div id="null-arquivos">Nenhum arquivo disponível.</div>   
            
            <form id="waterform" method="post" action="actionArquivos.php?act=tudo&campanha=<?php echo $campanha."&idcampanha=".$idcampanha; ?>" enctype="multipart/form-data" >
                <input id="title-header-form" type="text" name="campanha" required="required" value="<?php echo 'Arquivos '.ucwords($_GET['nameCampanha']); ?>" readonly/><br/>
                <div id="cabecalho">
                    <div id="nome-arquivo">Nome arquivo</div>
                    <div>Tamanho</div>
                </div>
                <?php
                    while($rowsCampanhaSelect=mysqli_fetch_array($queryArquivos)){
                        $arquivo = "../companies/{$_SESSION["nome"]}/campaigns/{$_GET["campanha"]}/files/outros/{$rowsCampanhaSelect["nome_arquivo"]}";

                        if(file_exists($arquivo)){

                            $nameArquivo = $rowsCampanhaSelect['nome_arquivo'];
                            $countName = strlen($nameArquivo);
                            

                            if($countName>35){
                                $lastChar = strrpos($nameArquivo,'.');
                                $countExt = $countName - $lastChar;
                                $ext = substr($nameArquivo, $lastChar-$countName);
                                $nameArquivo = substr($nameArquivo, 0, 35-$countExt );

                                $nameArquivo = $nameArquivo."...".$ext;
                            }
                                
                            echo "
                            <div class='box'>
                                <div class='sub-box-layout'>
                                <input class='checkbox' type='checkbox' id='".$rowsCampanhaSelect['idarquivos']."' >
                                        <div class='sub-box-text'>
                                            ".$nameArquivo."
                                        </div>
                                </div><br>
                                <div class='download' idlayout=".$rowsCampanhaSelect['idarquivos'].">
                                    <div class='sub-box-text'>
                                    <div style='width: 80px;'>".fileSizeConvert(filesize($arquivo))."</div>
                                    </div>
                                </div>
                            </div>
                        "; 



                        }
                    }
                    
                ?>
            </form>
                           
            <div id="button">
                <div id="sub-button">
                    <div class="download-tudo download btn" >
                        Baixar todos 
                    </div>
                    <?php if($_SESSION['tipo'] == "agencia" || $_SESSION['tipo'] == "admin"){?>
                            <div class='btn download remover' action='delete'>
                                Remover todos 
                            </div>
                    <?php } ?>

                </div>  
            </div>


    </body>
</html>