









<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4GmPkkD/0/1jMNKx" crossorigin="anonymous">
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

    $categorias = obterCategorias();

    function obterCategorias()
    {
        $conn = conectarBD();
        $sql = "SELECT * FROM categorias";
        $result = $conn->query($sql);
        $categorias = array();

        while ($categoria = $result->fetch_assoc()) {
            $categorias[] = $categoria;
        }

        $conn->close();
        return $categorias;
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
        <h2>Pratos</h2>
        <button id="adicionarPratoBtn">+ Adicionar Prato</button>

        <?php
        // Busca pratos do restaurante
        $conn = conectarBD();
        $sql = "SELECT * FROM pratos WHERE restaurante_id = $restaurante_id";
        $result_pratos = $conn->query($sql);
        $conn->close();
        ?>

        <div class="pratos">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($prato = $result_pratos->fetch_assoc()): ?>
                        <tr>
                            <td class="nome">
                                <?= $prato['nome'] ?>
                            </td>
                            <td class="descricao">

                                <?= $prato['descricao'] ?>
                            </td>
                            <td class="preco">
                                <?= $prato['preco'] ?>
                            </td>
                            <td class="categoria">
                                <?php
                                foreach ($categorias as $categoria) {
                                    if ($categoria['id'] == $prato['categoria_id']) {
                                        echo $categoria['nome'];
                                        break;
                                    }
                                }
                                ?>
                            </td>
                            <td class="acoes">
                                <button class="btn btn-warning btn-sm editarPratoBtn">Editar</button>
                                <button class="btn btn-danger btn-sm excluirPratoBtn">Excluir</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4GmPkkD/0/1jMNKx"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-Lx6D5U6NfpF5hA8Rf+1j9/154qz3k6aJhDq5mRAA5ua6pLYeVM9WtIK0r9zj5U77"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-s7YuIpjbl6Qtdidq3avCvI9dS8Td8nJ59S6GpU6NdbU6+8U6BjRrjxGga6CgDZM0"
        crossorigin="anonymous"></script>
    <script src="js/dashboard.js"></script> <!-- Adicione seu arquivo de script JavaScript aqui -->