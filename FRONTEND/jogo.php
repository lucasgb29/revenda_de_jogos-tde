
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GameStore - Detalhes do Jogo</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="cabecalho">

        <h1 class="logo">
            Game<span class="logo-destaque">Store</span>
        </h1>

        <div class="area-login">
            <a href="index.php" class="botao-login">
                Início
            </a>

            <a href="login.html" class="botao-cadastro">
                Entrar
            </a>
        </div>

    </header>

    <main>

        <section class="secao-detalhes">

            <h2 class="titulo-secao">Detalhes do jogo</h2>

            <div class="card-detalhes">

                <div class="area-imagem-detalhes">

                    <img
                        id="imagem-jogo"
                        src=""
                        alt="Imagem do jogo"
                        class="imagem-detalhes"
                    >

                </div>

                <div class="informacoes-jogo">

                    <h1 id="nome-detalhes" class="nome-detalhes">
                        Carregando...
                    </h1>

                    <p id="descricao-detalhes" class="descricao-detalhes">
                    </p>

                    <p id="preco-detalhes" class="preco-detalhes">
                    </p>

                    <div class="informacao-item">
                        <strong>Gênero:</strong>
                        <span id="genero-detalhes"></span>
                    </div>
                    <div class="informacao-item">
                        <strong>Publicado por:</strong>
                        <span id="publicador-detalhes"></span>
                    </div>
                    <div class="informacao-item">
                        <strong>Disponibilidade:</strong>
                        <span id="estoque-detalhes" class="disponivel"></span>
                    </div>

                    <div class="area-compra">

                        <a href="index.php" class="botao-voltar">
                            Voltar para a loja
                        </a>

                    </div>

                    <p id="mensagem"></p>

                </div>

            </div>

        </section>

    </main>

    <footer class="rodape">

        <p class="texto-rodape">
            &copy; 2026 GameStore - Todos os direitos reservados.
        </p>

    </footer>

    <script src="../JS/detalhe_jogo.js" defer></script>
</body>
</html>

