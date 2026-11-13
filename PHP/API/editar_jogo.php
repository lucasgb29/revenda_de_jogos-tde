
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

// AUTenticado
if (!isset($_SESSION['utilizador'])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Você precisa estar conectado."
    ]);

    exit();
}

// same dos outros
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido."
    ]);

    exit();
}

// Recebe os dados JSON
$dados = json_decode(file_get_contents("php://input"), true);

if (!is_array($dados)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos."
    ]);

    exit();
}

// Organiza os dados
$id = filter_var($dados['id'] ?? null, FILTER_VALIDATE_INT);
$nome = trim($dados['nome'] ?? '');
$descricao = trim($dados['descricao'] ?? '');
$preco = $dados['preco'] ?? null;
$categoriaId = filter_var(
    $dados['categoria_id'] ?? null,
    FILTER_VALIDATE_INT
);
$imagem = trim($dados['imagem'] ?? '');
$estoque = filter_var(
    $dados['estoque'] ?? null,
    FILTER_VALIDATE_INT
);

// Valida os dados
$precoValido = is_numeric($preco)
    && is_finite((float)$preco)
    && (float)$preco >= 0
    && (float)$preco <= 99999999.99;

$protocolo = parse_url($imagem, PHP_URL_SCHEME);

$imagemValida = filter_var($imagem, FILTER_VALIDATE_URL) !== false
    && in_array(
        strtolower((string)$protocolo),
        ['http', 'https'],
        true
    );

if (
    !$id || $id < 1 ||
    $nome === '' ||
    mb_strlen($nome) > 150 ||
    $descricao === '' ||
    !$precoValido ||
    !$categoriaId || $categoriaId < 1 ||
    !$imagemValida ||
    strlen($imagem) > 500 ||
    $estoque === false ||
    $estoque < 0
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Verifique os dados informados."
    ]);

    exit();
}

try {

    require_once __DIR__ . "/../conexao.php";

    // Confere se o jogo existe
    $consultaJogo = $pdo->prepare(
        "SELECT id FROM jogos WHERE id = :id"
    );

    $consultaJogo->execute([
        ":id" => $id
    ]);

    if (!$consultaJogo->fetch()) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Jogo não encontrado."
        ]);

        exit();
    }

    // Busca a categoria
    $consultaCategoria = $pdo->prepare(
        "SELECT nome FROM categorias WHERE id = :id"
    );

    $consultaCategoria->execute([
        ":id" => $categoriaId
    ]);

    $categoria = $consultaCategoria->fetch();

    if (!$categoria) {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Categoria não encontrada."
        ]);

        exit();
    }

    // Atualiza o jogo
    $sql = "UPDATE jogos SET
                nome = :nome,
                descricao = :descricao,
                preco = :preco,
                genero = :genero,
                categoria_id = :categoria_id,
                imagem = :imagem,
                estoque = :estoque
            WHERE id = :id";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ":nome" => $nome,
        ":descricao" => $descricao,
        ":preco" => $preco,
        ":genero" => $categoria['nome'],
        ":categoria_id" => $categoriaId,
        ":imagem" => $imagem,
        ":estoque" => $estoque,
        ":id" => $id
    ]);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Jogo atualizado com sucesso!"
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao atualizar o jogo."
    ], JSON_UNESCAPED_UNICODE);

}

?>
