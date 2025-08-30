<?php
if(!empty($_POST)){

    $nome = $_POST['nome'];
    $cor = $_POST['cor'];
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];

    if( $senha1 == $senha2 )
    {


        $DataBase = new DataBase;
        $conn = $DataBase->connect();

        $sqlUsuarioName= "SELECT email From usuarios WHERE email =  '$email' or nome = '$nome' LIMIT 1";
        $queryUsuarios = $DataBase->query($sqlUsuarioName);
        $total = mysqli_num_rows($queryUsuarios);

        if($total>0){
            header('Location: actionCreateEmpresa.php?msg= Razão social ou e-mail já está Cadastrado');
        }

        //Insere a campanha no banco de dados
        $sqlInsertEmpresas = "INSERT INTO empresas (nome, cnpj, cor) VALUES ('{$nome}', '{$cnpj}', '{$cor}')";
        if($DataBase->query($sqlInsertEmpresas)){
            $sqlInsertId = "SELECT MAX(idempresas) AS idempresas FROM empresas";
            $queryId = $DataBase->query($sqlInsertId);
            $row=mysqli_fetch_array($queryId);
            $fkempresas = $row['idempresas'];
            $sqlInsertEmpresas = "INSERT INTO usuarios (fkempresas, nome, tipo, email, senha) VALUES ($fkempresas,'{$nome}', '{$tipo}', '{$email}', '{$senha1}')";
            $DataBase->query($sqlInsertEmpresas);

            if(!file_exists('../companies/'.$nome)){
                mkdir('../companies/'.$nome, 0755, true);
                mkdir('../companies/'.$nome.'/downloads', 0755, true);
                mkdir('../companies/'.$nome.'/uploads', 0755, true);
                $arquivos = $_FILES['arquivo'];
                move_uploaded_file($arquivos['tmp_name'],'../companies/'.$nome.'/uploads/logo.png');
        
                // Carrega a imagem a ser manipulada
                $image = WideImage::load('../companies/'.$nome.'/uploads/logo.png');
                // Redimensiona a imagem
                $image_b = $image->resize(246,112);
                //$image_p = $image_p->resize(2000,112);
                
                $image_p = $image->resize(530,115);
                //$image_b = $image_b->resize(2000,115);
                
                $image = $image->resize(530,115);
                
                // Salva a imagem em um arquivo (novo ou não)
                $image_p->saveToFile('../companies/'.$nome.'/logo_pequeno.png');
                $image_b->saveToFile('../companies/'.$nome.'/logo_branco.png');
                $image->saveToFile('../companies/'.$nome.'/logo.png');
            }
                
        }
    }else{
        header('Location: actionCreateEmpresa.php?msg= As senhas não coincidem');
    }
}
?>