<?php
    $DataBase = new DataBase();
    $conn     = $DataBase->connect();

    if(isset($_POST["act"]) && $_POST["act"] == "saveConfigLayout"){
        try {
            $idcampanha = $_POST['campanha'];
            $idlayout   = $_POST['idlayout'];
            $sql = "
                UPDATE layouts_campanha 
                SET caracteristicas = '{$_POST["data"]}'
                WHERE fkcampanhas = {$idcampanha} AND fklayouts = {$idlayout}
            ";
            $DataBase->query($sql);
            echo 1;
        } catch(Exeption $e) {
            echo 0;
        }
        exit;
    }

    if(isset($_POST["act"]) && $_POST["act"] == "status"){
            
        //validamos os dados utilizados no update
        if(!is_numeric($_POST["tema"])) return;
        $status = $_POST["status"] == "true" ? "TRUE" : "FALSE";

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

        //die($sqlFiles);
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
        exit;
    }

    if(!empty($_GET['acao'])){
        $fkusuario = $_GET['usuario'];
        $fklayout = $_GET['layout'];
        $acao = $_GET['acao'];
        $fktema = $_GET['tema'];
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
        exit(1);
    }

    $idcampanha = $_GET['campanha'];
    $layout     = $_GET['layout'];
    $idlayout   = $_GET['idlayout'];
    $namelayout = $_GET['nomeLayout'];

    //TODO nome da empresa nao esta disponivel na session?
    $sqlConsultCompanie = "SELECT nome FROM empresas WHERE idempresas = " . $_SESSION["id"];
    $queryEmpresas = $DataBase->query($sqlConsultCompanie);
    $row=mysqli_fetch_array($queryEmpresas);
    $companie = $row['nome'];

    $logo        = $__HTTP_HOST . '/images/logoPeimage.png';
    $imageMenu   = $__HTTP_HOST . '/images/menu.png';
    $dirCompanie = $__HTTP_HOST . '/companies/'. $companie .'/';
    $logoCompany = $dirCompanie . "logo.png";
    $dirThemes   = $dirCompanie . 'campaigns/'.$idcampanha.'/'.$namelayout.'/';

    $sqlConsultTemas = "
        SELECT
            DISTINCT(idtemas),
            nome_arquivo,
            CASE WHEN utilizacao = 1 THEN 'sem_restricao' 
                WHEN utilizacao = 2 THEN 'postavel' 
                ELSE 'download' 
                END AS utilizacao,
            status_teste,
            caracteristicas
        FROM temas 
            INNER JOIN layouts_campanha ON idlayouts_campanha = fklayouts_campanha 
            INNER JOIN layouts          ON idlayouts = layouts_campanha.fklayouts
            INNER JOIN layouts_empresa  ON layouts_empresa.fklayouts = layouts.idlayouts 

        WHERE
            layouts_campanha.fkcampanhas = $idcampanha
            AND layouts_campanha.fklayouts = $idlayout 
            AND temas.desativacao IS NOT TRUE 
    ";

    $queryTemas = $DataBase->query($sqlConsultTemas);

    $themes = array();
    while($row=mysqli_fetch_assoc($queryTemas)){
        $themes[] = $row;
    }


    $sqlIdsCampanhas = "
        SELECT idcampanhas 
        FROM campanhas
        WHERE
            fkempresas = {$_SESSION["id"]}
            AND desativacao IS NOT TRUE 
            AND (NOW() >= dt_inicio AND NOW() <= dt_encerramento)
    ";
    $queryCampanha = $DataBase->query($sqlIdsCampanhas);

    $idsCampanha = array();
    while($row=mysqli_fetch_assoc($queryCampanha)){
        $idsCampanha[] = $row["idcampanhas"];
    }    
    
    $__HTTP_HOST = "..";

    //generate - layout de edicao de imagem (conteudo do layout: título, descricao, etc)
    //config - layout de configuracao do template (tamanho da fonte, cores de texto, etc)
    $__TYPE_LAYOUT           = $_SESSION['tipo'] == 'agencia' || $_SESSION['tipo'] == 'admin' ? "config" : "edit";
    $__PATH_FILE_MODE_LAYOUT = $__HTTP_HOST . "/companies/". $_SESSION["nome"] . "/layouts/" . $_GET["layout"] . "/" . $__TYPE_LAYOUT . ".php";
    $__PATH_PHP_FORM_LAYOUT  = $__HTTP_HOST . "/companies/". $_SESSION["nome"] . "/layouts/" . $_GET["layout"] . "/layout.php";
    $__PATH_CSS_GENERATOR    = $__HTTP_HOST . "/companies/". $_SESSION["nome"] . "/layouts/" . $_GET["layout"] . "/layout.css";
    $__PATH_JS_GENERATOR     = $__HTTP_HOST . "/companies/". $_SESSION["nome"] . "/layouts/" . $_GET["layout"] . "/layout.js";
    
?>