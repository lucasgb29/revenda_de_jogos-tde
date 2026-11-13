
<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../FRONTEND/cadastro.html");
    exit();
}

// recebe os dados do formulario
$nome = trim($_POST['nome'] ?? '');
$usuario = trim($_POST['usuario'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$senha = $_POST['senha'] ?? '';

// Mas uma validação de campo
if (
    $nome === '' ||
    $usuario === '' ||
    $email === '' ||
    $telefone === '' ||
    $senha === ''
) {
    echo "<script>
        alert('Preencha todos os campos.');
        history.back();
    </script>";
    exit();
}

if (
    strlen($nome) > 100 ||
    strlen($usuario) > 50 ||
    strlen($email) > 150 ||
    strlen($telefone) > 20 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($senha) < 8
) {
    echo "<script>
        alert('Verifique os dados. A senha deve ter pelo menos 8 caracteres.');
        history.back();
    </script>";
    exit();
}

try {

    // Vanco conecct
    require_once __DIR__ . "/conexao.php";

    // coloca a senha em hash isso foi um bonus ai de cyber
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    //  prepara o cad
    $sql = "INSERT INTO usuarios
            (nome, usuario, email, telefone, senha)
            VALUES
            (:nome, :usuario, :email, :telefone, :senha)";

    $consulta = $pdo->prepare($sql);

    // joga os dados la 
    $consulta->execute([
        ':nome' => $nome,
        ':usuario' => $usuario,
        ':email' => $email,
        ':telefone' => $telefone,
        ':senha' => $senhaHash
    ]);

    // dai ja inicia a sessao do novo usuario que chique ne
    session_regenerate_id(true);
    $_SESSION['utilizador'] = $usuario;

    header("Location: ../FRONTEND/index.php");
    exit();

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    if ($erro->getCode() === '23000') {
        echo "<script>
            alert('Esse usuário ou e-mail já está cadastrado.');
            history.back();
        </script>";
    } else {
        echo "<script>
            alert('Erro ao realizar o cadastro.');
            history.back();
        </script>";
    }

    exit();
}

?>
