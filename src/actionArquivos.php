<?php
    require_once('actionBasica.php');
    include 'models/modelArquivos.php';
    if(empty($_GET["act"])){
        include 'views/viewArquivos.php';
    }
?>