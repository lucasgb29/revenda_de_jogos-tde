
<?php
session_start();

require_once "conexao.php";

if (!isset($_SESSION['utilizador'])) {
    header("Location: ../FRONTEND/login.html");
    exit();
}

$sql = "SELECT perfil FROM usuarios WHERE usuario = :usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':usuario' => $_SESSION['utilizador']
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || $usuario['perfil'] !== 'admin') {
    http_response_code(403);
    exit("Acesso negado. Apenas administradores podem acessar esta página.");
}
