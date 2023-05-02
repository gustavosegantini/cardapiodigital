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
                                <?= number_format($prato['preco'], 2, ',', '.') ?>
                            </td>
                            <td class="categoria">
                                <?= $prato['categoria'] ?>
                            </td>
                            <td>
                                <button data-id="<?= $prato['id'] ?>" class="btn-editar"
                                    onclick="editarPrato(event)">Editar</button>

                                <button class="btn btn-danger btn-excluir"
                                    data-prato-id="<?= $prato['id'] ?>">Excluir</button>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>

    </section>

    <!-- Modal Adicionar Prato -->
    <div id="adicionarPratoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5>Adicionar Prato</h5>
            <form action="adicionar_prato_action.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div>
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3"></textarea>
                </div>
                <div>
                    <label for="imagem">Imagem (opcional)</label>
                    <input type="file" id="imagem" name="imagem">
                </div>
                <div>
                    <label for="preco">Preço</label>
                    <input type="number" step="0.01" id="preco" name="preco" required>
                </div>
                <div>
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="entrada">Entrada</option>
                        <option value="petiscos">Petiscos</option>
                        <option value="pratos principais">Pratos Principais</option>
                        <option value="bebidas">Bebidas</option>
                        <option value="sobremesas">Sobremesas</option>
                        <option value="carta de vinhos">Carta de Vinhos</option>
                    </select>
                </div>
                <div>
                    <button type="button"
                        onclick="document.getElementById('adicionarPratoModal').style.display='none'">Fechar</button>
                    <button type="submit">Adicionar Prato</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Prato -->
    <div id="editarPratoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5>Editar Prato</h5>
            <form action="editar_prato_action.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="editarPratoId" name="id">
                <div>
                    <label for="editarPratoNome">Nome</label>
                    <input type="text" id="editarPratoNome" name="nome" required>
                </div>
                <div>
                    <label for="editarPratoDescricao">Descrição</label>
                    <textarea id="editarPratoDescricao" name="descricao" rows="3"></textarea>
                </div>
                <div>
                    <label for="imagem">Imagem (opcional)</label>
                    <input type="file" id="imagem" name="imagem">
                </div>
                <div>
                    <label for="editarPratoPreco">Preço</label>
                    <input type="number" step="0.01" id="editarPratoPreco" name="preco" required>
                </div>
                <div>
                    <label for="editarPratoCategoria">Categoria</label>
                    <select id="editarPratoCategoria" name="categoria" required>
                        <option value="entrada">Entrada</option>
                        <option value="petiscos">Petiscos</option>
                        <option value="pratos principais">Pratos Principais</option>
                        <option value="bebidas">Bebidas</option>
                        <option value="sobremesas">Sobremesas</option>
                        <option value="carta de vinhos">Carta de Vinhos</option>
                    </select>
                </div>
                <div>
                    <button type="button"
                        onclick="document.getElementById('editarPratoModal').style.display='none'">Fechar</button>
                    <button type="submit">Salvar Prato</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Pega o modal
        var modal = document.getElementById("adicionarPratoModal");

        // Pega o botão que abre o modal
        var btn = document.getElementById("adicionarPratoBtn");

        // Pega o elemento <span> que fecha o modal
        var span = document.getElementsByClassName("close")[0];

        // Quando o usuário clicar no botão, abra o modal
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // Quando o usuário clicar no <span> (x), feche o modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // Quando o usuário clicar em qualquer lugar fora do modal, feche-o
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            } else if (event.target == editarPratoModal) {
                editarPratoModal.style.display = "none";
            }
        }


        function editarPrato(event) {
            var pratoId = event.target.dataset.id;
            var pratoRow = event.target.closest('tr');
            var nome = pratoRow.querySelector('.nome').textContent.trim();
            var descricao = pratoRow.querySelector('.descricao').textContent.trim();
            var preco = parseFloat(pratoRow.querySelector('.preco').textContent.replace('.', '').replace(',', '.'));
            var categoria = pratoRow.querySelector('.categoria').textContent.trim();

            // Atualize os campos do formulário no modal "Editar Prato"
            document.getElementById('editarPratoId').value = pratoId;
            document.getElementById('editarPratoNome').value = nome;
            document.getElementById('editarPratoDescricao').value = descricao;
            document.getElementById('editarPratoPreco').value = preco;
            document.getElementById('editarPratoCategoria').value = categoria;

            // Abra o modal "Editar Prato"
            var editarPratoModal = document.getElementById("editarPratoModal");
            editarPratoModal.style.display = "block";
        }

        function excluirPrato(pratoId) {
            if (confirm("Deseja realmente excluir este prato?")) {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "excluir_prato_action.php");

                var idField = document.createElement("input");
                idField.setAttribute("type", "hidden");
                idField.setAttribute("name", "id");
                idField.setAttribute("value", pratoId);
                form.appendChild(idField);

                document.body.appendChild(form);
                form.submit();
            }
        }

        document.querySelectorAll(".btn-excluir").forEach(function (btn) {
            btn.addEventListener("click", function () {
                excluirPrato(this.dataset.pratoId);
            });
        });




        function salvarPrato() {
            var pratoId = document.getElementById('prato-form').getAttribute('data-id');
            var nome = document.getElementById('nome').value;
            var descricao = document.getElementById('descricao').value;
            var preco = document.getElementById('preco').value;
            var categoria = document.getElementById('categoria').value;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };

            if (pratoId) { // Editar prato existente
                xhttp.open("POST", "editar_prato_action.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id=" + pratoId + "&nome=" + nome + "&descricao=" + descricao + "&preco=" + preco + "&categoria=" + categoria);
            } else { // Adicionar novo prato
                xhttp.open("POST", "adicionar_prato_action.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("nome=" + nome + "&descricao=" + descricao + "&preco=" + preco + "&categoria=" + categoria);
            }
        }


    </script>

</body>

</html>