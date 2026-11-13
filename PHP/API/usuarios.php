
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../conexao.php";

function responder($status, $dados) {
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit();
}

// Verificar autenticação
if (!isset($_SESSION['utilizador'])) {
    responder(401, [
        "sucesso" => false,
        "mensagem" => "Faça login primeiro."
    ]);
}

// Verificar administrador
$consultaAdmin = $pdo->prepare(
    "SELECT id, perfil FROM usuarios
     WHERE usuario = :usuario"
);

$consultaAdmin->execute([
    ":usuario" => $_SESSION['utilizador']
]);

$admin = $consultaAdmin->fetch();

if (!$admin || $admin['perfil'] !== 'admin') {
    responder(403, [
        "sucesso" => false,
        "mensagem" => "Acesso permitido somente ao administrador."
    ]);
}

$metodo = $_SERVER['REQUEST_METHOD'];

try {

    // READ: listar ou consultar
    if ($metodo === "GET") {

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            $consulta = $pdo->prepare(
                "SELECT id, nome, usuario, email, telefone,
                        perfil, data_criacao
                 FROM usuarios WHERE id = :id"
            );

            $consulta->execute([":id" => $id]);
            $resultado = $consulta->fetch();

            if (!$resultado) {
                responder(404, [
                    "sucesso" => false,
                    "mensagem" => "Usuário não encontrado."
                ]);
            }

            responder(200, [
                "sucesso" => true,
                "dados" => $resultado
            ]);
        }

        $consulta = $pdo->query(
            "SELECT id, nome, usuario, email, telefone,
                    perfil, data_criacao
             FROM usuarios ORDER BY id DESC"
        );

        responder(200, [
            "sucesso" => true,
            "dados" => $consulta->fetchAll()
        ]);
    }

    // Receber JSON nas outras operações
    $dados = json_decode(file_get_contents("php://input"), true);

    if (!is_array($dados)) {
        responder(400, [
            "sucesso" => false,
            "mensagem" => "Dados inválidos."
        ]);
    }

    // CREATE: cadastrar
    if ($metodo === "POST") {

        $nome = trim($dados['nome'] ?? '');
        $usuario = trim($dados['usuario'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $senha = $dados['senha'] ?? '';

        $perfil = $dados['perfil'] ?? 'usuario';

        if (
            $nome === '' ||
            mb_strlen($nome) > 100 ||
            $usuario === '' ||
            mb_strlen($usuario) > 50 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($email) > 150 ||
            $telefone === '' ||
            strlen($telefone) > 20 ||
            !is_string($senha) ||
            strlen($senha) < 8 ||
            !in_array($perfil, ['usuario', 'admin'], true)
        ) {
            responder(400, [
                "sucesso" => false,
                "mensagem" => "Verifique os dados e a senha de pelo menos 8 caracteres."
            ]);
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $consulta = $pdo->prepare(
            "INSERT INTO usuarios
             (nome, usuario, email, telefone, senha, perfil)
             VALUES
             (:nome, :usuario, :email, :telefone, :senha, :perfil)"
        );

        $consulta->execute([
            ":nome" => $nome,
            ":usuario" => $usuario,
            ":email" => $email,
            ":telefone" => $telefone,
            ":senha" => $hash,
            ":perfil" => $perfil
        ]);

        responder(201, [
            "sucesso" => true,
            "mensagem" => "Usuário cadastrado com sucesso."
        ]);
    }

    // UPDATE: editar
    if ($metodo === "PUT") {

        $id = filter_var($dados['id'] ?? null, FILTER_VALIDATE_INT);

        $nome = trim($dados['nome'] ?? '');
        $usuario = trim($dados['usuario'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $senha = $dados['senha'] ?? '';
        $perfil = $dados['perfil'] ?? 'usuario';

        if (
            !$id || $id < 1 ||
            $nome === '' ||
            mb_strlen($nome) > 100 ||
            $usuario === '' ||
            mb_strlen($usuario) > 50 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($email) > 150 ||
            $telefone === '' ||
            strlen($telefone) > 20 ||
            !in_array($perfil, ['usuario', 'admin'], true)
        ) {
            responder(400, [
                "sucesso" => false,
                "mensagem" => "Dados inválidos."
            ]);
        }

        if ($senha !== '' && (!is_string($senha) || strlen($senha) < 8)) {
            responder(400, [
                "sucesso" => false,
                "mensagem" => "A senha deve ter pelo menos 8 caracteres."
            ]);
        }

        // Confirmar que o usuário existe
        $verifica = $pdo->prepare(
            "SELECT id FROM usuarios WHERE id = :id"
        );

        $verifica->execute([":id" => $id]);

        if (!$verifica->fetch()) {
            responder(404, [
                "sucesso" => false,
                "mensagem" => "Usuário não encontrado."
            ]);
        }

        if ($senha !== '') {

            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "UPDATE usuarios SET
                        nome = :nome,
                        usuario = :usuario,
                        email = :email,
                        telefone = :telefone,
                        senha = :senha,
                        perfil = :perfil
                    WHERE id = :id";

        } else {

            $sql = "UPDATE usuarios SET
                        nome = :nome,
                        usuario = :usuario,
                        email = :email,
                        telefone = :telefone,
                        perfil = :perfil
                    WHERE id = :id";
        }

        $consulta = $pdo->prepare($sql);

        $parametros = [
            ":nome" => $nome,
            ":usuario" => $usuario,
            ":email" => $email,
            ":telefone" => $telefone,
            ":perfil" => $perfil,
            ":id" => $id
        ];

        if ($senha !== '') {
            $parametros[":senha"] = $hash;
        }

        $consulta->execute($parametros);

        // Manter a sessão atualizada
        if ((int)$admin['id'] === $id) {
            $_SESSION['utilizador'] = $usuario;
            $_SESSION['perfil'] = $perfil;
        }

        responder(200, [
            "sucesso" => true,
            "mensagem" => "Usuário atualizado com sucesso."
        ]);
    }

    // DELETE: excluir
    if ($metodo === "DELETE") {

        $id = filter_var($dados['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            responder(400, [
                "sucesso" => false,
                "mensagem" => "ID inválido."
            ]);
        }

        // Impedir excluir a própria conta
        if ((int)$admin['id'] === $id) {
            responder(400, [
                "sucesso" => false,
                "mensagem" => "Você não pode excluir sua própria conta."
            ]);
        }

        // Verificar se existem jogos publicados pelo usuário
        $consultaJogos = $pdo->prepare(
            "SELECT COUNT(*) FROM jogos WHERE criado_por = :id"
        );

        $consultaJogos->execute([":id" => $id]);

        if ((int)$consultaJogos->fetchColumn() > 0) {
            responder(409, [
                "sucesso" => false,
                "mensagem" => "Este usuário possui jogos cadastrados. Não pode ser excluído."
            ]);
        }

        $consulta = $pdo->prepare(
            "DELETE FROM usuarios WHERE id = :id"
        );

        $consulta->execute([":id" => $id]);

        if ($consulta->rowCount() === 0) {
            responder(404, [
                "sucesso" => false,
                "mensagem" => "Usuário não encontrado."
            ]);
        }

        responder(200, [
            "sucesso" => true,
            "mensagem" => "Usuário excluído com sucesso."
        ]);
    }

    responder(405, [
        "sucesso" => false,
        "mensagem" => "Método não permitido."
    ]);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    if ($erro->getCode() === '23000') {
        responder(409, [
            "sucesso" => false,
            "mensagem" => "Usuário ou e-mail já cadastrado."
        ]);
    }

    responder(500, [
        "sucesso" => false,
        "mensagem" => "Erro ao processar usuário."
    ]);
}

?>
