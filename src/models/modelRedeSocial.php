<?php

$fb = new FBPost( (new DataBase())->connect() );

switch ($_POST["act"]){
    case 'changeToken':
        $fb->changeTokenExtended(
            array(
                "oauth" => array(
                    "client_id"         => "376199693057711",
                    "client_secret"     => "ecf87e3547d96d338148ac93df55ae37",
                    "fb_exchange_token" => $_POST["token"]
                ),
                "intern" => array(
                    "uid_user"    => $_POST["userID"],
                    //"id_album"    => $_POST["idAlbum"],
                    //"nome_album"  => $_POST["nameAlbum"],
                    "id_pagina"   => $_POST["idPage"],
                    "nome_pagina" => $_POST["namePage"]
                )
            )
        );
    break;

    case "invalidToken":
        $fb->setInvalidToken();
    break;

    case "saveStatistic":
        $fb->insertStatistic();
    break;
}

class FBPost{

    private $conf;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

/*
    static function checkExpiredToken(){
        if(!empty($_SESSION["fb_token_expiracao"])){
            return $_SESSION["fb_token_expiracao"] > date("d/m/Y H:i:s");
        }
        return true;
    }
*/

    public function changeTokenExtended($arrayConf){

        $this->conf = $arrayConf;
        $this->conf["oauth"]["grant_type"] = "fb_exchange_token";

        $response = $this->curlRequestTokenExtended();

        if(!isset($response->error) && isset($response->access_token)){

            $data = $this->conf["intern"];
            $codeExclusion = $data['uid_user'] . "peimage";

            //dados retirados do fb
            //fb_id_album = '{$data["id_album"]}',
            //fb_nome_album = '{$data["nome_album"]}',

            $update = "
                UPDATE usuarios 
                SET 
                    fb_uid_usuario = '{$data['uid_user']}',
                    fb_token_extendido = '{$response->access_token}', 
                    fb_id_pagina = '{$data["id_pagina"]}', 
                    fb_nome_pagina = '{$data["nome_pagina"]}',
                    fb_cod_exclusao = MD5('{$codeExclusion}')
                WHERE idusuarios = {$_SESSION["user"]} 
                LIMIT 1
            ";
            
            if($this->conn->query($update) === true){
                $_SESSION['fb_token_extendido'] = $response->access_token;
                $_SESSION['fb_uid_usuario']     = $data['uid_user'];
                //$_SESSION['fb_id_album']        = $data['id_album'];
                //$_SESSION['fb_nome_album']      = $data['nome_album'];
                $_SESSION['fb_id_pagina']       = $data['id_pagina'];
                $_SESSION['fb_nome_pagina']     = $data['nome_pagina'];
                echo json_encode(array("result" => true));
            } else {
                echo json_encode(array("result" => false));
            }
        
        } else {
            echo json_encode(array("result" => false));
        }
    }

    private function curlRequestTokenExtended(){
        $url = "https://graph.facebook.com/oauth/access_token";
        $ch = curl_init();
        // Set query data here with the URL
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($this->conf["oauth"])); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);//seconds
        $content = trim(curl_exec($ch));
        curl_close($ch);
        return json_decode($content);
    }

    public function setInvalidToken(){
        $update = "
            UPDATE usuarios 
            SET 
                fb_uid_usuario = '',
                fb_token_extendido = '', 
                fb_id_album = '',
                fb_nome_album = '',
                fb_id_pagina = '', 
                fb_nome_pagina = ''
            WHERE idusuarios = {$_SESSION["user"]} 
            LIMIT 1
        ";
        if($this->conn->query($update) === true && $this->conn->affected_rows == 1){
            $_SESSION['fb_uid_usuario']     = '';
            $_SESSION['fb_token_extendido'] = '';
            $_SESSION['fb_id_album']        = '';
            $_SESSION['fb_nome_album']      = '';
            $_SESSION['fb_id_pagina']       = '';
            $_SESSION['fb_nome_pagina']     = '';
            echo json_encode(array("result" => true));
        } else {
            echo json_encode(array("result" => false));
        }
    }

}

?>