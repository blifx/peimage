<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    $campanha = strtolower($_GET['campanha']);
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
        
        <title>Peimage - Arquivos</title>
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

            
            __HTTP_HOST ="<?php echo $__HTTP_HOST; ?>/";

            console.log(__HTTP_HOST)

            $(".box").first().css("border-top", "1px solid white");

            $(".download").click(function(){

                let act = $(this).attr("action");
                let requestUrl = __HTTP_HOST 
                    + "src/actionArquivos.php?idcampanha="+getParamURL("idcampanha")
                    + "&act="+act
                    + "&campanha="+getParamURL("idcampanha").toLowerCase();

                if(act == "downloadLayouts"){
                    requestUrl += "&idlayout="+$(this).attr("idlayout")
                        +"&layout="+$(this).attr("nameLayout").toLowerCase();
                }
                
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

            });
        });
    </script>

    <style>
        .box {
            border-bottom: 1px solid #ffffff;
            left: 0;
            bottom: 0;
            display: flex;
        }

        #title-header-form{
            background-color:#77bde0;
            color: #FFF;
            margin-bottom: 10px;
            margin-top: 20px;
            text-align: center;
            height: 50px;
            font-size: 1.29em;
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
        }
        
        .sub-box-text:hover{
            color:#FFF;
            text-shadow: 1px 1px 2px #3c3c3c;
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

        #btn{
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


    </style>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
        </div>
        </header>
        <div id="content" style="padding-bottom: 80px; padding-bottom: 80px;">
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>

            <form id="waterform" method="post" action="actionArquivos.php?act=tudo&campanha=<?php echo $campanha."&idcampanha=".$idcampanha; ?>" enctype="multipart/form-data" >
                <input id="title-header-form" type="text" name="campanha" required="required" value="<?php echo 'Arquivos '.$_GET['campanha']; ?>" readonly/><br/>

                <?php
                    while($rowsCampanhaSelect=mysqli_fetch_array($queryLayouts)){
                        if($rowsCampanhaSelect['idlayouts'] == NULL){
                            $action = 'action="downloadOutros"';
                            $actionLink = $__HTTP_HOST."/src/actionOutros.php?nameCampanha=".strtolower($_GET['campanha'])."&";
                        } else {
                            $action = 'action="downloadLayouts" nameLayout="'.$rowsCampanhaSelect['layout'].'"';
                            $actionLink = $__HTTP_HOST."/src/actionGaleria.php?";
                        }
                        

                        echo "
                            <div class='box'>

                                <div class='sub-box-layout'>
                                    <img style='filter: invert(1);' src='$__HTTP_HOST/images/lupa.png' height=20>
                                    <a href='".$actionLink."campanha=$idcampanha&layout=".$rowsCampanhaSelect['idlayouts']."'> 
                                        <div class='sub-box-text'>
                                            ".ucfirst($rowsCampanhaSelect['layout'])."
                                        </div>
                                    </a>
                                </div>
                    
                                <div class='download' ".$action." idlayout=".$rowsCampanhaSelect['idlayouts'].">
                                    <img src='$__HTTP_HOST/images/download.png' height=20>
                                    <div class='sub-box-text'>
                                        Baixar
                                    </div>
                                </div>
                            
                            </div>
                        ";
                    }
                ?>
            </form>
            <div id="button">
                <div id="sub-button">
                    <div class="download-tudo download" id="btn" action="downloadAll">
                        Baixar todos arquivos
                    </div>
                </div>  
            </div>

    </body>
</html>