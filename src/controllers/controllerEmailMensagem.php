<?php

if(!empty($_POST)){
    //alterar a variavel abaixo colocando o seu email
    $destinatario = "contato@peimage.com";
    $nome = acentoUpload($_POST['nome']);
    $email = $_POST['email'];
    $mensagem = acentoUpload($_POST['mensagem']);
    $assunto = acentoUpload($_POST['assunto']);

    // monta o e-mail na variavel $body
    $body = "<!DOCTYPE html>
    <html>
    <head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #444;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-top: 0;
        }
        .info {
            margin-bottom: 12px;
            line-height: 1.6;
        }
        .info span {
            font-weight: bold;
        }
    </style>
    </head>
    <body>
    
    <div class='container'>
        <h2>Formulario de Contato</h2>
        <p class='info'><span>Nome:</span> {$nome}</p>
        <p class='info'><span>Email:</span> {$email}</p>
        <p class='info'><span>Mensagem:</span> {$mensagem}</p>
    </div>
    
    </body>
    </html>";
// Exemplo de uso
    // Envia o e-mail
    echo $envio = enviaEmail($nome, $destinatario, $assunto, $body, $assunto);


}



?>

