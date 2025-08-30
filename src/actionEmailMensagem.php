<?php
require_once('actionBasica.php');

include 'controllers/controllerEmailMensagem.php';
if(empty($_POST)){
    include 'views/viewEmailMensagem.php';
}
?>
