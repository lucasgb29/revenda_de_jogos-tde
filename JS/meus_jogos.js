
async function carregarMeusJogos() {

    const lista = document.getElementById("lista-meus-jogos");

    try {

        const resposta = await fetch("/PHP/API/meus_jogos.php", {
            cache: "no-store"
        });

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(resultado.mensagem);
        }

        lista.replaceChildren();

        if (resultado.dados.length === 0) {
            lista.textContent = "Você ainda não publicou nenhum jogo.";
            return;
        }

        resultado.dados.forEach(jogo => {

            const item = document.createElement("div");

            const nome = document.createElement("h3");
            nome.textContent = jogo.nome;

            const preco = document.createElement("p");
            preco.textContent = Number(jogo.preco).toLocaleString(
                "pt-BR",
                { style: "currency", currency: "BRL" }
            );

            const genero = document.createElement("p");
            genero.textContent = "Gênero: " + jogo.genero;

            const estoque = document.createElement("p");
            estoque.textContent = "Estoque: " + jogo.estoque;

            // Botão de editar (vamos implementar a seguir)
            const editar = document.createElement("a");
            editar.href = `editar_jogo.php?id=${jogo.id}`;
            editar.textContent = "Editar";

            // Botão de excluir
            const excluir = document.createElement("button");
            excluir.textContent = "Excluir";

            excluir.addEventListener("click", async () => {

                const confirmar = confirm(
                    `Deseja realmente excluir ${jogo.nome}?`
                );

                if (!confirmar) return;

                try {

                    const resposta = await fetch(
                        "/PHP/API/excluir_jogo.php",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                id: jogo.id
                            })
                        }
                    );

                    const resultado = await resposta.json();

                    if (!resposta.ok || !resultado.sucesso) {
                        throw new Error(resultado.mensagem);
                    }

                    alert(resultado.mensagem);

                    // Atualiza a lista sem recarregar a página
                    carregarMeusJogos();

                } catch (erro) {

                    alert(erro.message);

                }

            });

            item.append(
                nome,
                preco,
                genero,
                estoque,
                editar,
                excluir
            );

            lista.appendChild(item);

        });

    } catch (erro) {

        console.error(erro);
        lista.textContent = erro.message;

    }
}

document.addEventListener("DOMContentLoaded", carregarMeusJogos);
