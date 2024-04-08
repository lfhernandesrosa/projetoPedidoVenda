<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a href="./" class="navbar-brand">Projeto L.F.H.R</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-menu navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCadastros" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cadastros
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCadastros">
                        <li><a class="dropdown-item" href="cliente.php">Cliente</a></li>
                        <li><a class="dropdown-item" href="produto.php">Produto</a></li>
                        <li><a class="dropdown-item" href="forma_pg.php">Forma de Pagamento</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownVendas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vendas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownVendas">
                        <li><a class="dropdown-item" href="pedidoVenda.php">Pedido de Venda</a></li>
                    </ul>
                </li>
            </ul>
            <button class="btn btn-secondary" onclick="logout()">Sair</button>
        </div>
    </div>
</nav>