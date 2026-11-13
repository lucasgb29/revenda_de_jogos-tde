
<?php
require_once "../PHP/verificar_login.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Jogos</title>

    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <header class="cabecalho">

        <h1 class="logo">
            Game<span class="logo-destaque">Store</span>
        </h1>

        <div class="area-login">

            <a href="index.php" class="botao-login">
                Voltar para a loja
            </a>

            <a href="../PHP/logout.php" class="botao-cadastro">
                Sair
            </a>

        </div>

    </header>

    <main class="secao-cadastro">

        <section class="card-cadastro">

            <h1 class="titulo-secao">
                Cadastro de Jogos
            </h1>

            <p class="descricao-cadastro">
                Preencha os campos abaixo para cadastrar um novo jogo
                na sua loja.
            </p>

            <form id="form-cadastro-jogo">

                <div class="grupo-campo">

                    <label for="nome">
                        Nome do jogo:
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        maxlength="150"
                        placeholder="Digite o nome do jogo"
                        required
                    >

                </div>

                <div class="grupo-campo">

                    <label for="descricao">
                        Descrição:
                    </label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        placeholder="Digite a descrição do jogo"
                        required
                    ></textarea>

                </div>

                <div class="grupo-campo">

                    <label for="preco">
                        Preço:
                    </label>

                    <input
                        type="number"
                        id="preco"
                        name="preco"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                    >

                </div>

                <div class="grupo-campo">

                    <label for="genero">
                        Gênero:
                    </label>

                    <select
                        id="genero"
                        name="genero"
                        class="seletor-genero"
                        required
                    >

                        <option value="">
                            Selecione o gênero
                        </option>

                        <option value="Ação">
                            Ação
                        </option>

                        <option value="Aventura">
                            Aventura
                        </option>

                        <option value="RPG">
                            RPG
                        </option>

                        <option value="Simulação">
                            Simulação
                        </option>

                        <option value="Esporte">
                            Esporte
                        </option>

                        <option value="Estratégia">
                            Estratégia
                        </option>

                        <option value="Corrida">
                            Corrida
                        </option>

                        <option value="Terror">
                            Terror
                        </option>

                        <option value="Outro">
                            Outro
                        </option>

                    </select>

                </div>

                <div class="grupo-campo">

                    <label for="imagem">
                        URL da imagem:
                    </label>

                    <input
                        type="url"
                        id="imagem"
                        name="imagem"
                        maxlength="500"
                        placeholder="https://..."
                        required
                    >

                </div>

                <div class="grupo-campo">

                    <label for="estoque">
                        Estoque:
                    </label>

                    <input
                        type="number"
                        id="estoque"
                        name="estoque"
                        min="0"
                        step="1"
                        placeholder="Quantidade disponível"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="botao-cadastrar-conta"
                >
                    Cadastrar jogo
                </button>

            </form>

            <p id="mensagem"></p>

        </section>

    </main>

    <footer class="rodape">

        <p class="texto-rodape">
            &copy; 2026 GameStore - Todos os direitos reservados.
        </p>

    </footer>

</body>

</html>
