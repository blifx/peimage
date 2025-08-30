<?php

$logo = '../../images/logoPeimage.png';
$imageMenu = '../../images/menu.png';
$dirCompanie = '../../images/';
list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
include('../../config.php');

?>

<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">

        <title>Peimage - supporte</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css?v=2">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css?v=1">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>

        <style>
            form#waterform{
                margin-top: 25px;
            }
            .link{
                margin: 0 auto;
                width: 178px;
                padding-top: 10px;
            }
            .link a{
                text-decoration:none;
            }
            .link a:hover{
                text-decoration: underline;
            }
            .box-support img{
                width: 25px;
            }
            .box-support{
                background: #77bde0;
                padding: 10px;
                text-align: center;
                text-shadow: 1px 1px 3px #3c3c3c;
            }
            .box-support a{
                font-size: 15px;
                color: white;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }
            .item-support{
                display: flex;
                line-height: 2.5;
            }
            .item-support img {
                filter:invert(0.8);
                padding-right: 10px;
            }
            .item-support:hover img{
                filter:invert(0);
            }
        </style>
        
    </head>

</head>
    <body>

        <header>
            <div id="logoCompany">
                <img src="<?=$dirCompanie;?>logo.png" style="max-width:90%" />
            </div>
        </header>

        <div id="content">
            <div class="fish" id="fish"></div>
            <div class="fish" id="fish2"></div>
            <div class="fish" id="fish3"></div>
            <div class="fish" id="fish4"></div>
            <form id="waterform" method="post" action="actionLogin.php" enctype="multipart/form-data" >

                <div class="box-support" style="background: #77bde0; border-bottom: 1px solid white;">
                    Nossos canais de suporte (segunda a sexta das 09h às 17:30h)
                </div>

                <div class="box-support">

                    <div class="item-support">
                        <a href="https://api.whatsapp.com/send?phone=5551994837161">
                            <img src="<?=$__HTTP_HOST?>/images/whatsapp_white.png" />
                            WhatsApp
                        </a>
                    </div>

                    <div class="item-support">
                        <a href="https://messenger.com/t/peimage">
                            <img src="<?=$__HTTP_HOST?>/images/facebook_white.png" />
                            Facebook (Messenger)
                        </a>
                    </div>
                
                    <!--
                    <div class="item-support">
                        <a href="tel:5551994837161">
                            <img src="<?=$__HTTP_HOST?>/images/telephone_white.png" />
                            +55 51 994837161
                        </a>
                    </div>
					-->

                    <div class="item-support">
                        <a href="mailto:contato@peimage.com">
                            <img src="<?=$__HTTP_HOST?>/images/email_white.png" />
                            contato@peimage.com
                        </a>
                    </div>
                </div>

                <div class="link">
                    <a href="<?=$__HTTP_HOST?>">Ir para página inicial</a>            
                </div>

            </form>
        </div>
    </body>

</html>