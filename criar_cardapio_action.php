<?php
session_start();

if (!isset($_SESSION["restaurante_id"])) {
    header("Location: login.php");
    exit();
}

require_once "../conect.php";
$conn = conectarBD();

$restaurante_id = $_SESSION["restaurante_id"];
$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$imagem = "";

// Processar o upload da imagem, se houver
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
    $imagem = "uploads/" . basename($_FILES["imagem"]["name"]);
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem);
}

$sql = "INSERT INTO cardapios (restaurante_id, nome, descricao, imagem) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $restaurante_id, $nome, $descricao, $imagem);
$stmt->execute();

header("Location: dashboard.php");
?>
