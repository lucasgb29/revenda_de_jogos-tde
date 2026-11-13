<?php

header("Content-Type: application/json; charset=UTF-8");

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do jogo inválido."
    ]);

    exit();
}

try {

    require_once __DIR__ . "/../conexao.php";

    $sql = "SELECT
                j.id,
                j.nome,
                j.descricao,
                j.preco,
                j.genero,
                j.imagem,
                j.estoque,
                j.criado_por,
                u.nome AS nome_publicador
            FROM jogos j
            LEFT JOIN usuarios u ON j.criado_por = u.id
            WHERE j.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ":id" => $id
    ]);

    $jogo = $consulta->fetch();

    if (!$jogo) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Jogo não encontrado."
        ]);

        exit();
    }

    echo json_encode([
        "sucesso" => true,
        "dados" => $jogo
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar o jogo."
    ]);

}

?>