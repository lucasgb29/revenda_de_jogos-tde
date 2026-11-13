
const formulario = document.getElementById("form-editar-jogo");
const mensagem = document.getElementById("mensagem");

const parametros = new URLSearchParams(window.location.search);
const id = parametros.get("id");

async function carregarJogo() {

    if (!id || !/^[1-9]\d*$/.test(id)) {
        mensagem.textContent = "ID do jogo inválido.";
        formulario.hidden = true;
        return;
    }

    try {

        const resposta = await fetch(
            `../PHP/API/detalhe_jogo.php?id=${encodeURIComponent(id)}`,
            { cache: "no-store" }
        );

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(resultado.mensagem);
        }

        const jogo = resultado.dados;

        // precnher p fprmularioooo
        formulario.elements["nome"].value = jogo.nome;
        formulario.elements["descricao"].value = jogo.descricao;
        formulario.elements["preco"].value = jogo.preco;
        formulario.elements["genero"].value = jogo.genero;
        formulario.elements["imagem"].value = jogo.imagem;
        formulario.elements["estoque"].value = jogo.estoque;

    } catch (erro) {

        mensagem.textContent = erro.message;
        formulario.hidden = true;
        console.error(erro);

    }
}

formulario.addEventListener("submit", async function(event) {

    event.preventDefault();

    const dadosFormulario = new FormData(formulario);

    const dados = {
        id: Number(id),
        nome: dadosFormulario.get("nome"),
        descricao: dadosFormulario.get("descricao"),
        preco: Number(dadosFormulario.get("preco")),
        genero: dadosFormulario.get("genero"),
        imagem: dadosFormulario.get("imagem"),
        estoque: Number(dadosFormulario.get("estoque"))
    };

    try {

        const resposta = await fetch("../PHP/API/editar_jogo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        });

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(resultado.mensagem);
        }

        mensagem.textContent = resultado.mensagem;

        // so para volar depois de salvar
        setTimeout(() => {
            window.location.href = "meus_jogos.php";
        }, 1000);

    } catch (erro) {

        mensagem.textContent = erro.message;
        console.error(erro);

    }

});

// so para chamar msm quando a pagina abrir
carregarJogo();
