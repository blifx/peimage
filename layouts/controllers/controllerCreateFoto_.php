<?php
if(!empty($_POST)){
    $titulo = $_POST['titulo'];
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


    $preco = number_format($preco, 2, ',', ' ');
    if(!empty($promo)){
    $promo = number_format($promo, 2, ',', ' ');
    }

    if($fonte == 'peimage'){
        $font = __DIR__.'/../../fonts/helveticaregular.otf';
        $fontBold = __DIR__.'/../../fonts/helveticaeb.otf';  

    }else{
        /*Carrega fontes*/
        $font = __DIR__.'/../../fonts/calibri.ttf';
        $fontBold = __DIR__.'/../../fonts/calibrib.ttf'; 
    }

    $promocao = 'on';
    if($promo == ''){
        $promocao = 'off'; 
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
    $imgWhite = imagecreate(500,400);
    imagecolorallocate($imgWhite, 255, 255, 255);

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
        if($plogo_hor == 'esquerda'){
            $horizontal=20;
        }else{

            $horizontal=750-$width_logo-$margin;
        }

        $imgPhoto=imagecreatetruecolor(1000, 750);
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
        
        if($plogo_hor == 'esquerda'){
            $horizontal=20;
        }else{

            $horizontal=750-$width_logo-$margin;
        }
        $imgPhoto=imagecreatetruecolor(750, 1000);
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
        if($plogo_hor == 'esquerda'){
            $horizontal=20;
        }else{
            $horizontal=1000-$width_logo-$margin;
        }
        $imgPhoto=imagecreatetruecolor(1000, 1000);
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
            ImageFilledRectangle($imgPhoto, 10, 962, $obsText_+20, 982, $whiteObs); 
            imagettftext($imgPhoto, 14, 0, $obsText, 978, $black, $font, $observacao);
        }
    }

    //Envia para pagian de download quando a imagem estiver criada
    header('Location: ../src/actionDownloads.php?download='.$new_name.'&estilo=photo&size='.$sizePhoto.'&usuario='.$idusuarios.'&idlayout='.$idlayout);
    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgPhoto, 255, 255, 255);
    $white1 = imagecolorallocate($imgPhoto, 255, 255, 255);
    $black = imagecolorallocate($imgPhoto, 0, 0, 0);
    $cinza = imagecolorallocate($imgPhoto, 162, 156, 158);
    $amarelo = imagecolorallocate($imgPhoto, 255, 203, 41);
    //$red = imagecolorallocate($imgPhoto, 214, 27, 12);
    $imgAnuncio = imagecreate(460,90);
    $colorEmpresa = explode(',', $colorEmpresa);  //cor tema da empresa
    imagecolorallocate($imgAnuncio,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
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
    }

    /**Cria a imagem final*/
    $finalImage = $dirCompanie.'downloads/'.$new_name.'.png';
    imagepng($imgPhoto, $finalImage, 0);
    /**Limpa a memoria*/
    imagedestroy($imgPhoto);
}
?>