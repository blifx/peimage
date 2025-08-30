<?php


if(!empty($_POST['idempresa'])){
    $DataBase = new DataBase;
    $conn = $DataBase->connect();


}


if(empty($_GET)){


    $DataBase = new DataBase;
    $conn = $DataBase->connect();

    $sqlConsultaLayouts = "SELECT
                                DISTINCT(idlayouts),  
                                fkcampanhas,
                                nome,
                                arquivo,
                                largura,
                                altura
                                FROM layouts
                                    INNER JOIN layouts_empresa ON layouts_empresa.fklayouts = idlayouts 
                                    INNER JOIN layouts_campanha ON layouts_campanha.fklayouts = idlayouts
                                WHERE (layouts_empresa.fkempresas = '{$idcompanie}') AND desativacao IS NOT TRUE
                                GROUP BY idlayouts ASC";
    $queryLayouts = $DataBase->query($sqlConsultaLayouts);


    $sqlInitStart = "SELECT
                        DISTINCT(idlayouts),   
                        fkcampanhas,
                        nome,
                        arquivo,
                        largura,
                        altura
                        FROM layouts
                            INNER JOIN layouts_empresa ON layouts_empresa.fklayouts = idlayouts 
                            INNER JOIN layouts_campanha ON layouts_campanha.fklayouts = idlayouts
                        WHERE (layouts_empresa.fkempresas = '{$idcompanie}') AND desativacao IS NOT TRUE
                        GROUP BY idlayouts ASC";


    $queryInitStart = $DataBase->query($sqlInitStart);
    $rowInit=mysqli_fetch_array($queryInitStart); 

    $sqlInitLayouts = "SELECT 
                        DISTINCT(idlayouts),   
                        fkcampanhas,
                        nome,
                        arquivo,
                        largura,
                        altura,
                        status_campanha
                        FROM layouts 
                            INNER JOIN layouts_empresa ON layouts_empresa.fklayouts = idlayouts 
                            INNER JOIN layouts_campanha ON layouts_campanha.fklayouts = idlayouts
                        WHERE idlayouts = {$rowInit['idlayouts']} AND desativacao IS NULL
                        GROUP BY idlayouts ASC";

    $queryInitLayouts = $DataBase->query($sqlInitLayouts);
    $rowInit=mysqli_fetch_array($queryInitLayouts);

 

}

if(!empty($_POST['idLayout']) && empty($_GET)){

    $DataBase = new DataBase;
    $conn = $DataBase->connect();

    $idLayout = strtolower ($_POST['idLayout']);
    $nomeLayout = strtolower ($_POST['nomeLayout']);
    $largura_layout = strtolower ($_POST['largura_layout']);
    $altura_layout = strtolower ($_POST['altura_layout']);
    $nomeArquivoLayout = $_POST['nomeArquivoLayout'];
    $status_campanha = strtolower ($_POST['status_campanha']);

 

    if(isset($_POST["Salvar"])){
        if($status_campanha == '1'){
            $sqlUpdateLayout = "UPDATE layouts 
                                    SET nome='$nomeLayout', 
                                        arquivo='$nomeArquivoLayout', 
                                        altura='$altura_layout', 
                                        largura='$largura_layout', 
                                        status_campanha='$status_campanha' 
                                        WHERE idlayouts='$idLayout'";
        }else{
            $sqlUpdateLayout = "UPDATE layouts 
                                    SET nome='$nomeLayout', 
                                        arquivo='$nomeArquivoLayout', 
                                        altura=NULL, 
                                        largura=NULL, 
                                        status_campanha='$status_campanha' 
                                        WHERE idlayouts='$idLayout'";

        }
        $queryUpdateLayout = $DataBase->query($sqlUpdateLayout);


    }else{

        $sqlDeleteLayout = "UPDATE layouts 
        SET desativacao = now() WHERE idlayouts = $idLayout";
        $queryDeleteLayout = $DataBase->query($sqlDeleteLayout);
    }


    header('Location: actionSetEmpresaCrudLayout.php');

}

if(!empty($_GET)){
    include('../../libs/peimageLib.php');
    include('../../libs/dataBaseClass.php');
    $DataBase = new DataBase;
    $conn = $DataBase->connect();
    if($_GET['act'] == 'atualizaLayout'){
        $sql = "
            SELECT * 
            FROM layouts 
            WHERE 
                idlayouts = {$_GET['layout']} 
                AND (desativacao IS NOT TRUE OR desativacao IS NULL)
                ORDER BY idlayouts ASC
        ";
        if ($result = $DataBase->query($sql)) {
            $returnJSON = [];
            while ($row = $result->fetch_assoc()) {
                $returnJSON[ $row["idlayouts"] ] = [
                    "idlayouts" => $row["idlayouts"],
                    "nome" => ucwords($row["nome"]),
                    "arquivo"  => $row["arquivo"],
                    "altura" => $row["altura"],
                    "largura" => $row["largura"],
                    "status_campanha" => $row["status_campanha"],
                ];
            }
            //print_r($returnJSON);
            echo json_encode($returnJSON);
            //echo '1';
        }
    }
}


?>
