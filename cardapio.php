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

    $restaurante_id = isset($_GET['restaurante_id']) ? (int) $_GET['restaurante_id'] : 0;
    if ($restaurante_id === 0) {
        // Lidar com o caso em que o ID do restaurante não foi fornecido ou é inválido
        echo "O ID do restaurante não foi fornecido ou é inválido.";
        exit;
    }

    $nome_restaurante = obterNomeRestaurante($restaurante_id);

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

    function obterPratosPorCategoria($restaurante_id, $categoria_id)
    {
        $conn = conectarBD();
        $sql = "SELECT * FROM pratos WHERE restaurante_id = ? AND categoria_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $restaurante_id, $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pratos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();
        return $pratos;
    }

    function obterCategorias()
    {
        $conn = conectarBD();
        $sql = "SELECT * FROM categorias";
        $result = $conn->query($sql);
        $categorias = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $categorias;
    }

    $nome_restaurante = obterNomeRestaurante($restaurante_id);
    $categorias = obterCategorias();
    ?>

    <h1>
        <?php echo $nome_restaurante; ?>
    </h1>

    <div class="card-container">
        <?php
        foreach ($categorias as $categoria) {
            $pratos = obterPratosPorCategoria($restaurante_id, $categoria["id"]);

            if (count($pratos) > 0) {
                echo "<h2>{$categoria['nome']}</h2>";

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