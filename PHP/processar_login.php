
<?php

session_start();

// req ==== POSTTTT
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../FRONTEND/login.php");
    exit();
}

// dados formulario
$usuarioInformado = trim($_POST['usuario'] ?? '');
$senhaInformada = $_POST['senha'] ?? '';

if ($usuarioInformado === '' || $senhaInformada === '') {
    header("Location: ../FRONTEND/login.php?erro=campos");
    exit();
}

try {

    // BANCO coneect
    require_once __DIR__ . "/conexao.php";

    // search usurio no banco
    $sql = "SELECT id, usuario, senha
            FROM usuarios
            WHERE usuario = :usuario
            LIMIT 1";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ':usuario' => $usuarioInformado
    ]);

    $usuarioBanco = $consulta->fetch();

    // aqui eu confiro se ele existe e se a senha ta certa
    if (
        $usuarioBanco &&
        password_verify($senhaInformada, $usuarioBanco['senha'])
    ) {

        // Renova o identificador da sessão
        session_regenerate_id(true);

        // Guarda os dados na sessão
        $_SESSION['utilizador'] = $usuarioBanco['usuario'];
        $_SESSION['usuario_id'] = (int) $usuarioBanco['id'];

        header("Location: ../FRONTEND/index.php");
        exit();

    } else {

        header("Location: ../FRONTEND/login.php?erro=credenciais");
        exit();

    }

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    header("Location: ../FRONTEND/login.php?erro=servidor");
    exit();

}

?>
