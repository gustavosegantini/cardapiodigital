<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Restaurante</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/dashboard_style.css"> <!-- Adicione seu arquivo de estilo CSS aqui -->
</head>
<body>
    <h1>Dashboard Restaurante</h1>

    <?php
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION["restaurante_id"])) {
        header("Location: login_restaurante.php");
        exit();
    }

    require_once '../conect.php';
    $conn = conectarBD();

    // Busca informações do restaurante
    $restaurante_id = $_SESSION["restaurante_id"];
    $sql = "SELECT * FROM restaurantes WHERE id = $restaurante_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $restaurante = $result->fetch_assoc();
    } else {
        echo "Restaurante não encontrado!";
        exit();
    }

    // Busca cardápios do restaurante
    $sql = "SELECT * FROM cardapios WHERE restaurante_id = $restaurante_id";
    $result = $conn->query($sql);

    $cardapios = [];
    while ($row = $result->fetch_assoc()) {
        $cardapios[] = $row;
    }

    $conn->close();
    ?>

    <section>
        <h2>Informações da Conta</h2>
        <p><strong>Nome:</strong> <?php echo $restaurante['nome']; ?></p>
        <p><strong>Email:</strong> <?php echo $restaurante['email']; ?></p>
    </section>

    <section>
        <h2>Cardápios</h2>
        <ul>
            <?php
            if (count($cardapios) > 0) {
                foreach ($cardapios as $cardapio) {
                    echo "<li>" . $cardapio['nome'] . "</li>";
                }
            } else {
                echo "<p>Nenhum cardápio encontrado.</p>";
            }
            ?>
        </ul>
    </section>
</body>
</html>
