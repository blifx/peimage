<?php
$DataBase = new DataBase;
$conn = $DataBase->connect();

if(!empty($_POST['layout'])){  
      
    $sqlConsultEmpresas = "SELECT cor, cor_texto FROM empresas WHERE idempresas = $idcompanie ";
    $queryEmpresas = $DataBase->query($sqlConsultEmpresas);
    $row=mysqli_fetch_array($queryEmpresas);
    $cor[0] = $row['cor']; 
    $cor[0] = hexrgb($cor[0]);//cor da empresa

    $cor_texto = $row['cor_texto']; 
    $cor_texto = hexrgb($cor_texto);//cor do texto

    $colorEmpresa = $cor[0];


    if(!empty($cor[1])){
        $cor[1] = hexrgb($cor[1]);
        $cor[2] = hexrgb($cor[2]);
        $cor[3] = hexrgb($cor[3]);
    }
    else{
        $cor[1] = '#000000'; 
        $cor[2] = '#000000'; 
        $cor[3] = '#FFFFFF'; 
        $cor[1] = hexrgb($cor[1]);
        $cor[2] = hexrgb($cor[2]);
        $cor[3] = $cor_texto;
    }
    
    $fkusuario = $idusuarios;
    $layout = $_POST['layout'];
    $idlayout = $_POST['idlayout'];
        //Insere a campanha no banco de dados
/*         $sqlInsertEmpresas = "INSERT INTO estatisticas (fkusuarios, dataLog, tipo) VALUES ($fkusuario, CURRENT_TIMESTAMP, '$layout')";
        $DataBase->query($sqlInsertEmpresas); */
}

?>