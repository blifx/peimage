<?php
if(!empty($_GET['layout'])){
    $idcampaign = $_GET['campanha'];
    $logo = '../../../images/logoPeimage.png';
    $imageMenu = '../../../images/menu.png';
    $typeThemes = 'cartaz';
    $dirCompanie = '../../../companies/'.$companie.'/';
    $layout = $_GET['namelayout'];
    $idlayout = $_GET['layout'];
    $caminhoLogo = $dirCompanie.'logo.png';



    $typeThemes = $_GET['namelayout'];
    $dirThemes = '../campaigns/'.$idcampaign.'/'.$typeThemes.'/';


    if(file_exists($dirCompanie.'logo.png')){
        list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    }

    include('../../../config.php');
?>

    <!DOCTYPE html>
    <html lang="pt-br" >
        <head>
            <meta charset="UTF-8">
            <meta name="format-detection" content="telephone=no">
            <meta name="msapplication-tap-highlight" content="no">
            <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
            
            <title>Peimage - Foto Real</title>
            <link rel="stylesheet" href="../../../css/dropzone.css" />
            <link rel="stylesheet" href="../../../css/style.css">
            <link rel="icon" href="../../../images/favicon.png" />
            <link rel="stylesheet" href="../../../css/menu.css">
            <link rel="stylesheet" type="text/css" href="../../../css/jcrop.css" />
            <script type="text/javascript" src="../../../js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" src="../../../js/dropzone.js"></script>
            <script type="text/javascript" src="../../../js/jquery.min.js"></script>
            <script type="text/javascript" src="../../../js/jquery.Jcrop.js"></script>

            <script>
                $(function(){
                    $("#tema").change(function(){
                        $("#img_theme img").attr("src", "<?php echo $dirThemes; ?>" + this.value);
                    });
                });
            </script>

<script type="text/javascript">


    var layout   = <?php echo $idlayout ?>;
    var usuario = <?php echo $idusuarios ?>;


    function getCoords(){
    var api;
    $('#toCrop').Jcrop({
    aspectRatio: 100,
    bgOpacity: 0.4,
    boxWidth: 540,   //Maximum width you want for your bigger images
      boxHeight: 960,  //Maximum Height for your bigger images

    addClass: 'jcrop-light',
    onSelect: updateCoords,
    onChange: updateCoords,
    setSelect: [0,0,540,960],
    aspectRatio: 10.8/19.2
    });
    }
 
    function updateCoords(c){
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
    };
 
    function _(element){
    if(document.getElementById(element))
    return document.getElementById(element);
    else
    return false;
    }
 
    function submitForm(){
        if(_('arquivo').files[0]){//Se houver um arquivo, faremos alguns testes no mesmo
            var arquivo = _('arquivo').files[0];
        if(arquivo.type != 'image/png' && arquivo.type != 'image/jpeg')
            _('result').innerHTML = 'Por favor, selecione uma imagem do tipo JPEG ou PNG';
        else if(arquivo.size > 1024 * 2048)//2MB
            _('result').innerHTML = 'Por favor selecione uma image mo máximo 2MB de tamanho.';
        else{
            var x = _('x').value;
            var y = _('y').value;
            var w = _('w').value;
            var h = _('h').value;
            var formData = new FormData();
            formData.append('arquivo', arquivo);
            formData.append('x', x);
            formData.append('y', y);
            formData.append('w', w);
            formData.append('h', h);
            if(_('imgType')){
                var imgType = _('imgType').value;
                formData.append('imgType', imgType);
            }
            if(_('imgName')){
                var imgName = _('imgName').value;
                formData.append('imgName', imgName);
            }

            if(_('titulo')){
                var titulo = $("#titulo").val();
                formData.append('titulo', titulo);
            }

            if(_('sub')){
                var sub = $("#sub").val();
                formData.append('sub', sub);
            }

            if(_('desc')){
                var desc = $("#desc").val();
                formData.append('desc', desc);
            }

            if(_('preco')){
                var preco = $("#preco").val();
                formData.append('preco', preco);
            }

            if(_('promo')){
                var promo  = $("#promo").val();
                formData.append('promo', promo);
            }

            if(_('parcela')){
                var parcela  = $("#parcela").val();
                formData.append('parcela', parcela);
            }

            if(_('font')){
                var font  = $("#font").val();
                formData.append('font', font);
            }

            if(_('namelayout')){
                var namelayout  = $("#namelayout").val();
                formData.append('namelayout', namelayout);
            }

            if(_('tema')){
                var tema  = $("#tema option:selected").attr("idtema");
                formData.append('tema', tema);

                var nametema  = $("#tema option:selected").val();
                formData.append('nametema', nametema);
            }



            if(_('campanha')){
                var campanha  = $("#campanha").val();
                formData.append('campanha', campanha);
            }


            var request  = new XMLHttpRequest();
            

            var includeFile = 'recebeFile.php';


            request.open('post', includeFile, true);

            request.onreadystatechange = function(){


                if(request.readyState == 4 && request.status == 200)
                    _('result').innerHTML = request.responseText;
                if(_('toCrop'))
                    //_('sendButton').value = 'Visualizar';
                    //window.open("../src/actionDownloads.php?download="+request.responseText+"&estilo=fotoReal'&usuario="+usuario+"&idlayout="+layout, "_blank");
                    console.log(request.responseText);
            }
            
            request.send(formData);
            //_('result').innerHTML = '<img src="loading.gif" />';
        }
        console.log(request.responseText);
        }
        else{
        alert('Por favor, selecione uma imagem para ser enviada!');
        }
    }



    function submitFormView(){

        if($("#titulo").val() == "" || $("#sub").val() == "" ||$("#desc").val() == "" || $("#preco").val() == "" || $("#promo").val() == ""){
            alert("Por favor, preencha todos os campos!")
            return;
        }

        var tema = $("#tema option:selected").attr("idtema");


        if(_('arquivo').files[0]){//Se houver um arquivo, faremos alguns testes no mesmo
            var arquivo = _('arquivo').files[0];
        if(arquivo.type != 'image/png' && arquivo.type != 'image/jpeg')
            _('result').innerHTML = 'Por favor, selecione uma imagem do tipo JPEG ou PNG';
        else if(arquivo.size > 1024 * 2048)//2MB
            _('result').innerHTML = 'Por favor selecione uma image mo máximo 2MB de tamanho.';
        else{
            var x = _('x').value;
            var y = _('y').value;
            var w = _('w').value;
            var h = _('h').value;
            var formData = new FormData();
            formData.append('arquivo', arquivo);
            formData.append('x', x);
            formData.append('y', y);
            formData.append('w', w);
            formData.append('h', h);
            if(_('imgType')){
                var imgType = _('imgType').value;
                formData.append('imgType', imgType);
            }
            if(_('imgName')){
                var imgName = _('imgName').value;
                formData.append('imgName', imgName);
            }


            if(_('titulo')){
                var titulo = $("#titulo").val();
                formData.append('titulo', titulo);
            }

            if(_('sub')){
                var sub = $("#sub").val();
                formData.append('sub', sub);
            }

            if(_('desc')){
                var desc = $("#desc").val();
                formData.append('desc', desc);
            }

            if(_('preco')){
                var preco = $("#preco").val();
                formData.append('preco', preco);
            }

            if(_('promo')){
                var promo  = $("#promo").val();
                formData.append('promo', promo);
            }

            if(_('parcela')){
                var parcela  = $("#parcela").val();
                formData.append('parcela', parcela);
            }

            if(_('font')){
                var font  = $("#font").val();
                formData.append('font', font);
            }

            if(_('namelayout')){
                var namelayout  = $("#namelayout").val();
                formData.append('namelayout', namelayout);
            }

            if(_('tema')){
                var tema  = $("#tema option:selected").attr("idtema");
                formData.append('tema', tema);

                var nametema  = $("#tema option:selected").val();
                formData.append('nametema', nametema);
            }

            if(_('campanha')){
                var campanha  = $("#campanha").val();
                formData.append('campanha', campanha);
            }


            var request  = new XMLHttpRequest();
            

            var includeFile = 'cropFile.php';


            request.open('post', includeFile, true);

            request.onreadystatechange = function(){


                if(request.readyState == 4 && request.status == 200)
                   // _('result').innerHTML = request.responseText;
                if(_('toCrop'))
                    //_('sendButton').value = 'Visualizar';
                    window.open("../../../src/actionDownloads.php?download="+request.responseText+"&estilo=fotoReal&usuario="+usuario+"&idlayout="+layout+"&tema="+tema, "_blank");
                    console.log(request.responseText);
            }
            
            request.send(formData);
           // _('result').innerHTML = '<img src="loading.gif" />';
        }
        console.log(request.responseText);
        }
        else{
            alert('Por favor, selecione uma imagem para ser enviada!');
        }
    }

    
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

            <?php 
        
        
            $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
            $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
            $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
            $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
            $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
            $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
            $symbian = strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
            $windowsphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");

            if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian || $windowsphone == true) {
                echo '<div class="box-support"  style="padding:10px;text-align:center;margin-top:100px;color:white;background: #77bde0;">
                    Este layout não está funcionando temporiamente em celulares. Por favor, acesse de um computador. 
                </div>'; 

            exit(1);
            }


            ?>
            
            <div id="content">
                <div class="fish" id="fish"></div>
                <div class="fish" id="fish2"></div>
                <div class="fish" id="fish3"></div>
                <div class="fish" id="fish4"></div>
                <form id="waterform" method="post" enctype="multipart/form-data" target="_blank">
                    <label>Título Produto*</label>
                    <input type="text" id="titulo" maxlength="17" name="titulo" required="required" /><br/>
                    <label>Subtítulo Produto*</label><br/>
                    <input id="sub" maxlength="17" name="sub"  required="required" /><br/>

                    <label>Descrição Produto*</label><br/>
                    <input id="desc" maxlength="20" name="desc" required="required" /><br/>


                    <label for="tema">Temas*</label><br>
                    <select id="tema" name="tema" required="required">
                    <?php 
                    $i=0;
                    $j=0;
                    while($row=mysqli_fetch_array($queryTemas)){
                        $i++;
                        if ($j==0){
                            $primaryTheme = $row['nome_arquivo'];
                            $j++;
                        }
                        if($i==1){
                            echo '<option idtema="'.$row['idtemas'].'" value="'.$row['nome_arquivo'].'"selected>Tema '.$i.'</option>'; 
                        }else{
                            echo '<option idtema="'.$row['idtemas'].'" value="'.$row['nome_arquivo'].'">Tema '.$i.'</option>';
                        }   

                    }
                    ?>
                    </select><br/>
                    <div id="img_theme">
                        <img src="<?php echo $dirThemes.$primaryTheme; ?>" width="126" height="180"/>
                    </div>



<!--                     <label>Foto</label><br>
                    <div id="uploads-file" class="dropzone upload message" ></div> -->

                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <label>Foto</label><br>
                    <input type="file" id="arquivo" />
                    <input onclick="submitForm();" type="button" id="sendButton" value="Enviar" />
                    <div style="margin-left:-20px;
                                padding-top:10px;
                                padding-bottom:10px;"
                                id="result">
                    </div>


<!--                     <label for="message">Girar Foto</label><br/>
                    <select id="rotacao" name="rotacao" required="required">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                    </select><br/> -->  
                    <label>Preço*</label>
                    <input type="text" id="preco" name="preco" maxlength="7" placeholder="ex: 149,90" required="required" value="" />
                    <label>Promoção</label> 
                    <input type="text" placeholder="ex: 99,90" maxlength="7" id="promo" name="promo" value="" /> 
                    <input type="hidden" id="namelayout" name="namelayout" value=<?php echo "'$layout'"; ?> />
                    <input type="hidden" id="campanha" name="campanha" value=<?php echo "'$idcampaign'"; ?> />
                    <?php if($companie == 'rede clip'){
                        echo "<input id='font' type='hidden' name='font' value= 'clip' />";
                    }else{
                        echo "<input id='font' type='hidden' name='font' value= 'peimage' />";
                    }
                    ?>
                    <input onclick="submitFormView();" type="button" id="sendButton" value="Visualizar" />
                    <!-- <input id="submit" type="submit" value="Visualizar" /> -->
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
