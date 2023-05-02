<?php
require 'config.php';
require 'conexao.php';

// Atualizar informações do prato no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];

    $conn = conectarBD();
    $sql = "UPDATE pratos SET nome = ?, descricao = ?, preco = ?, categoria = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $categoria, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>
