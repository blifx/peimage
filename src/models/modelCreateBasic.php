<?php
if(!empty($_POST)){    
    if( $senha1 == $senha2 )
    {
        $DataBase = new DataBase;
        $conn = $DataBase->connect();

        $sqlUsuarioName= "SELECT email From usuarios WHERE email =  '$email' ";
        $queryUsuarios = $DataBase->query($sqlUsuarioName);
        $total = mysqli_num_rows($queryUsuarios);
        

        if($total>0){
            header('Location: actionCreateBasic.php?msg=Este Email já está Cadastrado');
            exit(1);
        }

        if( $plano == 'pro'){
            $tipo = 'admin';
        }else if($plano == 'basic'){
            $tipo = 'basic';
        }        

        //Insere a campanha no banco de dados
        $sqlInsertEmpresas = "INSERT INTO empresas (nome, cnpj, cor, plano) VALUES ('{$nome}', '{$cnpj}', '{$cor}','{$plano}')";
        $DataBase->query($sqlInsertEmpresas);
        $sqlInsertId = "SELECT MAX(idempresas) AS idempresas FROM empresas";
        $queryId = $DataBase->query($sqlInsertId);
        $row=mysqli_fetch_array($queryId);
        $fkempresas = $row['idempresas'];
        $sqlInsertEmpresas = "INSERT INTO usuarios (fkempresas, nome, tipo, email, senha) VALUES ($fkempresas,'{$nome}', '{$tipo}', '{$email}', '{$senha1}')";
        $DataBase->query($sqlInsertEmpresas);
        
    }
}
?>