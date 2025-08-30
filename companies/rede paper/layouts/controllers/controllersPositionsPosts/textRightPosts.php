<?php 
    //require_once('../libs/sizeCenters.php');



    
    $margin=30;
    $positionCenterDescImage = centralBloco($width,18, $font, $desc, 0 );
    $positionCenterTituloImage = centralBloco($width,18, $fontBold, $titulo, 0 );
    $positionCenterPrecoImage = centralBloco($width,24, $fontBold, 'R$'.$preco, 0 );
    $positionCenterPromoImage = centralBloco($width,40, $fontBold, 'R$'.$promo.' un.', 0 );
    $positionCenterParcela = centralBloco($width,30, $fontBold, $vezes.'X de R$'.$parcela, 0 );
    $positionCenterLineImage = centralBloco($width,18, $font, 'R$'.$preco, 0 );



    if($promocao == 'on'){
        $vertical_y = 60;
        /*Insere a imagem do produto na imagem tema*/
        imagecopymerge($imgTheme, $imgProduct, $positionCenterPromoImage[0]-$margin+$horizontal, $vertical+300+$vertical_y, 0, 0, $width, $height, 100);
        /*Escreve na imagem tema*/
        imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$margin+$horizontal, $vertical+360+$vertical_y,$black, $fontBold, $titulo);
        imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$margin+$horizontal, $vertical+390+$vertical_y, $black, $font, $desc);
        imagettftext($imgTheme, 22, 0, $positionCenterPrecoImage[1]+$horizontal-68+$margin, $vertical+425+$vertical_y, $black, $font, "De:");
        imagettftext($imgTheme, 24, 0, $positionCenterPrecoImage[1]+$horizontal+$margin, $vertical+425+$vertical_y, $black, $fontBold, 'R$'.$preco);
        imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55+$margin, $vertical+465+$vertical_y, $black, $font, "Por:");
        imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal+$margin, $vertical+468+$vertical_y, $red, $fontBold, 'R$'.$promo.' un.');

        if($parcelado == 'on'){
            $x_h=30;
            $y_v=40; 

            /*Cria a caixa de desconto*/
            imagearc( $imgTheme, $positionCenterParcela[1]-63+$horizontal+$margin+200+$x_h+57, $vertical+490+$y_v+$vertical_y+57, 120, 120, 0, 360, $red );
            imagefill( $imgTheme, $positionCenterParcela[1]-63+$horizontal+$margin+200+$x_h+57, $vertical+490+$y_v+$vertical_y+57, $red );
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterParcela[1]-63+$horizontal+$margin+200+$x_h, $vertical+490+$y_v+$vertical_y, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+$horizontal-55+$margin, $vertical+465+$y_v+$vertical_y, $black, $font, "Ou:");
            imagettftext($imgTheme, 30, 0, $positionCenterParcela[1]+$horizontal+$margin+$x_h-30, $vertical+468+$y_v+$vertical_y, $red, $fontBold, $vezes.'X de R$'.$parcela);
            imagettftext($imgTheme, 45, 0, $positionCenterParcela[1]-43+$horizontal+$margin+200+$x_h, $vertical+580+$y_v+$vertical_y, $white, $fontBold, $porcentagem);
            imagettftext($imgTheme, 20, 0, $positionCenterParcela[1]+22+$horizontal+$margin+200+$x_h, $vertical+569+$y_v+$vertical_y, $white, $fontBold, "%");
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]-40+$horizontal+$margin+200+$x_h, $vertical+530+$y_v+$vertical_y, $white, $fontBold, "Desc.");

        }else if ($parcelado == 'off'){
            /*Cria a caixa de desconto*/
            imagearc( $imgTheme, $positionCenterParcela[1]-63+$horizontal+$margin+200+46, $vertical+490+$vertical_y+57, 120, 120, 0, 360, $red );
            imagefill( $imgTheme, $positionCenterParcela[1]-63+$horizontal+$margin+200+46, $vertical+490+$vertical_y+57, $red );
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterPromoImage[1]-63+$horizontal+$margin+200, $vertical+490+$vertical_y, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 45, 0, $positionCenterPromoImage[1]-43+$horizontal+$margin+200, $vertical+580+$vertical_y, $white, $fontBold, $porcentagem);
            imagettftext($imgTheme, 20, 0, $positionCenterPromoImage[1]+22+$horizontal+$margin+200, $vertical+569+$vertical_y, $white, $fontBold, "%");
            imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]-40+$horizontal+$margin+200, $vertical+530+$vertical_y, $white, $fontBold, "Desc.");

        }
   
        $constLineWidth = 160;
        $constLineHeight = 2;
        $imgLine = imagecreate($constLineWidth,$constLineHeight);
        imagecolorallocate($imgLine,161, 14, 18);
        
        imagecopymerge($imgTheme, $imgLine, $horizontal+$positionCenterLineImage[1], $vertical+415+$vertical_y, 0, 0, $constLineWidth, $constLineHeight, 100);
    }
    else if($promocao == 'off'){
        $vertical_y = 60;
        /*Insere a imagem do produto na imagem tema*/
        imagecopymerge($imgTheme, $imgProduct, $positionCenterPromoImage[0]-$margin+$horizontal, $vertical+300+$vertical_y, 0, 0, $width, $height, 100);
        /*Escreve na imagem tema*/
        imagettftext($imgTheme, 18, 0, $positionCenterTituloImage[1]+$margin+$horizontal, $vertical+370+$vertical_y,$black, $fontBold, $titulo);
        imagettftext($imgTheme, 18, 0, $positionCenterDescImage[1]+$margin+$horizontal, $vertical+400+$vertical_y, $black, $font, $desc);
        imagettftext($imgTheme, 22, 0, $positionCenterPromoImage[1]+$horizontal-55+$margin, $vertical+450+$vertical_y, $black, $font, "Por:");
        imagettftext($imgTheme, 40, 0, $positionCenterPromoImage[1]+$horizontal+$margin, $vertical+453+$vertical_y, $red, $fontBold, 'R$'.$preco.' un.');



        if($parcelado == 'on'){
            $x_h=30;
            $y_v=40; 

            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+$horizontal-15+$margin, $vertical+450+$y_v+$vertical_y, $black, $font, "Ou:");
            imagettftext($imgTheme, 30, 0, $positionCenterParcela[1]+$horizontal+$margin+$x_h+10, $vertical+453+$y_v+$vertical_y, $red, $fontBold, $vezes_spromo.'X de R$'.$parcela_spromo);

        }else{
            imagettftext($imgTheme, 30, 0, $positionCenterPromoImage[1]+$horizontal+$margin+60, $vertical+453+$vertical_y+45, $red, $fontBold, 'À Vista');
        }
    }
?>
