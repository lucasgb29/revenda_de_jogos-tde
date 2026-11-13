
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

function responder($status, $dados) {
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit();
}

if (!isset($_SESSION['utilizador'])) {
    responder(401, [
        "sucesso" => false,
        "mensagem" => "Você precisa estar conectado."
    ]);
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    responder(405, [
        "sucesso" => false,
        "mensagem" => "Método não permitido."
    ]);
}

try {

    require_once __DIR__ . "/../conexao.php";

    // Identifica o usuário conectado
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

    // Busca somente os jogos publicados por ele
    $sql = "SELECT id, nome, descricao, preco,
                   genero, imagem, estoque, data_cadastro
            FROM jogos
            WHERE criado_por = :usuario_id
            ORDER BY id DESC";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ":usuario_id" => $usuario['id']
    ]);

    $jogos = $consulta->fetchAll();

    responder(200, [
        "sucesso" => true,
        "dados" => $jogos
    ]);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    responder(500, [
        "sucesso" => false,
        "mensagem" => "Erro ao consultar suas publicações."
    ]);
}

?>
