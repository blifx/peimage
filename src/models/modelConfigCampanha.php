<?php

$DataBase = new DataBase;
$conn = $DataBase->connect();


if(isset($_POST['idcampanha'])){
    $idcampanhas =  $_POST['idcampanha'];  

    $sqlConsultCampanha = "SELECT nome FROM campanhas
                            WHERE idcampanhas = $idcampanhas";
    $queryCampanha = $DataBase->query($sqlConsultCampanha);
    $row=mysqli_fetch_array($queryCampanha);

    $sqlConsultLayouts= "SELECT fkcampanhas, idlayouts, layouts.nome
                            FROM layouts
                            INNER JOIN layouts_campanha ON layouts_campanha.fklayouts = idlayouts
                            INNER JOIN campanhas        ON campanhas.idcampanhas = layouts_campanha.fkcampanhas
                            WHERE 
                            fkcampanhas = $idcampanhas AND largura = '595' AND altura = '841'";
    $queryLayouts = $DataBase->query($sqlConsultLayouts);
}


if(isset($_GET['act'])){
    
    if($_GET['act'] == "coresUpdate"){

        try {
            $fklayouts_campanha = $_GET['fklayouts_campanha'];
            $cor1 = $_GET['cor1'];
            $cor2 = $_GET['cor2'];
            $cor3 = $_GET['cor3'];
    
            $sqlUpdateLayout = "
                UPDATE temas 
                SET cor1='$cor1', 
                    cor2='$cor2', 
                    cor3='$cor3' 
                WHERE fklayouts_campanha=$fklayouts_campanha
            ";

            //die($sqlUpdateLayout);
            $queryTemas = $DataBase->query($sqlUpdateLayout);


            echo "1";

        } catch(Exeption $e){
            echo "0";
        }

    } else {

        $idlayout = $_GET['idlayout'];
        $idcampanha = $_GET['idcampanha'];
    
        $sql = "SELECT idtemas, fklayouts_campanha, cor1, cor2, cor3 FROM temas
                INNER JOIN layouts_campanha ON  layouts_campanha.idlayouts_campanha = temas.fklayouts_campanha
                WHERE layouts_campanha.fklayouts = $idlayout AND layouts_campanha.fkcampanhas = $idcampanha"; 
    
        if ($result = $DataBase->query($sql)) {
            $returnJSON = [];
            while ($row = $result->fetch_assoc()) {
                $returnJSON[ $row["idtemas"] ] = [
                    "cor1" => $row["cor1"],
                    "cor2" => $row["cor2"],
                    "cor3"  => $row["cor3"],
                    "fklayouts_campanha"  => $row["fklayouts_campanha"],
                ];
            }
    //print_r($returnJSON);
            echo json_encode($returnJSON);
        }
    }
}

?>
