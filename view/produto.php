<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Produtos</div>
<div class="page-content d-flex justify-content-center">
    <div class="container">
        <div id="app">     
            <div class="text-right mb-3">
                <button class="btn btn-primary" @click="cadastrarProduto">Cadastrar</button>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" v-model="termoBusca" placeholder="Buscar produto...">
            </div>            
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(prod, index) in produtosFiltrados" :key="index">
                        <td>{{ prod.nome }}</td>
                        <td>{{ prod.quantidade }}</td>
                        <td>R$ {{ formatarPreco(prod.preco) }}</td>
                        <td>{{ prod.status == 1 ? 'Ativo' : 'Inativo' }}</td>
                        <td>
                            <button @click="abrirEdicao(prod)" class="btn btn-sm btn-primary">Editar</button>
                            <button @click="excluirProduto(prod.id)" class="btn btn-sm btn-danger">Excluir</button>
                        </td>
                    </tr>
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
<script src="../assets/js/produto.js"></script>