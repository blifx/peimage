<form id="form-layout">

    <label>Tema*</label>
    <select id="tema" name="tema" required="required">
        <?php
            foreach($themes as $key => $rowTheme){
                echo '<option uid="'.$rowTheme["idtemas"].'" status_teste="'.$rowTheme["status_teste"].'" value="'.$rowTheme["nome_arquivo"].'">Tema '.($key+1).'</option>';
            }
        ?>
    </select>

    <!-- TODO automatizar tamanho de acordo com layout -->
    <div id="content-img-theme">
        <img id="img-theme" src="" style="max-width:135px" />
    </div>

    <label>Modelo</label>
    <select id="model-layout"></select>

    <label>Margem superior da imagem</label>
    <input type="range" id="f-height-img" value="0" min="0" max="50">

    <!-- TODO
    <label>Imagem fundo desconto</label>
    <label for="selecao-arquivo" id="file-name">Carregar imagem</label>
    <div>
        <input id="selecao-arquivo" type='file' onchange="previewFile()">
        <div id="ctrl-img">
            <span>&#10005</span>
            <img src="<?=$__HTTP_HOST;?>/images/upload.png">
        </div>
    </div>
    -->

    <label>Cor fundo desconto</label>
    <input type="text" id="f-desc-color" placeholder="Entre com a cor em hexadecimal" maxlength="7" />

    <label>Cor fonte desconto</label>
    <input type="text" id="f-desc-font-color" placeholder="Entre com a cor em hexadecimal" maxlength="7" />

    <label>Cor título/descrição</label>
    <input type="text" id="f-title-color" placeholder="Entre com a cor em hexadecimal" required="required" maxlength="7" />

    <label>Cor preço normal</label>
    <input type="text" id="f-price1-color" placeholder="Entre com a cor em hexadecimal" maxlength="7" />

    <label>Cor tachado</label>
    <input type="text" id="f-strikethrough-color" placeholder="Entre com a cor em hexadecimal" maxlength="7" /> 

    <label>Cor borda preço normal</label>
    <input type="text" id="f-price1-color-border" placeholder="Entre com a cor em hexadecimal" maxlength="7" /> 

    <label>Cor preço promocional</label>
    <input type="text" id="f-price2-color" placeholder="Entre com a cor em hexadecimal" maxlength="7" /> 

</form>