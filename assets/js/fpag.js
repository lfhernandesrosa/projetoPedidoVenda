new Vue({
    el: '#app',
    data: {
        fpag: []
    },
    created() {
        this.carregarFpag();
    },
    methods: {
        carregarFpag() {
            axios.get('../controller/formaPagController.php')
                    .then(response => {
                        this.fpag = response.data.fpag;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar forma de pagamento: ', error);
                    });
        },
        
        cadastrarFormaPag() {
            window.location.href = "cad_formaPg.php";
        },
        abrirEdicao(fpag) {
            window.location.href = `cad_formaPg.php?id=${fpag.id}`;
        },
        excluirFPag(id) {
            if (confirm("Tem certeza que deseja excluir esta forma de pagamento?")) {
                axios.delete(`../controller/formaPagController.php?id=${id}`)
                        .then(response => {
                            this.carregarFpag();
                        })
                        .catch(error => {
                            console.error('Erro ao excluir forma de pagamento: ', error);
                        });
            }
        }
    },
    computed: {
        fpagFiltrados() {
            if (!this.termoBusca) {
                return this.fpag;
            }
            const termo = this.termoBusca.toLowerCase();
            return this.fpag.filter(fpag =>
                (fpag.nome && fpag.nome.toLowerCase().includes(termo))
            );
        },
        fpagComDescricao() {
            return this.fpag.map(fpag => {
                fpag.status = fpag.status === 1 ? 'Ativo' : 'Inativo';
                return fpag;
            });
        }
    }

});
