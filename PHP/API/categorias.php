
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

try {

    require_once __DIR__ . "/../conexao.php";

    // LISTAR E CONSULTAR CATEGORIAS
    if ($_SERVER["REQUEST_METHOD"] === "GET") {

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id !== null && $id !== false) {

            if ($id < 1) {
                http_response_code(400);
                echo json_encode([
                    "sucesso" => false,
                    "mensagem" => "ID inválido."
                ]);
                exit();
            }

            $consulta = $pdo->prepare(
                "SELECT id, nome, descricao
                 FROM categorias
                 WHERE id = :id"
            );

            $consulta->execute([":id" => $id]);

            $categoria = $consulta->fetch();

            if (!$categoria) {
                http_response_code(404);
                echo json_encode([
                    "sucesso" => false,
                    "mensagem" => "Categoria não encontrada."
                ]);
                exit();
            }

            echo json_encode([
                "sucesso" => true,
                "dados" => $categoria
            ]);

            exit();
        }

        $consulta = $pdo->query(
            "SELECT id, nome, descricao
             FROM categorias
             ORDER BY nome"
        );

        echo json_encode([
            "sucesso" => true,
            "dados" => $consulta->fetchAll()
        ], JSON_UNESCAPED_UNICODE);

        exit();
    }

    // ALTERAÇÕES EXIGEM LOGIN DE ADMINISTRADOR
    if (!isset($_SESSION['utilizador'])) {
        http_response_code(401);
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Você precisa estar conectado."
        ]);
        exit();
    }

    $consultaAdmin = $pdo->prepare(
        "SELECT perfil FROM usuarios
         WHERE usuario = :usuario"
    );

    $consultaAdmin->execute([
        ":usuario" => $_SESSION['utilizador']
    ]);

    $admin = $consultaAdmin->fetch();

    if (!$admin || $admin['perfil'] !== 'admin') {
        http_response_code(403);
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Somente administradores podem gerenciar categorias."
        ]);
        exit();
    }

    // RECEBER DADOS JSON
    $dados = json_decode(file_get_contents("php://input"), true);

    if (!is_array($dados)) {
        http_response_code(400);
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Dados inválidos."
        ]);
        exit();
    }

    // CADASTRAR CATEGORIA
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $nome = trim($dados['nome'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');

        if (
            $nome === '' ||
            mb_strlen($nome) > 60 ||
            mb_strlen($descricao) > 255
        ) {
            http_response_code(400);
            echo json_encode([
                "sucesso" => false,
                "mensagem" => "Preencha corretamente os campos."
            ]);
            exit();
        }

        $consulta = $pdo->prepare(
            "INSERT INTO categorias (nome, descricao)
             VALUES (:nome, :descricao)"
        );

        $consulta->execute([
            ":nome" => $nome,
            ":descricao" => $descricao
        ]);

        http_response_code(201);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Categoria cadastrada com sucesso!"
        ], JSON_UNESCAPED_UNICODE);

        exit();
    }

    // EDITAR CATEGORIA
    if ($_SERVER["REQUEST_METHOD"] === "PUT") {

        $id = filter_var(
            $dados['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $nome = trim($dados['nome'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');

        if (
            !$id || $id < 1 ||
            $nome === '' ||
            mb_strlen($nome) > 60 ||
            mb_strlen($descricao) > 255
        ) {
            http_response_code(400);
            echo json_encode([
                "sucesso" => false,
                "mensagem" => "Dados inválidos."
            ]);
            exit();
        }

        $consulta = $pdo->prepare(
            "UPDATE categorias
             SET nome = :nome, descricao = :descricao
             WHERE id = :id"
        );

        $consulta->execute([
            ":nome" => $nome,
            ":descricao" => $descricao,
            ":id" => $id
        ]);

        $verifica = $pdo->prepare(
            "SELECT id FROM categorias WHERE id = :id"
        );

        $verifica->execute([":id" => $id]);

        if (!$verifica->fetch()) {
            http_response_code(404);
            echo json_encode([
                "sucesso" => false,
                "mensagem" => "Categoria não encontrada."
            ]);
            exit();
        }

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Categoria atualizada com sucesso!"
        ], JSON_UNESCAPED_UNICODE);

        exit();
    }

    // EXCLUIR CATEGORIA
    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {

        $id = filter_var(
            $dados['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$id || $id < 1) {
            http_response_code(400);
            echo json_encode([
                "sucesso" => false,
                "mensagem" => "ID inválido."
            ]);
            exit();
        }

        $consulta = $pdo->prepare(
            "DELETE FROM categorias WHERE id = :id"
        );

        $consulta->execute([":id" => $id]);

        if ($consulta->rowCount() === 0) {
            http_response_code(404);
            echo json_encode([
                "sucesso" => false,
                "mensagem" => "Categoria não encontrada."
            ]);
            exit();
        }

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Categoria excluída com sucesso!"
        ], JSON_UNESCAPED_UNICODE);

        exit();
    }

    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido."
    ]);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    if ($erro->getCode() === '23000') {
        http_response_code(409);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Essa categoria já existe ou possui jogos vinculados."
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Erro ao processar categoria."
        ]);
    }
}

?>
