<?php
$DataBase = new DataBase;
$conn = $DataBase->connect();

include('../config.php');


function isEmailValido($email){
    $conta = "/[a-zA-Z0-9\._-]+@";
    $domino = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$/";
    $pattern = $conta.$domino.$extensao;
 
    if (preg_match($pattern, $email))
        return true;
    else
        return false;
}


    $idcompanie = $_GET['idempresa'];
    $i=0;
    $j=0;
    $k=0;
    $z=0;

if (($handle = fopen($_FILES['fileToUpload']['tmp_name'], "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if($data['0'] != 'Nome'){
            if($data['0'] != '' && $data['1'] != ''){
                $email = $data['1'];
                $sqlConsultUsuarios = "SELECT email FROM usuarios WHERE email = '{$email}'";
                $queryUsuarios = $DataBase->query($sqlConsultUsuarios);
                if(isEmailValido($email)){
                    if(mysqli_num_rows($queryUsuarios) > 0){
                        $emailExiste[$i] = $email;
                        $i++;
                    }else{
                        $str = 'abcdef123456789';
                        $senha = str_shuffle($str);
                        $sqlInsertEmpresas = "INSERT INTO usuarios (fkempresas, tipo, nome, email, senha, status_email, cod_validacao, status_validacao) VALUES ('{$idcompanie}', '', '{$data['0']}', '{$data['1']}', '{$senha}', 1, 0, 0)";
                        if($DataBase->query($sqlInsertEmpresas)){

                            $texto = "<p><a href=".$__HTTP_HOST."/src/actionLogin.php?loginOne=".$data['1']."&senhaOne=".$senha.">Clique aqui para realizar o seu primeiro acesso.</a></p>
                            <p>Caso prefira, você também pode colar o link abaixo no seu navegador para realizar o primeiro acesso utilizando os seguintes dados de usuário e senha:</p>".$__HTTP_HOST."</p>
                            <p>E-mail: ".$data['1']."<br/>Senha: $senha</p>";
                            $data = array_map("utf8_encode", $data);
                            if(!$envio = enviaEmail($data['0'], $data['1'], 'Link para primeiro acesso Peimage', $texto)){
                            $emailNaoEnviado[$z] = $email;
                            $z++; 
                            } 
                        }else{
                            $emailErro[$k] = $email;
                            $k++;
                        }
                    }
                }else{
                    $emailInvalido[$j] = $email;
                    $j++;
                }
            }
        }   
    }

    if($j>0){
        echo 'Os seguintes e-mails são inválidos: </br>';
        foreach ($emailInvalido as &$value) {
            echo $value.'; ';
        }
        echo "</br><div style='margin-bottom:5px;'></div>";
    }

    if($i>0){
        echo 'Já existe um usuário para os seguintes e-mails: </br>';
        foreach ($emailExiste as &$value) {
            echo $value.'; ';
        }
        echo "</br><div style='margin-bottom:5px;'></div>";
    }

    if($k>0){
        echo 'Os seguintes usuários não foram adicionados: </br>';
        foreach ($emailErro as &$value) {
            echo $value.'; ';
        }
        echo "</br><div style='margin-bottom:5px;'></div>";
    }

    if($z>0){
        echo 'O seguintes e-mails não foram enviados: </br>';
        foreach ($emailNaoEnviado as &$value) {
            echo $value.'; ';
        }
        echo "</br><div style='margin-bottom:5px;'></div>";;
    }

    fclose($handle);
}

if($i==0 && $j==0 && $k==0 && $z==0){
    echo '1';
}

?>