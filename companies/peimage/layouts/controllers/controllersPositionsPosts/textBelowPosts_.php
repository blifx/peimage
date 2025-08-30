<?php 
    //require_once('../libs/sizeCenters.php');
    $margin=($calcSize-100)+25;
    $positionCenterDescImage = centralBloco(0,18, $font, $desc, 0 );
    $positionCenterTituloImage = centralBloco(0,18, $font, $titulo, 0 );
    $positionCenterPrecoImage = centralBloco(0,24, $fontBold, 'R$'.$preco, 0 );
    $positionCenterPromoImage = centralBloco(0,40, $fontBold, 'R$'.$promo.' un.', 0 );
    $centerProduct=centerImage(960, $width);

    $marginPromo = imagettfbbox ( 45, 0, $fontBold, $promo );
    $marginPromo = $marginPromo[2] - $marginPromo[0];

    if ($promocao == 'on'){
    /*Insere a imagem do produto na imagem tema*/
    imagecopymerge($imgTheme, $imgProduct, $centerProduct+$horizontal, 280-$margin+$vertical, 0, 0, $width, $height, 100);
    /*Insere o retangulo de desconto na imagem tema*/
    imagecopymerge($imgTheme, $imgDesc, $positionCenterPromoImage[1]+117+$marginPromo+$horizontal, $vertical+550+$margin, 0, 0, 120, 120, 100);
    /*Escreve na imagem tema*/
    imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$horizontal, $vertical+580+$margin,$black, $font, $titulo);
    imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$horizontal, $vertical+610+$margin, $black, $font, $desc);
    imagettftext($imgTheme, 22, 0, $positionCenterPrecoImage[1]+$horizontal-58, $vertical+645+$margin, $black, $font, "De:");
    imagettftext($imgTheme, 24, 0, $positionCenterPrecoImage[1]+$horizontal, $vertical+645+$margin, $black, $fontBold, 'R$'.$preco);
    imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55, $vertical+685+$margin, $black, $font, "Por:");
    imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal, $vertical+688+$margin, $red, $fontBold, 'R$'.$promo.' un.');
    imagettftext($imgTheme, 45, 0, $positionCenterPromoImage[1]+137+$horizontal+$marginPromo, $vertical+640+$margin, $white, $fontBold, $porcentagem);
    imagettftext($imgTheme, 20, 0, $positionCenterPromoImage[1]+202+$horizontal+$marginPromo, $vertical+629+$margin, $white, $fontBold, "%");
    imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+140+$horizontal+$marginPromo, $vertical+590+$margin, $white, $fontBold, "Desc.");

    $constLineWidth = 150;
    $constLineHeight = 2;
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    imagecolorallocate($imgLine,161, 14, 18);
    imagecopymerge($imgTheme, $imgLine, $horizontal+405, $vertical+635+$margin, 0, 0, $constLineWidth, $constLineHeight, 100);
    }
    else if($promocao == 'off'){
    /*Insere a imagem do produto na imagem tema*/
    imagecopymerge($imgTheme, $imgProduct, $centerProduct+$horizontal, 280-$margin+$vertical, 0, 0, $width, $height, 100);
    /*Escreve na imagem tema*/
    imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$horizontal, $vertical+580+$margin,$black, $font, $titulo);
    imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$horizontal, $vertical+610+$margin, $black, $font, $desc);
    imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55, $vertical+660+$margin, $black, $font, "Por:");
    imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal, $vertical+663+$margin, $red, $fontBold, 'R$'.$preco.' un.');
    }
?>
