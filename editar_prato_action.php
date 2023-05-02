<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../conect.php';

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
    $stmt->bind_param("issssd", $restaurante_id, $nome, $descricao, $imagem, $preco, $categoria);


    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>
