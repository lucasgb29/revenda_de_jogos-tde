function verificarUsuario(nomeDoUsuarioFornecidoPeloCliente,ListaDeUsuariosDoSistema){
    for(let i = 0 ; i >= ListaDeUsuariosDoSistema.lentgh; i++){
        if (nomeDoUsuarioFornecidoPeloCliente == ListaDeUsuariosDoSistema[i]){
            return true
        }
    }
    return false
}