<?php
include('../config.php');

if(isset($_POST['act']) && $_POST['act'] == "remove"){

    $DataBase = new DataBase();
    $conn = $DataBase->connect();

    $campanha = strtolower($_POST['nome_campanha']);
    $idcampanha = $_POST['campanhas'];

    $storeCampanha = $__BASE_DIR."/companies/{$companie}/campaigns/{$idcampanha}/";

    function recurseRmdir($dir) {
        if(file_exists($dir)) {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
            (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }
      }

      recurseRmdir($storeCampanha);

      if(file_exists($storeCampanha)) {
          echo '0';
          return;
      }

    try {
        //$conn->begin_transaction();

        $idcampanha = $_POST['campanhas'];
        $idlayout   = $_POST['uploads-select'];

        $sqlUpdateCampanha = "
            UPDATE campanhas
            SET desativacao = 1
            WHERE idcampanhas = $idcampanha
        ";


        $DataBase->query($sqlUpdateCampanha);
        $sqlUpdateTemas = "
            UPDATE temas 
            SET desativacao = TRUE 
            WHERE idtemas IN (
                SELECT idtemas 
                FROM (
                    SELECT idtemas 
                    FROM campanhas 
                    INNER JOIN layouts_campanha ON fkcampanhas = idcampanhas 
                    INNER JOIN temas ON fklayouts_campanha = idlayouts_campanha 
                    WHERE idcampanhas = $idcampanha
                ) AS subquery
            );
        ";

        $DataBase->query($sqlUpdateTemas);

        $sqlUpdateArquivos= "
            DELETE FROM arquivos
            WHERE fkcampanhas = $idcampanha;
        ";
        $DataBase->query($sqlUpdateArquivos);

        //if($conn->commit()){
            header("location: actionCrudCampanha.php?response=1");
        //} else {
        //    header("location: actionCrudCampanha.php?response=0");
        //}

     } catch(Exception $e) {
        header("location: actionCrudCampanha.php?response=0");
        //$conn->rollback();
        //echo '0';
    }

} else if(isset($_POST['act']) && $_POST['act'] == "update"){

    $DataBase = new DataBase;
    $conn     = $DataBase->connect();

     try {

        //$conn->begin_transaction();
        
        $idcampanha      = $_POST['campanhas'];
        $dt_inicio       = $_POST['inicio'];
        $dt_encerramento = $_POST['encerramento'];

        //TODO update esta sendo feito a cada insercao de um novo arquivo quando deveria ser feito uma unica vez
        $sqlUpdateCampanha = "UPDATE campanhas SET dt_inicio = '$dt_inicio', dt_encerramento = '$dt_encerramento' WHERE idcampanhas = $idcampanha";
        $queryUpdateCampanha = $DataBase->query($sqlUpdateCampanha);

        //if($conn->commit()){
            header("location: actionCrudCampanha.php?response=1");
        //} else {
        //    header("location: actionCrudCampanha.php?response=0");
        //}

     } catch(Exception $e) {
        header("location: actionCrudCampanha.php?response=0");
        //$conn->rollback();
        //echo '0';
    }

} else if (!empty($_FILES)) {

    $idcampanha = $_GET['idcampanha'];
    $campanha = strtolower($_GET['campanha']);
    $tipo = strtolower ($_GET['tipo']);
    $fklayout = $_GET['idlayout'];
    $fkcampanha = $_GET['idcampanha'];
    $dt_inicio = $_GET['dt_inicio'];
    $dt_encerramento = $_GET['dt_encerramento'];

    $dirCampanha = __DIR__."/../../companies/{$companie}/campaigns/";
    $storeCampanha = __DIR__."/../../companies/{$companie}/campaigns/{$idcampanha}/";
    $storeFolder = __DIR__."/../../companies/{$companie}/campaigns/{$idcampanha}/{$tipo}/";

    if(!is_dir($dirCampanha)){
        mkdir($dirCampanha, 0755);
    }

    if(!is_dir($storeCampanha)){
        mkdir($storeCampanha, 0755);
    }

    if(!is_dir($storeFolder)){
        mkdir($storeFolder, 0755);
    }
    
    $tempFile = $_FILES['fileToUpload']['tmp_name'];
    $targetPath = '/'.$storeFolder.'/';  //4
    list($width, $height) = getimagesize($tempFile);  

    if( ($_GET["width"] <> $width) || ($_GET["height"] <> $height) ){
        exit;
    } 
    
    $unique = uniqid(rand(), true);
    $nome_arquivo = $unique .'.png';
    
    if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $storeFolder.'/'.$nome_arquivo)){
        echo "Erro ao enviar o arquivo: ".$_FILES['fileToUpload']['name'];
    } else {

        makeThumbnails($storeFolder .  '/', $unique, '.png');

        $DataBase = new DataBase;
        $conn = $DataBase->connect();

        try {
            //$conn->begin_transaction();

            $sqlConsultVerfication = "
                SELECT
                    COUNT(idlayouts_campanha) AS n_verification,
                    idlayouts_campanha
                FROM layouts_campanha
                WHERE fklayouts = $fklayout AND fkcampanhas = $fkcampanha
                GROUP BY idlayouts_campanha;
            ";
            $queryVerfication = $DataBase->query($sqlConsultVerfication);
            $rowVerification = mysqli_fetch_assoc($queryVerfication);

            if($rowVerification['n_verification'] == 0){
                $sqlInserLayoutsCampanha = "INSERT INTO layouts_campanha (fklayouts, fkcampanhas) VALUES ($fklayout, $fkcampanha)";
                $DataBase->query($sqlInserLayoutsCampanha);
                $fklayouts_campanha = $conn->insert_id;
            }else{
                $fklayouts_campanha = $rowVerification['idlayouts_campanha'];
            }

            $sqlInserTema = "INSERT INTO temas (fklayouts_campanha, nome_arquivo, desativacao) VALUES ('$fklayouts_campanha', '$nome_arquivo', '0')";
            $DataBase->query($sqlInserTema);
            //TODO update esta sendo feito a cada insercao de um novo arquivo quando deveria ser feito uma unica vez
            $sqlUpdateCampanha = "UPDATE campanhas SET dt_inicio = '$dt_inicio', dt_encerramento = '$dt_encerramento' WHERE idcampanhas = $idcampanha";
            $queryUpdateCampanha = $DataBase->query($sqlUpdateCampanha);

            //desativa todos temas quando um novo eh inserido
            $sqlUpdateTemas = "
                UPDATE temas 
                SET status_teste = FALSE 
                WHERE idtemas IN (
                    SELECT idtemas 
                    FROM (
                        SELECT temas.idtemas 
                        FROM campanhas
                        INNER JOIN layouts_campanha ON campanhas.idcampanhas = layouts_campanha.fkcampanhas
                        INNER JOIN temas ON layouts_campanha.idlayouts_campanha = temas.fklayouts_campanha
                        WHERE campanhas.idcampanhas = $idcampanha
                        AND layouts_campanha.fklayouts = $fklayout
                    ) AS subquery
                ) AND desativacao IS NOT TRUE;
            ";
            //die($sqlUpdateTemas);
            $DataBase->query($sqlUpdateTemas);

            //if($conn->commit()){
                echo '1';
            //} else {
            //    echo '0';
            //}
            
        } catch(Exception $e) {
            //$conn->rollback();
            echo '0';
        } 
    }
}
        
?>