<?php
require 'config.php';
require 'conexao.php';

// Obter o ID do prato e buscar informações no banco de dados
$prato_id = $_GET['id'];
$conn = conectarBD();
$sql = "SELECT * FROM pratos WHERE id = $prato_id";
$result = $conn->query($sql);
$prato = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Prato</title>
    <link rel="stylesheet" href="dashboard_style.css">
</head>
<body>
    <h1>Editar Prato</h1>
    <section>
        <form action="editar_prato_action.php" method="POST">
            <input type="hidden" name="id" value="<?= $prato['id'] ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= $prato['nome'] ?>" required>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= $prato['descricao'] ?></textarea>
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" value="<?= $prato['preco'] ?>" required>
            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" value="<?= $prato['categoria'] ?>" required>
            <button type="submit">Salvar</button>
        </form>
    </section>
</body>
</html>
