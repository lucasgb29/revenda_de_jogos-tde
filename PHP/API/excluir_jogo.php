
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

function responder($status, $dados) {
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit();
}

// Autenticado
if (!isset($_SESSION['utilizador'])) {
    responder(401, [
        "sucesso" => false,
        "mensagem" => "Você precisa estar conectado."
    ]);
}

// same dos outros
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    responder(405, [
        "sucesso" => false,
        "mensagem" => "Método não permitido."
    ]);
}

// receber o id do JASON
$dados = json_decode(file_get_contents("php://input"), true);

$id = filter_var(
    $dados['id'] ?? null,
    FILTER_VALIDATE_INT
);

if (!$id || $id < 1) {
    responder(400, [
        "sucesso" => false,
        "mensagem" => "ID do jogo inválido."
    ]);
}

try {

    require_once __DIR__ . "/../conexao.php";

    // ver quem ta conectado
    $sqlUsuario = "SELECT id FROM usuarios
                   WHERE usuario = :usuario";

    $consultaUsuario = $pdo->prepare($sqlUsuario);

    $consultaUsuario->execute([
        ":usuario" => $_SESSION['utilizador']
    ]);

    $usuario = $consultaUsuario->fetch();

    if (!$usuario) {
        responder(401, [
            "sucesso" => false,
            "mensagem" => "Usuário não encontrado."
        ]);
    }

    // ve se o cara é dono do jogo
    $sql = "DELETE FROM jogos
            WHERE id = :id
            AND criado_por = :usuario_id";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ":id" => $id,
        ":usuario_id" => $usuario['id']
    ]);

    if ($consulta->rowCount() === 0) {
        responder(403, [
            "sucesso" => false,
            "mensagem" => "Você não pode excluir esta publicação."
        ]);
    }

    responder(200, [
        "sucesso" => true,
        "mensagem" => "Jogo excluído com sucesso!"
    ]);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    responder(500, [
        "sucesso" => false,
        "mensagem" => "Erro ao excluir o jogo."
    ]);
}

?>
