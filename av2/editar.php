<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php'; 

// Verifica se o ID do aluno foi passado na URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    // Busca os dados do aluno com base no ID
    $sql = "SELECT * FROM alunos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id); // Liga o parâmetro da query ao ID
    $stmt->execute();
    $aluno = $stmt->fetch(); // Obtém os dados do aluno
} else {
    // Redireciona para a lista de alunos se o ID não for válido
    header('Location: index.php');
    exit;
}

// Verifica se o formulário de atualização foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    // Atualiza os dados do aluno no banco de dados
    $sql = "UPDATE alunos SET nome = :nome, idade = :idade, email = :email, curso = :curso WHERE id = :id";
    $stmt = $conn->prepare($sql);
    
    // Liga os parâmetros da query aos valores do formulário
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':idade', $idade);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':curso', $curso);
    $stmt->bindValue(':id', $id);
    $stmt->execute(); // Executa a query

    // Redireciona de volta para a lista de alunos com mensagem de sucesso
    header('Location: index.php?status=edit_sucesso');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Inclui o CSS para estilização -->
</head>
<body>
    <h1>Editar Aluno</h1>
    <form action="editar.php?id=<?= $id ?>" method="POST"> <!-- Formulário para atualizar o aluno -->
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" required><br>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" value="<?= htmlspecialchars($aluno['idade']) ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($aluno['email']) ?>" required><br>

        <label for="curso">Curso:</label>
        <input type="text" name="curso" value="<?= htmlspecialchars($aluno['curso']) ?>" required><br>

        <button type="submit">Atualizar</button> <!-- Botão para enviar o formulário -->
    </form>

    <a href="index.php">Voltar para a lista de alunos</a> <!-- Link para voltar -->
</body>
</html>
