<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Vendas</div>
<div class="page-content d-flex justify-content-center">
    <div class="container">
        <div id="app">     
            <div class="text-right mb-3">
                <button class="btn btn-primary" @click="cadastrarPedido">Novo Pedido</button>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" v-model="termoBusca" placeholder="Buscar cliente...">
            </div> 
            <table class="table">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Forma de Pagamento</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(vendas, index) in vendasFiltrados" :key="index">
                        <td>{{ addZerosEsquerda(vendas.n_pedido,5) }}</td>                        
                        <td>{{ vendas.data }}</td>
                        <td>{{ vendas.nomeCli }}</td>
                        <td>{{ vendas.nomeForma }}</td>               
                        <td> R$ {{ formatarPreco(vendas.total) }}</td>
                        <td>
                            <button @click="abrirVisual(vendas)" class="btn btn-sm btn-primary">Ver Pedido</button>
                            <button @click="excluirProduto(vendas.id)" class="btn btn-sm btn-danger">Excluir</button>
                        </td>
                    </tr>
                <hr>                   
                </tbody>
            </table>      
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': paginaAtual === 1 }">
                        <button class="page-link" @click="paginaAnterior">&laquo; Anterior</button>
                    </li>
                    <li v-for="page in totalPaginas" :key="page" class="page-item" :class="{ 'active': paginaAtual === page }">
                        <button class="page-link" @click="irParaPagina(page)">{{ page }}</button>
                    </li>
                    <li class="page-item" :class="{ 'disabled': paginaAtual === totalPaginas }">
                        <button class="page-link" @click="proximaPagina">Próxima &raquo;</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php
require_once '../template/template_footer.php';
?>
<script src="../assets/js/pedidoVenda.js"></script>