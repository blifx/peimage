<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
    <title>Atualização Peimage</title>
    <style>
        /* Estilos do Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .text {
            color: #006064;
            text-shadow: 1px 1px 3px #77bde0;
        }

        .modal-content {
            background-color: #77bde0; /* Cor de fundo da classe box-support */
            margin: 15% auto;
            padding: 20px;
            padding-top: 1px;
            width: 80%;
            max-width: 400px;
            position: relative;
            text-shadow: 1px 1px 3px #3c3c3c;
            color: #fff;
            font-size: 17px;
        }

        .close {
            color: white; /* Cor do botão de fechar */
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            position: absolute; /* Posição absoluta em relação ao modal-content */
            top: -10px; /* Posicionamento em relação ao topo */
            right: -10px; /* Posicionamento em relação à direita */
            background-color: #006064; /* Cor de fundo do botão */
            border: none; /* Removendo borda do botão */
            border-radius: 50%; /* Deixando o botão redondo */
            width: 30px; /* Definindo largura */
            height: 30px; /* Definindo altura */
            line-height: 30px; /* Centralizando o texto verticalmente */
            text-align: center; /* Centralizando o texto horizontalmente */
        }

        .close:hover {
            background-color: #00BCD4; /* Mudando a cor de fundo ao passar o mouse */
        }

        .modal-content a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .modal-content a:hover {
            text-decoration: underline;
        }

        .btn-no-show {
            background-color: #006064;
            color: #fff;
            border: 2px solid #77bde0;
            padding: 10px 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 254px;
            font-family: 'Sniglet', cursive;
        }

        .btn-no-show:hover {
            background-color: #00BCD4;
        }
    </style>
</head>
<body>

<!-- Modal HTML -->
<div id="myModal" class="modal-overlay">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <h2>Atualização Peimage</h2>
        <div class="text">
            <p>Temos novidades! Os layouts <b>Post</b> e <b>Storie</b> foram atualizados. Confira agora mesmo!</p>
            <a href="https://app.peimage.com/src/actionCreateLayoutPost.php?campanha=130&layout=post&idlayout=4&nomeLayout=post%20-%20padrao" target="_blank">Acessar Layout de Post</a>
            <a href="https://app.peimage.com/src/actionCreateLayoutStorie.php?campanha=130&layout=storie&idlayout=40&nomeLayout=stories%20-%20padrao" target="_blank">Acessar Layout de Storie</a>
        </div>
        <button id="btnNoShow" class="btn-no-show">Não mostrar mais</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Função para fechar o modal
        function closeModal() {
            $("#myModal").hide();
        }

        // Função para verificar se o modal deve ser exibido
        function shouldShowModal() {
            var noShowCookie = getCookie('modalNoShow');
            return !noShowCookie;
        }

        // Função para obter o valor de um cookie
        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }

        // Fechar o modal quando clicar no botão de fechar
        $("#closeModal").click(function() {
            closeModal();
        });

        // Fechar o modal quando clicar fora da área do modal
        $(window).click(function(event) {
            if (event.target == document.getElementById('myModal')) {
                closeModal();
            }
        });

        // Ocultar o modal permanentemente quando clicar no botão "Não mostrar novamente"
        $("#btnNoShow").click(function() {
            document.cookie = "modalNoShow=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
            closeModal();
        });

        // Mostrar o modal se necessário
        if (shouldShowModal()) {
            $("#myModal").show();
        }
    });
</script>

</body>
</html>
