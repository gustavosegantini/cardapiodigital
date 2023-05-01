<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['restaurante_id'])) {
    header("Location: login_restaurante.php");
    exit;
}

require_once("conect.php");

$restaurante_id = $_SESSION['restaurante_id'];
$titulo = $_POST['titulo'];

// Inserir o cardápio no banco de dados
$sql = "INSERT INTO cardapios (restaurante_id, titulo) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $restaurante_id, $titulo);

if ($stmt->execute()) {
    // Redirecionar para o dashboard
    header("Location: dashboard.php?msg=Cardápio criado com sucesso!");
} else {
    // Redirecionar para a página de criação de cardápio com mensagem de erro
    header("Location: criar_cardapio.php?msg=Erro ao criar o cardápio. Por favor, tente novamente.");
}

$stmt->close();
$conn->close();
?>