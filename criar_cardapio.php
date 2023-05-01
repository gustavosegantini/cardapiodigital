<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Cardápio</title>
    <link rel="stylesheet" href="path/to/your/css/colors.css">
    <link rel="stylesheet" href="path/to/your/css/cadastro_style.css">
    <link rel="stylesheet" href="css/criar_cardapio_style.css">
    <!-- Adicione o caminho correto para seus arquivos CSS -->
</head>

<body>
    <div class="container">
        <h1>Criar Cardápio</h1>
        <form action="criar_cardapio_action.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome do Cardápio:</label>
                <input type="text" name="nome" id="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição do Cardápio (opcional):</label>
                <textarea name="descricao" id="descricao"></textarea>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem do Cardápio (opcional):</label>
                <input type="file" name="imagem" id="imagem">
            </div>
            <input type="submit" value="Criar Cardápio">
        </form>
    </div>
</body>

</html>