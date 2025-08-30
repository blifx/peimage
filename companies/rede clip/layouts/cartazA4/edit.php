<form id="form-layout">

    <label>Tema*</label>
    <select id="tema" name="tema" required="required">
        <?php
            foreach($themes as $key => $rowTheme){
                echo '<option uid="'.$rowTheme["idtemas"].'" status_teste="'.$rowTheme["status_teste"].'" value="'.$rowTheme["nome_arquivo"].'">Tema '.($key+1).'</option>';
            }
        ?>
    </select>

    <label>Imagem do produto</label>
    <label for="selecao-arquivo" id="file-name">Carregar imagem</label>
    <div>
        <input id="selecao-arquivo" type='file' accept='image/*' onchange="previewFile()">
        <div id="ctrl-img">
            <span>&#10005</span>
            <img src="<?=$__HTTP_HOST;?>/images/upload.png">
        </div>
    </div>

    <label>Título*</label>
    <input type="text" id="f-title-img" placeholder="Digite o título do produto" required="required" maxlength="42"/>

    <label>Descrição</label>
    <input type="text" id="f-descr-img" placeholder="Digite a descrição do produto" maxlength="54" />

    <label>Preço normal*</label>
    <input type="text" id="f-price1" placeholder="Digite o preço normal" maxlength="7" />

    <label>Preço promocional</label>
    <input type="text" id="f-price2" placeholder="Digite o preço promocional" maxlength="7" /> 

    <label>Precificação</label>
    <input type="text" id="f-precif" placeholder="Digite a precificação do produto" maxlength="5" /> 

    <label>Observação</label>
    <textarea id="f-obs-img" placeholder="Digite uma observação" maxlength="65"></textarea>

    <?php

        if(!empty($_SESSION["fb_nome_pagina"])){
            echo "
                <label>Mensagem do Facebook</label>
                <textarea id='f-post-fb' placeholder='Página: {$_SESSION["fb_nome_pagina"]}\nLinha do tempo' maxlength='1024'></textarea>
            ";
        }

    ?>

</form>