<?php
ob_start();  
session_start();
ini_set('default_charset','UTF-8');
require_once('../libs/peimageLib.php');
require_once("../libs/dataBaseClass.php");

include 'models/modelLogin.php';
include 'views/viewLogin.php';
?>