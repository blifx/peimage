<?php

if(!empty($_POST)){
    $nome = $_POST['nome'];
    $cor = $_POST['cor'];
    $cor_texto = $_POST['cor_texto'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];


    if($_FILES['arquivo']['size'] != 0)
    {
        if(!file_exists('../companies/'.$nome)){
            mkdir('../companies/'.$nome, 0755, true);
            mkdir('../companies/'.$nome.'/downloads', 0755, true);
            mkdir('../companies/'.$nome.'/uploads', 0755, true);
        }

    $arquivos = $_FILES['arquivo'];
    move_uploaded_file($arquivos['tmp_name'],'../companies/'.$nome.'/uploads/logo.png');

    // Carrega a imagem a ser manipulada
    $image = WideImage::load('../companies/'.$nome.'/uploads/logo.png');
    // Redimensiona a imagem
    $image_b = $image->resize(246,112);
    $image_p = $image->resize(530,115);
    $image = $image->resize(530,115);

    // Salva a imagem em um arquivo (novo ou não)
    $image_p->saveToFile('../companies/'.$nome.'/logo_pequeno.png');
    $image_b->saveToFile('../companies/'.$nome.'/logo_branco.png');
    $image->saveToFile('../companies/'.$nome.'/logo.png');
    }

}
?>


