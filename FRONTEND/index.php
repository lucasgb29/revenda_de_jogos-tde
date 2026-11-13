
<?php
session_start();

$logado = isset($_SESSION['utilizador']);
$usuario = $logado ? $_SESSION['utilizador'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore - Loja de Jogos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Cabeçalho -->
    <header class="cabecalho">

        <h1 class="logo">
            Game<span class="logo-destaque">Store</span>
        </h1>

        <div class="area-login">

            <?php if ($logado): ?>

                <span class="nome-usuario">
                    Bem-vindo, <?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?>!
                </span>
                <a href="gerenciar.php" class="botao-login">
                    Gerenciar publicações
                </a>
                <a href="cadastrar_jogo.php" class= "botao-login">
                        Cadastrar jogo
                </a>
                <a href="../PHP/logout.php" class="botao-login">
                    Sair
                </a>

            <?php else: ?>

                <a href="login.html" class="botao-login">
                    Entrar 
                </a>

                <a href="cadastro.html" class="botao-cadastro">
                    Cadastrar
                </a>

            <?php endif; ?>

        </div>

    </header>

    <main>

        <!-- Banner principal -->
        <section id="inicio" class="banner">

            <h2 class="banner-titulo">
                Encontre seus jogos favoritos!
            </h2>

            <p class="banner-descricao">
                Os melhores jogos pelos melhores preços.
            </p>

            <!-- Filtros -->
            <div class="filtros">

                <button type="button"
                    class="botao-filtro botao-todos ativo"
                    data-filtro="todos">
                    Ver todos
                </button>

                <button type="button"
                    class="botao-filtro botao-ofertas"
                    data-filtro="ofertas">
                    Ofertas
            
                </button>

                <select id="filtro-genero" class="seletor-genero">
                    <option value="">Todos os gêneros</option>
                    <option value="acao">Ação</option>
                    <option value="aventura">Aventura</option>
                    <option value="rpg">RPG</option>
                    <option value="simulacao">Simulação</option>
                    <option value="esporte">Esporte</option>
                    <option value="estrategia">Estratégia</option>
                </select>

            </div>

        </section>

        <!-- Jogos -->
        <section id="jogos" class="secao-produtos">

            <h2 class="titulo-secao">Jogos disponíveis</h2>

            <div class="lista-jogos">
            <p>Carregando jogos...</p>
            </div>

        </section>

        <!-- Sobre -->
        <section id="sobre" class="secao-sobre">

            <h2 class="titulo-secao">Sobre a GameStore</h2>

            <p class="texto-sobre">
                Somos uma loja fictícia especializada na revenda de jogos.
                Nosso objetivo é oferecer variedade, qualidade e preços acessíveis
                para todos os jogadores.
            </p>

        </section>

        <!-- Contato -->
        <section id="contato" class="secao-contato">

            <h2 class="titulo-secao">Entre em contato</h2>

            <p class="texto-contato">Email: contato@gamestore.com</p>

            <p class="texto-contato">Telefone: (00) 12345-6789</p>

        </section>

    </main>

    <!-- Rodapé -->
    <footer class="rodape">

        <p class="texto-rodape">
            &copy; 2026 GameStore - Todos os direitos reservados.
        </p>

    </footer>

    <!-- o script que tava aqui ta la na pasta JS/listar_jogos.js-->
    <script src="../JS/listar_jogos.js" defer></script>

</body>
</html>
