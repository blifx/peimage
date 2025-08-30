<?php

if(!empty($_POST['layout'])){

    include('config.php');
    $idcampanha = $_POST['idcampanha'];
    $idempresa = $_POST['fkempresa'];
    $layout=$_POST['layout'];
    $idlayout=$_POST['idlayout'];
    $namelayout=$_POST['namelayout'];

    if(empty($idcampanha)){//O layout não participa de campanha
        header("Location:layouts/$layout.php?layout=".$layout."&idlayout=".$idlayout);      
    }else{
        header("Location:companies/$companie/layouts/$layout.php?campanha=".$idcampanha."&layout=".$idlayout."&namelayout=".$namelayout);      
    }
}