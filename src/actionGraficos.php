<?php
require_once('actionBasica.php');

if(!empty($_GET)) {
    include 'models/modelGraficos.php';
} else {
    include 'views/viewGraficos.php';
}

?>