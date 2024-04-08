new Vue({
    el: '#app',
    data: {
        vendas: [],
        paginaAtual: 1,
        totalPaginas: 1,
        vendasPorPagina: 5,
        termoBusca: ''
    },
    created() {
        this.carregarVendas();
    },
    methods: {
        carregarVendas() {
            axios.get('../controller/pedidoVendaController.php', {
                params: {
                    pagina: this.paginaAtual,
                    vendasPorPagina: this.vendasPorPagina
                }
            })
                    .then(response => {
                        this.vendas = response.data.vendas;
                        this.totalPaginas = response.data.totalPaginas;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar vendas: ', error);
                    });
        },
        cadastrarPedido() {
            window.location.href = "cad_pedidoVenda.php";
        },
        paginaAnterior() {
            if (this.paginaAtual > 1) {
                this.paginaAtual--;
                this.carregarVendas();
            }
        },
        proximaPagina() {
            if (this.paginaAtual < this.totalPaginas) {
                this.paginaAtual++;
                this.carregarVendas();
            }
        },
        irParaPagina(page) {
            this.paginaAtual = page;
            this.carregarVendas();
        },
        abrirVisual(prod) {
            window.location.href = `ver_pedidoVenda.php?id=${prod.id}`;
        },
        excluirProduto(id) {
            if (confirm("Tem certeza que deseja excluir esta venda?")) {
                axios.delete(`../controller/pedidoVendaController.php?id=${id}`)
                        .then(response => {
                            this.carregarVendas();
                        })
                        .catch(error => {
                            console.error('Erro ao excluir venda: ', error);
                        });
            }
        }
    },
    computed: {
        vendasFiltrados() {
            if (!this.termoBusca) {
                return this.vendas;
            }
            const termo = this.termoBusca.toLowerCase();
            return this.vendas.filter(vendas =>
                (vendas.nomeCli && vendas.nomeCli.toLowerCase().includes(termo)) ||
                        (vendas.id && vendas.id.toLowerCase().includes(termo)) ||
                        (vendas.nomeProd && vendas.nomeProd.toLowerCase().includes(termo)) ||
                        (vendas.nomeForma && vendas.nomeForma.toLowerCase().includes(termo))
            );
        }
    }

});
