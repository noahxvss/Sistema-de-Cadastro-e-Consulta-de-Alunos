<?php
// Definições de conexão ao banco de dados
$host = 'localhost'; // Host do banco de dados
$db = 'escola';      // Nome do banco de dados
$user = 'noah';   // Usuário do banco de dados
$pass = '123456';       // Senha do usuário
$port = 3307;        // Porta de conexão

try {
    // Cria a conexão PDO com o banco de dados, incluindo a porta
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    
    // Define o modo de erro do PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Exibe mensagem de erro e encerra o script em caso de falha na conexão
    die("Erro na conexão: " . $e->getMessage());
}
?>
