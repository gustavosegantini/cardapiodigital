<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'conect.php';

function obterPratos($restaurante_id)
{
    $conn = conectarBD();
    $sql = "SELECT * FROM pratos WHERE restaurante_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurante_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $pratos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pratos[] = $row;
        }
    }

    $stmt->close();
    $conn->close();

    return $pratos;
}


$pratos = obterPratos();
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <!-- Inclua aqui o link para o CSS e qualquer outro recurso de estilo que você desejar -->
</head>

<body>
    <h1>Cardápio</h1>
    <div id="cardapio-container">
        <?php foreach ($pratos as $prato): ?>
            <div class="prato">
                <h2>
                    <?= $prato['nome'] ?>
                </h2>
                <p>
                    <?= $prato['descricao'] ?>
                </p>
                <p>R$
                    <?= number_format($prato['preco'], 2, ',', '.') ?>
                </p>
                <p>Categoria:
                    <?= $prato['categoria'] ?>
                </p>
            </div>
        <?php endforeach; ?>

        <!-- Aqui vamos exibir os pratos do cardápio -->
    </div>
    <!-- Inclua aqui o link para o JavaScript e qualquer outro recurso de script que você desejar -->
</body>

</html>