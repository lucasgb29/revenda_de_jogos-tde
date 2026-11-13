<?php

$host = "127.0.0.1";
$porta = "3307";
$banco = "gamestore";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5
        ]
    );

} catch (PDOException $erro) {
    error_log($erro->getMessage()); # isso aqui é so para tratar o erro se der ;)
    throw $erro;
}



?>