<?php
    session_start(); # isso ai é aquela coisa de salvar a sessao 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $usuarioInformado = trim($_POST['usuario']); # O trim so serve para tirar espaço em branco
        $senhaInformada = trim($_POST['senha']);


        $utilizadoresValidos = [
        "Filipak" => "Yang",
        "Lucas" => "tabuleiro", # coloquei usuarios e senha pq num tem banco de dados 
        "Suguimati" => "24"
        ];

        if (array_key_exists($usuarioInformado, $utilizadoresValidos) && $utilizadoresValidos[$usuarioInformado] === $senhaInformada) {
       # ^^^ aqui ele so ta vendo se existe e igualado para ver se bate
        $_SESSION['utilizador'] = $usuarioInformado; # aqui eu coloquei para salvar o nome do usuario para colocar no front bonitinho

        header("Location: ../FRONTEND/index.html"); # aqui volta para o inicio la
        exit();
        }else {
            echo "<script> alert('Pare de tentar nvadir :P') </script>";# aqui é meme Lucas veja ai oque ele quer fazer 
        }
    }else{
         echo "<script> alert('Deu B.O na requisição') </script>"; #DEbug
         header("Location: ../FRONTEND/index.html");
         exit();
    }

?>