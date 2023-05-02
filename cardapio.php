<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/cardapio_style.css">
</head>

<body>
    <?php
    require_once '../conect.php';

    function obterNomeRestaurante($restaurante_id)
    {
        $conn = conectarBD();
        $sql = "SELECT nome FROM restaurantes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $restaurante_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $stmt->close();
        $conn->close();
        return $nome;
    }

    function obterPratosPorCategoria($restaurante_id, $categoria)
    {
        $conn = conectarBD();
        $sql = "SELECT * FROM pratos WHERE restaurante_id = ? AND categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $restaurante_id, $categoria);
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
    } // Você deve obter o ID do restaurante por outros meios, por exemplo, através de uma URL amigável
    $nome_restaurante = obterNomeRestaurante($restaurante_id);

    $categorias = ["Entradas", "Pratos Principais", "Bebidas", "Sobremesas"]; // Lista de categorias possíveis
    ?>

    <h1>
        <?php echo $nome_restaurante; ?>
    </h1>

    <div class="card-container">
        <?php
        foreach ($categorias as $categoria) {
            $pratos = obterPratosPorCategoria($restaurante_id, $categoria);

            if (count($pratos) > 0) {
                echo "<h2>{$categoria}</h2>";

                foreach ($pratos as $prato) {
                    echo '<div class="card">';
                    if ($prato["imagem"]) {
                        echo '<img class="card-img" src="' . $prato["imagem"] . '" alt="' . $prato["nome"] . '">';
                    }
                    echo '<div class="card-content">';
                    echo '<h3 class="card-text">' . $prato["nome"] . '</h3>';
                    echo '<p class="card-text">' . $prato["descricao"] . '</p>';
                    echo '<p class="card-text">R$ ' . number_format($prato["preco"], 2, ',', '.') . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</body>

</html>