
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>GameStore - Detalhes do Jogo</title>

    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    require_once "../PHP/proteger.php";
    ?>

    <header class="cabecalho">

        <h1 class="logo">
            Game<span class="logo-destaque">Store</span>
        </h1>

        <div class="area-login">
            <a href="index.html" class="botao-login">Início</a>
            <a href="login.html" class="botao-cadastro">Entrar</a>
        </div>

    </header>

    <main>

        <section class="secao-detalhes">

            <h2 class="titulo-secao">Detalhes do jogo</h2>

            <div class="card-detalhes">

                <div class="area-imagem-detalhes">

                    <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQydwnDp4Akcny34BxZhQPgSruB_AH7L0NW6VVI9HkQ-Q&s=10"
                        alt="Imagem do GTA V"
                        class="imagem-detalhes"
                    />

                </div>

                <div class="informacoes-jogo">

                    <h1 class="nome-detalhes">GTA V</h1>

                    <p class="descricao-detalhes">
                        Explore o mundo aberto de Los Santos, participe
                        de missões, dirija diversos veículos e viva
                        aventuras em um dos jogos mais populares do mundo.
                    </p>

                    <p class="preco-detalhes">
                        R$ 79,90
                    </p>

                    <div class="informacao-item">
                        <strong>Vendedor:</strong>
                        <span>GameStore Oficial</span>
                    </div>

                    <div class="informacao-item">
                        <strong>Contato:</strong>
                        <span>contato@gamestore.com</span>
                    </div>

                    <div class="informacao-item">
                        <strong>Telefone:</strong>
                        <span>(00) 12345-6789</span>
                    </div>

                    <div class="informacao-item">
                        <strong>Disponibilidade:</strong>
                        <span class="disponivel">6 unidades em estoque</span>
                    </div>

                    <div class="area-compra">

                        <button
                            type="button"
                            class="botao-efetuar-compra"
                        >
                            Efetuar compra
                        </button>

                        <a href="index.html" class="botao-voltar">
                            Voltar para a loja
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <footer class="rodape">

        <p class="texto-rodape">
            &copy; 2026 GameStore - Todos os direitos reservados.
        </p>

    </footer>

</body>

</html>
