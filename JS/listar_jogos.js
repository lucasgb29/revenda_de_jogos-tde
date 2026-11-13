
const listaJogos = document.querySelector(".lista-jogos");
const botoesFiltro = document.querySelectorAll(".botao-filtro");
const seletorGenero = document.getElementById("filtro-genero");

let jogosCarregados = [];
let filtroAtual = "todos";

function normalizar(texto) {
    return String(texto ?? "") //isso aqui pe eu coloquei para tirar acentos essas coisas padronizar
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase();
}


async function carregarJogos() {  // aqui é para buscar na api os baguio

    try {

        const resposta = await fetch("../PHP/API/jogos.php");

        if (!resposta.ok) {
            throw new Error("Erro ao consultar a API.");
        }

        const resultado = await resposta.json();

        if (!resultado.sucesso) {
            throw new Error("Não foi possível carregar os jogos.");
        }

        jogosCarregados = resultado.dados;

        renderizarJogos();

    } catch (erro) {

        console.error("Erro:", erro);

        listaJogos.textContent =
            "Não foi possível carregar os jogos.";

    }
}


function renderizarJogos() { // aqui é para montar os cards da pagina

    listaJogos.replaceChildren();

    const generoSelecionado = normalizar(seletorGenero.value);

    const jogosFiltrados = jogosCarregados.filter(jogo => {

        const correspondeGenero =
            generoSelecionado === "" ||
            normalizar(jogo.genero) === generoSelecionado;

        return correspondeGenero;

    });

    if (jogosFiltrados.length === 0) {

        listaJogos.textContent = "Nenhum jogo encontrado.";
        return;

    }

    jogosFiltrados.forEach(jogo => {

        const card = document.createElement("div");
        card.className = "card-jogo";

        const imagem = document.createElement("img");
        imagem.className = "imagem-jogo";
        imagem.src = jogo.imagem;
        imagem.alt = jogo.nome;

        const nome = document.createElement("h3");
        nome.className = "nome-jogo";
        nome.textContent = jogo.nome;

        const preco = document.createElement("p");
        preco.className = "preco-jogo";

        preco.textContent = Number(jogo.preco).toLocaleString(
            "pt-BR",
            {
                style: "currency",
                currency: "BRL"
            }
        );

        const botao = document.createElement("a");
        botao.className = "botao-comprar";
        botao.href = `jogo.php?id=${encodeURIComponent(jogo.id)}`;
        botao.textContent = "Ver detalhes";

        card.append(imagem, nome, preco, botao);

        listaJogos.appendChild(card);

    });

}

// aqui ta o evento do filtrooooo
botoesFiltro.forEach(botao => {

    botao.addEventListener("click", () => {

        filtroAtual = botao.dataset.filtro;

        botoesFiltro.forEach(outro => {
            outro.classList.remove("ativo");
        });

        botao.classList.add("ativo");

        renderizarJogos();

    });

});

seletorGenero.addEventListener("change", renderizarJogos);

carregarJogos();
