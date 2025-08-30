<?php
if(!empty($_POST)){
    $tema = $_POST['tema'];
    $namelayout = $_POST['namelayout'];
    $titulo = $_POST['titulo'];
    $desc = $_POST['desc'];
    $origens  = array(',', 'R$');
    $destinos = array('.', '');
    $preco = (float)str_replace($origens,$destinos,$_POST['preco']);
    $promo = (float)str_replace($origens,$destinos,$_POST['promo']);
    $observacao = $_POST['obs'];
    $sizeProduct = (int)$_POST['sizeProduct'];
    $calcSize = $sizeProduct;
    $campaign = $_POST['idcampanha'];
    $positionText = $_POST['positionText'];
    $rotacao = $_POST['rotacao'];
    $parcela = $_POST['parcela'];

    $promocao = 'on';
    if($promo == ''){
        $promocao = 'off'; 
    }



    $parcelado = 'on';
    if($parcela == '1'){
        $parcelado = 'off'; 
    }

    if($promo == ""){
        $vezes= (int)$parcela;
        $parcela = (float)($preco/$vezes);
        $parcela = number_format($parcela, 2, ',', ' ');
        $parcela_spromo = $parcela;
        $vezes_spromo = $vezes;
    }else{
        $vezes = (int)$parcela;
        $parcela = (float)($promo/$vezes);
        $parcela = number_format($parcela, 2, ',', ' ');
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
if($_FILES['fileUpload']['size'] != 0)
{
    $productState = 'com imagem';
    /*Faz o upload da imagem do produto*/
    $dir = '../uploads/'; //Diretório para uploads
    move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name.$ext); //Fazer upload do arquivo
}
$dir = "../uploads/".$new_name.$ext;
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
    /*Faz o calculo da porcentagem de desconto*/
    $porcentagem = round(100 - ($promo*100/$preco));
    /*Modificado formato da dados*/
    $preco = number_format($preco, 2, ',', ' ');
    $promo = number_format($promo, 2, ',', ' ');
    
    /*Faz o aumento ou diminuição da imagem do produto*/
    $sizeProduct = $sizeProduct/100;
    if($sizeProduct<=0){ 
        $sizeProduct = 1;
    }
    $sizeProduct = $sizeProduct*300;

    $imgProduct = ajustImagePaper($dir, $productState, $sizeProduct);


    /*Descobre as caracteristicas da imagem produto*/
    list($width, $height, $type, $attr) = getimagesize($dir); 
        
    if($rotacao == 'on'){
        $imgPhoto=imagecreatetruecolor($height, $width);
        imagecopyresampled($imgPhoto,$imgProduct,0,0,0,0,$height,$width,$width, $height);
        $imgProduct = $imgPhoto;
        $imgProduct = imagerotate ($imgProduct , -90 , 0 );   
    } 

    /*Carrega nas variáveis as imagens de tema e desconto*/
/*     
    $imgDesc = imagecreatefromjpeg($dirCompanie.'desconto'.'.jpg'); */
    $imgTheme = imagecreatefrompng($dirCompaign.'/'.$tema);

    /*Cores usadas na imagem do produto e tema*/
    $white = imagecolorallocate($imgTheme, 255, 255, 255);
    $black = imagecolorallocate($imgTheme, 55, 52, 53);
    $red = imagecolorallocate($imgTheme, 161, 14, 18);


    $font = __DIR__.'/../../../../fonts/calibri.ttf';
    $fontBold = __DIR__.'/../../../../fonts/calibrib.ttf'; 

 
    switch ($positionText) {
        case "direita":
            include 'controllersPositionsPosts/textRightPosts.php';
            break;
        case "esquerda":
            include 'controllersPositionsPosts/textLeftPosts.php';
            break;
        case "acima":
            include 'controllersPositionsPosts/textAbovePosts.php';
            break;
        case "abaixo":
            include 'controllersPositionsPosts/textBelowPosts.php';
            break;
    }
   
    if ($observacao != "") {
        $obsText = imagettfbbox ( 14, 0, $font, $observacao );
        $obsText_ = $obsText[2];
        $obsText = 15;
        $whiteObs = imagecolorallocate($imgTheme, 255, 255, 255);
        ImageFilledRectangle($imgTheme, 10, 932, $obsText_+20, 952, $whiteObs); 
        imagettftext($imgTheme, 14, 0, $obsText, 948, $black, $font, $observacao);
    } 

    /*Redireciona para pagina de download assim que o script acaba*/
    header('Location: ../../../src/actionDownloads.php?download='.$new_name.'&estilo=post&tema='.$fktema.'&usuario='.$idusuarios);

    /*Cria a imagem final*/
    $finalImage = '../downloads/'.$new_name.'.png';
    imagepng($imgTheme, $finalImage, 0);
    imagepng($imgTheme);

    /*Limpa a memoria*/
    imagedestroy($imgTheme);
    imagedestroy($imgProduct);
}
?>
