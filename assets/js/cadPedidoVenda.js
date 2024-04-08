new Vue({
    el: '#app',
    data: {
        produtos: [],
        clientes: [],
        formasPagamento: [],
        produtoSelecionado: null,
        quantidade: 1,
        itensVenda: [],
        totalVenda: 0,
        clienteSelecionado: null,
        formaPagamentoSelecionada: null
    },
    mounted() {
        // Verifica se há um ID na URL
        const urlParams = new URLSearchParams(window.location.search);
        const pedidoId = urlParams.get('id');
        if (pedidoId) {
            this.carregarDetalhesPedido(pedidoId);
        } else {
            this.carregarProdutos();
            this.carregarClientes();
            this.carregarFormasPagamento();
        }
    },
    methods: {
        carregarDetalhesPedido(pedidoId) {
            axios.get(`../controller/pedidoVendaController.php?id=${pedidoId}`)
                    .then(response => {
                        const pedido = response.data;
                        this.itensVenda = pedido.itensVenda;
                        this.clienteSelecionado = pedido.clientes[0];
                        this.formaPagamentoSelecionada = pedido.fpag[0];
                    })
                    .catch(error => {
                        console.error('Erro ao carregar detalhes do pedido:', error);
                    });
        },
        carregarClientes() {
            axios.get('../controller/clienteController.php')
                    .then(response => {
                        this.clientes = response.data.clientes;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar clientes:', error);
                    });
        },
        carregarFormasPagamento() {
            axios.get('../controller/formaPagController.php?pedidoVenda=1')
                    .then(response => {
                        this.formasPagamento = response.data.fpag;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar formas de pagamento:', error);
                    });
        },
        carregarProdutos() {
            axios.get('../controller/produtoController.php?pedidoVenda=1')
                    .then(response => {
                        this.produtos = response.data.produtos;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar produtos:', error);
                    });
        },
        adicionarItem() {
            // Verifica se um produto foi selecionado
            if (this.produtoSelecionado) {
                // Converte a quantidade para um número inteiro
                const quantidade = parseInt(this.quantidade);

                // Verifica se a quantidade é um número positivo maior que zero
                if (!isNaN(quantidade) && quantidade > 0) {
                    // Calcula o subtotal do item
                    const subtotal = this.produtoSelecionado.preco * quantidade;

                    // Verifica se a quantidade selecionada não excede o estoque disponível
                    if (quantidade <= this.produtoSelecionado.quantidade) {
                        // Adiciona o item à lista de itens da venda
                        this.itensVenda.push({
                            produto: this.produtoSelecionado,
                            quantidade: quantidade,
                            subtotal: subtotal
                        });

                        // Subtrai a quantidade do estoque do produto
                        this.produtoSelecionado.quantidade -= quantidade;

                        // Calcula o total da venda
                        this.totalVenda += subtotal;

                        // Limpa o campo de produto e quantidade
                        this.produtoSelecionado = null;
                        this.quantidade = 1;

                    } else {
                        alert('Quantidade indisponível em estoque.\n Em nosso estoque consta ' + this.produtoSelecionado.quantidade + ' unidade(s) do produto');
                    }
                } else {
                    alert('Quantidade inválida.\n Insira um número positivo maior que zero.');
                }
            } else {
                alert('Selecione um produto.');
            }
        },
        removerItem(index) {
            // Obtém o item a ser removido
            const itemRemovido = this.itensVenda[index];

            // Remove o item da lista de itens da venda
            this.itensVenda.splice(index, 1);

            // Restaura a quantidade do estoque do produto
            itemRemovido.produto.quantidade += itemRemovido.quantidade;

            // Atualiza o total da venda
            this.totalVenda -= itemRemovido.subtotal;
        },
        finalizarVenda() {
            // Verifica se há itens na venda
            if (this.itensVenda.length === 0) {
                alert('Adicione itens à venda antes de finalizá-la.');
                return;
            }

            // Verifica se um cliente foi selecionado
            if (!this.clienteSelecionado) {
                alert('Selecione um cliente para finalizar a venda.');
                return;
            }

            // Verifica se uma forma de pagamento foi selecionada
            if (!this.formaPagamentoSelecionada) {
                alert('Selecione uma forma de pagamento para finalizar a venda.');
                return;
            }

            // Monta o objeto com os dados da venda
            const venda = {
                itens: this.itensVenda,
                total: this.totalVenda,
                cliente: this.clienteSelecionado,
                formaPagamento: this.formaPagamentoSelecionada
            };

            // Envia a requisição POST para o controlador com os dados da venda
            axios.post('../controller/pedidoVendaController.php', venda)
                    .then(response => {
                        this.limparDadosVenda();
                        window.location.href = "pedidoVenda.php";
                    })
                    .catch(error => {
                        alert('Erro ao finalizar a venda. Por favor, tente novamente.');
                    });
        },
        // Método para limpar os dados da venda após a finalização
        limparDadosVenda() {
            this.itensVenda = [];
            this.totalVenda = 0;
            this.clienteSelecionado = null;
            this.formaPagamentoSelecionada = null;
        }
    }
});
 