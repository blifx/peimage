<?php
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

	$widthTitulo = imagettfbbox ( 50, 0, $fontBold, $preco );
	$widthTituloz = imagettfbbox ( 50, 0, $fontBold, $preco );


    $widthPreco = imagettfbbox ( 50, 0, $fontBold, $preco );
    $widthPreco_ = imagettfbbox ( 22, 0, $fontBold, 'R$ '.$preco );
    $widthPromo = imagettfbbox ( 50, 0, $fontBold, $promo );


    $widthPreco = $widthPreco[2] - $widthPreco[0]; 
    $widthPreco_ = $widthPreco_[2] - $widthPreco_[0]; 
    $widthPromo = $widthPromo[2] - $widthPromo[0];

    $constLineWidth = 220;
    $constLineHeight = 2;
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgLine, $corLinhaDesc[0], $corLinhaDesc[1], $corLinhaDesc[2] );

    $x_anuncio=-45;
    $y_anuncio=180;



    list($left1,, $right1) = imageftbbox( 30, 0, $fontBold, $titulo);
    $width1 = $right1 - $left1 + 40;
    list($left2,, $right2) = imageftbbox( 30, 0, $font, $subtitulo);
    $width2 = $right2 - $left2 + 40;
    list($left3,, $right3) = imageftbbox( 20, 0, $font, $desc);
    $width3 = $right3 - $left3 + 40;


    if($promocao == "on"){
        list($left4,, $right4) = imageftbbox( 26, 0, $fontBold, "R$ ".$preco);
        $width4 = $right4 - $left4 + 40;
    }else{
        list($left4,, $right4) = imageftbbox( 50, 0, $fontBold, "R$ ".$preco);
        $width4 = $right4 - $left4 + 40;
    }


    list($left5,, $right5) = imageftbbox( 50, 0, $fontBold, "R$ ".$promo);
    $width5 = $right5 - $left5 + 40;


    $tamanhoMaxText = max($width1, $width2, $width3, $width4, $width5);
    
    if($tamanhoMaxText > 400)
    $tamanhoMaxText = $width5+100;

    //Escreve a descrição do produto na imagem tema
    $tamanhoFontTexto1 = ajustSizeString(30, $tamanhoMaxText, $fontBold, $titulo);
    $tamanhoFontTexto2 = ajustSizeString(30, $tamanhoMaxText, $font, $subtitulo);
    $tamanhoFontTexto = min($tamanhoFontTexto1, $tamanhoFontTexto2);
    $tamanhoFontTexto3 = $tamanhoFontTexto*0.72;

    $z=0;
if($desc==""){
$z=25;
}
 
    switch ($promocao) 
    {
        case "on":    
            imagecopymerge($imgPhoto, $imgWhite, 45+$x_anuncio+$move_x, 392+$y_anuncio+$move_y, 0, 0, $tamanhoMaxText+20, 240, 100);
            //imagecopymerge($imgPhoto, $imgAnuncio, 420+$x_anuncio, 392+$y_anuncio, 0, 0, 30, 230, 100);
            imagettftext($imgPhoto, $tamanhoFontTexto, 0, 105+$x_anuncio-10-20+$move_x, 435+$y_anuncio+$move_y+$z, $corTitulo, $fontBold, $titulo);
            imagettftext($imgPhoto, $tamanhoFontTexto, 0, 105+$x_anuncio-10-20+$move_x, 473+$y_anuncio+$move_y+$z, $corSubtitulo, $font, $subtitulo);
            imagettftext($imgPhoto, $tamanhoFontTexto3, 0, 105+$x_anuncio-10-20+$move_x, 505+$y_anuncio+$move_y, $corDesc, $font, $desc);
            imagettftext($imgPhoto, 18, 0, 105+$x_anuncio-10-20+$move_x, 545+$y_anuncio+$move_y, $corPrecoPromo, $fontBold, 'de');
            imagettftext($imgPhoto, 24, 0, 135+$x_anuncio-20+$move_x, 545+$y_anuncio+$move_y, $corPrecoPromo, $font, 'R$ '.$preco);
            imagecopymerge($imgPhoto, $imgLine, 127+$x_anuncio-20+$move_x, 536+$y_anuncio+$move_y, 0, 0, $widthPreco_+27, $constLineHeight, 100);
            imagettftext($imgPhoto, 18, 0, 105+$x_anuncio-10-20+$move_x, 565+$y_anuncio+$move_y, $corTitulo, $fontBold, 'por');
            imagettftext($imgPhoto, 26, 0, 105+$x_anuncio-10-20+$move_x, 600+$y_anuncio+$move_y, $corPromo, $fontBold, 'R$');
            imagettftext($imgPhoto, 50, 0, 140+$x_anuncio-20+$move_x, 600+$y_anuncio+$move_y, $corPromo, $fontBold, $promo);
            imagettftext($imgPhoto, 18, 0, 145+$x_anuncio+$widthPromo-20+$move_x, 615+$y_anuncio+$move_y, $corTitulo, $fontBold, 'cada');
        break;
        case "off":
            imagecopymerge($imgPhoto, $imgWhite, 45+$x_anuncio+$move_x, 392+$y_anuncio+$move_y, 0, 0, $tamanhoMaxText+30, 215, 100);
            //imagecopymerge($imgPhoto, $imgAnuncio, 440+$x_anuncio, 372+$y_anuncio, 0, 0, 50, 280, 100);
            imagettftext($imgPhoto, $tamanhoFontTexto, 0, 105+$x_anuncio-10-20+$move_x, 435+$y_anuncio+$move_y, $corTitulo, $fontBold, $titulo);
            imagettftext($imgPhoto, $tamanhoFontTexto, 0, 105+$x_anuncio-10-20+$move_x, 473+$y_anuncio+$move_y, $corSubtitulo, $font, $subtitulo);
            imagettftext($imgPhoto, $tamanhoFontTexto3, 0, 105+$x_anuncio-10-20+$move_x, 505+$y_anuncio+$move_y, $corDesc, $font, $desc);
            imagettftext($imgPhoto, 18, 0, 105+$x_anuncio-10-20+$move_x, 565+$y_anuncio-30+$move_y, $corTitulo, $fontBold, 'por');
            imagettftext($imgPhoto, 26, 0, 105+$x_anuncio-10-20+$move_x, 600+$y_anuncio-30+$move_y, $corPreco, $fontBold, 'R$');
            imagettftext($imgPhoto, 50, 0, 140+$x_anuncio-20+$move_x, 600+$y_anuncio-30+$move_y, $corPreco, $fontBold, $preco);
            imagettftext($imgPhoto, 18, 0, 145+$x_anuncio+$widthPreco-20+$move_x, 615+$y_anuncio-30+$move_y, $black, $corTitulo, 'cada');
        break;
    }

?>