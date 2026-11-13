
async function carregarDetalhes() {

    // captura o ID do jogo presenteeee na URL
    const parametros = new URLSearchParams(window.location.search);
    const id = parametros.get("id");

    const mensagem = document.getElementById("mensagem");

    // verifica se o id é valido
    if (!id || !/^[1-9]\d*$/.test(id)) {
        mensagem.textContent = "ID do jogo inválido.";
        return;
    }

    try {

        // busca detalhes do jogo no detalhe_jogo.php meio atuo explciativo
       const resposta = await fetch(
         `/PHP/API/detalhe_jogo.php?id=${encodeURIComponent(id)}`,
         { cache: "no-store" }
        );
        // -----> JSON
        const resultado = await resposta.json();

        // ve se nao teve neneuhm errro
        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(
                resultado.mensagem || "Erro ao carregar o jogo."
            );
        }

        // Armazena os dados recebidos
        const jogo = resultado.dados;

        // Preenche as informações do jogo no HTML
        document.getElementById("nome-detalhes").textContent =
            jogo.nome;

        document.getElementById("descricao-detalhes").textContent =
            jogo.descricao;

        document.getElementById("preco-detalhes").textContent =
            Number(jogo.preco).toLocaleString("pt-BR", {
                style: "currency",
                currency: "BRL"
            });

        document.getElementById("genero-detalhes").textContent =
            jogo.genero;
        document.getElementById("publicador-detalhes").textContent =
            jogo.nome_publicador || "Publicador não identificado";

        document.getElementById("estoque-detalhes").textContent =
            `${jogo.estoque} unidades em estoque`;

        // carregar a imagemm
        const imagem = document.getElementById("imagem-jogo");

        imagem.src = jogo.imagem;
        imagem.alt = jogo.nome;

        // atualizar o nome da imagem(meramente facultativo mas como ja tava ai msm)
        document.title = `GameStore - ${jogo.nome}`;

    } catch (erro) {

        console.error("Erro ao carregar detalhes:", erro);

        document.getElementById("nome-detalhes").textContent =
            "Não foi possível carregar o jogo.";

        mensagem.textContent = erro.message;

    }
}

// isso é para ele executar so quando o HTMl tiver carregado
document.addEventListener("DOMContentLoaded", carregarDetalhes);
