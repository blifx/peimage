<!--
<script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/color-picker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>
-->

<form id="form-layout">

    <label>Tema*</label>
    <select id="tema" name="tema" required="required">
        <?php
            foreach($themes as $key => $rowTheme){
                echo '<option uid="'.$rowTheme["idtemas"].'" status_teste="'.$rowTheme["status_teste"].'" value="'.$rowTheme["nome_arquivo"].'">Tema '.($key+1).'</option>';
            }
        ?>
    </select>

    <label>Modelo</label>
    <select id="model-layout"></select>

    <fieldset>
        <legend>Cores do convite</legend>

        <label>Fundo do título convite</label>
        <input type="color" id="type-invite-bgcolor" />

        <label>Título convite</label>
        <input type="color" id="type-invite-color" />

        <label>Tema</label>
        <input type="color" id="title-event-color" />

        <label>Título</label>
        <input type="color" id="title-event-line1-color" />

        <label>Subtítulo</label>
        <input type="color" id="title-event-line2-color" />

        <label>Dia da semana</label>
        <input type="color" id="date-day-week-color" />

        <label>Data e hora</label>
        <input type="color" id="container-date-color" />

        <label>Endereço</label>
        <input type="color" id="container-address-color" />

        <label>Descrição</label>
        <input type="color" id="container-description-evt-color" />

        <label>Mensagem ícone</label>
        <input type="color" id="touch-img-color" />

        <label>Ícones</label>
        <input type="color" id="icons-color" />

        <label>Frase rodapé</label>
        <input type="color" id="join-color" />
    </fieldset>

    <fieldset>
        <legend>Configuração dos ícones</legend>
        <label>Número de telefone</label>
        <input type="text" placeholder="Digite telefone de contato" id="icon-tel-href" />

        <label>E-mail de contato</label>
        <input type="text" placeholder="Digite seu e-mail de contato" id="icon-email-href" />

        <label>
            <a href="https://www.google.com/maps" title="Procurar local" target="_blank">Google Maps</a>
        </label>
        <input type="text" placeholder="Link padrão de localização" id="icon-local-href" />

        <label>Facebook</label>
        <input type="text" placeholder="Link do Facebook" id="icon-face-href" />

        <label>WhatsApp</label>
        <input type="text" placeholder="Número do WhatsApp" id="icon-whatsapp-href" />
    </fieldset>
    
    <br/>

</form>