<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Bem vindo, <?php echo $_SESSION['nome']; ?>!</div>
<div class="page-content">
    <div class="container">
        <h2>O Projeto</h2>
        <p>Nesta aplicação você poderá:</p>
        <ul>
            <li>Cadastrar Clientes</li>
            <li>Cadastrar Produto</li>
            <li>Cadastrar Forma de pagamento</li>
            <li>Realizar Pedido de Venda</li>
        </ul>
        <div>Utilizando as tecnologias, Vue.js, PHP e banco de dados MySQL</div>
    </div>
</div>
<?php
require_once '../template/template_footer.php';
?>

