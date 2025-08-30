<?php 
    //require_once('../libs/sizeCenters.php');

    $width1 = $width*0.8;
    
    $margin=-(100 - $calcSize);
    $positionCenterDescImage = centralBloco($width1,18, $font, $desc, 0 );
    $positionCenterTituloImage = centralBloco($width1,18, $font, $titulo, 0 );
    $positionCenterPrecoImage = centralBloco($width1,24, $fontBold, 'R$'.$preco, 0 );
    $positionCenterPromoImage = centralBloco($width1,40, $fontBold, 'R$'.$promo.' un.', 0 );
    $positionCenterLineImage = centralBloco($width1,18, $font, 'R$'.$preco, 0 );




    /*Insere a imagem do produto na imagem tema*/
    imagecopymerge($imgTheme, $imgProduct, $positionCenterPromoImage[1]-$margin+$horizontal, $vertical+300, 0, 0, $width, $height, 100);
    /*Insere o retangulo de desconto na imagem tema*/
    imagecopymerge($imgTheme, $imgDesc, $positionCenterPromoImage[0]-63+$horizontal+$margin, $vertical+490, 0, 0, 120, 120, 100);
    /*Escreve na imagem tema*/
    imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[0]+$margin+$horizontal, $vertical+360,$black, $font, $titulo);
    imagettftext($imgTheme, 18, 0, $positionCenterDescImage[0]+$margin+$horizontal, $vertical+390, $black, $font, $desc);
    imagettftext($imgTheme, 22, 0, $positionCenterPrecoImage[0]+$horizontal-65+$margin, $vertical+425, $black, $font, "De:");
    imagettftext($imgTheme, 24, 0, $positionCenterPrecoImage[0]+$horizontal+$margin, $vertical+425, $black, $fontBold, 'R$'.$preco);
    imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[0]+$horizontal-55+$margin, $vertical+465, $black, $font, "Por:");
    imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[0]+$horizontal+$margin, $vertical+468, $red, $fontBold, 'R$'.$promo.' un.');
    imagettftext($imgTheme, 45, 0, $positionCenterPromoImage[0]-43+$horizontal+$margin, $vertical+580, $white, $fontBold, $porcentagem);
    imagettftext($imgTheme, 20, 0, $positionCenterPromoImage[0]+22+$horizontal+$margin, $vertical+569, $white, $fontBold, "%");
    imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[0]-40+$horizontal+$margin, $vertical+530, $white, $fontBold, "Desc.");

    $constLineWidth = 160;
    $constLineHeight = 2;
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgLine,161, 14, 18);
    imagecopymerge($imgTheme, $imgLine, $horizontal+$positionCenterLineImage[0]-30+$margin, $vertical+415, 0, 0, $constLineWidth, $constLineHeight, 100);
   

?>
