
const formulario = document.getElementById("form-usuario");
const lista = document.getElementById("lista-usuarios");
const mensagem = document.getElementById("mensagem");

const campoId = document.getElementById("id");
const campoNome = document.getElementById("nome");
const campoUsuario = document.getElementById("usuario");
const campoEmail = document.getElementById("email");
const campoTelefone = document.getElementById("telefone");
const campoSenha = document.getElementById("senha");
const campoPerfil = document.getElementById("perfil");

async function carregarUsuarios() {

    try {

        const resposta = await fetch("../PHP/API/usuarios.php", {
            cache: "no-store"
        });

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(resultado.mensagem);
        }

        lista.replaceChildren();

        resultado.dados.forEach(usuario => {

            const item = document.createElement("div");

            const nome = document.createElement("h3");
            nome.textContent = usuario.nome;

            const dados = document.createElement("p");
            dados.textContent =
                `${usuario.usuario} | ${usuario.email} | ${usuario.telefone}`;

            const perfil = document.createElement("p");
            perfil.textContent = "Perfil: " + usuario.perfil;

            const editar = document.createElement("button");
            editar.textContent = "Editar";

            editar.addEventListener("click", () => {

                campoId.value = usuario.id;
                campoNome.value = usuario.nome;
                campoUsuario.value = usuario.usuario;
                campoEmail.value = usuario.email;
                campoTelefone.value = usuario.telefone;
                campoSenha.value = "";
                campoPerfil.value = usuario.perfil;

                document.getElementById("titulo-formulario").textContent =
                    "Editar usuário";

                mensagem.textContent = "Editando " + usuario.nome;

            });

            const excluir = document.createElement("button");
            excluir.textContent = "Excluir";

            excluir.addEventListener("click", async () => {

                if (!confirm(`Deseja excluir ${usuario.nome}?`)) {
                    return;
                }

                try {

                    const resposta = await fetch("../PHP/API/usuarios.php", {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id: usuario.id })
                    });

                    const resultado = await resposta.json();

                    if (!resposta.ok || !resultado.sucesso) {
                        throw new Error(resultado.mensagem);
                    }

                    mensagem.textContent = resultado.mensagem;
                    carregarUsuarios();

                } catch (erro) {

                    mensagem.textContent = erro.message;

                }

            });

            item.append(
                nome,
                dados,
                perfil,
                editar,
                excluir,
                document.createElement("hr")
            );

            lista.appendChild(item);

        });

        if (resultado.dados.length === 0) {
            lista.textContent = "Nenhum usuário cadastrado.";
        }

    } catch (erro) {

        lista.textContent = erro.message;

    }
}

formulario.addEventListener("submit", async event => {

    event.preventDefault();

    const editando = Boolean(campoId.value);

    const dados = {
        id: editando ? Number(campoId.value) : undefined,
        nome: campoNome.value,
        usuario: campoUsuario.value,
        email: campoEmail.value,
        telefone: campoTelefone.value,
        senha: campoSenha.value,
        perfil: campoPerfil.value
    };

    if (!editando && dados.senha.length < 8) {
        mensagem.textContent = "A senha deve ter pelo menos 8 caracteres.";
        return;
    }

    try {

        const resposta = await fetch("../PHP/API/usuarios.php", {
            method: editando ? "PUT" : "POST",
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
        campoId.value = "";

        document.getElementById("titulo-formulario").textContent =
            "Cadastrar usuário";

        carregarUsuarios();

    } catch (erro) {

        mensagem.textContent = erro.message;

    }

});

document.getElementById("cancelar").addEventListener("click", () => {

    formulario.reset();
    campoId.value = "";

    document.getElementById("titulo-formulario").textContent =
        "Cadastrar usuário";

    mensagem.textContent = "";

});

carregarUsuarios();
