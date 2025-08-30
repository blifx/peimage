<form id="form-layout">

    <fieldset>
        <legend>Geral</legend>

        <label>Tema*</label>
        <select id="tema" name="tema" required="required">
            <?php
                foreach($themes as $key => $rowTheme){
                    echo '<option uid="'.$rowTheme["idtemas"].'" status_teste="'.$rowTheme["status_teste"].'" value="'.$rowTheme["nome_arquivo"].'">Tema '.($key+1).'</option>';
                }
            ?>
        </select>

        <label class="required">Tipo de material</label>
        <select id="mode" required="required">
            <option readonly disabled selected value="">Selecione uma opção</option>
            <option value="digital">Digital</option>
            <option value="print">Impresso</option>
        </select>

        <label class="required">Título do convite</label>
        <input type="text" id="title-invite" required="required" placeholder="Digite o título do convite" maxlength="13">

        <label class="required">Título do tema</label>
        <input type="text" id="title-theme" placeholder="Digite o título do tema" maxlength="45" />

        <label class="required">Subtítulo do tema</label>
        <input type="text" id="subtitle-theme" placeholder="Digite o subtítulo do tema" maxlength="45" />
    </fieldset>

    <fieldset>
        <legend>Data/hora</legend>
        <label class="required">Data do convite</label>
        <input type="date" id="date" placeholder="Digite a data do convite" maxlength="" />

        <label class="required">Hora de início</label>
        <input type="time" id="time-start" placeholder="Digite a data do convite" maxlength="" />

        <label>Hora de encerramento</label>
        <input type="time" id="time-end" placeholder="Digite a data do convite" maxlength="" />
    </fieldset>

    <fieldset>
        <legend>Endereço</legend>
        <label class="required">Local</label>
        <input type="text" id="local" placeholder="Digite o local" maxlength="32" />

        <label class="required">Rua</label>
        <input type="text" id="street" placeholder="Digite o nome da rua" maxlength="32" />

        <label class="required">Número</label>
        <input type="text" id="number-address" placeholder="Digite o número do endereço" maxlength="4" />

        <label>Complemento</label>
        <input type="text" id="address-complement" placeholder="Digite o complemento (opcional)" maxlength="10" />

        <label class="required">Bairro</label>
        <input type="text" id="neighborhood" placeholder="Digite o bairro do local" maxlength="32" />

        <label class="required">Cidade</label>
        <input type="text" id="city" placeholder="Digite a cidade do local" maxlength="27" />

        <label class="required">Estado</label>
        <select id="state">
            <option value="" selected readonly disabled>Selecione um estado</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>

        <label class="required">
            <a href="https://www.google.com/maps" title="Procurar local" target="_blank">Link do ícone endereço</a>
        </label>
        <input type="text" id="link-address" placeholder="Copie e cole o link do endereço" maxlength="500" />

    </fieldset>

    <fieldset>
        <legend class="required">Descrição do convite</legend>
        <textarea id="description-invite" placeholder="Digite a descrição do convite" rows="10" cols="13" maxlength="670"></textarea>

        <label class="required">Alinhamento</label>
        <select id="align" required="required">
            <option value="justify">Justificado</option>
            <option value="center">Centralizado</option>
            <option value="left">À esquerda</option>
        </select>
    </fieldset>
 
    <?php

        if(!empty($_SESSION["fb_nome_pagina"])){
            echo "
                <label>Mensagem do Facebook</label>
                <textarea id='f-post-fb' placeholder='Página: {$_SESSION["fb_nome_pagina"]}\nLinha do tempo' maxlength='1024'></textarea>
            ";
        }

    ?>

</form>