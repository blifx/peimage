<?php


$DataBase = new DataBase;
    $conn = $DataBase->connect();


    $sqlConsultCampanha = "SELECT idcampanhas, nome FROM campanhas WHERE fkempresas = $idcompanie AND desativacao = 0 
                            ORDER BY dt_inicio DESC, idcampanhas DESC";
    $queryCampanhas = $DataBase->query($sqlConsultCampanha);
    $numCampanhas = mysqli_num_rows($queryCampanhas);

    $sqlConsultUsuarios = "SELECT COUNT(idusuarios) AS n_usuarios FROM usuarios WHERE fkempresas = $idcompanie";
    $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
    $row=mysqli_fetch_array($queryUsuarios);
    $numUsuarios = $row['n_usuarios'];


    //json para layouts
    $layoutOptions = array();
    if($numCampanhas > 0){
        $sqlConsultaLayouts = "
            SELECT
                idlayouts,  
                fkcampanhas,
                nome,
                arquivo,
                largura,
                altura
                FROM layouts
                INNER JOIN layouts_empresa ON layouts_empresa.fklayouts = idlayouts 
                INNER JOIN layouts_campanha ON layouts_campanha.fklayouts = idlayouts
            WHERE (layouts_empresa.fkempresas = '$idcompanie') AND desativacao IS NOT TRUE
            ORDER BY idlayouts ASC
        ";


       // die($sqlConsultaLayouts);
        $queryLayouts = $DataBase->query($sqlConsultaLayouts);
        while($row=mysqli_fetch_array($queryLayouts)){
            $layoutOptions[ $row["fkcampanhas"] ][ $row["idlayouts"] ] = array(
                "idlayout" => $row["idlayouts"],
                "nome" => $row["nome"],
                "arquivo" => $row["arquivo"],
                "largura" => $row["largura"], 
                "altura" => $row["altura"]         
            );
        }
    }
    $layoutOptions = json_encode($layoutOptions);



    $sql = "
        SELECT DISTINCT fklayouts, fkcampanhas 
        FROM campanhas
        INNER JOIN arquivos ON fkcampanhas = idcampanhas
        WHERE fkempresas = {$_SESSION["id"]}
    ";
    $query = $DataBase->query($sql);
    $whileResult = array();
    while($result = mysqli_fetch_assoc($query)){
        $whileResult[ $result["fkcampanhas"] ][] = $result["fklayouts"];
    }
    $json = json_encode($whileResult);

?>