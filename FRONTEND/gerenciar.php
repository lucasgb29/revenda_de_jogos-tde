
<?php

require_once "../PHP/verificar_login.php";
require_once "../PHP/conexao.php";

$consulta = $pdo->prepare(
    "SELECT perfil FROM usuarios WHERE usuario = :usuario"
);

$consulta->execute([
    ":usuario" => $_SESSION['utilizador']
]);

$dadosUsuario = $consulta->fetch();

if (!$dadosUsuario) {
    header("Location: ../PHP/logout.php");
    exit();
}

$_SESSION['perfil'] = $dadosUsuario['perfil'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GameStore - Gerenciamento</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="cabecalho">

        <div class="logo">
            Game<span class="logo-destaque">Store</span>
        </div>

        <nav class="area-login">
            <a href="index.php" class="botao-login">
                Voltar para a loja
            </a>

            <a href="../PHP/logout.php" class="botao-cadastro">
                Sair
            </a>
        </nav>

    </header>

    <main class="painel-gerenciamento">

        <section class="secao-painel">

            <div class="cabecalho-painel">
                <h1 class="titulo-painel">
                    Painel de Gerenciamento
                </h1>

                <div class="boas-vindas">
                    <p>
                        Bem-vindo,
                        <strong>
                            <?= htmlspecialchars($_SESSION['utilizador'], ENT_QUOTES, 'UTF-8') ?>
                        </strong>!
                    </p>
                    <span>Gerencie sua loja GameStore por aqui.</span>
                </div>
            </div>

            <section class="grupo-gerenciamento">

                <h2 class="titulo-grupo">
                    <span class="indicador-titulo"></span>
                    Gerenciamento de jogos
                </h2>

                <div class="opcoes-gerenciamento">

                    <a href="cadastrar_jogo.php" class="card-gerenciamento card-jogos">
                        <span class="icone-gerenciamento">+</span>
                        <span class="texto-card">
                            <strong>Cadastrar novo jogo</strong>
                            <small>Adicione um novo jogo à loja.</small>
                        </span>
                        <span class="seta-card">›</span>
                    </a>

                    <a href="meus_jogos.php" class="card-gerenciamento card-publicacoes">
                        <span class="icone-gerenciamento">▤</span>
                        <span class="texto-card">
                            <strong>Minhas publicações</strong>
                            <small>Consulte e edite seus jogos publicados.</small>
                        </span>
                        <span class="seta-card">›</span>
                    </a>

                </div>

            </section>

            <?php if ($_SESSION['perfil'] === 'admin'): ?>

                <section class="grupo-gerenciamento">

                    <h2 class="titulo-grupo">
                        <span class="indicador-titulo indicador-admin"></span>
                        Administração
                    </h2>

                    <div class="opcoes-gerenciamento">

                        <a href="gerenciar_usuarios.php" class="card-gerenciamento card-usuarios">
                            <span class="icone-gerenciamento">♙</span>
                            <span class="texto-card">
                                <strong>Gerenciar usuários</strong>
                                <small>Cadastre, edite e administre usuários.</small>
                            </span>
                            <span class="seta-card">›</span>
                        </a>

                        <a href="gerenciar_categorias.php" class="card-gerenciamento card-categorias">
                            <span class="icone-gerenciamento">▦</span>
                            <span class="texto-card">
                                <strong>Gerenciar categorias</strong>
                                <small>Organize as categorias dos jogos.</small>
                            </span>
                            <span class="seta-card">›</span>
                        </a>

                    </div>

                </section>

            <?php endif; ?>

            <section class="navegacao-painel">

                <h2 class="titulo-grupo">
                    Navegação
                </h2>

                <div class="botoes-navegacao">

                    <a href="index.php" class="botao-loja">
                        Voltar para a loja
                    </a>

                    <a href="../PHP/logout.php" class="botao-sair-painel">
                        Sair da conta
                    </a>

                </div>

            </section>

        </section>

    </main>

    <footer class="rodape">
        <p class="texto-rodape">
            GameStore - Todos os direitos reservados.
        </p>
    </footer>

</body>
</html>
