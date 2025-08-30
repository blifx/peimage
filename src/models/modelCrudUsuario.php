<?php 
$DataBase = new DataBase;
$conn = $DataBase->connect();


if(!empty($_POST)){
    $idusuarios = $_POST['idusuarios'];
    if(isset($_POST['excluir'])){

    $sqlDelete = "SELECT COUNT(tipo) AS tipo FROM usuarios where idusuarios = $idusuarios AND tipo = 'admin' ";
    $queryDelete = $DataBase->query($sqlDelete);  
    $row=mysqli_fetch_array($queryDelete);
    $tipo = $row['tipo']; 

    if($tipo > 0){
        header('Location: actionCrudUsuario.php?msg=Você não pode excluir o usuário admin');
        exit(1);    
    }

    $sqlDeleteUsuEst = "DELETE FROM estatisticas WHERE fkusuarios =  $idusuarios ";
    $queryDeleteUsuEst = $DataBase->query($sqlDeleteUsuEst);

    $sqlDeleteUsuarios = "DELETE FROM usuarios WHERE idusuarios =  $idusuarios ";
    $queryDeleteUsuarios = $DataBase->query($sqlDeleteUsuarios);
    header('Location: actionCrudUsuario.php');  
    }

    if(isset($_POST['alterar'])){
    $sqlUsuarioName= "SELECT * From usuarios WHERE idusuarios =  $idusuarios";
    $queryUsuarioName = $DataBase->query($sqlUsuarioName);
    $rowUsuarioName=mysqli_fetch_array($queryUsuarioName);
    $id = $rowUsuarioName['idusuarios'];
    $nome = $rowUsuarioName['nome'];
    $email = $rowUsuarioName['email'];
    $senha = $rowUsuarioName['senha'];
    }
}
else
{
    //Consulta todas as campanhas da empresa
    $sqlConsultCampanha = "SELECT idusuarios, nome FROM usuarios WHERE fkempresas = $idcompanie ORDER BY nome asc";
    $queryCampanhas = $DataBase->query($sqlConsultCampanha);
}


?>
