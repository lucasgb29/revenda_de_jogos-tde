<?php

$host = "localhost";  #-------\
$porta = "3307";      #-------\
$banco = "gamestore"; # ---------> isso ai é para puxar o banco ;---;
$usuario = "root";    #-------|
$senha = "";          #-------|

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4", # PDO é a ferramenta para mecher com BDD
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  # tratamento de erro ai parça
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, # isso ai é para pegar coluna
            PDO::ATTR_EMULATE_PREPARES => false # isso é para nao emular para num ter SQL Injection
        ]
    );

} catch (PDOException $erro) {
    error_log($erro->getMessage()); # isso aqui é so para tratar o erro se der ;)
    throw $erro;
}



?>