<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar se o usuário está logado
if (!isset($_SESSION['restaurante_id'])) {
    header("Location: login_restaurante.php");
    exit;
}

require_once("../conect.php");
$conn = conectarBD();

$restaurante_id = $_SESSION['restaurante_id'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : null;

// Lidar com o upload de imagem (opcional)
$imagem = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Verificar se o arquivo é uma imagem
    $check = getimagesize($_FILES["imagem"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Verificar se o arquivo já existe
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Verificar o tamanho do arquivo
    if ($_FILES["imagem"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Verificar o formato do arquivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Tentar fazer o upload
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
            $imagem = $target_file;
        } else {
            $uploadOk = 0;
        }
    }
}

// Inserir o prato no banco de dados
$sql = "INSERT INTO pratos (restaurante_id, nome, descricao, imagem, preco, categoria_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssii", $restaurante_id, $nome, $descricao, $imagem, $preco, $categoria_id);

if ($stmt->execute()) {
    // Redirecionar para o dashboard
    header("Location: dashboard.php?msg=Prato adicionado com sucesso!");
} else {
    // Redirecionar para a página de criação de cardápio com mensagem de erro
    header("Location: dashboard.php?msg=Erro ao adicionar o prato. Por favor, tente novamente.");
}

$stmt->close();
$conn->close();
?>