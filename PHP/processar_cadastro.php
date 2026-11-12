<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $usuarioCadastrado = trim($_POST['usuario']); # O trim so serve para tirar espaço em branco
        $senhaCadastrada = trim($_POST['senha']);
        $nomeCadastrado = trim($_POST['nome']);
        $emailCadastrado = trim($_POST['email']);
        $telefoneCadastro = trim($_POST['telefone']);

        
         $utilizadoresValidos = [
        "Filipak" => "Yang",
        "Lucas" => "tabuleiro", # coloquei usuarios e senha pq num tem banco de dados 
        "Suguimati" => "24"
        ];

        if (array_key_exists($usuarioCadastrado, $utilizadoresValidos))  {
         echo "<script> alert('Usuario do cadastro ja feito') </script>";# aqui é meme Lucas veja ai oque ele quer fazer  
         exit();
        }else {
            session_start(); # isso ai é aquela coisa de salvar a sessao 
            $_SESSION['utilizador'] = $usuarioCadastrado; # aqui eu coloquei para salvar o nome do usuario para colocar no front bonitinho
            echo "<script> alert('Cadastro feito') </script>";# aqui é meme Lucas veja ai oque ele quer fazer 
        }
    }else{
         echo "<script> alert('Deu B.O na requisição') </script>"; #DEbug
         exit();
    }

?>