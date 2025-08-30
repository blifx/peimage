<?php
    require_once('config.php');
    require_once('libs/peimageLib.php');
    require_once("libs/dataBaseClass.php");

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_cache_limiter('private_no_expire');
        session_start();
    }

    if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:src/actionLogin.php');
    }    

    $companie = $_SESSION['nome'];

    //verifica se eh um layout em JS ou um layout que possui a estrutura antiga
    if(!empty($_POST["layout"])){
        $idcampanha = $_POST['idcampanha'];
        $idempresa  = $_POST['fkempresa'];
        $layout     = $_POST['layout'];
        $idlayout   = $_POST['idlayout'];
        $namelayout = $_POST['namelayout'];
        $path = $__HTTP_HOST . "/companies/" . $_SESSION['nome'] . "/layouts/" . $_POST["layout"];
        if  ($_POST["layout"] == "cartazA4"){
            header('location:src/actionCreateLayoutA4.php'
                .'?campanha='.$idcampanha
                .'&layout='.$_POST["layout"]
                .'&idlayout='.$idlayout
                .'&nomeLayout='.$namelayout
            );

            exit();
        } else if  ($_POST["layout"] == "storie"){
            header('location:src/actionCreateLayoutStorie.php'
                .'?campanha='.$idcampanha
                .'&layout='.$_POST["layout"]
                .'&idlayout='.$idlayout
                .'&nomeLayout='.$namelayout
            );

            exit();
        }else if  ($_POST["layout"] == "post"){
            header('location:src/actionCreateLayoutPost.php'
                .'?campanha='.$idcampanha
                .'&layout='.$_POST["layout"]
                .'&idlayout='.$idlayout
                .'&nomeLayout='.$namelayout
            );

            exit();
        }
    }

    include 'controllers/controllerCreateLayout.php'; 

    if($_SESSION["tipo"] == "agencia" || $_SESSION["tipo"] == "admin"){
        include 'models/modelCreateLayoutAgencia.php';
        include 'views/viewCreateLayoutAgencia.php';
    } else {    
        include 'models/modelCreateLayout.php';
        include 'views/viewCreateLayout.php';
    }

?>