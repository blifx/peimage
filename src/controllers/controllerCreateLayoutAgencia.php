<?php

if(!empty($_POST['layout'])){

    include('config.php');
    $idcampanha = $_POST['idcampanha'];
    $idempresa = $_POST['fkempresa'];
    $layout=$_POST['layout'];
    $idlayout=$_POST['idlayout'];
    $namelayout=$_POST['namelayout'];



    if(empty($idcampanha)){//O layout não participa de campanha
        if( $idempresa == '1' ){
            header("Location:$__HTTP_HOST/src/$layout.php?layout=".$layout."&idlayout=".$idlayout);
        }else{
            header("Location:$__HTTP_HOST/companies/$companie/layouts/$layout.php?layout=".$layout."&idlayout=".$idlayout);      
        }

    }else{
        if( $idempresa == '1' ){//O layout participa de campanha
            header("Location:$__HTTP_HOST/src/$layout.php?campanha=".$idcampanha."&layout=".$idlayout."&namelayout=".$namelayout);
        }else{
            header("Location:$__HTTP_HOST/companies/$companie/layouts/$layout.php?campanha=".$idcampanha."&layout=".$idlayout."&namelayout=".$namelayout);      
        }
        
    }
}

?>
