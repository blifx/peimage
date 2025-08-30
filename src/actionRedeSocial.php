<?php

require_once('actionBasica.php');

if(empty($_POST)){
    include('views/viewRedeSocial.php');
} else if(!empty($_POST)) {
    include('models/modelRedeSocial.php');
}

?>