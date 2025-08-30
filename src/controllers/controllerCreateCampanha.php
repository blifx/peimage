<?php
if (!empty($_FILES)) {

        $campanha = trim(acentoUpload(strtolower($_GET['campanha'])));
        $tipo = strtolower ($_GET['tipo']);
        $fklayout = $_GET['idlayout'];
        $fkcampanha = $_GET['idcampanha'];

        $dirCampanha = __DIR__."/../../companies/{$companie}/campaigns/";
        $storeCampanha = __DIR__."/../../companies/{$companie}/campaigns/{$fkcampanha}/";
        $storeFolder = __DIR__."/../../companies/{$companie}/campaigns/{$fkcampanha}/{$tipo}";
        
        if(!is_dir($dirCampanha)){
            mkdir($dirCampanha, 0755);
        }


        if(!is_dir($storeCampanha)){
            mkdir($storeCampanha, 0755);
        }

        if(!is_dir($storeFolder)){
            mkdir($storeFolder, 0755);
        }
        
        $tempFile = $_FILES['fileToUpload']['tmp_name'];          //3             
        $targetPath = '/'.$storeFolder.'/';  //4
        list($width, $height) = getimagesize($tempFile);  

        if( (int)$_GET["width"] <> (int)$width ){
            exit(1);
        } else if( (int)$_GET["height"] <> (int)$height ){
            exit(1);
        } 
        
        $nome_arquivo = uniqid(rand(), true).'.png';
        if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $storeFolder.'/'.$nome_arquivo))
        {
            echo "Erro ao enviar o arquivo: ".$_FILES['fileToUpload']['name'];
        }else{
            $DataBase = new DataBase;
            $conn = $DataBase->connect();
/* 
            try {
                $conn->begin_transaction(); */

            
                $sqlConsultVerfication = ("SELECT COUNT(idlayouts_campanha) AS n_verification, idlayouts_campanha FROM layouts_campanha WHERE fklayouts = $fklayout AND fkcampanhas = $fkcampanha LIMIT 1");
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

/*                 $conn->commit();
                echo '1';

            } catch(Exeption $e){
                $conn->rollback();
                echo '0';
            } */

        }
    }
        
  ?>