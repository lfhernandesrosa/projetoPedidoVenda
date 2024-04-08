<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Pedido de Venda</div>
<div class="page-content">
    <div class="container">
        <div id="app">
            <div class="row">
                <div class="text-right mb-3">
                    <button class="btn btn-secondary" onclick="goBack()">Voltar</button>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cliente">Selecione o Cliente:</label>
                        <select v-model="clienteSelecionado" class="form-control">
                            <option v-for="cliente in clientes" :key="cliente.id" :value="cliente">{{ cliente.nome }}</option>
                        </select>
                        <div class="form-group" v-if="clienteSelecionado">
                            <p>CPF: {{ clienteSelecionado.cpf }}</p>
                            <p>E-mail: {{ clienteSelecionado.email }}</p>
                            <p>Endereço: {{ clienteSelecionado.endereco }}, {{ clienteSelecionado.numero }} - {{ clienteSelecionado.bairro }} - {{ clienteSelecionado.cidade }} - {{ clienteSelecionado.estado }} - CEP: {{ clienteSelecionado.cep }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="formaPagamento">Selecione a Forma de Pagamento:</label>
                        <select v-model="formaPagamentoSelecionada" class="form-control">
                            <option v-for="formaPagamento in formasPagamento" :key="formaPagamento" :value="formaPagamento.id">{{ formaPagamento.nome }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">                    
                    <div class="form-group">
                        <label for="produto">Selecione o Produto:</label>
                        <select v-model="produtoSelecionado" class="form-control">                           
                            <option v-for="produto in produtos" :key="produto.id" :value="produto">{{ produto.nome }} - R$ {{ formatarPreco(produto.preco) }}</option>
                        </select>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" v-model="quantidade" class="form-control">
                    </div>
                    <div class="form-group">
                        <button @click="adicionarItem()" class="btn btn-primary">Adicionar Produto</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" v-if="itensVenda.length > 0">
                    <hr>
                    <h2>Itens da Venda:</h2>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(item, index) in itensVenda" :key="index">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-75">
                                    <strong>{{ item.produto.nome }}</strong><br>
                                    <span>Quantidade: {{ item.quantidade }}</span><br>
                                    <span>Subtotal: R$ {{ formatarPreco(item.subtotal) }}</span>
                                </div>
                                <button @click="removerItem(index)" class="btn btn-danger btn-sm">Remover</button>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <div class="fpedido">
                        <h2 class="mt-4">Total do Pedido: R$ {{ formatarPreco(totalVenda) }} </h2>
                        <button @click="finalizarVenda()" class="btn btn-success mt-2 ml-auto">Finalizar Venda</button>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/template_footer.php';
?>
<script src="../assets/js/cadPedidoVenda.js"></script>