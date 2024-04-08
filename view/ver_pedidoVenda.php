<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Demonstrativo - Pedido de Venda </div>
<div class="page-content">
    <div class="container">
        <div id="app">
            <div class="row">
                <div class="text-right mb-3">
                    <button class="btn btn-secondary" onclick="goBack()">Voltar</button>
                </div>
                <div class="col-md-7">
                    <div class="form-group">    
                        <div class="form-group" v-if="clienteSelecionado">
                            <p><b>Nome:</b> {{ clienteSelecionado.nome }} </p>
                            <p><b>CPF:</b> {{ clienteSelecionado.cpf }}</p>
                            <p><b>E-mail:</b> {{ clienteSelecionado.email }}</p>
                            <p><b>Endereço:</b> {{ clienteSelecionado.endereco }}, {{ clienteSelecionado.numero }} - {{ clienteSelecionado.bairro }} - {{ clienteSelecionado.cidade }} - {{ clienteSelecionado.estado }} - CEP: {{ clienteSelecionado.cep }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">                      
                        <div class="form-group" v-if="formaPagamentoSelecionada">
                            <p><b>Forma de Pagamento:</b> {{ formaPagamentoSelecionada.nome }} </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" v-if="itensVenda.length > 0">
                    <hr>
                    <h2>Pedido {{ addZerosEsquerda(itensVenda[0].n_pedido,5) }}</h2>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(item, index) in itensVenda" :key="index">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-75">
                                    <strong>{{ item.nome }}</strong><br>
                                    <span>Valor: R$ {{ formatarPreco(item.valor) }}</span><br>
                                    <span>Quantidade: {{ item.quantidade }}</span><br>
                                    <span>Subtotal: R$ {{ formatarPreco(item.quantidade * item.valor) }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <div class="fpedido">
                        <h2 class="mt-4">Total: R$ {{ formatarPreco(itensVenda[0].total) }} </h2>                        
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