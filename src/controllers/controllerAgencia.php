<?php
if(!empty($_POST['button'])){
include('../config.php');
$button=$_POST['button'];
    switch ($button) {
        case 'Visualizar Campanhas':
            header('Location: '.$__HTTP_HOST.'/src/actionAgenciaCampanha.php');
            break;
        case 'Criar Campanha':
            header('Location: '.$__HTTP_HOST.'/src/actionCreateCampanha.php');
            break;
        case 'Alterar Campanhas':
            header('Location: '.$__HTTP_HOST.'/src/actionCrudCampanha.php');
            break;
        case 'Perfil Agência':
            header('Location: '.$__HTTP_HOST.'/src/actionAgenciaPerfil.php');
            break;
        case 'Adicionar Arquivos':
            header('Location: '.$__HTTP_HOST.'/src/actionAgenciaArquivos.php');
            break;
    }
}
?>
