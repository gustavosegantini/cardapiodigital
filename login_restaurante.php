<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Restaurante</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/login_style.css"> <!-- Adicione seu arquivo de estilo CSS aqui -->
</head>
<body>
    <h1>Login Restaurante</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once '../conect.php';

        $conn = conectarBD();

        $email = $conn->real_escape_string($_POST['email']);
        $senha = $conn->real_escape_string($_POST['senha']);

        $sql = "SELECT id, senha FROM restaurantes WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($senha, $row['senha'])) {
                echo "Login realizado com sucesso!";
                // Inicie a sessão e armazene o ID do restaurante na variável de sessão
                session_start();
                $_SESSION["restaurante_id"] = $row['id'];
                
                // Redirecione para a página inicial do restaurante (substitua "dashboard.php" pelo nome da sua página inicial)
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Email não encontrado!";
        }

        $conn->close();
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <input type="submit" value="Login">
    </form>
</body>
</html>
