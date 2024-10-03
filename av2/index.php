<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php'; 

// Verifica se o campo de pesquisa foi enviado
$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

// Consulta para buscar alunos, com ou sem pesquisa
if ($pesquisa) {
    // Busca por nome ou curso, se houver valor na pesquisa
    $sql = "SELECT * FROM alunos WHERE nome LIKE :pesquisa OR curso LIKE :pesquisa";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':pesquisa', '%' . $pesquisa . '%'); // Adiciona '%' para busca parcial
} else {
    // Busca todos os alunos se não houver pesquisa
    $sql = "SELECT * FROM alunos";
    $stmt = $conn->prepare($sql);
}

$stmt->execute(); // Executa a consulta
$alunos = $stmt->fetchAll(); // Obtém todos os resultados
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Cadastro de Alunos</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Inclui o CSS para estilização -->
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    <form action="cadastro.php" method="POST"> <!-- Formulário para cadastrar novos alunos -->
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br>

        <label for="curso">Curso:</label>
        <input type="text" name="curso" required><br>

        <button type="submit">Cadastrar</button> <!-- Botão para cadastrar o aluno -->
    </form>

    <?php
    // Exibe mensagens de status
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    if ($status == 'sucesso') {
        echo "<p style='color: green;'>Aluno cadastrado com sucesso!</p>";
    } elseif ($status == 'erro') {
        echo "<p style='color: red;'>Erro ao cadastrar o aluno. Tente novamente.</p>";
    } elseif ($status == 'edit_sucesso') {
        echo "<p style='color: green;'>Aluno atualizado com sucesso!</p>";
    } elseif ($status == 'edit_erro') {
        echo "<p style='color: red;'>Erro ao atualizar o aluno. Tente novamente.</p>";
    } elseif ($status == 'delete_sucesso') {
        echo "<p style='color: green;'>Aluno excluído com sucesso!</p>";
    } elseif ($status == 'delete_erro') {
        echo "<p style='color: red;'>Erro ao excluir o aluno. Tente novamente.</p>";
    }
    ?>

    <h1>Lista de Alunos</h1>

    <!-- Formulário de pesquisa -->
    <form action="index.php" method="GET"> 
        <label for="pesquisa">Pesquisar por nome ou curso:</label>
        <input type="text" name="pesquisa" id="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>"> <!-- Campo de pesquisa -->
        <button type="submit">Pesquisar</button> <!-- Botão para enviar a pesquisa -->
    </form>

    <!-- Exibir tabela de alunos -->
    <?php if (count($alunos) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Email</th>
                <th>Curso</th>
                <th class="acoes">Ações</th> <!-- Coluna para ações -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
            <tr>
                <td><?= $aluno['id'] ?></td>
                <td><?= htmlspecialchars($aluno['nome']) ?></td> <!-- Escape de HTML para segurança -->
                <td><?= $aluno['idade'] ?></td>
                <td><?= htmlspecialchars($aluno['email']) ?></td>
                <td><?= htmlspecialchars($aluno['curso']) ?></td>
                <td>
                    <a href="editar.php?id=<?= $aluno['id'] ?>">Editar</a> | <!-- Link para editar o aluno -->
                    <a href="deletar.php?id=<?= $aluno['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a> <!-- Link para excluir o aluno -->
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Nenhum aluno encontrado.</p> <!-- Mensagem caso não haja alunos -->
    <?php endif; ?>
</body>
</html>
