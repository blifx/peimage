<?php
if(!empty($_GET)){
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis vindas via post ou get------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $titulo = mb_strtoupper($_GET['titulo']);
    $desc = mb_strtoupper($_GET['desc']);
    $origens  = array(',', 'R$');
    $destinos = array('.', '');
    $preco = (float)str_replace($origens,$destinos,$_GET['preco']);
    $promo = (float)str_replace($origens,$destinos,$_GET['promo']);
    $fonte = $_GET['font'];
    $parcela = strtoupper($_GET['parcela']);
    $rotacao = $_GET['rotacao'];
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Upload e manipulação da imagem do produto---------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $dirCompanie = '../companies/'.$companie.'/';
    $dir = $dirCompanie.'uploads/';
    $new_name =uniqid(rand(), true);  
    $ext = strtolower(substr($_FILES['fileToUpload']['name'],-4));
    if($ext == 'jpeg'){
        $ext = '.jpg';   
    }
    if($_FILES['fileToUpload']['size'] != 0)
    {
        $productState = 'com imagem';
        /*Faz o upload da imagem do produto*/
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $dir.$new_name.$ext); //Fazer upload do arquivo
    }


    $dirImage = $dirCompanie."uploads/".$new_name.$ext;
    // Carrega a imagem a ser manipulada
    $image = WideImage::load($dirImage);
    // Redimensiona a imagem
    $image = $image->resize(595,595);
    $image->saveToFile($dirImage);
    list($width, $height, $type, $attr) = getimagesize($dirImage); 
    if($type == 2){
        imagepng(imagecreatefromjpeg($dirImage),$dirImage);
        $image = imagecreatefrompng($dirImage);
    }else if($type == 3){
        $image = imagecreatefrompng($dirImage);
    }else{
        echo "formato de imagem incorreto";
    }

    if($rotacao == 'on'){
        $image = imagerotate ($image , -90 , 0 );
      }

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis que recebem diretórios ou arquivos------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $dirCompanie = '../companies/'.$companie.'/';
    $imgTheme = imagecreatefrompng('../images/fundo_branco_retrato.png');
    // Carrega a imagem a ser manipulada
    $imgLogo = WideImage::load($dirCompanie.'logo_pequeno.png');
    // Redimensiona a imagem
    $imgLogo = $imgLogo->resize(150,60);
    $dirLogo=$dirCompanie."uploads/".$new_name.'234.png';
    $imgLogo->saveToFile($dirLogo);
    $imgLogo = imagecreatefrompng($dirLogo); 

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
           
    if($parcela <> "1"){
    $promocao = "parcelado";

    $auxPromo = $promo;
    $promo = $preco/(int)$parcela;
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
    $imgCabecalho = imagecreate(595,841);
    $imgRodape = imagecreate(595,841);
    $imgTraco = imagecreate(20,100);
    $imgDesconto = imagecreate(80,80);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Cores utilizadas no layoute-----------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $colorEmpresa = explode(',', $colorEmpresa);  //cor tema da empresa
    $colorEmpresaSecundaria = explode(',', $colorEmpresaSecundaria);  //cor tema da empresa
    $cor_texto = explode(',', $cor_texto); //cor do texto da empresa
    imagecolorallocate($imgCabecalho,  $colorEmpresaSecundaria[0], $colorEmpresaSecundaria[1], $colorEmpresaSecundaria[2]);
    imagecolorallocate($imgRodape,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    imagecolorallocate($imgDesconto,  $colorEmpresaSecundaria[0], $colorEmpresaSecundaria[1], $colorEmpresaSecundaria[2]);
    imagecolorallocate($imgTraco,  $cor_texto[0], $cor_texto[1], $cor_texto[2]); 
    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgTheme, 255, 255, 255);
    $black = imagecolorallocate($imgTheme, 0, 0, 0);
    
    /*Cores usadas na imagem do produto e tema*/
    $white1 = imagecolorallocate($imgTheme, 255, 255, 255);
    $cinza = imagecolorallocate($imgTheme, 162, 156, 158);
    $amarelo = imagecolorallocate($imgTheme, 255, 203, 41);

    $colorText_empresa = imagecolorallocate($imgTheme,  $cor_texto[0], $cor_texto[1], $cor_texto[2]);
    $colorEmpresa = imagecolorallocate($imgTheme,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    $colorEmpresaSecundaria = imagecolorallocate($imgTheme,  $colorEmpresaSecundaria[0], $colorEmpresaSecundaria[1], $colorEmpresaSecundaria[2]);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Redimencionamento do logo------------- -------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    list($width_logo, $height_logo) = getimagesize($dirLogo);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Centralização e ajuste de posição dos objetos do layout------------- -------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
     $textPromo = imagecolorallocate($imgTheme, $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    // if($companie == 'rede paper'){
    //     $textPromo = $colorText_empresa ; 
    // }

//separa os o valor de promoção onde há virgula
    $promo = explode(',', $promo);
    $widthPromoConvert = imagettfbbox ( 80, 0, $fontBold, $promo[0] );
    $widthPromo = $widthPromoConvert[2];
    $widthPromoCentavosConvert = imagettfbbox ( 30, 0, $fontBold, ','.$promo[1]);
    $widthPromoCentavos = $widthPromoCentavosConvert[2];
    //caso 1 - com promocional, titulo e descrição
    $horizontalTitulo=centerText(595, 30, $fontBold, $titulo);
    $horizontalDescricao=centerText(595, 24, $fontBold, $desc);
    $horizontalPromo=centerText(595, 80, $fontBold, $promo[0]);
    $horizontalPromoCentavos=centerText(595, 30, $fontBold, ','.$promo[1]);
    $horizontalPor=centerText(595, 20, $fontBold, "POR");
    $horizontalDe=centerText(595, 18, $fontBold, "R$");

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Insersão dos objetos na imagem final(imgTheme)------------- --------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    imagecopymerge($imgTheme, $imgCabecalho, 0, 0, 0, 0, 595, 20, 100); 
    imagecopymerge($imgTheme, $imgRodape, 0, 625, 0, 0, 595, 225, 100); 
    imagecopymerge($imgTheme, $image, 0, 25, 0, 0, 595, 595, 100);  
    imagecopy($imgTheme, $imgLogo, 595-$width_logo-15, 40, 0, 0, $width_logo, $height_logo);
    
    //imagecopymerge($imgTheme, $imgTraco, 225, $centerVerticalTraco, 0, 0, 13, 110, 100); 
    //imagecopyresampled($imgTheme, $imgLogo, $centerHorizontalLogo, $centerVerticalLogo, 0, 0, $width_logo/1.2, $height_logo/1.2, $width_logo, $height_logo);
    //imagettftext($imgTheme, 70, 0, $centerHorizontalCabecalho+117, $centerVerticalCabecalho, $colorText_empresa, $fontBold, $textoCabecalho);

    switch ($promocao) 
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
    }
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
