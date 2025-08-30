<?php



    $db = new DataBase();

    $conn = $DataBase->connect();



    if(!empty($_GET['acao'])){

        $fkusuario = $_SESSION["user"];

        $fklayout  = $_GET['layout'];

        $acao      = $_GET['acao'];

        $fktema    = $_GET['tema'];



        //a estatistica pode ser salva de pacote em pacote

        //ou durante a geracao da lista um array contendo o id

        //de todos temas

        if($_GET["acao"] == "printList" || $_GET["acao"] == "downloadList"){



            $action = $_GET["acao"] == "printList" ? "p" : "d";



            $fktema = json_decode(($fktema));

            foreach($fktema as $idtema){

                if(!empty($fktema)){

                    $sqlInsertEstatistica = "INSERT INTO estatisticas (fktemas, fkusuarios, dth_Log, acao) VALUES ('$idtema', '$fkusuario', NOW(), '$action')";

                    $DataBase->query($sqlInsertEstatistica); 

                } else {

                    $sqlInsertEstatistica = "INSERT INTO estatisticas (fklayouts, fkusuarios, dth_Log, acao) VALUES ('$idtema', '$fkusuario', NOW(), '$action')";

                    $DataBase->query($sqlInsertEstatistica);

                }

            }



        } else {

            if(!empty($fktema)){

                if(!empty($fkarquivo)){

                    $sqlInsertEstatistica = "INSERT INTO estatisticas (fktemas, fkarquivos, fkusuarios, dth_Log, acao) VALUES ('$fktema', '$fkarquivos', '$fkusuario', NOW(), $acao)";

                    $DataBase->query($sqlInsertEstatistica);

                }else{

                    $sqlInsertEstatistica = "INSERT INTO estatisticas (fktemas, fkusuarios, dth_Log, acao) VALUES ('$fktema', '$fkusuario', NOW(), '$acao')";

                    $DataBase->query($sqlInsertEstatistica); 

                }

            }else{

                $sqlInsertEstatistica = "INSERT INTO estatisticas (fklayouts, fkusuarios, dth_Log, acao) VALUES ('$fklayout', '$fkusuario', NOW(),'$acao')";

                $DataBase->query($sqlInsertEstatistica);

            }

        }

        exit(1);

    }



    if(isset($_POST["act"]) && $_POST["act"] == "status"){

        

        //validamos os dados utilizados no update

        if(!is_numeric($_POST["tema"])) return;

        $status = $_POST["status"] == 1 ? "TRUE" : "FALSE";



        $sqlFiles = "
            UPDATE temas
            SET status_teste = {$status}
            WHERE fklayouts_campanha IN (
                SELECT fklayouts_campanha
                FROM (
                    SELECT fklayouts_campanha
                    FROM temas
                    WHERE idtemas = {$_POST['tema']}
                ) AS subquery
            )
        ";

    

        try {

            $conn->begin_transaction();

            $conn->query($sqlFiles);

            if($conn->commit()){

                echo "1";

            } else {

                echo "0";

            }

        } catch(Exception $e){

            echo "0";

            $conn->rollback();

        }

        

    } else {



        if(!is_numeric($_POST["tema"])) return;

        $response = $db->query("SELECT status_teste FROM temas WHERE idtemas = {$tema}");

        

    }



?>