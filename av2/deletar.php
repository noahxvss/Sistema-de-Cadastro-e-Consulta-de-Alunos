<?php
// Inclui a conexão com o banco de dados
include 'db.php'; 

// Verifica se o parâmetro 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtém o ID do aluno a ser deletado

    try {
        // Prepara o SQL para deletar o aluno com base no ID
        $sql = "DELETE FROM alunos WHERE id = :id";
        $stmt = $conn->prepare($sql);

        // Liga o parâmetro ID à query
        $stmt->bindParam(':id', $id);

        // Executa a query
        $stmt->execute();

        // Redireciona de volta à página principal com uma mensagem de sucesso
        header("Location: index.php?status=delete_sucesso");
        exit(); // Interrompe a execução após o redirecionamento
    } catch (PDOException $e) {
        // Redireciona de volta à página principal com uma mensagem de erro
        header("Location: index.php?status=delete_erro");
        exit(); // Interrompe a execução após o redirecionamento
    }
}
?>
