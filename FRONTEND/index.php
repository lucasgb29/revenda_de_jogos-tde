<?php
session_start();

if (!isset($_SESSION['utilizador'])) {
    header("Location: login.html");
    exit();
}

$usuario = $_SESSION['utilizador'];
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GameStore - Loja de Jogos</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <!-- Cabeçalho -->

    <h2>
    Bem-vindo, <?= htmlspecialchars($usuario) ?>!
</h2>
    <header class="cabecalho">
      <h1 class="logo">Game<span class="logo-destaque">Store</span></h1>

      <div class="area-login">
        <a href="login.html" class="botao-login">Entrar</a>
        <a href="cadastro.html" class="botao-cadastro">Cadastrar</a>
      </div>
    </header>

    <main>
      <!-- Banner principal -->
      <section id="inicio" class="banner">
        <h2 class="banner-titulo">Encontre seus jogos favoritos!</h2>

        <p class="banner-descricao">Os melhores jogos pelos melhores preços.</p>

        <!-- Filtros -->
        <div class="filtros">
          <button
            type="button"
            class="botao-filtro botao-todos ativo"
            data-filtro="todos"
          >
            Ver todos
          </button>

          <button
            type="button"
            class="botao-filtro botao-ofertas"
            data-filtro="ofertas"
          >
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

      <section id="jogos" class="secao-produtos">
        <h2 class="titulo-secao">Jogos disponíveis</h2>

        <div class="lista-jogos">
          <div class="card-jogo" data-genero="acao" data-oferta="true">
            <img
              class="imagem-jogo"
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQydwnDp4Akcny34BxZhQPgSruB_AH7L0NW6VVI9HkQ-Q&s=10"
              alt="GTA V"
            />

            <h3 class="nome-jogo">GTA V</h3>

            <p class="preco-jogo">R$ 79,90</p>

            <a href="../FRONTEND/jogo.html"><button type="button" class="botao-comprar">Comprar</button></a>
          </div>

          <div class="card-jogo" data-genero="simulacao" data-oferta="false">
            <img
              class="imagem-jogo"
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQ0-qoePFEhP1QiaI0mF8lfEaJDT_ZhaNCiPstD4TSlA&s=10"
              alt="Spore"
            />

            <h3 class="nome-jogo">Spore</h3>

            <p class="preco-jogo">R$ 59,90</p>

            <button type="button" class="botao-comprar">Comprar</button>
          </div>

          <div class="card-jogo" data-genero="rpg" data-oferta="true">
            <img
              class="imagem-jogo"
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnx8biHnY2OPfRBtXAW322cxOCXZivUuZ1fusqgnutmQ&s=10"
              alt="Skyrim"
            />

            <h3 class="nome-jogo">Skyrim</h3>

            <p class="preco-jogo">R$ 99,90</p>

            <button type="button" class="botao-comprar">Comprar</button>
          </div>
        </div>
      </section>

      <!-- Sobre a loja -->
      <section id="sobre" class="secao-sobre">
        <h2 class="titulo-secao">Sobre a GameStore</h2>

        <p class="texto-sobre">
          Somos uma loja fictícia especializada na revenda de jogos. Nosso
          objetivo é oferecer variedade, qualidade e preços acessíveis para
          todos os jogadores.
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

    <!-- JavaScript dos filtros -->
    <script>
      const botoesFiltro = document.querySelectorAll(".botao-filtro");
      const seletorGenero = document.getElementById("filtro-genero");
      const jogos = document.querySelectorAll(".card-jogo");

      let filtroAtual = "todos";

      function filtrarJogos() {
        const generoSelecionado = seletorGenero.value;

        jogos.forEach((jogo) => {
          const genero = jogo.dataset.genero;
          const emOferta = jogo.dataset.oferta === "true";

          const correspondeGenero =
            generoSelecionado === "" || genero === generoSelecionado;

          const correspondeOferta =
            filtroAtual === "todos" || (filtroAtual === "ofertas" && emOferta);

          jogo.style.display =
            correspondeGenero && correspondeOferta ? "" : "none";
        });
      }

      botoesFiltro.forEach((botao) => {
        botao.addEventListener("click", () => {
          filtroAtual = botao.dataset.filtro;

          seletorGenero.value = "";

          botoesFiltro.forEach((outroBotao) => {
            outroBotao.classList.remove("ativo");
          });

          botao.classList.add("ativo");

          filtrarJogos();
        });
      });

      seletorGenero.addEventListener("change", filtrarJogos);
    </script>
  </body>
</html>
