
const formulario = document.getElementById("form-cadastro-jogo");
const mensagem = document.getElementById("mensagem");

formulario.addEventListener("submit", async function(event) {

    
    event.preventDefault(); // impede o cara de recarreginaga

    // captura os dadoooos
    const formularioDados = new FormData(formulario);

    const dados = {
        nome: formularioDados.get("nome"),
        descricao: formularioDados.get("descricao"),
        preco: Number(formularioDados.get("preco")),
        genero: formularioDados.get("genero"),
        imagem: formularioDados.get("imagem"),
        estoque: Number(formularioDados.get("estoque"))
    };

    try {

        // aqui ele envia os dados para API
        const resposta = await fetch("/PHP/API/cadastrar_jogo.php", {
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

        formulario.reset();

    } catch (erro) {

        console.error(erro);

        mensagem.textContent =
            erro.message || "Erro ao cadastrar o jogo.";

    }

});
