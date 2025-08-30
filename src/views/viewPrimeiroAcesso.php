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
            
            <title>Peimage - Primeiro acesso</title>
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
            <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
            <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">


            <style>
                #box-suport-fb{
                    margin-top: 15px;
                    margin-bottom: 15px;
                    background: #77bde0;
                    padding: 10px 0 10px 0;
                    text-align: center;
                    border: 2px solid #98d5f4;
                    text-align: justify;
                    padding: 0 12px 0 12px;
                    line-height: 1.4;
                }
                #box-suport-fb a{
                    font-size: 22px;
                    color: white;
                }

            </style>
        </head>
        <body>
            <?php //menu($logo, $imageMenu); ?>
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
                <form id="waterform" method="post" action="actionPrimeiroAcesso.php" enctype="multipart/form-data">
                    <?php
                    if(isset($_GET['msg'])){
                        echo '<div id="msg-error";> '.$_GET['msg'].'</div>';
                    }
                    ?>
                    <?php
                    if(($statusEmail == 0 && $cod_validacao == 0)){
                    ?>
                        <div id="box-suport-fb">
                        <p style="font-size:15px;text-shadow: 1px 1px 3px #3c3c3c;">
                        Nossa política de uso foi atualizada para aumentar sua segurança. Por favor, 
                        atualize seus dados de acesso ao sistema.
                        Não esqueça, após atualização do seu cadastro, utilize seus novos dados de login no próximo acesso ao Peimage.</p>
                        </div>
                        <label>E-mail</label> 
                        <input type="text"  placeholder="Digite seu novo e-mail de login" name="email1" value=''  pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" required="required" autocomplete="off"/><br/>
                        <input type="text"  placeholder="Repita seu novo e-mail de login" name="email2" value='' pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" required="required" autocomplete="off"/><br/> 

                        <label>Senha</label>
                        <input type="text" id="senha" maxlength="15" placeholder="Digite sua nova senha de login"  name="senha1" pattern="(?=.*[a-z]).{6,15}" value="" required="required" autocomplete="off"/>
                        <input type="text" id="senha" maxlength="15" value="" placeholder="Repita sua nova senha de login"  name="senha2" value=""  pattern="(?=.*[a-z]).{6,15}" required="required" autocomplete="off"/>
                        <div style="padding-left:7px;padding-right:1px;font-size:15px;text-shadow: 1px 1px 3px #3c3c3c;" >Sua senha deve conter pelo menos 6 caracteres com no mínimo um número e uma letra*</div> 
                        <input type="submit" style="margin-top: 5px;" value="Cadastrar" />

                    <?php
                    }else if($statusEmail == 1 && $cod_validacao == 0){?>
                    
                        <div id='box-suport-fb' style="padding: 5px;">
                        <label>Dados do Usuário</label>
                        </div>
                        <label>E-mail</label>
                        <input type='text'  id='name' placeholder='Digite seu e-mail' name='email1' value='<?=$email?>'  required='required' pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" readonly/><br/>
                        <input type='hidden'  placeholder='Digite seu e-mail novamente' name='email2' value='email' required='required' pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" autocomplete='off'/>
                        <label>Senha</label>
                        <input type="text" id="senha" maxlength="15" placeholder="Digite sua senha de login" value="" name="senha1" pattern="(?=.*[a-z]).{6,15}" value="" required="required" autocomplete="off"/>
                        <input type="text" id="senha" maxlength="15" placeholder="Digite sua senha de login novamente"  name="senha2" value=""  pattern="(?=.*[a-z]).{6,15}" required="required" autocomplete="off"/>
                        <div style="padding-left:7px;padding-right:1px;font-size:15px;text-shadow: 1px 1px 3px #3c3c3c;" >Sua senha deve conter pelo menos 6 caracteres com no mínimo um número e uma letra*</div> 
                        <input type="submit" style="margin-top: 5px;" value="Salvar" />

                    <?php
                    }else{
                        header('location: ../index.php');
                    }
                    ?>
                    <div id="box-suport-fb" style='text-align:center; padding:5px; text-shadow: 1px 1px 3px #3c3c3c;'>
                        <?php echo "<a href='$__HTTP_HOST/src/actionEmailMensagem.php'> Contatar suporte </a>"?>
                    </div>
                </form>
            </div>
        </body>
    </html>
