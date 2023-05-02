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
        <p><strong>Nome:</strong>
            <?php echo $restaurante['nome']; ?>
        </p>
        <p><strong>Email:</strong>
            <?php echo $restaurante['email']; ?>
        </p>
    </section>

    <section>
        <h2>Cardápios</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarPratoModal">
            + Adicionar Prato
        </button>
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


    <!-- Modal Adicionar Prato -->
    <div class="modal fade" id="adicionarPratoModal" tabindex="-1" aria-labelledby="adicionarPratoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adicionarPratoModalLabel">Adicionar Prato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="adicionar_prato_action.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem (opcional)</label>
                            <input type="file" class="form-control" id="imagem" name="imagem">
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço</label>
                            <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="entrada">Entrada</option>
                                <option value="petiscos">Petiscos</option>
                                <option value="pratos principais">Pratos Principais</option>
                                <option value="bebidas">Bebidas</option>
                                <option value="sobremesas">Sobremesas</option>
                                <option value="carta de vinhos">Carta de Vinhos</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Adicionar Prato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>