<?php
    $DataBase = new DataBase;
    $conn = $DataBase->connect();

    $idcampanha = $_GET["campanha"];
    $campanha   = $_GET["campanha"];
    $infoPath   = array();


    if(isset($_GET["act"])){

        if($_GET["act"] == "remove"){

            $ids = join(',', json_decode($_GET["ids"]));
            if(!empty($ids)){
                $sqlFiles = "
                SELECT * 
                FROM arquivos 
                WHERE idarquivos IN ({$ids})
            ";

            }else{
                $sqlFiles = "
                SELECT * 
                FROM arquivos 
                WHERE fkcampanhas = '$idcampanha' AND fklayouts IS NULL  
            ";

            }
        
    
            $query = $conn->query($sqlFiles);
            
            $idRemove = [];
            while($result = mysqli_fetch_array($query)){
                $fileDatabase = $result["nome_arquivo"];
                $fileName  = substr($fileDatabase, 0, strrpos($fileDatabase, "."));
            
                $path = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/outros/{$fileDatabase}";

                if(file_exists($path) && !unlink($path)){
                        echo "0";
                        exit;  
                }
                $idRemove[] = $result["idarquivos"];
            }
        
            $sqlFiles = "DELETE FROM estatisticas WHERE fkarquivos IN (" . join(',', $idRemove) . ")";
            $conn->query($sqlFiles);
            $sqlStatistics = "DELETE FROM arquivos WHERE idarquivos IN (" . join(',', $idRemove) . ")";
            $conn->query($sqlStatistics);
            echo "1";
            exit;
        }

    
        try {

            if($_GET["act"] == "downloadAll"){
                $sqlFiles = "
                    SELECT * 
                    FROM arquivos 
                    WHERE fkcampanhas = '$idcampanha' AND fklayouts IS NULL 
                ";
                $query = $conn->query($sqlFiles);
                // Add files to the zip file
                while($result = mysqli_fetch_array($query)){
                    $path = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/outros/{$result["nome_arquivo"]}";
                    if(file_exists($path)){
                        $fkarquivos = $result["idarquivos"];
                        $fkusuario = $idusuarios;
                        $sqlInsertEstatistica = "INSERT INTO estatisticas (fkarquivos, fkusuarios, dth_Log, acao) VALUES ('$fkarquivos', '$fkusuario', NOW(), 'd')";
                        $conn->query($sqlInsertEstatistica);
                        $infoPath[$fkarquivos]["path"] = $path;
                        $infoPath[$fkarquivos]["fileName"] = $result["nome_arquivo"];
                    }
                }
                $fileNameZip = "Peimage-" . $campanha."-Outros.zip";
                createZip($fileNameZip, $infoPath);

            } else if($_GET["act"] == "downloadOutros") {


                $ids= join(',', json_decode($_GET["ids"]));

                if(!empty($ids) > 0){
                    $sqlFiles = "
                        SELECT * 
                        FROM arquivos 
                        WHERE idarquivos IN ({$ids})
                    ";

                } else {
                    $sqlFiles = "
                        SELECT * 
                        FROM arquivos 
                        WHERE 
                            fkcampanhas = $idcampanha
                            AND fklayouts IS NULL
                    ";
                }

                $query = $conn->query($sqlFiles);

                // Add files to the zip file
                while($result = mysqli_fetch_array($query)){
                    $path = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/outros/{$result["nome_arquivo"]}";
   
                    if(file_exists($path)){
                        $fkarquivos = $result["idarquivos"];
                        $fkusuario = $idusuarios;
                        $sqlInsertEstatistica = "INSERT INTO estatisticas (fkarquivos, fkusuarios, dth_Log, acao) VALUES ('$fkarquivos', '$fkusuario', NOW(), 'd')";
                        $conn->query($sqlInsertEstatistica);
                        $infoPath[$fkarquivos]["path"] = $path;
                        $infoPath[$fkarquivos]["fileName"] = $result["nome_arquivo"];
                    }
                }
                $fileNameZip = "Peimage-" . $campanha. "-outros.zip";
                createZip($fileNameZip, $infoPath);

            }

        } catch (Exception $e) {
            ob_clean();
            header("Set-Cookie: fileDownload=false; path=/; max-age=1;");
            exit;
        }

    } else {

        $campanha = $_GET["campanha"];

        $sqlConsultListArquivos = "
        SELECT idarquivos, nome_arquivo FROM arquivos 
            WHERE fkcampanhas = '$campanha' AND fklayouts IS NULL
            ORDER BY idarquivos DESC
        ";
        $queryArquivos = $DataBase->query($sqlConsultListArquivos);

    }

    function createZip($file, $infoPath){

        if(count($infoPath) == 0) return;
        
        $zip = new ZipArchive();
        if ($zip->open($file, ZipArchive::CREATE) === TRUE){
            foreach($infoPath as $key => $path){
                $zip->addFile($path["path"], $path["fileName"]);
            }
        } else {
            throw new Exception();
        }

        // All files are added, so close the zip file.
        $zip->close();

        header("Set-Cookie: fileDownload=true; path=/; max-age=1;");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length: ".filesize($file));
        header("Content-Disposition: attachment; filename=\"".basename($file)."\"");

        if(!readfile($file)){
            throw new Exception();
        }
        unlink($file);
        exit;
    }

?>