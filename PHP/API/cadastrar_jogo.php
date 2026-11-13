
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

// padrozinar a respostaa tava dando erro
function responder($status, $dados) {
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit();
}

// verificar a autrenciar para ver se ta em uma sessao
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

// recebier o JASON
$dados = json_decode(file_get_contents("php://input"), true);

if (!is_array($dados)) {
    responder(400, [
        "sucesso" => false,
        "mensagem" => "Dados inválidos."
    ]);
}

// organizar e padronizar os campos
$nome = trim($dados['nome'] ?? '');
$descricao = trim($dados['descricao'] ?? '');
$preco = $dados['preco'] ?? null;
$genero = $dados['genero'] ?? '';
$imagem = trim($dados['imagem'] ?? '');
$estoque = filter_var(
    $dados['estoque'] ?? null,
    FILTER_VALIDATE_INT
);

$generosPermitidos = [
    "Ação",
    "Aventura",
    "RPG",
    "Simulação",
    "Esporte",
    "Estratégia"
];

$esquemaImagem = parse_url($imagem, PHP_URL_SCHEME);

$precoValido = is_numeric($preco)
    && is_finite((float)$preco)
    && (float)$preco >= 0
    && (float)$preco <= 99999999.99;

$imagemValida = filter_var(
    $imagem,
    FILTER_VALIDATE_URL
) !== false
    && in_array(
        strtolower((string)$esquemaImagem),
        ["http", "https"],
        true
    );

// validar os dadossss
if (
    $nome === '' ||
    strlen($nome) > 600 ||
    $descricao === '' ||
    !$precoValido ||
    !in_array($genero, $generosPermitidos, true) ||
    !$imagemValida ||
    strlen($imagem) > 500 ||
    $estoque === false ||
    $estoque < 0
) {
    responder(400, [
        "sucesso" => false,
        "mensagem" => "Verifique os dados informados."
    ]);
}

try {

    require_once __DIR__ . "/../conexao.php";

    // aqui ele cata o id da pessoa pela sessao
    $sqlAutor = "SELECT id
                 FROM usuarios
                 WHERE usuario = :usuario
                 LIMIT 1";

    $consultaAutor = $pdo->prepare($sqlAutor);

    $consultaAutor->execute([
        ":usuario" => $_SESSION['utilizador']
    ]);

    $autor = $consultaAutor->fetch();

    if (!$autor) {
        responder(401, [
            "sucesso" => false,
            "mensagem" => "Usuário não encontrado."
        ]);
    }

    $autorId = (int) $autor['id'];

    // salva o jogo e seu proprietario
    $sql = "INSERT INTO jogos
            (nome, descricao, preco, genero, imagem, estoque, criado_por)
            VALUES
            (:nome, :descricao, :preco, :genero, :imagem, :estoque, :criado_por)";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ":nome" => $nome,
        ":descricao" => $descricao,
        ":preco" => $preco,
        ":genero" => $genero,
        ":imagem" => $imagem,
        ":estoque" => $estoque,
        ":criado_por" => $autorId
    ]);

    responder(201, [
        "sucesso" => true,
        "mensagem" => "Jogo cadastrado com sucesso!",
        "id" => $pdo->lastInsertId(),
        "criado_por" => $autorId
    ]);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    responder(500, [
        "sucesso" => false,
        "mensagem" => "Erro ao cadastrar o jogo."
    ]);
}

?>
