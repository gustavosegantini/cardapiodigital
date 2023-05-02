<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../conect.php';

function obterPratos($restaurante_id) {
    $conn = conectarBD();
    $sql = "SELECT * FROM pratos WHERE restaurante_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurante_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pratos = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    return $pratos;
}

// Obter o restaurante_id do parâmetro GET
if (isset($_GET['restaurante_id'])) {
    $restaurante_id = intval($_GET['restaurante_id']);
    $pratos = obterPratos($restaurante_id);
} else {
    die("Nenhum restaurante selecionado.");
}

// Restante do arquivo cardapio.php...


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <!-- Adicione seus estilos e scripts aqui -->
</head>
<body>
    <h1>Cardápio</h1>

    <?php foreach ($pratos as $prato) { ?>
        <div>
            <h2><?php echo $prato["nome"]; ?></h2>
            <p><?php echo $prato["descricao"]; ?></p>
            <p>Preço: <?php echo $prato["preco"]; ?></p>
            <p>Categoria: <?php echo $prato["categoria"]; ?></p>
            <?php if ($prato["imagem"] !== null) { ?>
                <img src="<?php echo $prato["imagem"]; ?>" alt="<?php echo $prato["nome"]; ?>">
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>
