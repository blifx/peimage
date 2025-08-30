<?php
require_once('actionBasica.php');

if(!empty($_GET['titulo'])){
    include 'models/modelCreateFotoCartaz.php';
    include 'controllers/controllerCreateFotoCartaz.php'; 
}else{
    include 'views/viewCreateFotoCartaz.php';
}
?>