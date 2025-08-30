<?php
if(!empty($_POST)){
$tema = $_POST['tema'];



function hex2RGB($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
}


//string json
//agora o primeiro empregado possui dependentes e os outros não.
//também foi acrescentado um campo denominado "data", contendo a data do arquivo de empregados


//faz o parsing da string, criando o array "empregados"



switch ($companie) {
    case "peimage":
        $json_str = '{
            "tema3":
            [
                {
                    "titulo":"#363636", "subtitulo":"#363636", "desc":"#6959CD", "preco": "#363636", "precoPromo": "#363636", "promo": "#D33438", "linha": "#363636", "linhaDesc": "#D33438", "fundoPromo": "#D33438", "fundoRet": "#FFF"                                             
                }
            ],
            "tema1":
                [
                    {
                        "titulo":"#363636", "subtitulo":"#363636", "desc":"#6959CD", "preco": "#FFF", "precoPromo": "#363636", "promo": "#FFF", "linha": "#363636", "linhaDesc": "#D33438", "fundoPromo": "#D33438", "fundoRet": "#FFF"                                                   
                    }
                ],
            "tema2":
                [
                    {
                        "titulo":"#363636", "subtitulo":"#363636", "desc":"#4F4F4F", "preco": "#363636", "precoPromo": "#CD2626", "promo": "#000", "linha": "#363636", "linhaDesc": "#CD2626", "fundoPromo": "#CD2626", "fundoRet": "#FFF"                                             
                    }
                ]

        }';

        break;
    case "rede clip":
        $json_str = '{
            "tema3":
            [
                {
                    "titulo":"#363636", "subtitulo":"#363636", "desc":"#6959CD", "preco": "#363636", "precoPromo": "#363636", "promo": "#CD2626", "linha": "#363636", "linhaDesc": "#CD2626", "fundoPromo": "#CD2626", "fundoRet": "#FFF"                                             
                }
            ],
            "tema1":
                [
                    {
                        "titulo":"#363636", "subtitulo":"#363636", "desc":"#6959CD", "preco": "#FFF", "precoPromo": "#363636", "promo": "#FFF", "linha": "#363636", "linhaDesc": "#CD2626", "fundoPromo": "#CD2626", "fundoRet": "#FFF"                                                   
                    }
                ],
            "tema2":
                [
                    {
                     "titulo":"#000", "subtitulo":"#000", "desc":"#4F4F4F", "preco": "#CD2626", "precoPromo": "#CD2626", "promo": "#000", "linha": "#000", "linhaDesc": "#CD2626", "fundoPromo": "#CD2626", "fundoRet": "#FFF"                                              
                    }
                ]

        }';

        break;
    case "Muita Coisa Comercio de Utilidades Ltda":
        $json_str = '{
            "tema3":
            [
                {
                    "titulo":"#000", "subtitulo":"#000", "desc":"#A9A4A6", "preco": "#000", "precoPromo": "#000", "promo": "#EC3236", "linha": "#000", "linhaDesc": "#EC3236", "fundoPromo": "#EC3236", "fundoRet": "#FFF"                                              
                }
            ],
            "tema1":
                [
                    {
                        "titulo":"#000", "subtitulo":"#000", "desc":"#A9A4A6", "preco": "#FFF", "precoPromo": "#000", "promo": "#FFF", "linha": "#000", "linhaDesc": "#EC3236", "fundoPromo": "#EC3236", "fundoRet": "#FFF"                                                    
                    }
                ],
            "tema2":
                [
                    {
                        "titulo":"#000", "subtitulo":"#000", "desc":"#A9A4A6", "preco": "#EC3236", "precoPromo": "#000", "promo": "#EC3236", "linha": "#000", "linhaDesc": "#EC3236", "fundoPromo": "#EC3236", "fundoRet": "#FFF"                                              
                    }
                ]

        }';
        break;
    case "rede paper":
        $json_str = '{
            "tema3":
            [
                {
                    "titulo":"#363636", "subtitulo":"#363636", "desc":"#4F4F4F", "preco": "#363636", "precoPromo": "#363636", "promo": "#006BB5", "linha": "#FFDE21", "linhaDesc": "#006BB5", "fundoPromo": "#CD2626", "fundoRet": "#FFF"                                              
                }
            ],
            "tema1":
                [
                    {
                        "titulo":"#363636", "subtitulo":"#363636", "desc":"#4F4F4F", "preco": "#FFF", "precoPromo": "#363636", "promo": "#006BB5", "linha": "#363636", "linhaDesc": "#006BB5", "fundoPromo": "#FFDE21", "fundoRet": "#FFF"                                                   
                    }
                ],
            "tema2":
                [
                    {
                        "titulo":"#363636", "subtitulo":"#363636", "desc":"#4F4F4F", "preco": "#006BB5", "precoPromo": "#363636", "promo": "#006BB5", "linha": "#363636", "linhaDesc": "#006BB5", "fundoPromo": "#CD2626", "fundoRet": "#FFDE21"                                              
                    }
                ]

        }';


        break;
}
$jsonObj = json_decode($json_str);

switch ($tema) {
    case "1":
        $tema = $jsonObj->tema1;
        break;
    case "2":
        $tema = $jsonObj->tema2;
        break;
    case "3":
        $tema = $jsonObj->tema3;
        break;
}


foreach ( $tema as $e )
{
    $corTitulo = $e->titulo;
    $corTitulo = hex2RGB($corTitulo);

    $corSubtitulo = $e->subtitulo;
    $corSubtitulo = hex2RGB($corSubtitulo);

    $corDesc = $e->desc;
    $corDesc = hex2RGB($corDesc);

    $corPreco = $e->preco;
    $corPreco = hex2RGB($corPreco);

    $corPrecoPromo = $e->precoPromo;
    $corPrecoPromo = hex2RGB($corPrecoPromo);

    $corPromo = $e->promo;
    $corPromo = hex2RGB($corPromo);

    $corLinha = $e->linha;
    $corLinha = hex2RGB($corLinha);

    $corLinhaDesc = $e->linhaDesc;
    $corLinhaDesc = hex2RGB($corLinhaDesc);

    $corFundoPromo = $e->fundoPromo;
    $corFundoPromo = hex2RGB($corFundoPromo);

    $corFundoRet = $e->fundoRet;
    $corFundoRet = hex2RGB($corFundoRet);


}


/*--------------------------------------------------------------------------Produto 1-------------------------------------------------------------------------*/ 
    $titulo = $_POST['titulo'];
    if(isset($_POST['subtitulo']))
        $subtitulo = $_POST['subtitulo'];
    $desc = $_POST['desc'];
    $plogo = $_POST['plogo'];
    $origens  = array(',', 'R$');
    $destinos = array('.', '');
    $preco = (float)str_replace($origens,$destinos,$_POST['preco']);
    $promo = (float)str_replace($origens,$destinos,$_POST['promo']);
    $observacao = $_POST['obs'];
    $dirCompanie = '../companies/'.$companie.'/';
    $fonte = $_POST['font'];
    $rotacao = $_POST['rotacao']; 
    $move_x = (float)$_POST['horizontalProduct']*37.795275590551;
    $move_y = (float)$_POST['verticalProduct']*37.795275590551;
    $plogo_hor = $_POST['plogo_hor'];
    $tema = $_POST['tema'];
    $parcela = $_POST['parcela'];


    //$preco = number_format($preco, 2, ',', ' ');
    //$preco = str_replace(' ', '', $preco);

    if(!empty($promo)){
        $total = $promo; 
        $promo = $promo/$parcela;    
        $promo = number_format($promo, 2, ',', ' ');
        $total = number_format($total, 2, ',', ' ');
    }else{
        $total = $preco;
        $preco = $preco/$parcela; 
        
    }
    $preco = str_replace(' ', '', $preco);
    $preco = number_format($preco, 2, ',', ' ');


    //$preco = number_format($preco, 2, ',', ' ');
    //$preco = str_replace(' ', '', $preco);


/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/ 

/*--------------------------------------------------------------------------Produto 2-------------------------------------------------------------------------*/ 
$produto2 = 0;
if(($_POST['titulo2'] && $_POST['preco2']) <> ""){
    $produto2 = 1;
    $titulo2 = $_POST['titulo2'];
    $origens  = array(',', 'R$');
    $destinos = array('.', '');
    $preco2 = (float)str_replace($origens,$destinos,$_POST['preco2']);
    $promo2 = (float)str_replace($origens,$destinos,$_POST['promo2']);
    $move_x2 = (float)$_POST['horizontalProduct2']*37.795275590551;
    $move_y2 = (float)$_POST['verticalProduct2']*37.795275590551;
    $parcela2 = $_POST['parcela2'];
    

    //$preco2 = number_format($preco2, 2, ',', ' ');
    //$preco2 = str_replace(' ', '', $preco2);
    
    if(!empty($promo2)){
        $total2 = $promo2; 
        $promo2 = $promo2/$parcela2;    
        $promo2 = number_format($promo2, 2, ',', ' ');
        $total2 = number_format($total2, 2, ',', ' ');
    }else{
        $total2 = $preco2;
        $preco2 = $preco2/$parcela2;
        $preco2 = number_format($preco2, 2, ',', ' ');
    }
}
$preco2 = str_replace(' ', '', $preco2);
$preco2 = number_format($preco2, 2, ',', ' ');

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    if($fonte == 'peimage'){
        $font = __DIR__.'/../../fonts/helveticaregular.otf';
        $fontBold = __DIR__.'/../../fonts/helveticaeb.otf';  

    }else{
        /*Carrega fontes*/
        $font = __DIR__.'/../../fonts/calibri.ttf';
        $fontBold = __DIR__.'/../../fonts/calibrib.ttf'; 
    }

    $promocao = 'on';
    $promocao2 = 'on';
    if($promo == ''){
        $promocao = 'off'; 
    }
    if($promo2 == ''){
        $promocao2 = 'off'; 
    }




    $productState = 'sem imagem';

    /*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $dirCompanie = '../companies/'.$companie.'/';
    $new_name = uniqid(rand(), true); 
    $ext = strtolower(substr($_FILES['fileUpload']['name'],-4));
    if($_FILES['fileUpload']['size'] != 0)
    {
        $productState = 'com imagem';
        /*Faz o upload da imagem do produto*/
        $dir = $dirCompanie.'uploads/'; //Diretório para uploads
        move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name.$ext); //Fazer upload do arquivo
    }
    $dirImage = $dirCompanie."uploads/".$new_name.$ext;
    list($width, $height, $type, $attr) = getimagesize($dirImage); 

    if($type == 2){
        imagepng(imagecreatefromjpeg($dirImage),$dirImage);
        $myImage = imagecreatefrompng($dirImage);
    }else if($type == 3){
        $myImage = imagecreatefrompng($dirImage);
    }else{
        echo "formato de imagem incorreto";
    }



    $imgRed = imagecreate(24,200);
    imagecolorallocate($imgRed, $corFundoPromo[0], $corFundoPromo[1], $corFundoPromo[2] );





    $imgLogo = WideImage::load($dirCompanie.'logo_pequeno.png');
    // Redimensiona a imagem
    $imgLogo = $imgLogo->resize(220,100);
    $dirLogo=$dirCompanie."uploads/".$new_name.'234.png';
    $imgLogo->saveToFile($dirLogo);
    $imgLogo = imagecreatefrompng($dirLogo); 
    list($width_logo, $height_logo) = getimagesize($dirLogo);


    $new_name = uniqid(rand(), true); 


    $margin = 20;//margin do logo   
    
    if($width > $height)
    {
        $sizeImagePhoto = 1000;
        if($plogo_hor == 'esquerda'){
            $horizontal=20;
        }else{

            $horizontal=750-$width_logo-$margin;
        }

        $imgPhoto=imagecreatetruecolor(1000, 750);
        $black = imagecolorallocate($imgPhoto, 0, 0, 0);
        imagecopyresampled($imgPhoto,$myImage,0,0,0,0,1000,750,$width, $height);
        $imgPhoto = imagerotate ($imgPhoto , -90 , 0 );
        if($plogo == 'inferior'){
            imagecopy($imgPhoto, $imgLogo, $horizontal, 1000-$height_logo-$margin, 0, 0, $width_logo, $height_logo);
        }
        else{
            imagecopy($imgPhoto, $imgLogo, $horizontal, $margin, 0, 0, $width_logo, $height_logo);
        }
        $sizePhoto = 'width';
        if ($observacao != "") 
        {
            $obsText = imagettfbbox ( 14, 0, $font, $observacao );
            $obsText_ = $obsText[2];
            $obsText = 15;
            $whiteObs = imagecolorallocate($imgPhoto, 255, 255, 255);
            ImageFilledRectangle($imgPhoto, 10, 962, $obsText_+20, 982, $whiteObs); 
            imagettftext($imgPhoto, 14, 0, $obsText, 978, $black, $font, $observacao);
        }
    }
    else if($width < $height)
    {   
        $sizeImagePhoto = 750;
        if($plogo_hor == 'esquerda'){
            $horizontal=20;
        }else{

            $horizontal=750-$width_logo-$margin;
        }
        $imgPhoto=imagecreatetruecolor(750, 1000);
        $black = imagecolorallocate($imgPhoto, 0, 0, 0);
        imagecopyresampled($imgPhoto,$myImage,0,0,0,0,750,1000,$width, $height);
        if($plogo == 'inferior'){
            imagecopy($imgPhoto, $imgLogo, $horizontal, 1000-$height_logo-$margin, 0, 0, $width_logo, $height_logo);
        }
        else{
            imagecopy($imgPhoto, $imgLogo, $horizontal, $margin, 0, 0, $width_logo, $height_logo);
        }
        $sizePhoto = 'height';
        if ($observacao != "") 
        {
            $obsText = imagettfbbox ( 14, 0, $font, $observacao );
            $obsText_ = $obsText[2];
            $obsText = 15;
            $whiteObs = imagecolorallocate($imgPhoto, 255, 255, 255);
            ImageFilledRectangle($imgPhoto, 10, 962, $obsText_+20, 982, $whiteObs); 
            imagettftext($imgPhoto, 14, 0, $obsText, 978, $black, $font, $observacao);
        }
    }
    else if($width == $height)
    {
        $sizeImagePhoto = 1000;
        if($plogo_hor == 'esquerda'){
            $horizontal=20;
        }else{
            $horizontal=1000-$width_logo-$margin;
        }
        $imgPhoto=imagecreatetruecolor(1000, 1000);
        $black = imagecolorallocate($imgPhoto, 0, 0, 0);
        imagecopyresampled($imgPhoto,$myImage,0,0,0,0,1000,1000,$width, $height);
      if($rotacao == 'off'){
        $imgPhoto = imagerotate ($imgPhoto , -90 , 0 );
      }
        if($plogo == 'inferior'){
            imagecopy($imgPhoto, $imgLogo, $horizontal, 1000-$height_logo-$margin, 0, 0, $width_logo, $height_logo);
        }
        else{
            imagecopy($imgPhoto, $imgLogo, $horizontal, $margin, 0, 0, $width_logo, $height_logo);
        }
        $sizePhoto = 'equal';
        if ($observacao != "")
        {
            $obsText = imagettfbbox ( 14, 0, $font, $observacao );
            $obsText_ = $obsText[2];
            $obsText = 15;
            $whiteObs = imagecolorallocate($imgPhoto, 255, 255, 255);
            $black = imagecolorallocate($imgPhoto, 0, 0, 0);
            ImageFilledRectangle($imgPhoto, 10, 962, $obsText_+20, 982, $whiteObs); 
            imagettftext($imgPhoto, 14, 0, $obsText, 978, $black, $font, $observacao);
        }
    }

    //Envia para pagian de download quando a imagem estiver criada
    header('Location: ../src/actionDownloads.php?download='.$new_name.'&estilo=photo&size='.$sizePhoto.'&usuario='.$idusuarios.'&idlayout='.$idlayout);
    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgPhoto, 255, 255, 255);
    $white1 = imagecolorallocate($imgPhoto, 255, 255, 255);
    $cinza = imagecolorallocate($imgPhoto, 162, 156, 158);
    $amarelo = imagecolorallocate($imgPhoto, 255, 203, 41);



    $corTitulo = imagecolorallocate($imgPhoto, $corTitulo[0], $corTitulo[1], $corTitulo[2]);
    $corSubtitulo = imagecolorallocate($imgPhoto, $corSubtitulo[0], $corSubtitulo[1], $corSubtitulo[2]);
    $corDesc = imagecolorallocate($imgPhoto, $corDesc[0], $corDesc[1], $corDesc[2]);
    $corPreco = imagecolorallocate($imgPhoto, $corPreco[0], $corPreco[1], $corPreco[2]);
    $corPrecoPromo = imagecolorallocate($imgPhoto, $corPrecoPromo[0], $corPrecoPromo[1], $corPrecoPromo[2]);
    $corPromo = imagecolorallocate($imgPhoto, $corPromo[0], $corPromo[1], $corPromo[2]);



    $imgWhite = imagecreate(500,400);
    imagecolorallocate($imgWhite, $corFundoRet[0], $corFundoRet[1], $corFundoRet[2]);



    //$red = imagecolorallocate($imgPhoto, 214, 27, 12);
    $imgAnuncio = imagecreate(460,90);
    $colorEmpresa = explode(',', $colorEmpresa);  //cor tema da empresa
    imagecolorallocate($imgAnuncio,  $corFundoPromo[0], $corFundoPromo[1], $corFundoPromo[2]);
    $imgRed = $imgAnuncio;
    $color = imagecolorallocate($imgPhoto,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]); 
    $textPromo = imagecolorallocate($imgPhoto, $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    if($companie == 'rede paper'){
        $textPromo = imagecolorallocate($imgPhoto, 0, 107, 181);
    }
    

    switch ($tema) {
        case "1":
            include 'temasFoto/tema2.php';
            break;
        case "2":
            include 'temasFoto/tema1.php';
            break;
        case "3":
            include 'temasFoto/tema3.php';
            break;
    }

    /**Cria a imagem final*/
    $finalImage = $dirCompanie.'downloads/'.$new_name.'.png';
    imagepng($imgPhoto, $finalImage, 0);
    /**Limpa a memoria*/
    imagedestroy($imgPhoto);
}
?>