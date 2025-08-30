<?php

$db = new DataBase();
$conn = $DataBase->connect();

if(isset($_GET["act"]) && $_GET["act"] == "download"){

    try {

        $campanha = urldecode($_GET["mkt"]);
        $layout   = urldecode($_GET["tp"]);
        $ids      = join(',', json_decode($_GET["ids"]));

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
                    fkcampanhas = {$_GET["cp"]}
                    AND fklayouts = {$_GET["ly"]}
            ";
        }

        $query = $conn->query($sqlFiles);

        $file = "download-peimage-".$layout.".zip";
        $zip = new ZipArchive();
        if ($zip->open($file, ZipArchive::CREATE) === TRUE){

            // Add files to the zip file
            while($result = mysqli_fetch_array($query)){
                $path = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/{$layout}/{$result["nome_arquivo"]}";
                if(file_exists($path)){
                    $fkarquivos = $result["idarquivos"];
                    $fkusuario = $idusuarios;
                    $sqlInsertEstatistica = "INSERT INTO estatisticas (fkarquivos, fkusuarios, dth_Log, acao) VALUES ('$fkarquivos', '$fkusuario', NOW(), 'd')";
                    $conn->query($sqlInsertEstatistica);
                    $zip->addFile($path, $result["nome_arquivo"]);
                }
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
        
        } else {
            ob_clean();
            header("Set-Cookie: fileDownload=false; path=/; max-age=1;");
            exit;
        }

    } catch (Exception $e) {
        ob_clean();
        header("Set-Cookie: fileDownload=false; path=/; max-age=1;");
        exit;
    }

} else if(isset($_GET["act"]) && $_GET["act"] == "remove"){

    $idcampanha = urldecode($_GET["idcampanha"]);
    $campanha = urldecode($_GET["mkt"]);
    $layout   = urldecode($_GET["tp"]);
    $ids      = join(',', json_decode($_GET["ids"]));

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
        WHERE fkcampanhas = '$idcampanha' AND fklayouts = {$_GET["idlayout"]} 
        ";
        $response = "tudo";

    }

    $query = $conn->query($sqlFiles);

    $idRemove = [];
    while($result = mysqli_fetch_array($query)){
        $fileDatabase = $result["nome_arquivo"];
        $fileName  = substr($fileDatabase, 0, strrpos($fileDatabase, "."));
    
        $pathThumb = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/{$layout}/{$fileName}_thumb.jpg";
        $path      = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/files/{$layout}/{$fileDatabase}";

        if(file_exists($path) && (!unlink($path) || !unlink($pathThumb))){
            echo "0";
            exit;  
        }
        $idRemove[] = $result["idarquivos"];
    }

    $sqlFiles = "DELETE FROM estatisticas WHERE fkarquivos IN (" . join(',', $idRemove) . ")";
    $sqlStatistics = "DELETE FROM arquivos WHERE idarquivos IN (" . join(',', $idRemove) . ")";
    //die($sqlFiles);

    try {
        $conn->query($sqlFiles);
        $conn->query($sqlStatistics);
        //TODO transacao
        //$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
        //if($conn->query($sqlFiles)){
            if(isset($response) &&  $response == "tudo"){
                echo $response;
            }else{
                echo "1";
            }
            
        //} else {
        //    echo "0";
        //}
        //$mysqli->commit();
    } catch(Exception $e){
        echo "0";
        //$conn->rollback();
    }

    exit;

} else if(isset($_GET["act"]) && $_GET["act"] == "tema" 
    && !empty($_GET["campanha"])){

    $sqlNamesPath = "
        SELECT 
            idtemas,
            temas.nome_arquivo,
            campanhas.nome AS campanha,
            layouts.nome   AS layout
        FROM 
            campanhas 
            INNER JOIN layouts_campanha ON fkcampanhas        = idcampanhas
            INNER JOIN layouts          ON idlayouts          = fklayouts
            INNER JOIN temas            ON fklayouts_campanha = idlayouts_campanha
        WHERE 
            fkcampanhas = {$_GET["campanha"]}
            AND campanhas.fkempresas = {$_SESSION["id"]}
            AND temas.desativacao IS NOT TRUE
        ORDER BY idlayouts ASC
    ";
    //die($sqlNamesPath);

    $files = [];
    $idRemove = [];
    $query = $conn->query($sqlNamesPath);
    while($result = mysqli_fetch_array($query)){
        
        $fileDatabase = $result["nome_arquivo"];
        $fileName  = substr($fileDatabase, 0, strrpos($fileDatabase, "."));
        $extension = substr($fileDatabase, strrpos($fileDatabase, "."), strlen($fileDatabase));

        $path = "../companies/{$_SESSION["nome"]}/campaigns/{$_GET["campanha"]}/{$result["layout"]}/{$fileName}.png";

        if(file_exists($path)){
            $files[ $result["idtemas"] ] = [
                "ext" => $extension,
                "path" => $path
            ];
        }
    }

} else if(isset($_GET["act"]) && $_GET["act"] == "removeTheme"){

    $campanha = urldecode($_GET["mkt"]);
    $layout   = urldecode($_GET["tp"]);
    $ids      = join(',', json_decode($_GET["ids"]));
    $response = "";

    if(!empty($ids)){//Exclui invidualmente os arquivos
        $sqlFiles = "
        SELECT nome_arquivo, idtemas, layouts.nome AS nome 
        FROM temas 
        INNER JOIN layouts_campanha ON idlayouts_campanha = fklayouts_campanha
        INNER JOIN layouts ON idlayouts = fklayouts
        WHERE idtemas IN ({$ids})
        ";

        $query = $conn->query($sqlFiles);

        while($result = mysqli_fetch_array($query)){
            $fileDatabase = $result["nome_arquivo"];
            $idTema = $result["idtemas"];
            $layout = $result["nome"];
            $fileName  = substr($fileDatabase, 0, strrpos($fileDatabase, "."));

            $pathThumb = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/{$layout}/{$fileName}_thumb.jpg";
            $path     = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/{$layout}/{$fileDatabase}";
    
           
            if(!file_exists($pathThumb)){
                if(file_exists($path) && unlink($path)){
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                }else{
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                }
            }else if(file_exists($pathThumb)){
                if(file_exists($path) && unlink($path) && unlink($pathThumb)){
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                }else if(file_exists($path) && unlink($path)){
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                } 
            }else{
                echo "0";
                exit;
            }   
        }       
    }else{//Exclui todos os arquivos
        $sqlFiles = "
        SELECT nome_arquivo, idtemas, layouts.nome AS nome 
        FROM temas 
        INNER JOIN layouts_campanha ON idlayouts_campanha = fklayouts_campanha
        INNER JOIN layouts ON idlayouts = fklayouts
        WHERE fkcampanhas =  {$_GET["idcampanha"]} AND temas.desativacao IS NOT TRUE 
        ";

        $response = "tudo";
        $query = $conn->query($sqlFiles);

        while($result = mysqli_fetch_array($query)){
            $fileDatabase = $result["nome_arquivo"];
            $idTema = $result["idtemas"];
            $layout = $result["nome"];
            $fileName  = substr($fileDatabase, 0, strrpos($fileDatabase, "."));
        
            //tema nao tem thumb
            $pathThumb = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/{$layout}/{$fileName}_thumb.jpg";
            $path     = "../companies/{$_SESSION["nome"]}/campaigns/{$campanha}/{$layout}/{$fileDatabase}";
    
           
            if(!file_exists($pathThumb)){
                if(file_exists($path) && unlink($path)){
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                }else{
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                }
            }else if(file_exists($pathThumb)){
                if(file_exists($path) && unlink($path) && unlink($pathThumb)){
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                }else if(file_exists($path) && unlink($path)){
                    $sqlFiles = "UPDATE temas SET desativacao = TRUE WHERE idtemas = {$idTema}";
                    $conn->query($sqlFiles);
                } 
            }else{
                echo "0";
                exit;
            }   
        }


    }


    if($response == "tudo"){  
        echo $response;          
    }else{
        echo "1";
    }
    exit;

} else {

    $files = [];

    if(!isset($_GET["campanha"]) || !isset($_GET["layout"])) return;

    $sqlConfiguracaoInterface = "
        SELECT DISTINCT
            idcampanhas,
            campanhas.nome AS nome_campanha,
            idlayouts, 
            layouts.nome AS nome_layout
        FROM layouts 
        INNER JOIN campanhas ON campanhas.fkempresas = {$_SESSION["id"]} AND EXISTS( 
            SELECT * FROM arquivos 
            WHERE 
                fkcampanhas = idcampanhas 
                AND fklayouts = idlayouts 
            LIMIT 1
        )
    ";
    $configInterface = [];
    $query = $conn->query($sqlConfiguracaoInterface);
    while($result = mysqli_fetch_array($query)){
        $configInterface[ $result["idcampanhas"] ][ $result["idlayouts"] ] = [
            "nome_layout" => $result["nome_layout"]
        ];
    };

    if(!empty($configInterface) && isset($configInterface[ $_GET["campanha"] ][ $_GET["layout"] ])){

        $layout = $configInterface[ $_GET["campanha"] ][ $_GET["layout"] ]["nome_layout"];

        $sqlFiles = "
            SELECT * 
            FROM arquivos 
            WHERE 
                fkcampanhas = {$_GET["campanha"]} 
                AND fklayouts = {$_GET["layout"]} 
        ";
        $query = $conn->query($sqlFiles);
        
        while($result = mysqli_fetch_array($query)){

            $fileDatabase = $result["nome_arquivo"];
            $fileName  = substr($fileDatabase, 0, strrpos($fileDatabase, "."));
            $extension = substr($fileDatabase, strrpos($fileDatabase, "."), strlen($fileDatabase));

            $files[ $result["idarquivos"] ] = [
                //"postado_fb" => $result["postado_fb"], //TODO postagem no facebook  
                "path" => "../companies/{$_SESSION["nome"]}/campaigns/{$_GET["campanha"]}/files/{$layout}/{$fileName}_thumb.jpg",
                "ext" => $extension
            ];
        }
    }

}

?>