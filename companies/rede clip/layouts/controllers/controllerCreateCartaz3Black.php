<?php
if(!empty($_POST)){
    $tema = $_POST['tema'];
    $namelayout = $_POST['namelayout'];
    $texto1 = strtoupper($_POST['texto1']);
    $texto2 = strtoupper($_POST['texto2']);
    $texto3 = strtoupper($_POST['texto3']);
    $desc = $_POST['desc'];
    $origens  = array(',', 'R$');
    $destinos = array('.', '');
    $preco = (float)str_replace($origens,$destinos,$_POST['preco']);
    $promo = (float)str_replace($origens,$destinos,$_POST['promo']);
    $outlet = (float)str_replace($origens,$destinos,$_POST['outlet']);
    $observacao = $_POST['obs'];
    $sizeProduct = (int)$_POST['sizeProduct'];
    $calcSize = $sizeProduct;
    $campaign = $_POST['idcampanha'];
    $rotacao = $_POST['rotacao'];

    $promocao = 'on';
    if($promo == ''){
        $promocao = 'off'; 
    }



    $dirCompaign = '../campaigns/'.$campaign.'/'.$namelayout;

    /*Carrega os dados vindos via post*/   
    $horizontal = (float)$_POST['horizontalProduct']*37.795275590551;
    $vertical = (float)$_POST['verticalProduct']*37.795275590551;

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Upload e manipulação da imagem do produto---------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

$new_name =uniqid(rand(), true);  
$ext = strtolower(substr($_FILES['fileUpload']['name'],-4));
if($ext == 'jpeg'){
    $ext = '.jpg';   
}

$fileOn = 0;
if($_FILES['fileUpload']['size'] != 0)
{
	$fileOn = 1;
    $productState = 'com imagem';
    /*Faz o upload da imagem do produto*/
    $dir = '../uploads/'; //Diretório para uploads
    move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name.$ext); //Fazer upload do arquivo
}
$dir = "../uploads/".$new_name.$ext;
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    /*Faz o calculo da porcentagem de desconto*/
    $porcentagem = round(100 - ($outlet*100/$preco));
    /*Modificado formato da dados*/
    $preco = number_format($preco, 2, ',', ' ');
    $promo = number_format($promo, 2, ',', ' ');
    $outlet = number_format($outlet, 2, ',', ' ');

    if($_FILES['fileUpload']['size'] != 0)
    {
    /*Faz o aumento ou diminuição da imagem do produto*/
    $sizeProduct = $sizeProduct/100;
    if($sizeProduct<=0){ 
        $sizeProduct = 1;
    }
    $sizeProduct = $sizeProduct*190;


    // Carrega a imagem a ser manipulada
    $image = WideImage::load($dir);
    // Redimensiona a imagem
    //$imgProduct = $image->resize(200,200);

    $imgProduct = ajustImagePaper($dir, $productState, $sizeProduct);
    /*Descobre as caracteristicas da imagem produto*/
    list($width, $height, $type, $attr) = getimagesize($dir); 
        
    if($rotacao == 'on'){
        $imgPhoto=imagecreatetruecolor($height, $width);
        imagecopyresampled($imgPhoto,$imgProduct,0,0,0,0,$height,$width,$width, $height);
        $imgProduct = $imgPhoto;
        $imgProduct = imagerotate ($imgProduct , -90 , 0 );   
    } 
}



$imgTheme = imagecreatefrompng($dirCompaign.'/'.$tema);

    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgTheme, 255, 255, 255);
    $black = imagecolorallocate($imgTheme, 0, 0, 0);
    $red = imagecolorallocate($imgTheme, 161, 14, 18);
    $amarelo = imagecolorallocate($imgTheme, 255, 242, 18);


    $font = __DIR__.'/../../../../fonts/calibri.ttf';
    $fontBold = __DIR__.'/../../../../fonts/calibrib.ttf'; 

 
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*---Escreve as informações do produto na imagem do tema-----------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

$preco = str_replace(' ', '', $preco);
$promo = str_replace(' ', '', $promo);
$outlet = str_replace(' ', '', $outlet);


    $tamanhoMaxText = 595-$width-80;

    //Escreve a descrição do produto na imagem tema
    $tamanhoFontTexto1 = ajustSizeString(40, $tamanhoMaxText, $fontBold, $texto1);
    $tamanhoFontTexto2 = ajustSizeString(40, $tamanhoMaxText, $fontBold, $texto2);
    $tamanhoFontTexto3 = ajustSizeString(40, $tamanhoMaxText, $fontBold, $texto3);
    $tamanhoFont = min($tamanhoFontTexto1, $tamanhoFontTexto2, $tamanhoFontTexto3);

	if($fileOn == 1){
    	$espaco = 70;
	}else{
    	$espaco = 0;
	}

    $horText1=centerText(595-$width+$espaco, $tamanhoFont, $fontBold, $texto1);
    $horText2=centerText(595-$width+$espaco, $tamanhoFont, $fontBold, $texto2);
    $horText3=centerText(595-$width+$espaco, $tamanhoFont, $fontBold, $texto3);
    imagettftext($imgTheme, $tamanhoFont, 0, ($horText1+$width), 310, $black, $fontBold, $texto1);
    imagettftext($imgTheme, $tamanhoFont, 0, ($horText2+$width), 360, $black, $fontBold, $texto2);
    imagettftext($imgTheme, $tamanhoFont, 0, ($horText3+$width), 410, $black, $fontBold, $texto3);

    //Coloca a imagem do produto na imagem
    imagecopymerge($imgTheme, $imgProduct, 50, 247+$vertical, 0, 0, $width, $height, 100);

    //Escreve o valor do preço na imagem
    list($left,, $right) = imageftbbox( 70, 0, $fontBold, "R$ ".$preco);
    $widthPreco = $right - $left;
    $horPreco=centerText(595-130, 70, $fontBold, "R$ ".$preco);
    imagettftext($imgTheme, 20, 0, 20, 495, $black, $fontBold, "PREÇO");
    imagettftext($imgTheme, 20, 0, 20, 520, $black, $fontBold, "NORMAL:");
    imagettftext($imgTheme, 70, 0, 130+$horPreco, 525, $black, $fontBold, "R$ ".$preco);
    $imgLine = imagecreate(2,2);
	imagecolorallocate($imgLine,237, 50, 55);
    imagecopymerge($imgTheme, $imgLine, 130+$horPreco, 495, 0, 0, $widthPreco, 4, 100);



    //Escreve o valor da oferta na imagem
    list($left,, $right) = imageftbbox( 70, 0, $fontBold, "R$ ".$promo);
    $widthPromo = $right - $left;
    $horPromo=centerText(595-130, 70, $fontBold, "R$ ".$promo);
    imagettftext($imgTheme, 20, 0, 20, 600, $black, $fontBold, "PREÇO NA");
    imagettftext($imgTheme, 20, 0, 20, 625, $black, $fontBold, "OFERTA:");
    imagettftext($imgTheme, 70, 0, 130+$horPromo, 630, $black, $fontBold, "R$ ".$promo);
    imagecopymerge($imgTheme, $imgLine, 130+$horPromo, 600, 0, 0, $widthPromo, 4, 100);

    //Escreve o valor do outlet na imagem
    list($left,, $right) = imageftbbox( 120, 0, $fontBold, $outlet);
    $widthOutlet = $right - $left;
    $horOutlet=centerText(595-130, 100, $fontBold, $outlet);
    imagettftext($imgTheme, 25, 0, 20, 715, $amarelo, $fontBold, "SÓ NO");
    imagettftext($imgTheme, 25, 0, 20, 743, $amarelo, $fontBold, "BLACK");
    imagettftext($imgTheme, 25, 0, 20, 771, $amarelo, $fontBold, "FRIDAY");
    imagettftext($imgTheme, 25, 0, 20, 799, $amarelo, $fontBold, "CLIP:");

    if($outlet < 10 ){
        imagettftext($imgTheme, 135, 0, 180, 797, $amarelo, $fontBold, $outlet);

    }else if(($outlet >= 10) && ($outlet < 100)){
        imagettftext($imgTheme, 135, 0, 165, 805, $amarelo, $fontBold, $outlet);
    }else if(($outlet > 100) && ($outlet < 1000) ){
        imagettftext($imgTheme, 120, 0, 130, 797, $amarelo, $fontBold, $outlet);
    }else{
        imagettftext($imgTheme, 100, 0, 140, 787, $amarelo, $fontBold, $outlet);
    }


    //Coloca a porcentafem de desconto na imagem
    imagettftext($imgTheme, 18, 0, 470, 180, $white, $fontBold, "Desconto");

    if($porcentagem < 10){
        imagettftext($imgTheme, 50, 0, 470, 233, $white, $fontBold, "0".$porcentagem);
    }else{
        imagettftext($imgTheme, 50, 0, 470, 233, $white, $fontBold, $porcentagem);
    }
    imagettftext($imgTheme, 25, 0, 540, 213, $white, $fontBold, "%");

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
   
    if ($observacao != "") {
        $obsText = imagettfbbox ( 14, 0, $font, $observacao );
        $obsText_ = $obsText[2];
        $obsText = 15;
        $whiteObs = imagecolorallocate($imgTheme, 255, 255, 255);
        ImageFilledRectangle($imgTheme, 10, 815, $obsText_+20, 952, $whiteObs); 
        imagettftext($imgTheme, 14, 0, $obsText, 835, $black, $font, $observacao);
    } 

    /*Redireciona para pagina de download assim que o script acaba*/
    header('Location: ../../../src/actionDownloads.php?download='.$new_name.'&estilo=cartaz&tema='.$fktema.'&usuario='.$idusuarios);

    /*Cria a imagem final*/
    $finalImage = '../downloads/'.$new_name.'.png';
    imagepng($imgTheme, $finalImage, 0);
    imagepng($imgTheme);

    /*Limpa a memoria*/
    imagedestroy($imgTheme);
    imagedestroy($imgProduct);
}
?>
