
const formulario = document.getElementById("form-categoria");

const lista = document.getElementById("lista-categorias");

const mensagem = document.getElementById("mensagem");

const campoId = document.getElementById("id");
const campoNome = document.getElementById("nome");
const campoDescricao = document.getElementById("descricao");

async function carregarCategorias() {

    try {

        const resposta = await fetch(
            "../PHP/API/categorias.php",
            { cache: "no-store" }
        );

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(resultado.mensagem);
        }

        lista.replaceChildren();

        if (resultado.dados.length === 0) {
            lista.textContent = "Nenhuma categoria cadastrada.";
            return;
        }

        resultado.dados.forEach(categoria => {

            const item = document.createElement("div");

            const nome = document.createElement("h3");
            nome.textContent = categoria.nome;

            const descricao = document.createElement("p");
            descricao.textContent =
                categoria.descricao || "Sem descrição.";

// botao editar -------------------------------------------
            const editar = document.createElement("button");

            editar.type = "button";
            editar.textContent = "Editar";

            editar.addEventListener("click", () => {

                campoId.value = categoria.id;
                campoNome.value = categoria.nome;
                campoDescricao.value = categoria.descricao || "";

                document.getElementById(
                    "titulo-formulario"
                ).textContent = "Editar categoria";

                mensagem.textContent = "Editando categoria: " + categoria.nome;

            });

// botão excluir ----------------------------------------------------------------------------------------
            const excluir = document.createElement("button");

            excluir.type = "button";
            excluir.textContent = "Excluir";

            excluir.addEventListener("click", async () => {

                const confirmar = confirm(
                    `Deseja excluir a categoria ${categoria.nome}?`
                );

                if (!confirmar) return;

                try {

                    const resposta = await fetch(
                        "../PHP/API/categorias.php",
                        {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                id: categoria.id
                            })
                        }
                    );

                    const resultado = await resposta.json();

                    if (!resposta.ok || !resultado.sucesso) {
                        throw new Error(resultado.mensagem);
                    }

                    mensagem.textContent = resultado.mensagem;

                    carregarCategorias();

                } catch (erro) {

                    mensagem.textContent = erro.message;

                }

            });

            item.append(
                nome,
                descricao,
                editar,
                excluir,
                document.createElement("hr")
            );

            lista.appendChild(item);

        });

    } catch (erro) {

        console.error(erro);

        lista.textContent = erro.message;

    }
}

// cadastar ou editar ------------------------------------------------------------------------------------
formulario.addEventListener("submit", async function(event) {

    event.preventDefault();

    const editando = Boolean(campoId.value);

    const dados = {
        nome: campoNome.value,
        descricao: campoDescricao.value
    };

    if (editando) {
        dados.id = Number(campoId.value);
    }

    try {

        const resposta = await fetch(
            "../PHP/API/categorias.php",
            {
                method: editando ? "PUT" : "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify(dados)
            }
        );

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(resultado.mensagem);
        }

        mensagem.textContent = resultado.mensagem;

        formulario.reset();

        campoId.value = "";

        document.getElementById(
            "titulo-formulario"
        ).textContent = "Cadastrar categoria";

        carregarCategorias();

    } catch (erro) {

        mensagem.textContent = erro.message;

    }

});

// se a pessoa quiser cancelar a edição ------------------------------------------------------------------
document.getElementById("cancelar").addEventListener("click", () => {

    formulario.reset();

    campoId.value = "";

    mensagem.textContent = "";

    document.getElementById(
        "titulo-formulario"
    ).textContent = "Cadastrar categoria";

});

// de vdd nunca mais quero fazer web
carregarCategorias();
