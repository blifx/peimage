<?php
if(!empty($_POST)){
    if( $senha1 == $senha2 )
    { 
        $DataBase = new DataBase;
        $conn = $DataBase->connect();
        //Insere a campanha no banco de dados
        $sqlUsuarioName= "SELECT email From usuarios WHERE email = '$email' AND idusuarios != $id";
        $queryUsuarios = $DataBase->query($sqlUsuarioName);
        $total = mysqli_num_rows($queryUsuarios); 
        
        if($total>0){
            header('Location: actionCrudUsuario.php?msg=Este Email já está Cadastrado');
            exit(1);
        }
        
        $queryUsuarioName = $DataBase->query($sqlUsuarioName);
        $sqlUpdateUsuarios = "UPDATE usuarios SET  nome = '{$nome}', email = '{$email}', senha = '{$senha1}' WHERE idusuarios = '{$id}'";
        $DataBase->query($sqlUpdateUsuarios);
        
        header('Location: actionCrudUsuario.php'); 
    }
}
?>