<?php
require_once('actionBasica.php');


if(!empty($_GET['acao'])){
    include 'models/modelDownload.php';
}

include 'views/viewDownloads.php';
?>