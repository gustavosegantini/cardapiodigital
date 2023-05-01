<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Cardápio</title>
    <link rel="stylesheet" href="path/to/your/css/criar_cardapio_style.css">
</head>
<body>
    <div class="container">
        <h1>Criar Cardápio</h1>
        <form action="criar_cardapio_action.php" method="post">
            <div class="form-group">
                <label for="titulo">Título do Cardápio:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>
            <input type="submit" value="Criar Cardápio">
        </form>
    </div>
</body>
</html>
