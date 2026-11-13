
<?php

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../conexao.php";

try {

    $sql = "SELECT * FROM jogos ORDER BY id DESC"; # consulta SQL

    $consulta = $pdo->query($sql);

    $jogos = $consulta->fetchAll();


    echo json_encode([
        "sucesso" => true,
        "dados" => $jogos                                # para dar print nos baguiooo
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} catch (PDOException $erro) {
  
    error_log($erro->getMessage());   # tratamento de erroooo

    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Não foi possível buscar os jogos."
    ]);

}
