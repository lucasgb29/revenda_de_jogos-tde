
<?php
require_once "../PHP/verificar_admin.php"; // Verifica se está na sessão de administrador
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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

                <h1 class="titulo-secao">Gerenciar Usuários</h1>

                <p class="descricao-cadastro">
                    Cadastre, edite e gerencie os usuários da GameStore.
                </p>

                <hr>

                <h2 id="titulo-formulario">Cadastrar usuário</h2>

                <form id="form-usuario">

                    <input type="hidden" id="id">

                    <div class="grupo-campo">
                        <label for="nome">Nome:</label>
                        <input
                            type="text"
                            id="nome"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="usuario">Usuário:</label>
                        <input
                            type="text"
                            id="usuario"
                            maxlength="50"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="email">E-mail:</label>
                        <input
                            type="email"
                            id="email"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="telefone">Telefone:</label>
                        <input
                            type="text"
                            id="telefone"
                            maxlength="20"
                            required
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="senha">
                            Senha (vazia mantém a atual):
                        </label>
                        <input
                            type="password"
                            id="senha"
                        >
                    </div>

                    <div class="grupo-campo">
                        <label for="perfil">Perfil:</label>
                        <select id="perfil">
                            <option value="usuario">Usuário</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <div class="area-botoes-formulario">

                        <button
                            type="submit"
                            class="botao-salvar"
                        >
                            Salvar
                        </button>

                        <button
                            type="button"
                            id="cancelar"
                            class="botao-cancelar"
                        >
                            Cancelar edição
                        </button>

                    </div>

                </form>

                <p id="mensagem"></p>

                <hr>

                <h2 class="titulo-secao">Usuários cadastrados</h2>

                <div id="lista-usuarios">
                    Carregando...
                </div>

            </div>

        </section>

    </main>

    <footer class="rodape">
        <p class="texto-rodape">
            GameStore - Todos os direitos reservados.
        </p>
    </footer>

    <script src="../JS/gerenciar_usuarios.js" defer></script>

</body>
</html>
