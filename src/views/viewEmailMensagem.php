<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $typeThemes = 'cartaz';
    $dirCompanie = '../companies/'.$companie.'/';
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
            
            <title>Peimage - Suporte técnico</title>
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
            <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">

            <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>

            <style>

                form#waterform{
                    margin-top: 25px;
                }

                #box-suport-fb{
                    margin-top: 15px;
                    margin-bottom: 15px;
                    background: #77bde0;
                    padding: 10px 0 10px 0;
                    text-align: center;
                    border: 2px solid #98d5f4;
                }
                #box-suport-fb a{
                    font-size: 1.29em;
                    color: white;
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
                .item-support:hover a{
                    text-decoration: underline;
                }
                fieldset {
                    border: 1px solid #2195a0;
                    padding: 10px;
                    margin-top: 10px;
                    box-shadow: 5px 5px 0px 0px #8cc5e2;
                }
                legend {
                    color: white;
                    text-shadow: 1px 1px 2px #3c3c3c;
                    font-size: 20px;
                }
            </style>
            
            <script>
                $(function(){
                    $("#enviar").click(function(){
                        $.ajax({
                            type: "POST",
                            dataType: "text",
                            url: "<?=$__HTTP_HOST;?>" + "/src/actionEmailMensagem.php",
                            data: {
                                assunto : $("#assunto").val(),
                                nome : $("#nome").val(),
                                email : $("#email").val(),
                                mensagem : $("#mensagem").val()
                            },
                            success: function(response){
                                if(response == 1){
                                    alert("Mensagem enviada com sucesso, em breve entraremos em contato.");
                                    $("#waterform")[0].reset();
                                } else {
                                    alert("Houve um erro ao enviar sua mensagem.");
                                }
                            },
                            fail: function(){
                                alert("Ops, ocorreu algum erro. Verifique sua conexão com a internet.");
                            }
                        });
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
                        echo "<img src='{$caminhoLogo}' style='max-width:{$largura}px' />";
                    } else {
                        echo "<h1><a href='src/actionPerfil.php'>Clique aqui para adicionar seu logo</a></h1>";
                    }
                ?>
                </div>
            </header>

            <div id="content" autocomplete="off">

                <div class="fish" id="fish"></div>
                <div class="fish" id="fish2"></div>
                <div class="fish" id="fish3"></div>
                <div class="fish" id="fish4"></div>

                <form id="waterform">


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

                    <fieldset style="margin-top:10px">
                        <legend>Se preferir deixe sua mensagem abaixo</legend>
                    
                        <label>Tipo de mensagem*</label>
                        <select id="assunto" name="assunto" required="required">
                            <option value="sugestao">Sugestão</option>
                            <option value="reclamacao">Reclamação</option>
                            <option value="suporte">Suporte</option>
                        </select>
                        
                        <label>Nome*</label>
                        <input type="text" maxlength="32" id="nome" name="nome" required="required" /><br/>
                        
                        <label>E-mail*</label>
                        <input type="email" maxlength="50" id="email" name="email" required="required" /><br/>
                        
                        <label>Mensagem*</label>
                        <textarea step="any" id="mensagem" maxlength="300" name="mensagem"></textarea>
                        
                        <input id="enviar" type="button" value="Enviar" />

                    </fieldset>
                </form>

            </div>
        </body>
    </html>
