<?php
if(!empty($_POST)){
 
 /*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis vindas via post ou get------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
$titulo = $_POST['titulo'];
$desc = $_POST['desc'];
$origens  = array(',', 'R$');
$destinos = array('.', '');
$preco = (float)str_replace($origens,$destinos,$_POST['preco']);

$promo = (float)str_replace($origens,$destinos,$_POST['parcelado'])/intval($_POST['parcela']);
$parcela = intval($_POST['parcela']);
//$promo = (float)str_replace($origens,$destinos,$_POST['promo']);
if(!empty($_POST['validade'])){
    $validade = $_POST['validade'];
}else{
    $validade = 0;  
}
$sizeProduct = (int)$_POST['sizeProduct'];
$calcSize = $sizeProduct;
$rotacao = $_POST['rotacao'];
//$textoCabecalho = mb_strtoupper($_POST['cabecalho']);
$fonte = $_POST['font'];
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/   
    
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Variáveis que recebem diretórios ou arquivos------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

echo dirname(__FILE__);
$dirCompanie = '../companies/'.$companie.'/';
    $imgTheme = imagecreatefrompng('controllers/images/parcelado.png');
   // $imgLogo = imagecreatefrompng($dirCompanie.'logo_branco.png');    
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
    $horizontalDesc = 130; //Ajuste horizontal da posição do retangulo de desconto
    $verticalDesc = 0; //Ajuste vertical da posição do retangulo de desconto
    $constLineWidth = 400;
    $constLineHeight = 4;
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/ 

    
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Upload e manipulação da imagem do produto---------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
$productState = 'sem imagem';

$new_name =uniqid(rand(), true);  
$ext = strtolower(substr($_FILES['fileUpload']['name'],-4));
if($ext == 'jpeg'){
    $ext = '.jpg';   
}
if($_FILES['fileUpload']['size'] != 0)
{
    $productState = 'com imagem';
    /*Faz o upload da imagem do produto*/
    $dir = $dirCompanie.'uploads/'; //Diretório para uploads
    move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name.$ext); //Fazer upload do arquivo
}
$dir = $dirCompanie."uploads/".$new_name.$ext;
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Ajuste da imagem do produto------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    if($promo == ''){
        $sizemod = 270; //tamanho da imagem do produto caso não aja promoção
        $promocao = 'off';
        $preco = number_format($preco, 2, ',', ' '); 
    }else{
        $sizemod = 220; //tamanho da imagem do produto caso aja promoção
        $promocao = 'on';
        /*Faz o calculo da porcentagem de desconto*/
        $porcentagem = round(100 - ($promo*100/$preco));
        /*Modificado formato da dados*/
        $preco = number_format($preco, 2, ',', ' ');
        $promo = number_format($promo, 2, ',', ' ');
    }

    /*Faz o aumento ou diminuição da imagem do produto*/
    $sizeProduct = $sizeProduct/100;
    if($sizeProduct<=0){ 
        $sizeProduct = 1;
    }
    $sizeProduct = $sizeProduct*$sizemod;
    $imgProduct = ajustImagePaper($dir, $productState, $sizeProduct);
    list($width, $height, $type, $attr) = getimagesize($dir);  

    if($rotacao == 'on'){
        $imgPhoto=imagecreatetruecolor($height, $width);
        imagecopyresampled($imgPhoto,$imgProduct,0,0,0,0,$height,$width,$width, $height);
        $imgProduct = $imgPhoto;
        $imgProduct = imagerotate ($imgProduct , -90 , 0 );
    }
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Criação de todos os objetos que serão inseridos na imagem final(imgTheme)-------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $imgCabecalho = imagecreate(595,220);
    $imgRodape = imagecreate(595,190);
    $imgLine = imagecreate($constLineWidth,$constLineHeight);
    $imgColorDesconto = imagecreate(24,200);
    $imgTraco = imagecreate(20,100);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Cores utilizadas no layoute-----------------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    $colorEmpresa = explode(',', $colorEmpresa);  //cor tema da empresa
    $cor_texto = explode(',', $cor_texto); //cor do texto da empresa
    $color1 = explode(',', $cor[1]); //Cor título e Descrição
    $color2 = explode(',', $cor[2]); //Cor preço
    $color3 = explode(',', $cor[3]); //Cor promoção  

    imagecolorallocate($imgTraco,  $cor_texto[0], $cor_texto[1], $cor_texto[2]);


    imagecolorallocate($imgCabecalho,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    imagecolorallocate($imgRodape,  $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    imagecolorallocate($imgLine,161, 14, 18);
    imagecolorallocate($imgColorDesconto,161, 14, 18); //Colore o retangulo de desconto de vermelho

    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgTheme, 255, 255, 255);
    $black = imagecolorallocate($imgTheme, 0, 0, 0);
    $red = imagecolorallocate($imgTheme, $colorEmpresa[0], $colorEmpresa[1], $colorEmpresa[2]);
    $whiteDesc=imagecolorallocate($imgTheme, 255, 255, 255);
    /*titulo e descrição*/
    $colorText_empresa = imagecolorallocate($imgTheme,  $cor_texto[0], $cor_texto[1], $cor_texto[2]);
    $colorText = imagecolorallocate($imgTheme,  $color1[0], $color1[1], $color1[2]);  
    /*de-preço*/
    $colorRsDe = imagecolorallocate($imgTheme, $color2[0], $color2[1], $color2[2]);
    $colorPreco = imagecolorallocate($imgTheme, $color2[0], $color2[1], $color2[2]);
    $colorDe = imagecolorallocate($imgTheme, $color2[0], $color2[1], $color2[2]);
    /*por-promo*/
    $colorRsPor = imagecolorallocate($imgTheme, $color3[0], $color3[1], $color3[2]);
    $colorPromo = imagecolorallocate($imgTheme, $color3[0], $color3[1], $color3[2]);
    $colorPor = imagecolorallocate($imgTheme, $color3[0], $color3[1], $color3[2]);
    $colorObs = imagecolorallocate($imgTheme, $color1[0], $color1[1], $color1[2]);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Redimencionamento do logo------------- -------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
list($width_logo, $height_logo) = getimagesize($dirCompanie.'logo_branco.png');
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Lógica de Centralização e ajuste de posição dos objetos do layout------------- -------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
//$centerHorizontalCabecalho=centerText(595, 40, $fontBold, $textoCabecalho);
//$centerVerticalLogo=centerImage(220,$height_logo/1.2);
//$centerHorizontalLogo=centerImage(230,$width_logo/1.2);
//$centerVerticalTraco=centerImage(220,110);
//$centerVerticalCabecalho = imagettfbbox ( 40, 0, $fontBold, $textoCabecalho );
//$centerVerticalCabecalho=centerImage(220,$centerVerticalCabecalho[5]);


    $centerLine=centerImage(595, $constLineWidth);
    $horizontalTitulo=centerText(595, 24, $fontBold, $titulo);
    $horizontalDescricao=centerText(595, 20, $font, $desc);
    $horizontalPreco=centerText(595, 60, $fontBold, 'R$'.$preco);
    $horizontalPreco_=centerText(595, 100, $fontBold, $preco);
    $horizontalPromo=centerText(595+80, 100, $fontBold, $promo);
    $centerPreco = centerText(595, 100, $fontBold, $preco);
    /*Centraliza os textos quando não há imagem de produto*/
    $horizontalTitulo_=centerText(595, 26, $fontBold, $titulo);
    $horizontalDescricao_=centerText(595, 22, $font, $desc);
    $horizontalProduct=centerImage(595, $width);
    $horizontalLogo=centerImage(595, $width_logo);
    $VerticalLogo=centerImage(220, $height_logo);
    $centerTitulo=centerText(595, 30, $fontBold, $titulo);
    //$centerTextoCabecalho=centerText(595, 90, $fontBold, $textoCabecalho);
    $centerDescricao=centerText(595, 24, $font, $desc);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Insersão dos objetos na imagem final(imgTheme)------------- --------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/ 
//imagecopymerge($imgTheme, $imgCabecalho, 0, 0, 0, 0, 595, 220, 100); 
//imagecopymerge($imgTheme, $imgTraco, 225, $centerVerticalTraco, 0, 0, 13, 110, 100); 
//imagecopyresampled($imgTheme, $imgLogo, $centerHorizontalLogo, $centerVerticalLogo, 0, 0, $width_logo/1.2, $height_logo/1.2, $width_logo, $height_logo);
//imagettftext($imgTheme, 40, 0, $centerHorizontalCabecalho+112, $centerVerticalCabecalho, $colorText_empresa, $fontBold, $textoCabecalho); 

// imagecopymerge($imgTheme, $imgRodape, 0, 841-190, 0, 0, 595, 190, 100);

    $centerVerticalImage=centerImage(290, $height); 
    $centerVerticalImagePromo=centerImage(355, $height);

    switch ($productState) 
    {
        case "com imagem": 
                    imagecopymerge($imgTheme, $imgProduct, $horizontalProduct, 210+$centerVerticalImage, 0, 0, $width, $height, 100);
                    imagettftext($imgTheme, 24, 0, $horizontalTitulo, 500, $colorText, $fontBold, $titulo);
                    imagettftext($imgTheme, 20, 0, $horizontalDescricao, 530, $colorText, $font, $desc); 
                    /*Insere o preço e a promoção*/
                    imagettftext($imgTheme, 30, 0, 15, 605, $colorDe, $fontBold, "à vista");
                    imagettftext($imgTheme, 60, 0, $horizontalPreco, 605, $colorPreco, $fontBold, 'R$'.$preco);
                    if($parcela<10){
                        imagettftext($imgTheme, 73, 0, 20, 755, $colorText, $fontBold, $parcela."x");
                    }else{
                        imagettftext($imgTheme, 60, 0, 12, 750, $colorText, $fontBold, $parcela."x");
                    }
                    imagettftext($imgTheme, 100, 0, $horizontalPromo, 790, $colorPromo, $fontBold, $promo);
                    $widthPromo = imagettfbbox ( 100, 0, $fontBold, $promo );
                    imagettftext($imgTheme, 16, 0, $horizontalPromo+($widthPromo[2]), 800, $colorRsPor, $font, 'cada'); 

        break;
        case 'sem imagem':
                    imagecopymerge($imgTheme, $imgProduct, $horizontalProduct, 230, 0, 0, $width, $height, 100);
                    imagettftext($imgTheme, 26, 0, $horizontalTitulo_, 400, $colorText, $fontBold, $titulo);
                    imagettftext($imgTheme, 22, 0, $horizontalDescricao_, 430, $colorText, $font, $desc);
                    /*Insere o preço e a promoção*/
                    imagettftext($imgTheme, 30, 0, 15, 605, $colorDe, $fontBold, "à vista");
                    imagettftext($imgTheme, 60, 0, $horizontalPreco, 605, $colorPreco, $fontBold, 'R$'.$preco);
                    if($parcela<10){
                        imagettftext($imgTheme, 73, 0, 20, 755, $colorText, $fontBold, $parcela."x");
                    }else{
                        imagettftext($imgTheme, 60, 0, 12, 750, $colorText, $fontBold, $parcela."x");
                    }
                    imagettftext($imgTheme, 100, 0, $horizontalPromo, 790, $colorPromo, $fontBold, $promo);
                    $widthPromo = imagettfbbox ( 100, 0, $fontBold, $promo );
                    imagettftext($imgTheme, 16, 0, $horizontalPromo+($widthPromo[2]), 800, $colorRsPor, $font, 'cada'); 
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
    imagettftext($imgTheme, 10, 0, $margin, 831, $colorObs, $font, $texto); 
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Salva imagem final e redireciona para pagina de download------------- ----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/ 
    /**Cria a imagem final*/
    $finalImage = $dirCompanie.'downloads/'.$new_name.'.png';
    $quality = 100; //valor entre 0-100
    imagepng($imgTheme, $finalImage, 0);
    header('Location: ../src/actionDownloads.php?download='.$new_name.'&estilo=paper&usuario='.$idusuarios.'&idlayout='.$idlayout);
    imagepng($imgTheme);

    /**Limpa a memoria*/
    imagedestroy($imgTheme);
    imagedestroy($imgProduct);
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/    
}
?>
