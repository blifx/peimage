<?php

require_once('actionBasica.php');

if(empty($_POST))
exit(1);
else{
sleep(1);
$fileType = $_POST['imgType'];
$imgName  = $_POST['imgName'];

$titulo = mb_strtoupper($_POST['titulo']);
$sub = mb_strtoupper($_POST['sub']);
$desc = mb_strtoupper($_POST['desc']);
$origens  = array(',', 'R$');
$destinos = array('.', '');
$preco = (float)str_replace($origens,$destinos,$_POST['preco']);
$promo = (float)str_replace($origens,$destinos,$_POST['promo']);
$fonte = $_POST['font'];
$tema = $_POST['tema'];
$nameTema = $_POST['nametema'];
$namelayout = $_POST['namelayout'];
$campanha = $_POST['campanha'];

define('OUTPUT', '../downloads/thumbnail-' . $imgName);
if($fileType == 'image/png')
$img = imagecreatefrompng('../uploads/' . $imgName);
else
$img = imagecreatefromjpeg('../uploads/' . $imgName);
 
$imgWidth  = imagesx($img);
$imgHeight = imagesy($img);
 
$newImage = imagecreatetruecolor(540,960);
imagecopyresampled($newImage, $img, 0, 0, $_POST['x'], $_POST['y'], 540, 960, $_POST['w'], $_POST['h']);
if($fileType == 'image/png'){
$finalImage = imagepng($newImage, OUTPUT);
$image = imagecreatefrompng(OUTPUT);
}
else{
$finalImage = imagejpeg($newImage, OUTPUT);
$image = imagecreatefromjpeg(OUTPUT);
}
if($finalImage){

   // $image = $finalImage;
    include 'models/modelCreateFotoReal.php';
    include 'controllers/controllerCreateFotoReal.php'; 


//echo 'thumbnail-' . $imgName;
//echo '<img id="thumbnail" src="'. OUTPUT .'" />';
}else{
echo 'Ocorreu um erro ao tentar criar a nova imagem';
}
}
?>