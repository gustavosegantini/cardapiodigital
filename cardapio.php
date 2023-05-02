<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../conect.php';

function obterPratos($restaurante_id)
{
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
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio_style.css">
    <title>Cardápio</title>
</head>

<body>
    <div class="container">
        <h1>Cardápio</h1>
        <div class="row">
            <?php foreach ($pratos as $prato): ?>
                <div class="card">
                    <?php if ($prato['imagem']): ?>
                        <img src="<?php echo $prato['imagem']; ?>" alt="<?php echo htmlspecialchars($prato['nome']); ?>">
                    <?php endif; ?>
                    <h2 class="card-title">
                        <?php echo htmlspecialchars($prato['nome']); ?>
                    </h2>
                    <p class="card-text">
                        <?php echo htmlspecialchars($prato['descricao']); ?>
                    </p>
                    <p class="card-text">Preço: R$
                        <?php echo number_format($prato['preco'], 2, ',', '.'); ?>
                    </p>
                    <p class="card-text">Categoria:
                        <?php echo htmlspecialchars($prato['categoria']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>