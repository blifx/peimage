<?php
$path_absolute = $_SERVER['DOCUMENT_ROOT'];

if(file_exists($path_absolute . '/libs/peimageLib.php')){
    require_once($path_absolute . '/libs/peimageLib.php');
    require_once($path_absolute . '/libs/dataBaseClass.php');
}else{
    $path_absolute = $_SERVER['DOCUMENT_ROOT'].'/peimage';
    require_once($path_absolute . '/libs/peimageLib.php');
    require_once($path_absolute . '/libs/dataBaseClass.php');
}

include 'models/modelEsqueciSenha.php';
include 'views/viewEsqueciSenha.php';

?>