
<?php
require_once "../PHP/verificar_login.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="cabecalho">
        <div class="logo">
            Game<span class="logo-destaque">Store</span>
        </div>

        <nav class="area-login">
            <a href="meus_jogos.php" class="botao-login">
                Voltar para minhas publicações
            </a>

            <a href="../PHP/logout.php" class="botao-cadastro">
                Sair
            </a>
        </nav>
    </header>

    <main>
        <section class="secao-cadastro">

            <div class="card-cadastro">

                <h1 class="titulo-secao">Editar publicação</h1>

                <p class="descricao-cadastro">
                    Atualize as informações do seu jogo.
                </p>

                <form id="form-editar-jogo">

                    <div class="grupo-campo">
                        <label for="nome">Nome:</label>
                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="descricao">Descrição:</label>
                        <textarea
                            id="descricao"
                            name="descricao"
                            required
                        ></textarea>
                    </div>

                    <div class="grupo-campo">
                        <label for="preco">Preço:</label>
                        <input
                            type="number"
                            id="preco"
                            name="preco"
                            min="0"
                            step="0.01"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="genero">Gênero:</label>
                        <select id="genero" name="genero" required>
                            <option value="">Selecione um gênero</option>
                            <option value="Ação">Ação</option>
                            <option value="Aventura">Aventura</option>
                            <option value="RPG">RPG</option>
                            <option value="Esporte">Esporte</option>
                            <option value="Corrida">Corrida</option>
                            <option value="Estratégia">Estratégia</option>
                            <option value="Corrida">Corrida</option>
                            <option value="Terror">Terror</option>
                            <option value="Simulação">Simulação</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <div class="grupo-campo">
                        <label for="imagem">URL da imagem:</label>
                        <input
                            type="url"
                            id="imagem"
                            name="imagem"
                            maxlength="500"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="estoque">Estoque:</label>
                        <input
                            type="number"
                            id="estoque"
                            name="estoque"
                            min="0"
                            step="1"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="botao-cadastrar-conta"
                    >
                        Salvar alterações
                    </button>

                </form>

                <p id="mensagem"></p>

            </div>

        </section>
    </main>

    <footer class="rodape">
        <p class="texto-rodape">
            GameStore - Todos os direitos reservados.
        </p>
    </footer>

    <script src="../JS/editar_jogo.js" defer></script>

</body>
</html>
