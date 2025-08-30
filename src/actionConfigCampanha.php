<?php
require_once('actionBasica.php');

include 'models/modelConfigCampanha.php';
if(empty($_GET)){
    include 'views/viewConfigCampanha.php';
}

?>