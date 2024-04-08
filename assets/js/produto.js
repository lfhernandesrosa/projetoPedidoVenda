new Vue({
    el: '#app',
    data: {
        produtos: [],
        paginaAtual: 1,
        totalPaginas: 1,
        produtosPorPagina: 5,
        termoBusca: ''
    },
    created() {
        this.carregarProdutos();
    },
    methods: {
        carregarProdutos() {
            axios.get('../controller/produtoController.php', {
                params: {
                    pagina: this.paginaAtual,
                    produtosPorPagina: this.produtosPorPagina
                }
            })
                    .then(response => {
                        this.produtos = response.data.produtos;
                        this.totalPaginas = response.data.totalPaginas;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar produtos: ', error);
                    });
        },
        cadastrarProduto() {
            window.location.href = "cad_produto.php";
        },
        paginaAnterior() {
            if (this.paginaAtual > 1) {
                this.paginaAtual--;
                this.carregarProdutos();
            }
        },
        proximaPagina() {
            if (this.paginaAtual < this.totalPaginas) {
                this.paginaAtual++;
                this.carregarProdutos();
            }
        },
        irParaPagina(page) {
            this.paginaAtual = page;
            this.carregarProdutos();
        },
        abrirEdicao(prod) {
            window.location.href = `cad_produto.php?id=${prod.id}`;
        },
        excluirProduto(id) {
            // Implementação básica da exclusão
            if (confirm("Tem certeza que deseja excluir este produto?")) {
                axios.delete(`../controller/produtoController.php?id=${id}`)
                        .then(response => {
                            this.carregarProdutos();
                        })
                        .catch(error => {
                            console.error('Erro ao excluir produto: ', error);
                        });
            }
        }
    },
    computed: {
        produtosFiltrados() {
            if (!this.termoBusca) {
                return this.produtos;
            }
            const termo = this.termoBusca.toLowerCase();
            return this.produtos.filter(produtos =>
                (produtos.nome && produtos.nome.toLowerCase().includes(termo))
            );
        }
    }

});
