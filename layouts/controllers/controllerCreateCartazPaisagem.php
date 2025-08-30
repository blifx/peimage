<?php
if(!empty($_POST)){
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis vindas via post ou get------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
$titulo = $_POST['titulo'];
$subtitulo = $_POST['subtitulo'];
$desc = $_POST['desc'];
$origens  = array(',', 'R$');
$destinos = array('.', '');
$preco = (float)str_replace($origens,$destinos,$_POST['preco']);
$promo = (float)str_replace($origens,$destinos,$_POST['promo']);
$validade = $_POST['validade'];
$textoCabecalho = mb_strtoupper($_POST['cabecalho']);
$fonte = $_POST['font'];

if(!empty($_POST['validade'])){
    $validade = $_POST['validade'];
}else{
    $validade = 0;  
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis que recebem diretórios ou arquivos------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $dirCompanie = '../companies/'.$companie.'/';
    $imgTheme = imagecreatefrompng('../images/fundo_branco_paisagem.png');
    $imgLogo = imagecreatefrompng($dirCompanie.'logo_branco.png');    
    /*Carrega fontes*/
    if($fonte == 'peimage'){
        $font = __DIR__.'/../../fonts/helveticaregular.otf';
        $fontBold = __DIR__.'/../../fonts/helveticaeb.otf';  

    }else{
        /*Carrega fontes*/
        $font = __DIR__.'/../../fonts/calibri.ttf';
        $fontBold = __DIR__.'/../../fonts/calibrib.ttf'; 
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
    $preco = number_format($preco, 2, ',', ' '); 
}else{
    $promocao = 'on';
    /*Faz o calculo da porcentagem de desconto*/
    $porcentagem = round(100 - ($promo*100/$preco));

    /*Modificado formato da dados*/
    $preco = number_format($preco, 2, ',', ' ');
    $promo = number_format($promo, 2, ',', ' ');
}

if(empty($promo)){
    $promo = $preco;
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Gera o nome do arquivo----------------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

$new_name = uniqid(rand(), true); 
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Criação de todos os objetos que serão inseridos na imagem final(imgTheme)-------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $imgCabecalho = imagecreate(841,150);
    $imgTraco = imagecreate(20,100);
    $imgDesconto = imagecreate(110,110);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Cores utilizadas no layoute-----------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $colorEmpresa = explode(',', $colorEmpresa);  //cor tema da empresa
    $cor_texto = explode(',', $cor_texto); //cor do texto da empresa
    imagecolorallocate($imgCabecalho,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    imagecolorallocate($imgDesconto,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    imagecolorallocate($imgTraco,  $cor_texto[0], $cor_texto[1], $cor_texto[2]); 
    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgTheme, 255, 255, 255);
    $black = imagecolorallocate($imgTheme, 0, 0, 0);


        /*Cores usadas na imagem do produto e tema*/

        $white1 = imagecolorallocate($imgTheme, 255, 255, 255);
        $cinza = imagecolorallocate($imgTheme, 162, 156, 158);
        $amarelo = imagecolorallocate($imgTheme, 255, 203, 41);

        $colorText_empresa = imagecolorallocate($imgTheme,  $cor_texto[0], $cor_texto[1], $cor_texto[2]);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Redimencionamento do logo------------- -------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
list($width_logo, $height_logo) = getimagesize($dirCompanie.'logo_branco.png');
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Centralização e ajuste de posição dos objetos do layout------------- -------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
$textPromo = imagecolorallocate($imgTheme, $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
if($companie == 'rede paper'){
    $textPromo = $colorText_empresa ; 
}
$centerHorizontalCabecalho=centerText(841, 70, $fontBold, $textoCabecalho);
$centerVerticalLogo=centerImage(150,$height_logo/1.2);
$centerHorizontalLogo=centerImage(225,$width_logo/1.2);
$centerVerticalTraco=centerImage(150,112.5);
$centerVerticalCabecalho = imagettfbbox ( 70, 0, $fontBold, $textoCabecalho );
$centerVerticalCabecalho=centerImage(150,$centerVerticalCabecalho[5]);



$centerLine=centerImage(595, $constLineWidth);
$centerimg=centerImage(595, 460);

$horizontalTitulo=centerText(841, 30, $fontBold, $titulo);
$horizontalSubtitulo=centerText(841, 30, $fontBold, $subtitulo);
$horizontalDescricao=centerText(841, 24, $fontBold, $desc);
$horizontalPreco=centerText(595, 32, $fontBold, 'DE R$ '.$preco);
$horizontalPromo=centerText(595, 42, $fontBold, 'POR R$ '.$promo);
$centerTitulo=centerText(595, 32, $fontBold, $titulo);
$centerDescricao=centerText(595, 32, $fontBold, $desc);
$horizontalPreco_=centerText(595, 42, $fontBold, 'POR R$ '.$preco);


//Tamanho dos textos
$tamanhoDe = imagettfbbox ( 20, 0, $fontBold, 'De ' );
$tamanhoDe = $tamanhoDe[2] - $tamanhoDe[0];

$tamanhoCada = imagettfbbox ( 20, 0, $fontBold, 'cada' );
$tamanhoCada = $tamanhoCada[2] - $tamanhoCada[0];
$centertamanhoCada=centerText(841, 20, $fontBold, 'cada ');

$tamanhoRs = imagettfbbox ( 20, 0, $fontBold, 'R$' );
$tamanhoRs = $tamanhoRs[2] - $tamanhoRs[0];

$tamanhoPor = imagettfbbox ( 20, 0, $font, 'Por' );
$tamanhoPor = $tamanhoPor[2] - $tamanhoPor[0];

$centerHorizontalDe=centerText(841, 30, $fontBold, 'De ');
$widthPreco = imagettfbbox ( 30, 0, $fontBold, 'R$ '.$preco );
$widthPreco = $widthPreco[2] - $widthPreco[0];




$centerHorizontalPreco=centerText(841, 30, $fontBold, 'R$ '.$preco);
$centerHorizontalPromo=centerText(841, 130, $fontBold, $promo);

//Centraliza linha no preço
$widthLine = imagettfbbox ( 30, 0, $fontBold, 'R$   '.$preco );
$widthLine = $widthLine[2]-$widthLine[0];
$centerLine=centerImage(841, $widthLine);

$widthPromo = imagettfbbox ( 50, 0, $fontBold, $promo );
$widthPromo = $widthPromo[2] - $widthPromo[0];

$tamanhoTotalDoTexto = $tamanhoRs + $tamanhoPor + $widthPromo;


//exit(1);
$imgLine = imagecreate($constLineWidth,$constLineHeight);
imagecolorallocate($imgLine, 0, 0, 0);

$promo = explode(',', $promo);
$widthPromo = imagettfbbox ( 130, 0, $fontBold, $promo[0].',' );
$widthPromo2 = imagettfbbox ( 50, 0, $fontBold, $promo[1] );
$centerHorizontalPromo=centerText(841, 130, $fontBold, $promo[0].',');
$centerHorizontalPromo2=centerText(841, 130, $fontBold, $promo[1]);

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Insersão dos objetos na imagem final(imgTheme)------------- --------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    imagecopymerge($imgTheme, $imgCabecalho, 0, 0, 0, 0, 841, 150, 100); 
    imagecopymerge($imgTheme, $imgTraco, 225, $centerVerticalTraco, 0, 0, 13, 110, 100); 
    imagecopyresampled($imgTheme, $imgLogo, $centerHorizontalLogo, $centerVerticalLogo, 0, 0, $width_logo/1.2, $height_logo/1.2, $width_logo, $height_logo);
    imagettftext($imgTheme, 70, 0, $centerHorizontalCabecalho+117, $centerVerticalCabecalho, $colorText_empresa, $fontBold, $textoCabecalho);

    switch ($promocao) 
    {
        case "on":
            imagecopymerge($imgTheme, $imgDesconto, 680, 190, 0, 0, 110, 110, 100);
            imagettftext($imgTheme, 40, 0, 692, 278, $colorText_empresa, $fontBold, $porcentagem);
            imagettftext($imgTheme, 25, 0, 752, 266, $colorText_empresa, $fontBold, '%');
            imagettftext($imgTheme, 20, 0, 705, 235, $colorText_empresa, $fontBold, 'DESC');
            
            imagettftext($imgTheme, 30, 0, 50, 220, $black, $font, $titulo);
            imagettftext($imgTheme, 30, 0, 50, 265, $black, $font, $subtitulo);
            imagettftext($imgTheme, 24, 0, 50, 305, $cinza, $font, $desc);

            //imagettftext($imgTheme, 16, 0, 105+$x_anuncio-10, 235+$y_anuncio, $black, $fontBold, 'de');
            imagettftext($imgTheme, 20, 0, ($centerHorizontalDe-($widthPreco)/2)-20+((20+$tamanhoDe)/2), 365, $black, $fontBold, 'De ');
            imagettftext($imgTheme, 30, 0, $centerHorizontalPreco+(20+$tamanhoDe)/2, 370, $black, $fontBold, 'R$ '.$preco);
            imagecopymerge($imgTheme, $imgLine, $centerLine+((20+$tamanhoDe)/2)+2, 356, 0, 0, $widthLine, $constLineHeight, 100);

            imagettftext($imgTheme, 40, 0, ($centerHorizontalPromo-(($widthPromo2[2])/2)-100)+((100+$tamanhoPor)/2)+18-15, 442, $black, $fontBold, 'Por');
            imagettftext($imgTheme, 60, 0, ($centerHorizontalPromo-(($widthPromo2[2])/2)-100)+((100+$tamanhoRs)/2)-15, 510, $textPromo, $fontBold, 'R$');
            imagettftext($imgTheme, 130, 0,($centerHorizontalPromo-(($widthPromo2[2])/2)+((100+$tamanhoRs)/2))-15, 520, $textPromo, $fontBold, $promo[0].',');
            imagettftext($imgTheme, 50, 0, $centerHorizontalPromo+$widthPromo[2]-(($widthPromo2[2])/2)+((100+$tamanhoRs)/2)-15, 446, $textPromo, $fontBold, $promo[1]);
            imagettftext($imgTheme, 20, 0, $centerHorizontalPromo+$widthPromo[2]-(($widthPromo2[2])/2)+((100+$tamanhoRs)/2)+10-15, 510, $black, $fontBold, 'cada');
        break;
        case "off":
        imagettftext($imgTheme, 30, 0, $horizontalTitulo, 240, $black, $fontBold, $titulo);
        imagettftext($imgTheme, 30, 0, $horizontalSubtitulo, 285, $black, $fontBold, $subtitulo);
        imagettftext($imgTheme, 24, 0, $horizontalDescricao, 325, $cinza, $fontBold, $desc);

            imagettftext($imgTheme, 40, 0, ($centerHorizontalPromo-(($widthPromo2[2])/2)-100)+((100+$tamanhoPor)/2)+18-15, 442, $black, $fontBold, 'Por');
            imagettftext($imgTheme, 60, 0, ($centerHorizontalPromo-(($widthPromo2[2])/2)-100)+((100+$tamanhoRs)/2)-15, 510, $textPromo, $fontBold, 'R$');
            imagettftext($imgTheme, 130, 0,($centerHorizontalPromo-(($widthPromo2[2])/2)+((100+$tamanhoRs)/2))-15, 520, $textPromo, $fontBold, $promo[0].',');
            imagettftext($imgTheme, 50, 0, $centerHorizontalPromo+$widthPromo[2]-(($widthPromo2[2])/2)+((100+$tamanhoRs)/2)-15, 446, $textPromo, $fontBold, $promo[1]);
            imagettftext($imgTheme, 20, 0, $centerHorizontalPromo+$widthPromo[2]-(($widthPromo2[2])/2)+((100+$tamanhoRs)/2)+10-15, 510, $black, $fontBold, 'cada');
        break;
    }

    if($validade <> 0){
        $validade = dataMes($validade); //converte mês em número para nome. ex 6 = junho
        $texto = 'Oferta válida até '.$validade[2].' de '.$validade[1];
        $ValidadeText = imagettfbbox ( 10, 0, $font, $texto);
        $ValidadeText_ = $ValidadeText[2];
        $margin = 15;
        $whiteObs = imagecolorallocate($imgTheme, 255, 255, 255);
        ImageFilledRectangle($imgTheme, 10, 815, $ValidadeText_+20, 835, $whiteObs); 
        imagettftext($imgTheme, 10, 0, $margin, 585, $colorObs, $font, $texto); 
    }
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Salva imagem final e redireciona para pagina de download------------- ----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/ 
    /**Cria a imagem final*/
    
    $finalImage = $dirCompanie.'downloads/'.$new_name.'.png';
    imagepng($imgTheme, $finalImage, 0);
    header('Location: ../src/actionDownloads.php?download='.$new_name.'&estilo=paperPaisagem&usuario='.$idusuarios.'&idlayout='.$idlayout);
    imagepng($imgTheme);
    /**Limpa a memoria*/
    imagedestroy($imgTheme);
    imagedestroy($imgProduct);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
}
?>
