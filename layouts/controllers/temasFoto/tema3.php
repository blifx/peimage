<?php
$redutor = 0.8;

if($promocao == "on"){
    $tamTitulo = 23;
    
    $tamDe = 18*$redutor;
    $tamPor = 24*$redutor;
    
    $tamPreco = 32*$redutor;
    $tamPromo = 58*$redutor;
    
    $tamParc = 30*$redutor;
    
    $tamTotal = 20*$redutor;

}else{
    $tamTitulo = 23;
    
    $tamDe = 18*$redutor;
    $tamPor = 24*$redutor;
    
    $tamPreco = 58*$redutor;
    $tamPromo = 58*$redutor;
    
    $tamParc = 30*$redutor;
    
    $tamTotal = 20*$redutor;

}



    $constLineWidth = 220;
    $constLineHeight = 4;

    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgLine, $corLinhaDesc[0], $corLinhaDesc[1], $corLinhaDesc[2] );

    $imgTitulo = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgTitulo, $corLinha[0], $corLinha[1], $corLinha[2] );

    $x_anuncio=-45;
    $y_anuncio=180;


    list($left1,, $right1) = imageftbbox( $tamTitulo, 0, $font, $titulo);
    $width1 = $right1 - $left1 + 40;
    list($left2,, $right2) = imageftbbox( 20, 0, $font, $subtitulo);
    $width2 = $right2 - $left2 + 40;



    if($promocao == "on"){
        list($left4,, $right4) = imageftbbox( $tamPreco, 0, $font, $preco);
        $width4 = $right4 - $left4 + 40;
        $widthPreco = $right4 - $left4;
    }else{
        list($left4,, $right4) = imageftbbox( $tamPreco, 0, $font, $preco);
        $width4 = $right4 - $left4 + 100;
        $widthPreco = $right4 - $left4;
    }


    list($left5,, $right5) = imageftbbox( $tamPromo, 0, $fontBold, $promo);
    $width5 = $right5 - $left5 + 80;
    $widthPromo = $right5 - $left5;


    list($left6,, $right6) = imageftbbox( $tamTotal, 0, $font, 'Total: R$'.$total);
    $width6 = $right6 - $left6 + 80;
    $widthTotal = $right6 - $left6;


    $tamanhoMaxText = max($width1, $width2, $width4, $width5);
    
    if($tamanhoMaxText > 400)
    $tamanhoMaxText = max($width5, $width4)+100;


    //Escreve a descrição do produto na imagem tema
    $tamanhoFontTexto1 = ajustSizeString($tamTitulo, $tamanhoMaxText, $font, $titulo);

    list($left1,, $right1) = imageftbbox( $tamanhoFontTexto1, 0, $font, $titulo);
    $widthTitulo = $right1 - $left1;


    switch ($promocao) 
    {
        case "on":    
            imagettftext($imgPhoto, $tamanhoFontTexto1, 0, ((($tamanhoMaxText+20)/2)- ($widthTitulo)/2)+$move_x, 20+488+$y_anuncio+$move_y, $corTitulo, $font, $titulo);
            imagecopymerge($imgPhoto, $imgTitulo, 55+$x_anuncio+$move_x, 20+491+$y_anuncio+$move_y, 0, 0,$tamanhoMaxText, $constLineHeight, 100);
            imagettftext($imgPhoto, $tamDe, 0, ((($tamanhoMaxText-23)/2)- $widthPreco/2)+$move_x, 12+535+$y_anuncio+$move_y, $corPrecoPromo, $font, 'DE');
            imagettftext($imgPhoto, $tamPreco, 0, ((($tamanhoMaxText+60)/2)- $widthPreco/2)+$move_x, 12+542+$y_anuncio+$move_y, $corPrecoPromo, $font, $preco);
            imagecopymerge($imgPhoto, $imgLine, ((($tamanhoMaxText+60)/2)- ($widthPreco)/2)+$move_x, 17+522+$y_anuncio+$move_y, 0, 0, $widthPreco, $constLineHeight, 100);
            imagettftext($imgPhoto, $tamPor, 0, ((($tamanhoMaxText-41)/2)- $widthPromo/2)+$move_x, 575+$y_anuncio+$move_y, $corPrecoPromo, $font, 'POR');
            if($parcela>1){
                imagettftext($imgPhoto, $tamParc, 0, ((($tamanhoMaxText-41)/2)- $widthPromo/2)+$move_x, 610+$y_anuncio+$move_y, $corPromo, $fontBold, $parcela."x");
                imagettftext($imgPhoto, $tamTotal, 0, ((($tamanhoMaxText-120)/2))+$move_x, 647+$y_anuncio+$move_y, $corPrecoPromo, $font, 'Total: R$'.$total);
            }

            imagettftext($imgPhoto, $tamPromo, 0, ((($tamanhoMaxText+65)/2)- $widthPromo/2)+$move_x, 610+$y_anuncio+$move_y, $corPromo, $fontBold, $promo);

        break;
        case "off":
            imagettftext($imgPhoto, $tamanhoFontTexto1, 0, ((($tamanhoMaxText+20)/2)- ($widthTitulo)/2)+$move_x, 5+530+$y_anuncio+$move_y, $corTitulo, $font, $titulo);
            imagecopymerge($imgPhoto, $imgTitulo, 55+$x_anuncio+$move_x, 5+533+$y_anuncio+$move_y, 0, 0,$tamanhoMaxText, $constLineHeight, 100);
            imagettftext($imgPhoto, $tamPor, 0, ((($tamanhoMaxText-50)/2)- $widthPreco/2)+$move_x, 575+$y_anuncio+$move_y, $corPreco, $font, 'POR');
            if($parcela>1){
                imagettftext($imgPhoto, $tamParc, 0, ((($tamanhoMaxText-50)/2)- $widthPreco/2)+$move_x, 610+$y_anuncio+$move_y, $corPromo, $fontBold, $parcela."x");
                imagettftext($imgPhoto, $tamTotal, 0, ((($tamanhoMaxText-115)/2))+$move_x, 647+$y_anuncio+$move_y, $corPreco, $font, 'Total: R$'.$total);
            }
            imagettftext($imgPhoto, $tamPreco, 0, ((($tamanhoMaxText+65)/2)- $widthPreco/2)+$move_x, 610+$y_anuncio+$move_y, $corPromo, $fontBold, $preco);
        break;
    }

//////////////////////////////////////////////////////////////////////////////////////

    $redutor = 0.8;

    if($promocao2 == "on"){
        $tamTitulo = 23;
        
        $tamDe = 18*$redutor;
        $tamPor = 24*$redutor;
        
        $tamPreco = 32*$redutor;
        $tamPromo = 58*$redutor;
        
        $tamParc = 30*$redutor;
        
        $tamTotal = 20*$redutor;
    
    }else{
        $tamTitulo = 23;
        
        $tamDe = 18*$redutor;
        $tamPor = 24*$redutor;
        
        $tamPreco = 58*$redutor;
        $tamPromo = 58*$redutor;
        
        $tamParc = 30*$redutor;
        
        $tamTotal = 20*$redutor;
    
    }


if($produto2 == "1"){
    list($left1,, $right1) = imageftbbox( $tamTitulo, 0, $font, $titulo2);
    $width1 = $right1 - $left1 + 40;


    if($promocao2 == "on"){
        list($left4,, $right4) = imageftbbox( $tamPreco, 0, $font, $preco2);
        $width4 = $right4 - $left4 + 40;
        $widthPreco = $right4 - $left4;
    }else{
        list($left4,, $right4) = imageftbbox( $tamPreco, 0, $font, $preco2);
        $width4 = $right4 - $left4 + 100;
        $widthPreco = $right4 - $left4;
    }


    list($left5,, $right5) = imageftbbox( $tamPromo, 0, $fontBold, $promo2);
    $width5 = $right5 - $left5 + 80;
    $widthPromo = $right5 - $left5;


    list($left6,, $right6) = imageftbbox( $tamTotal, 0, $font, 'Total: R$'.$total2);
    $width6 = $right6 - $left6 + 80;
    $widthTotal = $right6 - $left6;


    $tamanhoMaxText = max($width1, $width4, $width5, $width6);
    
    if($tamanhoMaxText > 400)
    $tamanhoMaxText = max($width5, $width4)+100;

    //Escreve a descrição do produto na imagem tema
    $tamanhoFontTexto1 = ajustSizeString($tamTitulo, $tamanhoMaxText, $font, $titulo2);

    list($left1,, $right1) = imageftbbox( $tamanhoFontTexto1, 0, $font, $titulo2);
    $widthTitulo = $right1 - $left1;


    $x_anuncio=$sizeImagePhoto-($tamanhoMaxText)-7;
    $y_anuncio=-200;



    switch ($promocao2) 
    {
        case "on":    
            imagettftext($imgPhoto, $tamanhoFontTexto1, 0, $x_anuncio+((($tamanhoMaxText+20)/2)-($widthTitulo)/2)+$move_x2, 20+488+$y_anuncio+$move_y2, $corTitulo, $font, $titulo2);
            imagecopymerge($imgPhoto, $imgTitulo, $x_anuncio+$move_x2, 20+491+$y_anuncio+$move_y2, 0, 0,$tamanhoMaxText, $constLineHeight, 100);
            imagettftext($imgPhoto, $tamDe, 0, $x_anuncio+((($tamanhoMaxText-13)/2)- $widthPreco/2)+$move_x2, 12+535+$y_anuncio+$move_y2, $corPrecoPromo, $font, 'DE');
            imagettftext($imgPhoto, $tamPreco, 0, $x_anuncio+((($tamanhoMaxText+60)/2)- $widthPreco/2)+$move_x2, 12+542+$y_anuncio+$move_y2, $corPrecoPromo, $font, $preco2);
            imagecopymerge($imgPhoto, $imgLine, $x_anuncio+((($tamanhoMaxText+60)/2)- ($widthPreco)/2)+$move_x2, 17+522+$y_anuncio+$move_y2, 0, 0, $widthPreco, $constLineHeight, 100);
            imagettftext($imgPhoto, $tamPor, 0, $x_anuncio+((($tamanhoMaxText-50)/2)- $widthPromo/2)+$move_x2, 575+$y_anuncio+$move_y2, $corPreco, $font, 'POR');
            if($parcela2>1){
                imagettftext($imgPhoto, $tamParc, 0, $x_anuncio+((($tamanhoMaxText-50)/2)- $widthPromo/2)+$move_x2, 610+$y_anuncio+$move_y2, $corPromo, $fontBold, $parcela2."x");
                imagettftext($imgPhoto, $tamTotal, 0, $x_anuncio+((($tamanhoMaxText-120)/2))+$move_x2, 647+$y_anuncio+$move_y2, $corPreco, $font, 'Total: R$'.$total2);
            }
            imagettftext($imgPhoto, $tamPromo, 0, $x_anuncio+((($tamanhoMaxText+65)/2)- $widthPromo/2)+$move_x2, 610+$y_anuncio+$move_y2, $corPromo, $fontBold, $promo2);

        break;
        case "off":
            imagettftext($imgPhoto, $tamanhoFontTexto1, 0, $x_anuncio+((($tamanhoMaxText+20)/2)-($widthTitulo)/2)+$move_x2, 5+530+$y_anuncio+$move_y2, $corTitulo, $font, $titulo2);
            imagecopymerge($imgPhoto, $imgTitulo, $x_anuncio+$move_x2, 5+533+$y_anuncio+$move_y2, 0, 0,$tamanhoMaxText, $constLineHeight, 100);
            imagettftext($imgPhoto, $tamPor, 0, $x_anuncio+((($tamanhoMaxText-50)/2)- $widthPreco/2)+$move_x2, 575+$y_anuncio+$move_y2, $corPreco, $font, 'POR');
            if($parcela2>1){
                imagettftext($imgPhoto, $tamParc, 0, $x_anuncio+((($tamanhoMaxText-50)/2)-$widthPreco/2)+$move_x2, 610+$y_anuncio+$move_y2, $corPromo, $fontBold, $parcela2."x");
                imagettftext($imgPhoto, $tamTotal, 0, $x_anuncio+((($tamanhoMaxText-115)/2))+$move_x2, 647+$y_anuncio+$move_y2, $corPreco, $font, 'Total: R$'.$total2);
            }
            imagettftext($imgPhoto, $tamPreco, 0, $x_anuncio+((($tamanhoMaxText+65)/2)- $widthPreco/2)+$move_x2, 610+$y_anuncio+$move_y2, $corPromo, $fontBold, $preco2);
        break;
    }
}

?>