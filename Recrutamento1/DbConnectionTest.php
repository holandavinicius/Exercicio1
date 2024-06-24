<?php
$serverName = "Vinicius-PC\TEST"; // Nome do servidor ou IP
$database = "exercicio1"; // Nome da base de dados
$username = "root"; // Usuário do banco de dados
$password = "root"; // Senha do banco de dados

try {
    // Conexão usando PDO com o driver SQLSRV
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);

    // Definir o modo de erro do PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão estabelecida com sucesso!";
} catch (PDOException $e) {
    echo "Falha na conexão: " . $e->getMessage();
}
