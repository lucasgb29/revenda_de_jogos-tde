
<?php
require_once "../PHP/verificar_admin.php"; // Verifica se está na sessão de administrador
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="cabecalho">
        <div class="logo">
            Game<span class="logo-destaque">Store</span>
        </div>

        <nav class="area-login">
            <a href="gerenciar.php" class="botao-login">
                Voltar ao painel
            </a>

            <a href="../PHP/logout.php" class="botao-cadastro">
                Sair
            </a>
        </nav>
    </header>

    <main>

        <section class="secao-cadastro">

            <div class="card-cadastro">

                <h1 class="titulo-secao">Gerenciar Categorias</h1>

                <p class="descricao-cadastro">
                    Cadastre, edite e organize as categorias dos jogos da loja.
                </p>

                <hr>

                <h2 id="titulo-formulario">Cadastrar categoria</h2>

                <form id="form-categoria">

                    <input type="hidden" id="id">

                    <div class="grupo-campo">
                        <label for="nome">Nome:</label>
                        <input
                            type="text"
                            id="nome"
                            maxlength="60"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="descricao">Descrição:</label>
                        <textarea
                            id="descricao"
                            maxlength="255"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="botao-cadastrar-conta"
                    >
                        Salvar categoria
                    </button>

                    <button
                        type="button"
                        id="cancelar"
                        class="botao-voltar"
                    >
                        Cancelar edição
                    </button>

                </form>

                <p id="mensagem"></p>

                <hr>

                <h2 class="titulo-secao">Categorias cadastradas</h2>

                <div id="lista-categorias">
                    Carregando categorias...
                </div>

            </div>

        </section>

    </main>

    <footer class="rodape">
        <p class="texto-rodape">
            GameStore - Todos os direitos reservados.
        </p>
    </footer>

    <script src="../JS/gerenciar_categorias.js" defer></script>

</body>
</html>
