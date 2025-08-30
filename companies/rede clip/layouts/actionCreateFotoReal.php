<?php
require_once('actionBasica.php');

if(!empty($_GET['titulo'])){
    include 'models/modelCreateFotoReal.php';
    include 'controllers/controllerCreateFotoReal.php'; 
}else{

    $layout = $_GET['layout'];
    $fkcampanhas = (int)$_GET['campanha'];
    //Insere a campanha no banco de dados
    $sqlConsultTemas = "
        SELECT idtemas, nome_arquivo
        FROM temas 
            INNER JOIN layouts_campanha ON layouts_campanha.idlayouts_campanha = temas.fklayouts_campanha
        WHERE
            layouts_campanha.fkcampanhas = $fkcampanhas
            AND layouts_campanha.fklayouts = $layout
            AND temas.desativacao IS NOT TRUE
    ";

    $queryTemas = $DataBase->query($sqlConsultTemas);

    include 'views/viewCreateFotoReal.php';
}
?>