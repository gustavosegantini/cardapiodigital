<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Restaurante</title>
    <link rel="stylesheet" href="css/estilo.css"> <!-- Adicione seu arquivo de estilo CSS aqui -->
</head>
<body>
    <h1>Cadastro de Restaurante</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once '../conect.php';

        $conn = conectarBD();

        $nome = $conn->real_escape_string($_POST['nome']);
        $email = $conn->real_escape_string($_POST['email']);
        $senha = $conn->real_escape_string($_POST['senha']);
        $telefone = $conn->real_escape_string($_POST['telefone']);
        $endereco = $conn->real_escape_string($_POST['endereco']);

        // Criptografe a senha antes de armazená-la no banco de dados
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO restaurantes (nome, email, senha, telefone, endereco) VALUES ('$nome', '$email', '$senha_criptografada', '$telefone', '$endereco')";

        if ($conn->query($sql) === TRUE) {
            echo "Restaurante cadastrado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco">

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
