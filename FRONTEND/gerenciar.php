
<?php

require_once "../PHP/verificar_login.php";// verificar se ta na sessao
require_once "../PHP/conexao.php"; 



$consulta = $pdo->prepare(
    "SELECT perfil FROM usuarios WHERE usuario = :usuario" // busca o perfil do usuario
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
</head>

<body>

    <h1>Painel de Gerenciamento</h1>

    <p>
        Bem-vindo,
        <?= htmlspecialchars($_SESSION['utilizador'], ENT_QUOTES, 'UTF-8') ?>!
    </p>

    <hr>

    <h2>Gerenciamento de jogos</h2>

    <p>
        <a href="cadastrar_jogo.php">
            Cadastrar novo jogo
        </a>
    </p>

    <p>
        <a href="meus_jogos.php">
            Minhas publicações
        </a>
    </p>

    <?php if ($_SESSION['perfil'] === 'admin'): ?>

        <hr>

        <h2>Administração</h2>

        <p>
            <a href="gerenciar_usuarios.php">
                Gerenciar usuários
            </a>
        </p>

        <p>
            <a href="gerenciar_categorias.php">
                Gerenciar categorias
            </a>
        </p>

    <?php endif; ?>

    <hr>

    <h2>Navegação</h2>

    <p>
        <a href="index.php">Voltar para a loja</a>
    </p>

    <p>
        <a href="../PHP/logout.php">Sair da conta</a>
    </p>

</body>
</html>
