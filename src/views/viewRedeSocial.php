<?php

    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    $dirLogo = '../companies/'.$companie.'/';
    list($largura, $altura) = getimagesize($dirLogo.'logo.png');
    include('../config.php');     
?>

<!DOCTYPE html>
<html lang="pt-br" >

    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - Redes sociais</title>
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png">

        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/jquery.loadingModal.css">
        
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery.loadingModal.js"></script>
        <script type="text/javascript" src="../js/save-config-fb.js?v=1"></script>

        <script>
            var __DATA_FB = {
                session_user:'<?=$_SESSION["fb_uid_usuario"]?>',
                /*id_album:'<?=$_SESSION["fb_id_album"]?>',
                id_page:'<?=$_SESSION["fb_id_pagina"]?>',*/
                stateFB: '',
				userId: null,
				pages: {} 
				//pages[id_page] : {name:str, token:str, permission:[], id_album_timeline:int} 
            };
        </script>

        <style>

            #fb-login-button, #fb-logout-button{
                display:none;
            }
            .fb-button{
                background-color: white;
                letter-spacing: .25px;
                text-align: center;
                margin-top: 10px;
                cursor: pointer;
                width: 100%!important;
                outline: none;
                padding: 5px;
                font-family: 'Sniglet', cursive;
                font-size: 1em;
                color: #676767;
                border: solid 3px #98d4f3;
                transition: border 0.5s;
                -webkit-transition: border 0.5s;
                -moz-transition: border 0.5s;
                -o-transition: border 0.5s;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                height: 48px;
            }
            .fb-button img{
                float: left;
                width: 32px;
            }
            .fb-content{
                padding-top: 7px;
                margin-right: 32px;
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

    <div id="content" style="padding-bottom: 120px;">
        <div class="fish" id="fish"></div>
        <div class="fish" id="fish2"></div>
        <div class="fish" id="fish3"></div>
        <div class="fish" id="fish4"></div>

        <form id="waterform" >

            <div id="fb-login-button" class="fb-button">
                <img src="../images/facebook.png"/>
                <div class="fb-content">Entrar com o Facebook</div>
            </div>

            <div id="fb-logout-button" class="fb-button">
                <img src="../images/facebook.png"/>
                <div class="fb-content">Sair do Facebook</div>
            </div>

            <div id="config-fb" style="display:none">

                <label>Página</label>
                <select id="pages-manage-fb">
                    <option value="" disabled>Página que realizará suas postagens</option>
                </select>
<!--
                <br />
                <label>Álbum</label>
                <select id="albuns-page-fb">
                    <option value="" disabled>Álbum que suas postagens serão salvas</option>
                </select>
-->
                <div style="color:#373435; display:none" id="msg-error"></div>

                <br />
                <input id="save-config" type="button" value="Salvar configuração">

            </div>

        </form>

    </div>
</body>
</html>