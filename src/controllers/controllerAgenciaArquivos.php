<?php


if(!empty($_GET)){
    $tipo = strtolower ($_GET['tipo']);

    $campanha = strtolower($_GET['campanha']);
    $fklayout = $_GET['idlayout'];
    $fkcampanha = $_GET['idcampanha'];

    $storeCampanha = __DIR__."/../../companies/{$companie}/campaigns/{$fkcampanha}";
    $storeFiles = __DIR__."/../../companies/{$companie}/campaigns/{$fkcampanha}/files";
    $storeFolder = __DIR__."/../../companies/{$companie}/campaigns/{$fkcampanha}/files/{$tipo}";
    
    if(!is_dir($storeCampanha)){
        mkdir($storeCampanha, 0755);
    }

    if(!is_dir($storeFiles)){
        mkdir($storeFiles, 0755);
    }

    if(!is_dir($storeFolder)){
        mkdir($storeFolder, 0755);
    }

    $tempFile = $_FILES['fileToUpload']['tmp_name'];   
    $path = $_FILES['fileToUpload']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $name = pathinfo($path, PATHINFO_FILENAME);

    $targetPath = '/'.$storeFolder.'/';

    if($tipo == 'outros'){

        $DataBase = new DataBase();
        $conn = $DataBase->connect();
        $sqlInsertArquivo = "INSERT INTO arquivos (fkcampanhas) VALUES ('$fkcampanha')";
            
        if ($DataBase->query($sqlInsertArquivo)){

            $sqlUltimoId =  "SELECT LAST_INSERT_ID() AS id";
            $queryId = $DataBase->query($sqlUltimoId);
            
            $row=mysqli_fetch_array($queryId);
            $idArquivo = $row['id'];

            $tamanhoCorte = (int)strlen($idArquivo) +  (int)strlen($ext) + 3;
            $name = substr($name, 0, 150 - $tamanhoCorte);

            $nome_arquivo = $name.'-'.$idArquivo.'.'.$ext;
     
            $sqlUpdateNome = "UPDATE arquivos SET nome_arquivo = '$nome_arquivo' WHERE idarquivos = '$idArquivo' "; 
            $DataBase->query($sqlUpdateNome);

            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $storeFolder.'/'.$nome_arquivo);
        }

    }else{
        if (!empty($_FILES)) {
            $DataBase = new DataBase();
            $conn = $DataBase->connect();
            $sqlInsertArquivo = "INSERT INTO arquivos (fklayouts, fkcampanhas) VALUES ('$fklayout', '$fkcampanha')";
            
            if ($DataBase->query($sqlInsertArquivo)){

                $sqlUltimoId =  "SELECT LAST_INSERT_ID() AS id";
                $queryId = $DataBase->query($sqlUltimoId);
                
                $row=mysqli_fetch_array($queryId);
                $idArquivo = $row['id'];

                $tamanhoCorte = (int)strlen($idArquivo) + (int)strlen($ext) + 2;
                $name = substr($name, 0, 255 - $tamanhoCorte);

                $nome_arquivo = $name.'-'.$idArquivo.'.'.$ext;
         
                $sqlUpdateNome = "UPDATE arquivos SET nome_arquivo = '$nome_arquivo' WHERE idarquivos = '$idArquivo' "; 
                $DataBase->query($sqlUpdateNome);


                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $storeFolder.'/'.$nome_arquivo);
                makeThumbnails($storeFolder .  '/', $name.'-'.$idArquivo, '.png');
 
                
            } 
        }
    }
    
}
   

  ?>