// Obter o modal e o botão que abre o modal
var modal = document.getElementById("myModal");
var btn = document.getElementById("btn-criar-cardapio");

// Obter o elemento <span> que fecha o modal
var span = document.getElementsByClassName("close")[0];

// Quando o usuário clicar no botão, abrir o modal
btn.onclick = function() {
    document.getElementById('prato-form').removeAttribute('data-id');
    document.getElementById('modal-title').textContent = 'Adicionar Prato';
    modal.style.display = "block";
}

// Quando o usuário clicar em <span> (x), fechar o modal
span.onclick = function() {
    modal.style.display = "none";
}

// Quando o usuário clicar fora do modal, fechar o modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function editarPrato(event) {
    var pratoId = event.target.dataset.id;
    var pratoRow = event.target.closest('tr');
    var nome = pratoRow.querySelector('.nome').textContent;
    var descricao = pratoRow.querySelector('.descricao').textContent;
    var preco = pratoRow.querySelector('.preco').textContent;
    var categoria = pratoRow.querySelector('.categoria').textContent;

    document.getElementById('prato-form').setAttribute('data-id', pratoId);
    document.getElementById('nome').value = nome;
    document.getElementById('descricao').value = descricao;
    document.getElementById('preco').value = preco;
    document.getElementById('categoria').value = categoria;

    // Atualizar o título do modal para "Editar Prato"
    document.getElementById('modal-title').textContent = 'Editar Prato';

    modal.style.display = "block";
}
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