
<?php
require_once "../PHP/verificar_login.php";
?>


<html>

<head>
    <title>Editar Jogo</title>
</head>

<body>

    <h1>Editar publicação</h1>

    <a href="meus_jogos.php">Voltar para minhas publicações</a>

    <hr>

    <form id="form-editar-jogo">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" maxlength="150" required>
        <br><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>
        <br><br>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco"
               min="0" step="0.01" required>
        <br><br>

        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
            <option value="">Selecione</option>
            <option value="Ação">Ação</option>
            <option value="Aventura">Aventura</option>
            <option value="RPG">RPG</option>
            <option value="Simulação">Simulação</option>
            <option value="Esporte">Esporte</option>
            <option value="Estratégia">Estratégia</option>
        </select>
        <br><br>

        <label for="imagem">URL da imagem:</label>
        <input type="url" id="imagem" name="imagem"
               maxlength="500" required>
        <br><br>

        <label for="estoque">Estoque:</label>
        <input type="number" id="estoque" name="estoque"
               min="0" step="1" required>
        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <p id="mensagem"></p>

    <script src="../JS/editar_jogo.js" defer></script>

</body>
</html>
