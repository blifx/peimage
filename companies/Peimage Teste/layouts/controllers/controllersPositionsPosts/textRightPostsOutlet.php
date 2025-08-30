<?php 
    //require_once('../libs/sizeCenters.php');



    
    $margin=30;
    $positionCenterDescImage = centerText(341,18, $font, $desc);
    $positionCenterTituloImage = centerText(341,18, $fontBold, $titulo);
    $positionCenterPrecoImage = centralBloco($width,24, $fontBold, 'R$'.$preco, 0 );
    $positionCenterPromoImage = centralBloco($width,40, $fontBold, 'R$'.$promo.' un.', 0 );
    $positionCenterParcela = centralBloco($width,30, $fontBold, $vezes.'X de R$'.$parcela, 0 );
    $positionCenterLineImage = centralBloco($width,18, $font, 'R$'.$preco, 0 );
    $hCenterProduct = centerImage(960,$width);
    $vCenterProduct = centerImage(960,$height);




        $vertical_y = 60;

    /*Insere a imagem do produto na imagem tema*/
    imagecopymerge($imgTheme, $imgProduct, $hCenterProduct+$horizontal, $vCenterProduct+$vertical, 0, 0, $width, $height, 100);
    imagecopymerge($imgTheme, $imgOutlet, 20, 490, 0, 0, 341, 450, 100);
    imagecopymerge($imgTheme, $imgDesconto, 362, 800, 0, 0, 120, 92, 100);
    /*Escreve na imagem tema*/
    imagettftext($imgTheme, 18, 0, $positionCenterTituloImage+20, 745,$black, $fontBold, $titulo);
    imagettftext($imgTheme, 18, 0, $positionCenterDescImage+20, 770, $black, $font, $desc);
    imagettftext($imgTheme, 14, 0, 40, 830, $white, $font, "PREÇO NORMAL:");
    imagettftext($imgTheme, 14, 0, 40, 870, $white, $font, "PREÇO NA OFERTA:");
    imagettftext($imgTheme, 14, 0, 40, 910, $amarelo, $font, "SÓ NO OUTLET:");
    imagettftext($imgTheme, 18, 0, 180, 832, $white, $fontBold, 'R$'.$preco);
    imagettftext($imgTheme, 18, 0, 200, 872, $white, $fontBold, 'R$'.$promo);
    imagettftext($imgTheme, 28, 0, 170, 912, $amarelo, $fontBold, 'R$'.$outlet);




            /*Cria a caixa de desconto*/
            //imagearc( $imgTheme, -63+200+46+300, 490+57, 120, 120, 0, 360, $red );
            //imagefill( $imgTheme,-63+200+46+300, 490+57, $red );
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterPromoImage[1]-63+$horizontal+$margin+200, $vertical+490+$vertical_y, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 45, 0, 377, 880, $black, $fontBold, $porcentagem);
            imagettftext($imgTheme, 20, 0, 442, 869, $black, $fontBold, "%");
            imagettftext($imgTheme, 22, 0, 378, 830, $black, $fontBold, "Desc.");

        
   
    $constLineWidth = 160;
    $constLineHeight = 2;
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgLine,161, 14, 18);
    
    //imagecopymerge($imgTheme, $imgLine, $horizontal+$positionCenterLineImage[1], $vertical+415+$vertical_y, 0, 0, $constLineWidth, $constLineHeight, 100);
    
    
    
?>
