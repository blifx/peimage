<?php 
    //require_once('../libs/sizeCenters.php');


    $margin=($calcSize-100+50)+25;
    $imgDesc = imagecreatefromjpeg("controllers/circulo-desc.jpg");
    

    $titulo = strtoupper($titulo);
    $desc = strtoupper($desc);

    $positionCenterDescImage =  centerBloco(0,23, $fontBold, $desc, 720 );
    $positionCenterTituloImage =  centerBloco(0,23, $fontBold, $titulo, 720 );
    $positionCenterPrecoImage =  centerBloco(0,23, $fontBold, 'De'.$preco, 720 );
    $positionCenterPromoImage =  centerBloco(0,57, $fontBold, $promo, 720 );
    $positionCenterParcela =  centerBloco(0,30, $fontBold, $vezes.'X de R$'.$parcela, 720 );
    $centerProduct=centerImage(720, $width);

    $marginPromo = imagettfbbox ( 57, 0, $fontBold, $promo );
    $marginPromo = $marginPromo[2] - $marginPromo[0];
    $vertical = $vertical+200;


    $positionCenterPreco =  centerBloco(0,57, $fontBold, $preco, 720 );



    if($promocao == 'on'){
        /*Insere a imagem do produto na imagem tema*/
        imagecopymerge($imgTheme, $imgProduct, $centerProduct+$horizontal, 280-$margin+$vertical, 0, 0, $width, $height, 100);


        $sizePromo = imagettfbbox (57, 0, $fontBold, $promo );
        $sizePromo = $sizePromo[2] - $sizePromo[0];

        /*Escreve na imagem tema*/
        imagettftext($imgTheme, 23, 0, $positionCenterTituloImage[1]+$horizontal+2, $vertical+580+$margin,$black, $fontBold, $titulo);
        imagettftext($imgTheme, 23, 0, $positionCenterDescImage[1]+$horizontal+2, $vertical+610+$margin, $black, $fontBold, $desc);
       // imagettftext($imgTheme, 24, 0, $positionCenterPrecoImage[1]+$horizontal-18, $vertical+645+$margin, $black, $fontBold, "De");
        imagettftext($imgTheme, 23, 0, $positionCenterPrecoImage[1]+$horizontal, $vertical+645+$margin, $black, $fontBold, 'De '.$preco);
        imagettftext($imgTheme, 23, 0, $positionCenterPromoImage[1]+$horizontal-60, $vertical+710+$margin, $black, $fontBold, "POR");
        imagettftext($imgTheme, 57, 0, $positionCenterPromoImage[1]+$horizontal, $vertical+710+$margin, $red, $fontBold, $promo);
        imagettftext($imgTheme, 23, 0, $positionCenterPromoImage[1]+$horizontal+$sizePromo+10, $vertical+710+$margin, $black, $fontBold, 'CADA');

        $sizePreco = imagettfbbox (23, 0, $fontBold, 'De '.$preco );
        $sizePreco = $sizePreco[2] - $sizePreco[0];
        $constLineWidth = $sizePreco+10;
        $constLineHeight = 2;
        $imgLine = imagecreate($constLineWidth,$constLineHeight);
        imagecolorallocate($imgLine,205, 52, 56);
        imagecopymerge($imgTheme, $imgLine, $positionCenterPrecoImage[1]+$horizontal-4, $vertical+636+$margin, 0, 0, $constLineWidth, $constLineHeight, 100);

        if($parcelado == 'on'){
            $x_h=0;
            $y_v=40;  



                    
            /*Cria a caixa de desconto*/
            imagearc( $imgTheme, $positionCenterParcela[1]+137+$marginPromo+$x_h+56, $vertical+580+$margin+57, 125, 125, 0, 360, $red );
            imagefill( $imgTheme, $positionCenterParcela[1]+137+$marginPromo+$x_h+56, $vertical+580+$margin+57, $red );
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterParcela[1]+137+$marginPromo+$x_h, $vertical+355+$y_v, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+$horizontal-55, $vertical+415+$y_v, $black, $font, "Ou:");
            imagettftext($imgTheme, 30, 0, $positionCenterParcela[1]+$horizontal+$x_h, $vertical+418+$y_v, $red, $fontBold, $vezes.'X de R$'.$parcela);
            imagettftext($imgTheme, 45, 0, $positionCenterParcela[1]+157+$marginPromo+$x_h, $vertical+442+$y_v, $white, $fontBold, $porcentagem);
            imagettftext($imgTheme, 20, 0, $positionCenterParcela[1]+222+$marginPromo+$x_h, $vertical+431+$y_v, $white, $fontBold, "%");
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+160+$marginPromo+$x_h, $vertical+395+$y_v, $white, $fontBold, "Desc.");
        }
        else if($parcelado == 'off'){
            /*Cria a caixa de desconto*/
            imagecopymerge($imgTheme, $imgDesc, $positionCenterPromoImage[1]+45+$marginPromo+30, $vertical+551+$margin+65, 0, 0, 75, 75, 100);

            imagettftext($imgTheme, 28, 0, $positionCenterPromoImage[1]+56+$marginPromo+30, $vertical+668+$margin+5, $white, $fontBold, $porcentagem);
            imagettftext($imgTheme, 16, 0, $positionCenterPromoImage[1]+94+$marginPromo+30, $vertical+663+$margin+5, $white, $fontBold, "%");
            imagettftext($imgTheme, 16, 0, $positionCenterPromoImage[1]+60+$marginPromo+30, $vertical+640+$margin+5, $white, $fontBold, "DESC.");
        }


    }
    else if($promocao == 'off'){
        /*Insere a imagem do produto na imagem tema*/
        imagecopymerge($imgTheme, $imgProduct, $centerProduct+$horizontal, 280-$margin+$vertical, 0, 0, $width, $height, 100);

        /*Escreve na imagem tema*/
        imagettftext($imgTheme, 23, 0, $positionCenterTituloImage[1]+$horizontal+2, $vertical+580+$margin,$black, $fontBold, $titulo);
        imagettftext($imgTheme, 23, 0, $positionCenterDescImage[1]+$horizontal, $vertical+610+$margin, $black, $fontBold, $desc);
       // imagettftext($imgTheme, 24, 0, $positionCenterPrecoImage[1]+$horizontal-18, $vertical+645+$margin, $black, $fontBold, "De");

       
       $sizePreco = imagettfbbox (57, 0, $fontBold, $preco );
       $sizePreco = $sizePreco[2] - $sizePreco[0];

        imagettftext($imgTheme, 23, 0, $positionCenterPreco[1]+$horizontal-58, $vertical+678+$margin, $black, $fontBold, "POR");
        imagettftext($imgTheme, 57, 0, $positionCenterPreco[1]+$horizontal, $vertical+678+$margin, $red, $fontBold, $preco);
        imagettftext($imgTheme, 23, 0, $positionCenterPreco[1]+$horizontal+($sizePreco)+10, $vertical+678+$margin, $black, $fontBold, 'CADA');

        if($parcelado == 'on'){
            $x_h=40;
            $y_v=40;  
                    
            /*Insere o retangulo de desconto na imagem tema*/
            //imagecopymerge($imgTheme, $imgDesc, $positionCenterParcela[1]+137+$marginPromo+$x_h, $vertical+355+$y_v, 0, 0, 120, 120, 100);
            imagettftext($imgTheme, 22, 0, $positionCenterParcela[1]+$horizontal-10, $vertical+415+$y_v, $black, $font, "Ou:");
            imagettftext($imgTheme, 30, 0, $positionCenterParcela[1]+$horizontal+$x_h, $vertical+418+$y_v, $red, $fontBold, $vezes.'X de R$'.$parcela);
        }else if($parcelado == 'off'){
 
          
        }   
    }
?>
