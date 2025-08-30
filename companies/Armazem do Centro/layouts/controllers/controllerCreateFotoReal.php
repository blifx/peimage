<?php
if(!empty($_POST)){
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis vindas via post ou get------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $new_name = uniqid(rand(), true);




/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis que recebem diretórios ou arquivos------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $dirCompanie = '../../../companies/'.$companie.'/';
    $imgTheme = imagecreatefrompng('../.././../images/fundo_branco_status.png');

    $dirCompaign = '../campaigns/'.$campanha.'/'.$namelayout;
    $imgThemeType = imagecreatefrompng($dirCompaign.'/'.$nameTema);


    /*Carrega fontes*/
    if($fonte == 'peimage'){
        $font = __DIR__.'/../../../../fonts/helveticaregular.otf';
        $fontBold = __DIR__.'/../../../../fonts/helveticaeb.otf';  

    }else{
        /*Carrega fontes*/
        $font = __DIR__.'/../../../../fonts/calibri.ttf';
        $fontBold = __DIR__.'/../../../../fonts/calibrib.ttf'; 
    }
  
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Constantes----------------------------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/ 
    $constLineWidth = 220;
    $constLineHeight = 2;
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de quando existe ou não promoção-----------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/  
    
    if($promo == ''){
        $promocao = 'off';
    }else{
        $promocao = 'on';
        /*Faz o calculo da porcentagem de desconto*/
        $porcentagem = round(100 - ($promo*100/$preco));
    }
   
    if(empty($promo)){
        $avista = $preco;
        $promo = $preco;
    }else{
        $avista = $promo;
    }
           

  
    $preco = number_format($preco, 2, ',', ''); 
    $promo = number_format($promo, 2, ',', '');
    $avista = number_format($avista, 2, ',', '');
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Gera o nome do arquivo----------------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $new_name = uniqid(rand(), true); 
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Criação de todos os objetos que serão inseridos na imagem final(imgTheme)-------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $anuncio = imagecreate(300,300);
    $anuncioBoard = imagecreate(300,300);
    $imgDesconto = imagecreate(118,70);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Cores utilizadas no layoute-----------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    imagecolorallocate($anuncio,  255, 255, 255);
    imagecolorallocate($anuncioBoard,  173, 173, 173);
    imagecolorallocate($imgDesconto,  40, 40, 40);
    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgTheme, 255, 255, 255);
    $black = imagecolorallocate($imgTheme, 0, 0, 0);
    
    /*Cores usadas na imagem do produto e tema*/
    $white1 = imagecolorallocate($imgTheme, 255, 255, 255);
    $cinza = imagecolorallocate($imgTheme, 40, 40, 40);
    $vermelho = imagecolorallocate($imgTheme, 173, 52, 54);


/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Centralização e ajuste de posição dos objetos do layout------------- -------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
     $textPromo = imagecolorallocate($imgTheme, $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    // if($companie == 'rede paper'){
    //     $textPromo = $colorText_empresa ; 
    // }

//separa os o valor de promoção onde há virgula
    //caso 1 - com promocional, titulo e descrição
    $horizontalTitulo=centerText(165, 12, $fontBold, $titulo);
    $horizontalSub=centerText(165, 12, $fontBold, $sub);
    $horizontalDescricao=centerText(165, 11, $fontBold, $desc);

    $horizontalPreco=centerText(165, 18, $fontBold, "DE R$ ".$preco);
    $horizontalPromo=centerText(165, 18, $fontBold, "POR R$ ".$promo);

    $horizontalPorcDesc=centerText(165, 55, $fontBold, $porcentagem."%");
    $horizontalPorc=centerText(165, 15, $fontBold, "DE DESCONTO");


/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Insersão dos objetos na imagem final(imgTheme)------------- --------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $pos_x = 10;
    $pos_y = -40;
   
    //imagecopymerge($imgTheme, $imgThemeType, 100, 200, 0, 0, 100, 100, 100);
    imagecopymerge($imgTheme, $image, 0, 0, 0, 0, 540, 960, 100);  
    //imagecopymerge($imgTheme, $imgThemeType, 20, 20, 0, 0, 298, 362, 100);
    imagecopyresampled($imgTheme, $imgThemeType, 20, 50, 0, 0, 126, 180, 126, 180);

    imagecopymerge($imgTheme, $anuncioBoard, $pos_x+333, $pos_y+668, 0, 0, 169, 249, 100);   
    imagecopymerge($imgTheme, $anuncio, $pos_x+335, $pos_y+670, 0, 0, 165, 245, 100); 
 
    imagecopymerge($imgTheme, $imgDesconto, $pos_x+343, $pos_y+804, 0, 0, 148, 105, 100); 
    imagettftext($imgTheme, 12, 0,$pos_x+335+$horizontalTitulo, $pos_y+695, $cinza, $fontBold, $titulo);
    imagettftext($imgTheme, 12, 0,$pos_x+335+$horizontalSub, $pos_y+712, $cinza, $fontBold, $sub);
    imagettftext($imgTheme, 11, 0,$pos_x+335+$horizontalDescricao, $pos_y+729, $cinza, $fontBold, $desc);
    //imagettftext($imgTheme, 24, 0, $horizontalDescricao, 695, $colorText_empresa, $fontBold, $desc);

    imagettftext($imgTheme, 18, 0,$pos_x+335+$horizontalPreco, $pos_y+767, $cinza, $fontBold, "DE R$ ".$preco);
    imagettftext($imgTheme, 18, 0,$pos_x+335+$horizontalPromo, $pos_y+790, $vermelho, $fontBold, "POR R$ ".$promo);

    imagettftext($imgTheme, 55, 0,$pos_x+335+$horizontalPorcDesc, $pos_y+870, $white1, $fontBold, $porcentagem."%");
    imagettftext($imgTheme, 15, 0,$pos_x+335+$horizontalPorc, $pos_y+895, $white1, $fontBold, "DE DESCONTO");

    //$porcentagem
    
    //imagecopymerge($imgTheme, $imgTraco, 225, $centerVerticalTraco, 0, 0, 13, 110, 100); 
    //imagecopyresampled($imgTheme, $imgLogo, $centerHorizontalLogo, $centerVerticalLogo, 0, 0, $width_logo/1.2, $height_logo/1.2, $width_logo, $height_logo);
    //imagettftext($imgTheme, 70, 0, $centerHorizontalCabecalho+117, $centerVerticalCabecalho, $colorText_empresa, $fontBold, $textoCabecalho);

/*     switch ($promocao) 
    {
        case "on":
            imagettftext($imgTheme, 30, 0, $horizontalTitulo, 665, $colorText_empresa, $fontBold, $titulo);
            imagettftext($imgTheme, 24, 0, $horizontalDescricao, 695, $colorText_empresa, $fontBold, $desc);

            imagecopymerge($imgTheme, $imgDesconto, 495, 685, 0, 0, 70, 70, 100);
            imagettftext($imgTheme, 30, 0, 505, 743, $colorEmpresa, $fontBold, $porcentagem);
            imagettftext($imgTheme, 15, 0, 546, 735, $colorEmpresa, $fontBold, '%');
            imagettftext($imgTheme, 15, 0, 510, 710, $colorEmpresa, $fontBold, 'DESC');

            imagettftext($imgTheme, 15, 0, 20, 717, $colorEmpresaSecundaria, $fontBold, 'DE');
            imagettftext($imgTheme, 13, 0, 20, 732, $colorText_empresa, $fontBold, 'R$');
            imagettftext($imgTheme, 30, 0, 50, 732, $colorText_empresa, $fontBold, $preco);

            imagettftext($imgTheme, 80, 0, $horizontalPromo, 800, $colorText_empresa, $fontBold, $promo[0]);
            imagettftext($imgTheme, 30, 0, $horizontalPromoCentavos+($widthPromo/2)+30, 755, $colorText_empresa, $fontBold, ','.$promo[1]);
            imagettftext($imgTheme, 20, 0, $horizontalDe-($widthPromo)/2-35, 780, $colorEmpresaSecundaria, $fontBold, 'POR');
            imagettftext($imgTheme, 18, 0, $horizontalDe-($widthPromo)/2-35, 800, $colorText_empresa, $fontBold, 'R$');
        break;
        case "off":
            imagettftext($imgTheme, 30, 0, $horizontalTitulo, 665, $colorText_empresa, $fontBold, $titulo);
            imagettftext($imgTheme, 24, 0, $horizontalDescricao, 695, $colorText_empresa, $fontBold, $desc);

            imagettftext($imgTheme, 80, 0, $horizontalPromo, 800, $colorText_empresa, $fontBold, $promo[0]);
            imagettftext($imgTheme, 30, 0, $horizontalPromoCentavos+($widthPromo/2)+30, 755, $colorText_empresa, $fontBold, ','.$promo[1]);
            imagettftext($imgTheme, 20, 0, $horizontalDe-($widthPromo)/2-35, 780, $colorEmpresaSecundaria, $fontBold, 'POR');
            imagettftext($imgTheme, 18, 0, $horizontalDe-($widthPromo)/2-35, 800, $colorText_empresa, $fontBold, 'R$');
        break;
        case "parcelado":
            imagettftext($imgTheme, 30, 0, $horizontalTitulo, 665, $colorText_empresa, $fontBold, $titulo);
            imagettftext($imgTheme, 24, 0, $horizontalDescricao, 695, $colorText_empresa, $fontBold, $desc);

            imagettftext($imgTheme, 16, 0, 420, 778, $colorEmpresaSecundaria, $fontBold, 'À VISTA');
            imagettftext($imgTheme, 14, 0, 420, 810, $colorText_empresa, $fontBold, 'R$');
            imagettftext($imgTheme, 30, 0, 446, 810, $colorText_empresa, $fontBold, $avista);

            imagettftext($imgTheme, 80, 0, 20+$horizontalPromo-$widthPromoCentavos, 800, $colorText_empresa, $fontBold, $promo[0]);
            imagettftext($imgTheme, 30, 0, $horizontalPromoCentavos+($widthPromo/2-$widthPromoCentavos)+50, 755, $colorText_empresa, $fontBold, ','.$promo[1]);

            imagettftext($imgTheme, 15, 0, 50, 760, $colorText_empresa, $fontBold, 'R$');
            imagettftext($imgTheme, 35, 0, 50, 800, $colorEmpresaSecundaria, $fontBold, $parcela."X");
        break;
    } */
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Salva imagem final e redireciona para pagina de download------------- ----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/ 
    /**Cria a imagem final*/
    $finalImage = $dirCompanie.'downloads/'.$new_name.'.png';
    imagepng($imgTheme, $finalImage, 0);
    echo $new_name;
    
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
}
?>
