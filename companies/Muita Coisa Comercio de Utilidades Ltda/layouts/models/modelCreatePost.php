<?php
$DataBase = new DataBase;
$conn = $DataBase->connect();

if(empty($_POST['tema'])){

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

    $sqlConsultCampanhas = "SELECT nome FROM campanhas WHERE idcampanhas = $fkcampanhas";
    $queryCampanhas = $DataBase->query($sqlConsultCampanhas);
    $row=mysqli_fetch_array($queryCampanhas);
    $campaign = $row['nome'];

    $sqlConsultCompanie = "SELECT nome FROM empresas WHERE idempresas = $idcompanie";
    $queryEmpresas = $DataBase->query($sqlConsultCompanie);
    $row=mysqli_fetch_array($queryEmpresas);
    $companie = $row['nome'];


}else{

  $tema = $_POST['tema'];
    $sqlConsultTema = "SELECT idtemas FROM temas WHERE nome_arquivo = '$tema'";
    $queryTema = $DataBase->query($sqlConsultTema);
    $row=mysqli_fetch_array($queryTema);
    $fktema = $row['idtemas'];
/*
    $fkusuario = $idusuarios;
        //Insere a campanha no banco de dados
        $sqlInsertEmpresas = "INSERT INTO estatisticas (tipo,fktemas, fkusuarios, dataLog) VALUES ('posts', $fktema, $fkusuario, CURRENT_TIMESTAMP)";
        $DataBase->query($sqlInsertEmpresas); */

}



?>