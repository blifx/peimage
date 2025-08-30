<?php
require_once('actionBasica.php');


if(!empty($_POST['campanha'])){
    include 'models/modelCreateCampanha.php';
    include 'views/viewCreateCampanha.php';
}else{
    include 'controllers/controllerCreateCampanha.php';
}



?>