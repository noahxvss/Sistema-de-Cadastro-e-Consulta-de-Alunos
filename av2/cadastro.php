<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php'; 

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    try {
        // Prepara a query para inserção no banco de dados
        $sql = "INSERT INTO alunos (nome, idade, email, curso) VALUES (:nome, :idade, :email, :curso)";
        $stmt = $conn->prepare($sql);

        // Liga os parâmetros da query aos valores correspondentes
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':curso', $curso);

        // Executa a query
        $stmt->execute();

        // Redireciona para a página inicial com mensagem de sucesso
        header("Location: index.php?status=sucesso");
        exit(); // Interrompe a execução do script após o redirecionamento
    } catch (PDOException $e) {
        // Redireciona para a página inicial com mensagem de erro
        header("Location: index.php?status=erro");
        exit(); // Interrompe a execução do script após o redirecionamento
    }
}
?>