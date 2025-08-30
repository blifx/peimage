<?php
require_once("dataBaseClass.php");

$DataBase = new DataBase;
$conn = $DataBase->connect();

$sqlConsultConfigs = "
        SELECT
            base_url
        FROM configs 
";
$queryConfigs = $DataBase->query($sqlConsultConfigs);
$row = mysqli_fetch_array($queryConfigs);

$__HTTP_HOST = $row['base_url'];


/*-------------------------------------------------------------------------------*/

function ajustSizeString($tamanhoMaxFont, $tamanhoMax, $font, $texto){

    list($left,, $right) = imageftbbox( $tamanhoMaxFont, 0, $font, $texto);
    $tamanhoString = $right - $left;
    if($tamanhoString>$tamanhoMax){
      
    
        while($tamanhoString>$tamanhoMax){
            list($left,, $right) = imageftbbox( $tamanhoMaxFont, 0, $font, $texto);
            $tamanhoString = $right - $left;
            $tamanhoMaxFont = $tamanhoMaxFont - 0.4;
        }
    }

return $tamanhoMaxFont;

}


function makeThumbnails($path, $name, $ext) {
	$updir = $path . $name . $ext;
	$thumbnail_width = 200;
	$thumbnail_height = 284;
	$thumb_beforeword = "_thumb";
	$arr_image_details = getimagesize("$updir"); // pass id to thumb name
	$original_width = $arr_image_details[0];
	$original_height = $arr_image_details[1];

	if ($original_width == $original_height) {
		$thumbnail_height = 200;
		$new_width = 200;
		$new_height = 200;
	} else if ($original_width > $original_height) {
		$new_width = $thumbnail_width;
		$new_height = intval($original_height * $new_width / $original_width);
	} else {
		$new_height = $thumbnail_height;
		$new_width = intval($original_width * $new_height / $original_height);
	}
	$dest_x = intval(($thumbnail_width - $new_width) / 2);
	$dest_y = intval(($thumbnail_height - $new_height) / 2);
	if ($arr_image_details[2] == IMAGETYPE_JPEG) {
		$imgt = "ImageJPEG";
		$imgcreatefrom = "ImageCreateFromJPEG";
	}
	if ($arr_image_details[2] == IMAGETYPE_PNG) {
		$imgt = "ImagePNG";
		$imgcreatefrom = "ImageCreateFromPNG";
	}
	if ($imgt) {
		$old_image = $imgcreatefrom("$updir");
		$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
		ImageJPEG($new_image, $path . $name . $thumb_beforeword . ".jpg", 85);
	}
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviaEmail($nomeDestinatario, $emailDestinatario, $assunto, $texto, $saudacao = '') {
    global $smtpConfig, $remetente, $nomeRemetente;

    // Inclui a biblioteca PHPMailer
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';
    require_once 'PHPMailer/src/Exception.php';    
    
    // Configurações do servidor SMTP e do email
    $smtpConfig = array(
        'host' => 'smtp.titan.email',
        'port' => 587,
        'username' => 'contato@peimage.com',
        'password' => 'T0183m1234@',
        'smtpSecure' => 'tls',
    );
    
    $remetente = 'contato@peimage.com';
    $nomeRemetente = 'Equipe Peimage';


    // Configurações do corpo do email
    $corpoEmail = '<html><body>';
    $corpoEmail .= '<div style="color:#006064; font-size:20px">' . $saudacao . '</div>';
    $corpoEmail .= '<p>' . $texto . '</p>';
    $corpoEmail .= '<div>Atenciosamente,</div>';
    $corpoEmail .= '<div>Equipe Peimage.</div><br/>';
    $corpoEmail .= '<div style="max-width:150px"><a href="https://peimage.com"></a></div>';
    
   /* $corpoEmail .= '<div style="max-width:150px"><a href="https://peimage.com"><img src="https://peimage.com.br/wp-content/uploads/2019/06/peimage.png" style="max-width:150px"></a></div>'; */
        
    
    $corpoEmail .= '</body></html>';

    // Cria um novo objeto PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = $smtpConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtpConfig['username'];
        $mail->Password = $smtpConfig['password'];
        $mail->Port = $smtpConfig['port'];
        $mail->SMTPSecure = $smtpConfig['smtpSecure'];

        // Define o remetente e o destinatário do email
        $mail->setFrom($remetente, $nomeRemetente);
        $mail->addAddress($emailDestinatario, $nomeDestinatario);

        // Configura o assunto e o corpo do email
        $mail->Subject = $assunto;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Define o charset para UTF-8
        $mail->Body = $corpoEmail;

        // Envia o email
        $mail->send();
        
        // Retorna true quando o email é enviado com sucesso
        return true;
    } catch (Exception $e) {
        // Trata exceção
        throw new Exception("Erro ao enviar o email: {$mail->ErrorInfo}");
    }
}

function ajustImagePaper($dir, $productState, $sizeProduct){

	$dirExt = getimagesize($dir);
	if($dirExt["mime"] == 'image/png'){
		$original_img = imagecreatefrompng(realpath($dir));
		$cropped_img_white = imagecropauto($original_img , IMG_CROP_THRESHOLD, 0.5, 16777215); 
		imagepng($cropped_img_white,$dir);
		$original_img = imagecreatefrompng(realpath($dir));
		$cropped_img_white=imagecropauto($original_img, IMG_CROP_SIDES, 0.5,0);
		//Retira fundo preto
		$white = imagecolorallocate($cropped_img_white, 0, 0, 0);
		imagecolortransparent($cropped_img_white, $white);
		//
		
		imagealphablending( $cropped_img_white, false );
		$transparent = imagecolorallocatealpha( $cropped_img_white, 0, 0, 0, 127 );
		imagefill( $cropped_img_white, 0, 0, $transparent );
		imagesavealpha( $cropped_img_white,true );
		imagealphablending( $cropped_img_white, true );
		imagepng($cropped_img_white,$dir);
	}else{
		$original_img = imagecreatefromjpeg(realpath($dir));
		$cropped_img_white = imagecropauto($original_img , IMG_CROP_THRESHOLD, 0.5, 16777190); 
		//$white = imagecolorallocate($cropped_img_white, 255, 255, 255);
		//imagecolortransparent($cropped_img_white, $white);
		imagepng($cropped_img_white,$dir);
	}


    if($productState == 'com imagem'){
        /*Carrega a imagem a ser redimencionada*/
        $original = WideImage::load(realpath($dir));
        $resized = $original->resize($sizeProduct, $sizeProduct);
        $original->destroy();
        /*Executada a retirada do fundo branco*/
        $img = WideImage::createTrueColorImage($resized->getWidth(), $resized->getHeight());
        $bg  = $img->allocateColor(255,255,255);
        $img->fill(0,0,$bg);


        if($dirExt["mime"] == 'image/png'){
        /*Salva a imagem renderizada*/
        $img->merge($resized)->saveToFile($dir, 0);
                /*Carrega nas variáveis as imagens de tema, produto e desconto*/
                $imgProduct = imagecreatefrompng($dir);
        }else{
        /*Salva a imagem renderizada*/
        $img->merge($resized)->saveToFile($dir, 100);
            /*Carrega nas variáveis as imagens de tema, produto e desconto*/
            $imgProduct = imagecreatefromjpeg($dir);
        }  
	}
	



    return $imgProduct;

}




    function clearImages($path, $ext, $time){
		date_default_timezone_set("Brazil/East");
		$path = $path.'*'.$ext;
		$date = strtotime($time.' minute');
		foreach(glob($path) as $file){
			$filetime = filemtime($file);
			if( $date > $filetime ){
        	unlink($file);
			}
		}
	}

	function dataMes ($data){
    $validade = explode("-", $data);
    switch ($validade[1]) {
        case "1":
        $validade[1] = 'janeiro';
        break;
        case "2":
        $validade[1] = 'fevereiro';
        break;
        case "3":
        $validade[1] = 'março';
        break;
        case "4":
        $validade[1] = 'abril';
        break;
        case "5":
        $validade[1] = 'maio';
        break;
        case "6":
        $validade[1] = 'junho';
        break;
        case "7":
        $validade[1] = 'julho';
        break;
        case "8":
        $validade[1] = 'agosto';
        break;
        case "9":
        $validade[1] = 'setembro';
        break;
        case "10":
        $validade[1] = 'outubro';
        break;
        case "11":
        $validade[1] = 'novembro';
        break;
        case "12":
        $validade[1] = 'dezembro';
        break;
		}
		return $validade;

	}

	

	function menu($logo, $imageMenu){
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$__HTTP_HOST = $GLOBALS['__HTTP_HOST'];

		$email = $_SESSION['email'];
		echo '
		<div id="cssmenu">
		<ul>
			<li class="active has-sub"><img  src="'.$imageMenu.'" alt="logo"  width="23" height="22"/>
			  <ul>';
		if($email == 'tsilva_duarte@hotmail.com'){
			echo '
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionSetCreateCampanha.php"><span>Adicionar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCrudCampanha.php"><span>Atualizar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionAgenciaArquivos.php"><span>Adicionar Arquivos</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCreateUsuario.php"><span>Adicionar Usuário</span></a></li>				
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCrudUsuario.php"><span>Atualizar Usuário</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCreateEmpresa.php"><span>Adicionar Empresa</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionSetEmpresaImportUsuarios.php"><span>Importar Usuários</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCreatLayout.php"><span>Criar Layout</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionSetEmpresaCrudLayout.php"><span>Atualizar Layout</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionLogout.php"><span>Logout</span></a></li>';
		}else if(($_SESSION['tipo'] == 'admin')){
			//<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCreateUsuario.php"><span>Adicionar Usuário</span></a></li>
			//<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCrudUsuario.php"><span>Atualizar Usuário</span></a></li> 
			echo '
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionPerfil.php"><span>Perfil Empresa</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionAgenciaPerfil.php"><span>Perfil Equipe/Agência</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionSetCreateCampanha.php"><span>Adicionar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCrudCampanha.php"><span>Atualizar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionAgenciaArquivos.php"><span>Adicionar Arquivos</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionGraficos.php"><span>Estatísticas</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionLogout.php"><span>Logout</span></a></li>';
		
		}else if(($_SESSION['tipo'] == 'basic')){
			echo '
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionPerfil.php"><span>Perfil</span></a></li>
			 	<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionLogout.php"><span>Logout</span></a></li>';
		
		} else if(($_SESSION['tipo'] == 'agencia')){
			echo '
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionAgenciaPerfil.php"><span>Perfil</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionSetCreateCampanha.php"><span>Adicionar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionCrudCampanha.php"><span>Atualizar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionSetCampanhaConfig.php"><span>Configurar Campanha</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionAgenciaArquivos.php"><span>Adicionar Arquivos</span></a></li>
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionLogout.php"><span>Logout</span></a></li>';
		
		}else{
			echo '
				<li class="has-sub"><a href="' . $__HTTP_HOST . '/src/actionLogout.php"><span>Logout</span></a></li>';

		}
		echo '	
		</ul>
			</li>
			<li><div style="color:#FFF;padding:2px;font-weight:400; font-size:16px; text-shadow: 1px 1px 2px #615c5c;">'.ucfirst ($_SESSION['usuario']).'</div></li>
				</ul>
		</div>
		<div style="position: absolute; top: 6px; left: 5px; ">
			<a href="'.$__HTTP_HOST . '/index.php"><img  src="'.$logo.'" alt="logo"  width="128" height="24"/></a>
		</div>
		';
	}
	
	function acentoUpload($string){
		$LetraProibi = Array(".","'","\"","&","|","!","#","$","¨","*","(",")","`","´","<",">",";","=","+","§","{","}","[","]","^","~","?","%");
		$special = Array('Á','È','ô','Ç','á','è','Ò','ç','Â','Ë','ò','â','ë','Ø','Ñ','À','Ð','ø','ñ','à','ð','Õ','Å','õ','Ý','å','Í','Ö','ý','Ã','í','ö','ã',
		   'Î','Ä','î','Ú','ä','Ì','ú','Æ','ì','Û','æ','Ï','û','ï','Ù','®','É','ù','©','é','Ó','Ü','Þ','Ê','ó','ü','þ','ê','Ô','ß','‘','’','‚','“','”','„');
		$clearspc = Array('a','e','o','c','a','e','o','c','a','e','o','a','e','o','n','a','d','o','n','a','o','o','a','o','y','a','i','o','y','a','i','o','a',
		   'i','a','i','u','a','i','u','a','i','u','a','i','u','i','u','','e','u','c','e','o','u','p','e','o','u','b','e','o','b','','','','','','');
		$newString = str_replace($special, $clearspc, $string);
		$newString = str_replace($LetraProibi, "", trim($newString));
		return strtolower($newString);
	 }

	 function hexrgb($hex) {
		$hex = str_replace("#", "", $hex);
		if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);

		$rgb = implode(", ", $rgb);

		return $rgb;
}	 

function GetDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal/10000000;
}

function layoutsSelects($idcompanie, $required, $operation='0'){
	//$opetation 0=insert/1=alteração
	$simbol = "*";
	$required = "required='required'";

	if($operation == '1'){
		$required = '';
		$simbol = '';
	}
	$DataBase = new DataBase;
	$DataBase->connect(); 
	$sqlSelects = "SELECT idlayouts, nome, largura, altura FROM layouts
	WHERE (fkempresas = '$idcompanie' AND status_campanha = 1) OR (fkempresas IS NULL AND status_campanha = 1) 
	GROUP BY idlayouts";


	$querySelects = $DataBase->query($sqlSelects);
	while($rowsSelects=mysqli_fetch_array($querySelects)){
		echo "<label>".$rowsSelects['nome']."$simbol</label><label style='font-size:20px;'>(".$rowsSelects['largura']."x".$rowsSelects['altura']."px)</label>";
		echo "<input
				class='layouts-selects' 
				id='".$rowsSelects['nome']."' 
				largura='".$rowsSelects['largura']."' 
				altura='".$rowsSelects['altura']."' 
				type='file' 
				name='".$rowsSelects['nome']."[]' 
				accept='image/png' 
				$required 
				multiple='multiple' 
			/>";
		echo "<input type='hidden' name='".$rowsSelects['nome']."' value='".$rowsSelects['idlayouts']."' />";
		if($operation==	'0'){
			if (strpos($rowsSelects['nome'], "cartaz") !== false) {
				echo "<label for='name'>Cor Título/Descrição</label>";
				echo "<input type='text' id='cor1' name='cor1' value=''  maxlength='7' placeholder='ex: #FFFFFF' />";
				echo "<label for='name'>Cor Preço</label>";
				echo "<input type='text' id='cor2' name='cor2' value=''  maxlength='7' placeholder='ex: #FFFFFF' />";
				echo "<label for='name'>Cor Promoção</label>";
				echo "<input type='text' id='cor3' name='cor3' value=''  maxlength='7' placeholder='ex: #FFFFFF' />";
			}
		}
	}
}

function createCampanha($campanha, $idcompanie, $companie){

    $DataBase = new DataBase;
    $conn = $DataBase->connect();

    $sqlCampanha = "SELECT COUNT(idcampanhas) AS campanha FROM campanhas WHERE nome = '{$campanha}' AND fkempresas = '{$idcompanie}'";
    $queryCampanha = $DataBase->query($sqlCampanha);
    $rowCampanha=mysqli_fetch_array($queryCampanha);
    $quantCampanha = $rowCampanha['campanha'];

    if($quantCampanha > 0)
    {
        header('Location: actionCreateCampanha.php?msg=O nome da campanha já existe');
        exit(1);
    }
	//Insere a campanha no banco de dados
	$campanha = strtolower ($campanha);
    $sqlInsertCampanha = "INSERT INTO campanhas (fkempresas, nome) VALUES ($idcompanie, '{$campanha}')";
    $DataBase->query($sqlInsertCampanha);
	$fkcampanha = $conn->insert_id;
	

	//Cria a pasta campanha
	$pathCampanha = utf8_encode('../companies/'.$companie.'/campaigns'.'/'.$campanha.'/');
	if (!is_dir($pathCampanha)) 
	{
		mkdir($pathCampanha, 0755, true);
	}
	//Cria a pasta files  
	$pathFiles = utf8_encode('../companies/'.$companie.'/campaigns'.'/'.$campanha.'/'.'files/');
	if (!is_dir($pathFiles)) 
	{
		mkdir($pathFiles, 0755, true);
	} 

    return $fkcampanha;
}

function checkDimensions($file, $idcompanie, $companie, $fkcampanha, $campanha, $layout ,$operation='0'){
	//$opetation 0=insert/1=alteração

	$pathCampanha = utf8_encode('../companies/'.$companie.'/campaigns'.'/'.$campanha.'/'); 
	$pathFiles = utf8_encode('../companies/'.$companie.'/campaigns'.'/'.$campanha.'/'.'files/');

	$DataBase = new DataBase;
	$DataBase->connect();
		$sqlSizesLayouts = "SELECT nome, largura, altura FROM layouts WHERE (fkempresas = '$idcompanie' AND status_campanha = 1) OR (fkempresas IS NULL AND status_campanha = 1) 
		GROUP BY idlayouts";
		$querySizesLayouts = $DataBase->query($sqlSizesLayouts);
		$querySizes = $DataBase->query($sqlSizesLayouts); 

		while($rowSizesLayouts=mysqli_fetch_array($querySizesLayouts)){
			if($rowSizesLayouts['nome'] == $layout ){
					$larguraSizesLayouts = $rowSizesLayouts['largura'];
					$alturaSizesLayouts = $rowSizesLayouts['altura'];

					list($width, $height) = getimagesize($file);

					if($width != $larguraSizesLayouts || ($alturaSizesLayouts < $height && $height > $alturaSizesLayouts) ){
						while($rowSizes=mysqli_fetch_array($querySizes)){

							if($operation=='0'){
								if (is_dir($pathCampanha.$rowSizes['nome'])) 
								{
									clearImages($pathCampanha.$rowSizes['nome'].'/', 'png', '1');       
									rmdir($pathCampanha.$rowSizes['nome'].'/'); 
								}
							}
							header('Location: actionCreateCampanha.php?msg=Algum cartaz não tem '.$larguraSizesLayouts.'x'.$alturaSizesLayouts.'px');
						}
						if($operation=='0'){
							clearImages($pathFiles, 'png', '1');
							rmdir($pathFiles);
							rmdir($pathCampanha);

							$sqlDeleteTemas = "DELETE FROM temas WHERE fkcampanhas =  $fkcampanha ";
							$DataBase->query($sqlDeleteTemas);
							$sqlDeleteCampanhas = "DELETE FROM campanhas WHERE idcampanhas =  $fkcampanha ";
							$DataBase->query($sqlDeleteCampanhas);
						}
						exit(1);
					}
			}
		}
	}

function insertFiles($files, $post, $idcompanie, $companie, $fkcampanha, $campanha, $operation='0' ){
	//$opetation 0=insert/1=alteração
    $DataBase = new DataBase;
    $DataBase->connect();
    foreach($files as $nome_campo => $valor){
        $path = "../companies/{$companie}/campaigns/{$campanha}/{$nome_campo}/";
        $layout = $nome_campo;
         if (!is_dir($path)) 
        {
            mkdir($path, 0755, true);
        } 
        $total = count($valor['name']);
        for ($i = 0; $i < $total; $i++)
        {  
            $new_name = uniqid(rand(), true).'.png';
			$Dirfile = $path.$new_name;
			if($operation==0){
				
				
				
				if (strpos($nome_campo, "cartaz") !== false) {
					$sqlInsert = "INSERT INTO temas (fklayouts, fkcampanhas, tipo, nome_arquivo, cor1, cor2, cor3) 
					VALUES ('{$post[$nome_campo]}', $fkcampanha, '$layout', '$new_name','{$post['cor1']}','{$post['cor2']}','{$post['cor3']}')";
					$DataBase->query($sqlInsert); 
				}else{
					$sqlInsert = "INSERT INTO temas (fklayouts, fkcampanhas, tipo, nome_arquivo) VALUES ('{$post[$nome_campo]}', $fkcampanha, '$nome_campo', '$new_name')"; 
					$DataBase->query($sqlInsert); 
				}
			}else{
				$sqlInsert = "INSERT INTO temas (fklayouts, fkcampanhas, tipo, nome_arquivo) VALUES ('{$post[$nome_campo]}', $fkcampanha, '$nome_campo', '$new_name')"; 
				$DataBase->query($sqlInsert); 
			}
            
            if (!move_uploaded_file($valor['tmp_name'][$i], $Dirfile))
            {
                echo "Erro ao enviar o arquivo: ".$valor['name'][$i];
            }
	/*---------------------------------------------------------------------------------------------------------------*/
		if($operation=='1'){
			checkDimensions($Dirfile, $idcompanie, $companie, $fkcampanha, $campanha, $layout, '1');
		}else{
			checkDimensions($Dirfile, $idcompanie, $companie, $fkcampanha, $campanha, $layout);
		}
    /*---------------------------------------------------------------------------------------------------------------*/
    
        }
    
    }

}


?>