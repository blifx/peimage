<?php
    require_once('actionBasica.php');
    include 'models/modelOutros.php';
    if(empty($_GET["act"])){
        include 'views/viewOutros.php';
    }
?>