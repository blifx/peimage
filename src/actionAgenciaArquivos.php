<?php
require_once('actionBasica.php');

include 'controllers/controllerAgenciaArquivos.php'; 

if(empty($_GET)){
    include 'models/modelAgenciaArquivos.php';
    include 'views/viewAgenciaArquivos.php';
}
?>