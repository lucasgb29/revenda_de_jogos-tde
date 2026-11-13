
<?php
require_once "../PHP/verificar_admin.php"; // verificar se ta na sessao
?>


<html>
<head>
    <title>Gerenciar Usuários</title>
</head>

<body>

    <h1>Gerenciar usuários</h1>

    <a href="gerenciar.php">Voltar ao painel</a>

    <hr>

    <h2 id="titulo-formulario">Cadastrar usuário</h2>

    <form id="form-usuario">

        <input type="hidden" id="id">

        <p>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" maxlength="100" required>
        </p>

        <p>
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" maxlength="50" required>
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="email" id="email" maxlength="150" required>
        </p>

        <p>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" maxlength="20" required>
        </p>

        <p>
            <label for="senha">Senha (vazia mantém a atual):</label>
            <input type="password" id="senha">
        </p>

        <p>
            <label for="perfil">Perfil:</label>
            <select id="perfil">
                <option value="usuario">Usuário</option>
                <option value="admin">Administrador</option>
            </select>
        </p>

        <button type="submit">Salvar</button>
        <button type="button" id="cancelar">Cancelar edição</button>

    </form>

    <p id="mensagem"></p>

    <hr>

    <h2>Usuários cadastrados</h2>

    <div id="lista-usuarios">Carregando...</div>

    <script src="../JS/gerenciar_usuarios.js" defer></script>

</body>
</html>
