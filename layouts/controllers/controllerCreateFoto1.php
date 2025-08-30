<?php
if(!empty($_POST)){
    $titulo = $_POST['titulo'];
    $desc = $_POST['desc'];
    $origens  = array(',', 'R$');
    $destinos = array('.', '');
    $preco = (float)str_replace($origens,$destinos,$_POST['preco']);
    $promo = (float)str_replace($origens,$destinos,$_POST['promo']);
    $observacao = $_POST['obs'];
    $dirCompanie = '../companies/'.$companie.'/';
    $rotacao = $_GET['rotacao'];

    $promocao = 'on';
    if($promo == ''){
        $promocao = 'off'; 
    }

    $productState = 'sem imagem';
    $new_name = uniqid(rand(), true); 
    $ext='.jpg';

    if($_FILES['fileUpload']['size'] != 0)
    {
        $productState = 'com imagem';
        /*Faz o upload da imagem do produto*/
        $dir = $dirCompanie.'uploads/'; //Diretório para uploads
        move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name.$ext); //Fazer upload do arquivo
    }

    
    
    /*Faz o calculo da porcentagem de desconto*/
    $porcentagem = round(100 - ($promo*100/$preco));
    /*Modificado formato da dados*/
    $preco = number_format($preco, 2, ',', ' ');
    $promo = number_format($promo, 2, ',', ' ');
    
    /*Carrega fontes*/
    $font = __DIR__.'/../../fonts/calibri.ttf';
    $fontBold = __DIR__.'/../../fonts/calibrib.ttf'; 


    $name = $dirCompanie.'uploads/'.$new_name.'.jpg';
    //imagerotate ($name , 0 , 0 );
    $myImage = imagecreatefromjpeg($name);
    
    //Get the height and width of the image
    list($width, $height) = getimagesize($name);

    if($rotacao == 'on'){
        $myImage = imagerotate ($myImage , -90 , 0 );
    }

    $constLineWidth = 300;
    $constLineHeight = 4;
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    $imgTitulo = imagecreate(24,200);
    imagecolorallocate($imgLine, 161, 14, 18);

    $imgWhite = imagecreate(500,400);
    imagecolorallocate($imgWhite, 255, 255, 255);
    $imgLogo = imagecreatefrompng($dirCompanie.'logo_pequeno.png');    
    list($width_logo, $height_logo) = getimagesize($dirCompanie.'logo_pequeno.png');

    $new_name = uniqid(rand(), true);
    
    $imgRodape = imagecreatefrompng($dirCompanie.'rodape1.png');    
    
 

    if($width > $height)
    {
        $imgPhoto=imagecreatetruecolor(1000, 750);
        imagecopyresampled($imgPhoto,$myImage,0,0,0,0,1000,750,$width, $height);
        $imgPhoto = imagerotate ($imgPhoto , -90 , 0 );
        //imagecopy($imgPhoto, $imgLogo, 550, 30, 0, 0, $width_logo, $height_logo);
        // Carrega a imagem a ser manipulada
        $image = WideImage::load($dirCompanie.'rodape1.png');
        // Redimensiona a imagem
        $image = $image->resize(750, 160);
        // Salva a imagem em um arquivo (novo ou não)
        $image->saveToFile('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png');
        $imgRodape = imagecreatefrompng('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png'); 
        list($width_rodape, $height_rodape) = getimagesize('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png');
        imagecopy($imgPhoto, $imgRodape, 0, 1000-$height_rodape, 0, 0, $width_rodape, $height_rodape);

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
        $imgPhoto=imagecreatetruecolor(750, 1000);
        imagecopyresampled($imgPhoto,$myImage,0,0,0,0,750,1000,$width, $height);
        //imagecopy($imgPhoto, $imgLogo, 550, 30, 0, 0, $width_logo, $height_logo);
        $image = WideImage::load($dirCompanie.'rodape1.png');
        // Redimensiona a imagem
        $image = $image->resize(750, 160);
        // Salva a imagem em um arquivo (novo ou não)
        $image->saveToFile('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png');
        $imgRodape = imagecreatefrompng('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png'); 
        list($width_rodape, $height_rodape) = getimagesize('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png');
        imagecopy($imgPhoto, $imgRodape, 0, 1000-$height_rodape, 0, 0, $width_rodape, $height_rodape);
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
        $imgPhoto=imagecreatetruecolor(1000, 1000);
        imagecopyresampled($imgPhoto,$myImage,0,0,0,0,1000,1000,$width, $height);
        //$imgPhoto = imagerotate ($imgPhoto , -90 , 0 );
        //imagecopy($imgPhoto, $imgLogo, 777, 30, 0, 0, $width_logo, $height_logo);
        $image = WideImage::load($dirCompanie.'rodape1.png');
        // Redimensiona a imagem
        $image = $image->resize(1000, 209);
        // Salva a imagem em um arquivo (novo ou não)
        $image->saveToFile('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png');
        $imgRodape = imagecreatefrompng('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png'); 
        list($width_rodape, $height_rodape) = getimagesize('../companies/'.$companie.'/uploads'.'/'.$new_name.'.png');
        imagecopy($imgPhoto, $imgRodape, 0, 1000-$height_rodape, 0, 0, $width_rodape, $height_rodape);
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
    header('Location: ../src/actionDownloads.php?download='.$new_name.'&estilo=photo&size='.$sizePhoto);
    $imgRed = imagecreate(460,90);
    imagecolorallocate($imgRed, 214, 27, 12);

    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgPhoto, 255, 255, 255);
    $black = imagecolorallocate($imgPhoto, 0, 0, 0);
    $red = imagecolorallocate($imgPhoto, 214, 27, 12);

    /*Colore o retangulo de desconto de vermelho*/
    imagecolorallocate($imgLine,0, 0, 0);
    imagecolorallocate($imgTitulo,255, 0, 0);


    $centerLine=centerImage(595, $constLineWidth);
    $centerimg=centerImage(595, 460);
    $horizontalTitulo=centerText(595, 32, $fontBold, $titulo);
    $horizontalDescricao=centerText(595, 24, $fontBold, $desc);
    $horizontalPreco=centerText(595, 32, $fontBold, 'DE R$ '.$preco);
    $horizontalPromo=centerText(595, 42, $fontBold, 'POR R$ '.$promo);
    /*Centraliza os textos quando não há imagem de produto*/
    $horizontalTitulo_=centerText(595, 32, $fontBold, $titulo);
    $horizontalDescricao_=centerText(595, 32, $font, $desc);
    $centerTitulo=centerText(595, 32, $fontBold, $titulo);
    $centerDescricao=centerText(595, 32, $fontBold, $desc);
    $horizontalPreco_=centerText(595, 42, $fontBold, 'POR R$ '.$preco);

    $x_anuncio=-45;
    $y_anuncio=180;
    switch ($promocao) 
    {
        case "on":
            imagecopymerge($imgPhoto, $imgWhite, 45+$x_anuncio, 432+$y_anuncio, 0, 0, 500, 300, 100);
            imagecopymerge($imgPhoto, $imgRed, $centerimg+$x_anuncio, 600+$y_anuncio, 0, 0, 460, 90, 100);            
            imagettftext($imgPhoto, 32, 0, $horizontalTitulo+$x_anuncio, 500+$y_anuncio, $black, $fontBold, $titulo);
            imagettftext($imgPhoto, 24, 0, $horizontalDescricao+$x_anuncio, 530+10+$y_anuncio, $black, $fontBold, $desc); 
            /*Insere o preço e a promoção*/
            imagettftext($imgPhoto, 32, 0, $horizontalPreco+$x_anuncio, 590+$y_anuncio, $black, $fontBold, 'DE R$ '.$preco);
            imagettftext($imgPhoto, 42, 0, $horizontalPromo+$x_anuncio-30, 660+$y_anuncio, $white, $fontBold, 'POR R$ '.$promo);
            imagecopymerge($imgPhoto, $imgLine, $centerLine+$x_anuncio, 575+$y_anuncio, 0, 0, $constLineWidth, $constLineHeight, 100);
            imagettftext($imgPhoto, 18, 0, 460+$x_anuncio, 670+$y_anuncio, $white, $fontBold, 'UN.');  
        break;
        case "off":
            imagecopymerge($imgPhoto, $imgWhite, 45+$x_anuncio, 432+$y_anuncio, 0, 0, 500, 250, 100);
            imagecopymerge($imgPhoto, $imgRed, $centerimg+$x_anuncio, 565+$y_anuncio, 0, 0, 460, 90, 100);    
            imagettftext($imgPhoto, 32, 0, $horizontalTitulo+$x_anuncio, 505+$y_anuncio, $black, $fontBold, $titulo);
            imagettftext($imgPhoto, 24, 0, $horizontalDescricao+$x_anuncio, 530+15+$y_anuncio, $black, $fontBold, $desc); 
            /*Insere o preço e a promoção*/
            imagettftext($imgPhoto, 42, 0, $horizontalPreco_+$x_anuncio-30, 630+$y_anuncio, $white, $fontBold, 'Por R$ '.$preco);
            imagettftext($imgPhoto, 18, 0, 460+$x_anuncio, 635+$y_anuncio, $white, $fontBold, 'UN.');   
        break;
    }

    /**Cria a imagem final*/
    $finalImage = $dirCompanie.'downloads/'.$new_name.'.png';
    imagepng($imgPhoto, $finalImage, 0);
    /**Limpa a memoria*/
    imagedestroy($imgPhoto);
}
?>