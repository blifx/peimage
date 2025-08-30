<?php
require_once('actionBasica.php');

include 'controllers/controllerCrudCampanha.php';
if(empty($_GET) || isset($_GET["response"])){
    include 'models/modelCrudCampanha.php';
    include 'views/viewCrudCampanha.php';
}
?>