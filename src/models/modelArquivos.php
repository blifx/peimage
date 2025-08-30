<?php
    $DataBase = new DataBase;
    $conn = $DataBase->connect();

    $idcampanha = $_GET['idcampanha'];
    $campanha   = urldecode($_GET["idcampanha"]);
    $infoPath   = array();


    if(isset($_GET["act"])){
    
        try {

            if($_GET["act"] == "downloadLayouts"){

                $idlayout = $_GET['idlayout'];
                $layout = $_GET['layout'];
                $sqlFiles = "
                    SELECT * FROM arquivos 
                    WHERE fkcampanhas = '$idcampanha' AND fklayouts = '$idlayout' 
                ";
                $query = $conn->query($sqlFiles);
                // Add files to the zip file
                while($result = mysqli_fetch_array($query)){
                    $path = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/{$layout}/{$result["nome_arquivo"]}";
                    if(file_exists($path)){
                        $fkarquivos = $result["idarquivos"];
                        $fkusuario = $idusuarios;
                        $sqlInsertEstatistica = "INSERT INTO estatisticas (fkarquivos, fkusuarios, dth_Log, acao) VALUES ('$fkarquivos', '$fkusuario', NOW(), 'd')";
                        $conn->query($sqlInsertEstatistica);
                        
                        $infoPath[$fkarquivos]["path"] = $path;
                        $infoPath[$fkarquivos]["fileName"] = $result["nome_arquivo"];
                    }
                }
                $fileNameZip = "Peimage-" . $campanha."-".$layout.".zip";
                createZip($fileNameZip, $infoPath);

            } else if($_GET["act"] == "downloadOutros") {


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
                $fileNameZip = "Peimage-" . $campanha."-outros.zip";
                createZip($fileNameZip, $infoPath);



            } else if($_GET["act"] == "downloadAll") {


                $sqlConsultCampanhaSelect = "
                    SELECT
                        idarquivos,
                        nome_arquivo,
                        CASE   
                            WHEN idlayouts IS NULL THEN 'outros'
                            ELSE LOWER(layouts.nome)
                        END as layout
                        FROM campanhas
                            INNER JOIN arquivos ON arquivos.fkcampanhas = campanhas.idcampanhas
                            LEFT JOIN layouts ON layouts.idlayouts = arquivos.fklayouts 
                        WHERE idarquivos IN(
                            SELECT idarquivos
                            FROM arquivos 
                            WHERE fkcampanhas = '$idcampanha'
                        )
                        ORDER BY idlayouts DESC
                ";

                $queryLayouts = $DataBase->query($sqlConsultCampanhaSelect);

                while($resultLayout = mysqli_fetch_array($queryLayouts)){
                    //TODO TESTAR PARA VERIFICAR SE CONSULTA ESTA CERTA
                    //echo $resultLayout["layout"] . "\n";

                    $path = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/{$resultLayout["layout"]}/{$resultLayout["nome_arquivo"]}";
                    if(file_exists($path)){
                        $fkarquivos = $resultLayout["idarquivos"];
                        $fkusuario = $idusuarios;
                        $sqlInsertEstatistica = "INSERT INTO estatisticas (fkarquivos, fkusuarios, dth_Log, acao) VALUES ('$fkarquivos', '$fkusuario', NOW(), 'd')";
                        $conn->query($sqlInsertEstatistica);
                        $infoPath[$fkarquivos]["path"] = $path;
                        $infoPath[$fkarquivos]["fileName"] = $resultLayout["nome_arquivo"]; 
                    }
                }
                $fileNameZip = "Peimage-" . $campanha.".zip";
                createZip($fileNameZip, $infoPath);
            }

        } catch (Exception $e) {
            ob_clean();
            header("Set-Cookie: fileDownload=false; path=/; max-age=1;");
            exit;
        }
    } else {

        $sqlConsultCampanhaSelect = "
            SELECT  DISTINCT(fklayouts) AS idlayouts,
                CASE   
                    WHEN idlayouts IS NULL THEN 'outros'
                    ELSE LOWER(layouts.nome)
                END as layout
                FROM campanhas
                    INNER JOIN arquivos ON arquivos.fkcampanhas = campanhas.idcampanhas
                    LEFT JOIN layouts ON layouts.idlayouts = arquivos.fklayouts 
                WHERE idcampanhas = '$idcampanha'
                ORDER BY idlayouts DESC
        ";
        $queryLayouts = $DataBase->query($sqlConsultCampanhaSelect);

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