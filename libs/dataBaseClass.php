<?php

class DataBase{
    public $link;
    public function connect(){
        $bd = $_SERVER['HTTP_HOST'];

        if($bd == 'localhost'){
            $hostname = "peimage.com";
            $bancodedados = "peimag96_peimage_dev";
            $usuario = "peimag96_peimage";
            $senha = "T0183m123@123";

        } else if($bd == 'app.peimage.com'){
            $hostname = "localhost";
            $bancodedados = "peimag96_peimage";
            $usuario = "peimag96_peimage";
            $senha = "T0183m123@123";
            
        } 

        $this->link = new mysqli($hostname, $usuario, $senha, $bancodedados, 3306);
        
        if ($this->link->connect_errno) {
            print_r("Falha ao conectar: (" . $this->link->connect_errno . ") " . $this->link->connect_errno );
            die();
        }
        return $this->link;
    }

    public function desconnect(){
        mysqli_close($this->link);
    }
    
    public function query($sql = Null){
        if ($teste = mysqli_query($this->link, $sql)) {
            //echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . '';
        }
        return $teste;
    }

    public function viewSql($sql){
        $sql = mysqli_query($this->link,$sql) or die("Erro");
        while($dados=mysqli_fetch_assoc($sql))
            {
                echo $dados['nome'].'<br>';
            }
return $dados;
    }

} 


?>
