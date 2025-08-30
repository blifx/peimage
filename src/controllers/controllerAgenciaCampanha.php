<?php
if(!empty($_POST['button'])){
include('../config.php');
$button=$_POST['button'];
    switch ($button) {
        case 'Criar Campanha':
            header('Location: '.$__HTTP_HOST.'/src/actionCreateCampanha.php');
            break;
        case 'Adicionar arquivos':
            header('Location: '.$__HTTP_HOST.'/src/actionAgenciaArquivos.php');
            break;
    }
}

?>
