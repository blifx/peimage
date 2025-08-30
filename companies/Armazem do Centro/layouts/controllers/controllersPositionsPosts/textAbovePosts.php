<?php 
    //require_once('../libs/sizeCenters.php');


    
    $positionCenterDescImage = centralBloco(0,18, $fontBold, $desc, 0 );
    $positionCenterTituloImage = centralBloco(0,18, $font, $titulo, 0 );
    $positionCenterPrecoImage = centralBloco(0,24, $fontBold, 'R$'.$preco, 0 );
    $positionCenterPromoImage = centralBloco(0,40, $fontBold, 'R$'.$promo.' un.', 0 );
    $positionCenterParcela = centralBloco(0,30, $fontBold, $vezes.'X de R$'.$parcela, 0 );
    $centerProduct=centerImage(960, $width);

    $marginPromo = imagettfbbox ( 45, 0, $fontBold, $promo );
    $marginPromo = $marginPromo[2] - $marginPromo[0];


    if($promocao == 'on'){
        /*Insere a imagem do produto na imagem tema*/
        imagecopymerge($imgTheme, $imgProduct, $centerProduct+$horizontal, 480+$vertical, 0, 0, $width, $height, 100);

        /*Escreve na imagem tema*/
        imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$horizontal, $vertical+310,$black, $fontBold, $titulo);
        imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$horizontal, $vertical+340, $black, $font, $desc);
        imagettftext($imgTheme, 22, 0, $positionCenterPrecoImage[1]+$horizontal-58, $vertical+375, $black, $font, "De:");
        imagettftext($imgTheme, 24, 0, $positionCenterPrecoImage[1]+$horizontal, $vertical+375, $black, $fontBold, 'R$'.$preco);
        imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55, $vertical+415, $black, $font, "Por:");
        imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal, $vertical+418, $red, $fontBold, 'R$'.$promo.' un.');


        $constLineWidth = 150;
        $constLineHeight = 2;
        $imgLine = imagecreate($constLineWidth,$constLineHeight);
        imagecolorallocate($imgLine,161, 14, 18);
        imagecopymerge($imgTheme, $imgLine, $horizontal+405, $vertical+365, 0, 0, $constLineWidth, $constLineHeight, 100);

        if($parcelado == 'on'){
            $x_h=0;
            $y_v=40;  
                    
            /*Cria a caixa de desconto*/
            imagearc( $imgTheme, $positionCenterParcela[1]+137+$marginPromo+$x_h+56, $vertical+355+$y_v+57, 125, 125, 0, 360, $red );
            imagefill( $imgTheme, $positionCenterParcela[1]+137+$marginPromo+$x_h+56, $vertical+355+$y_v+57, $red );
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterParcela[1]+137+$marginPromo+$x_h, $vertical+355+$y_v, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+$horizontal-55, $vertical+415+$y_v, $black, $font, "Ou:");
            imagettftext($imgTheme, 30, 0, $positionCenterParcela[1]+$horizontal+$x_h, $vertical+418+$y_v, $red, $fontBold, $vezes.'X de R$'.$parcela);
            imagettftext($imgTheme, 45, 0, $positionCenterParcela[1]+157+$marginPromo+$x_h, $vertical+445+$y_v, $white, $fontBold, $porcentagem);
            imagettftext($imgTheme, 20, 0, $positionCenterParcela[1]+222+$marginPromo+$x_h, $vertical+434+$y_v, $white, $fontBold, "%");
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+160+$marginPromo+$x_h, $vertical+395+$y_v, $white, $fontBold, "Desc.");
        }
        else if($parcelado == 'off'){
            /*Cria a caixa de desconto*/
            imagearc( $imgTheme, $positionCenterParcela[1]+137+$marginPromo+$x_h+56, $vertical+355+$y_v+57, 125, 125, 0, 360, $red );
            imagefill( $imgTheme, $positionCenterParcela[1]+137+$marginPromo+$x_h+56, $vertical+355+$y_v+57, $red );
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterPromoImage[1]+137+$marginPromo, $vertical+355, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 45, 0, $positionCenterPromoImage[1]+157+$marginPromo+10, $vertical+445, $white, $fontBold, $porcentagem);
            imagettftext($imgTheme, 20, 0, $positionCenterPromoImage[1]+222+$marginPromo+10, $vertical+434, $white, $fontBold, "%");
            imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+160+$marginPromo+10, $vertical+395, $white, $fontBold, "Desc.");

        }


    }
    else if($promocao == 'off'){
        /*Insere a imagem do produto na imagem tema*/
        imagecopymerge($imgTheme, $imgProduct, $centerProduct+$horizontal, 500+$vertical, 0, 0, $width, $height, 100);
        /*Escreve na imagem tema*/
        imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$horizontal, $vertical+335,$black, $fontBold, $titulo);
        imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$horizontal, $vertical+365, $black, $font, $desc);
        imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55, $vertical+415, $black, $font, "Por:");
        imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal, $vertical+418, $red, $fontBold, 'R$'.$preco.' un.');   

        if($parcelado == 'on'){
            $x_h=40;
            $y_v=40;  
                    
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterParcela[1]+137+$marginPromo+$x_h, $vertical+355+$y_v, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+$horizontal-10, $vertical+415+$y_v, $black, $font, "Ou:");
            imagettftext($imgTheme, 30, 0, $positionCenterParcela[1]+$horizontal+$x_h, $vertical+418+$y_v, $red, $fontBold, $vezes.'X de R$'.$parcela);
        }else if($parcelado == 'off'){
            imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$horizontal, $vertical+335,$black, $fontBold, $titulo);
            imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$horizontal, $vertical+365, $black, $font, $desc);
            imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55, $vertical+415, $black, $font, "Por:");
            imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal, $vertical+418, $red, $fontBold, 'R$'.$preco.' un.');  
            imagettftext($imgTheme, 30, 0, 415+15, $vertical+418+45, $red, $fontBold, "À Vista");
        }   
    }
?>
