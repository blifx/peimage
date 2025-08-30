<?php




    $constLineWidth = 220;
    $constLineHeight = 4;
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgLine, $corLinhaDesc[0], $corLinhaDesc[1], $corLinhaDesc[2] );


    $x_anuncio=-45;
    $y_anuncio=180;



    list($left1,, $right1) = imageftbbox( 25, 0, $fontBold, $titulo);
    $width1 = $right1 - $left1 + 40;
    list($left2,, $right2) = imageftbbox( 20, 0, $font, $subtitulo);
    $width2 = $right2 - $left2 + 40;



    if($promocao == "on"){
        list($left4,, $right4) = imageftbbox( 42, 0, $font, $preco);
        $width4 = $right4 - $left4 + 40;
        $widthPreco = $right4 - $left4;
    }else{
        list($left4,, $right4) = imageftbbox( 58, 0, $font, $preco);
        $width4 = $right4 - $left4 + 100;
        $widthPreco = $right4 - $left4;
    }


    list($left5,, $right5) = imageftbbox( 58, 0, $fontBold, $promo);
    $width5 = $right5 - $left5 + 80;
    $widthPromo = $right5 - $left5;

    $tamanhoMaxText = max($width1, $width2, $width4, $width5);
    
    if($tamanhoMaxText > 400)
    $tamanhoMaxText = max($width5, $width4)+100;

    //Escreve a descrição do produto na imagem tema
    $tamanhoFontTexto1 = ajustSizeString(25, $tamanhoMaxText, $fontBold, $titulo);
    $tamanhoFontTexto2 = ajustSizeString(20, $tamanhoMaxText, $font, $subtitulo);

    list($left1,, $right1) = imageftbbox( $tamanhoFontTexto1, 0, $fontBold, $titulo);
    $widthTitulo = $right1 - $left1;
    list($left1,, $right1) = imageftbbox( $tamanhoFontTexto2, 0, $font, $subtitulo);
    $widthsubtitulo = $right1 - $left1;
 
    switch ($promocao) 
    {
        case "on":    
            imagecopymerge($imgPhoto, $imgWhite, 45+$x_anuncio+$move_x, 392+$y_anuncio+$move_y, 0, 0, $tamanhoMaxText+20, 240, 100);
            imagecopymerge($imgPhoto, $imgRed, 45+$x_anuncio+$move_x, 392+$y_anuncio+$move_y+140, 0, 0, $tamanhoMaxText+20, 100, 100);
            imagettftext($imgPhoto, $tamanhoFontTexto1, 0, ((($tamanhoMaxText+20)/2)- ($widthTitulo)/2)+$move_x, 435+$y_anuncio+$move_y, $corTitulo, $fontBold, $titulo);
            imagettftext($imgPhoto, $tamanhoFontTexto2, 0, ((($tamanhoMaxText+20)/2)- ($widthsubtitulo)/2)+$move_x, 463+$y_anuncio+$move_y, $corSubtitulo, $font, $subtitulo);
            imagettftext($imgPhoto, 18, 0, ((($tamanhoMaxText-13)/2)- $widthPreco/2)+$move_x, 495+$y_anuncio+$move_y, $corPrecoPromo, $font, 'DE');
            imagettftext($imgPhoto, 24, 0, ((($tamanhoMaxText-28)/2)- $widthPreco/2)+$move_x, 522+$y_anuncio+$move_y, $corPrecoPromo, $fontBold, 'R$');
            imagettftext($imgPhoto, 42, 0, ((($tamanhoMaxText+60)/2)- $widthPreco/2)+$move_x, 522+$y_anuncio+$move_y, $corPrecoPromo, $font, $preco);
            imagecopymerge($imgPhoto, $imgLine, ((($tamanhoMaxText+60)/2)- ($widthPreco)/2)+$move_x, 502+$y_anuncio+$move_y, 0, 0, $widthPreco, $constLineHeight, 100);
            
            imagettftext($imgPhoto, 24, 0, ((($tamanhoMaxText-50)/2)- $widthPromo/2)+$move_x, 575+$y_anuncio+$move_y, $corPromo, $font, 'POR');
            imagettftext($imgPhoto, 30, 0, ((($tamanhoMaxText-30)/2)- $widthPromo/2)+$move_x, 610+$y_anuncio+$move_y, $corPromo, $fontBold, 'R$');
            imagettftext($imgPhoto, 58, 0, ((($tamanhoMaxText+65)/2)- $widthPromo/2)+$move_x, 610+$y_anuncio+$move_y, $corPromo, $fontBold, $promo);
        break;
        case "off":
            imagecopymerge($imgPhoto, $imgWhite, 45+$x_anuncio+$move_x, 392+$y_anuncio+$move_y, 0, 0, $tamanhoMaxText+20, 210, 100);
            imagecopymerge($imgPhoto, $imgRed, 45+$x_anuncio+$move_x, 392+$y_anuncio+$move_y+110, 0, 0, $tamanhoMaxText+20, 100, 100);
            //imagecopymerge($imgPhoto, $imgAnuncio, 440+$x_anuncio, 372+$y_anuncio, 0, 0, 50, 280, 100);
            imagettftext($imgPhoto, $tamanhoFontTexto1, 0,  ((($tamanhoMaxText+20)/2)- ($widthTitulo)/2)+$move_x, 445+$y_anuncio+$move_y, $corTitulo, $fontBold, $titulo);
            imagettftext($imgPhoto, $tamanhoFontTexto2, 0, ((($tamanhoMaxText+20)/2)- ($widthsubtitulo)/2)+$move_x, 473+$y_anuncio+$move_y, $corSubtitulo, $font, $subtitulo);
            imagettftext($imgPhoto, 24, 0, ((($tamanhoMaxText-50)/2)- $widthPreco/2)+$move_x, 545+$y_anuncio+$move_y, $corPreco, $font, 'POR');
            imagettftext($imgPhoto, 30, 0, ((($tamanhoMaxText-30)/2)- $widthPreco/2)+$move_x, 580+$y_anuncio+$move_y, $corPreco, $fontBold, 'R$');
            imagettftext($imgPhoto, 58, 0, ((($tamanhoMaxText+65)/2)- $widthPreco/2)+$move_x, 580+$y_anuncio+$move_y, $corPreco, $fontBold, $preco);
        break;
    }

?>