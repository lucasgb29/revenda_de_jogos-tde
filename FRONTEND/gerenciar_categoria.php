
<?php
require_once "../PHP/verificar_admin.php"; // verificar se ta na sessao
?>

<
<html >

<head>
    <title>Gerenciar Categorias</title>
</head>

<body>

    <h1>Gerenciar Categorias</h1>

    <a href="gerenciar.php">Voltar ao painel</a>

    <hr>

    <h2 id="titulo-formulario">Cadastrar categoria</h2>

    <form id="form-categoria">

        <input type="hidden" id="id">

        <p>
            <label for="nome">Nome:</label>
            <input
                type="text"
                id="nome"
                maxlength="60"
                required
            >
        </p>

        <p>
            <label for="descricao">Descrição:</label>
            <textarea
                id="descricao"
                maxlength="255"
            ></textarea>
        </p>

        <button type="submit">Salvar categoria</button>

        <button type="button" id="cancelar">
            Cancelar edição
        </button>

    </form>

    <p id="mensagem"></p>

    <hr>

    <h2>Categorias cadastradas</h2>

    <div id="lista-categorias">
        Carregando categorias...
    </div>

    <script src="../JS/gerenciar_categorias.js" defer></script>

</body>
</html>
