<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
    <title>Modal Peimage</title>
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
            background-color: #77bde0; /* Cor de fundo do botão */
            border: none; /* Removendo borda do botão */
            border-radius: 50%; /* Deixando o botão redondo */
            width: 30px; /* Definindo largura */
            height: 30px; /* Definindo altura */
            line-height: 30px; /* Centralizando o texto verticalmente */
            text-align: center; /* Centralizando o texto horizontalmente */
        }

        .close:hover {
            background-color: #6096ba; /* Mudando a cor de fundo ao passar o mouse */
        }
    </style>
</head>
<body>

<!-- Modal HTML -->
<div id="myModal" class="modal-overlay">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <h2>Atualização Peimage</h2>
        <div class="text"><p>Temos novidade! Os layouts de <b>Post</b> e <b>Storie</b> foram atualizados. Confira agora mesmo!</p></div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Função para fechar o modal
        function closeModal() {
            $("#myModal").hide();
        }

        // Função para verificar se o modal deve ser exibido
        function shouldShowModal() {
            var lastShown = getCookie('modalLastShown');
            if (!lastShown) {
                return true; // Se o cookie não existe, mostrar o modal
            }
            return true;//remover para expirar os cookies
            var threeDaysAgo = new Date();
            threeDaysAgo.setDate(threeDaysAgo.getDate() - 3);

            return new Date(lastShown) <= threeDaysAgo; // Verificar se já passaram 3 dias
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

        // Mostrar o modal se necessário
        if (shouldShowModal()) {
            $("#myModal").show();
            var expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + 3); // Adiciona 3 dias à data atual
            document.cookie = "modalLastShown=true; expires=" + expirationDate.toUTCString() + "; path=/"; // Define o cookie com validade de 3 dias
        }
    });
</script>

</body>
</html>
