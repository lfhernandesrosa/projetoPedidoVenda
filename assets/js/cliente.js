new Vue({
    el: '#app',
    data: {
        usuarios: [],
        paginaAtual: 1,
        totalPaginas: 1,
        usuariosPorPagina: 5,
        termoBusca: ''
    },
    created() {
        this.carregarUsuarios();
    },
    methods: {
        carregarUsuarios() {
            axios.get('../controller/clienteController.php', {
                params: {
                    pagina: this.paginaAtual,
                    usuariosPorPagina: this.usuariosPorPagina
                }
            })
                    .then(response => {
                        this.usuarios = response.data.clientes;
                        this.totalPaginas = response.data.totalPaginas;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar cliente: ', error);
                    });
        },
        cadastrarCliente() {
            window.location.href = "cad_Cliente.php";
        },
        paginaAnterior() {
            if (this.paginaAtual > 1) {
                this.paginaAtual--;
                this.carregarUsuarios();
            }
        },
        proximaPagina() {
            if (this.paginaAtual < this.totalPaginas) {
                this.paginaAtual++;
                this.carregarUsuarios();
            }
        },
        irParaPagina(page) {
            this.paginaAtual = page;
            this.carregarUsuarios();
        },
        abrirEdicao(usuario) {
            window.location.href = `cad_cliente.php?id=${usuario.id}`;
        },
        excluirUsuario(id) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                axios.delete(`../controller/clienteController.php?id=${id}`)
                        .then(response => {
                            this.carregarUsuarios();
                        })
                        .catch(error => {
                            if (error.response && error.response.data && error.response.data.mensagem) {
                                alert(error.response.data.mensagem);
                            } else {
                                alert('Erro ao excluir usuário. Por favor, tente novamente.');
                            }
                        });
            }
        }
    },
    computed: {
        usuariosFiltrados() {
            if (!this.termoBusca) {
                return this.usuarios;
            }
            const termo = this.termoBusca.toLowerCase();
            return this.usuarios.filter(user =>
                (user.nome && user.nome.toLowerCase().includes(termo)) ||
                        (user.email && user.email.toLowerCase().includes(termo)) ||
                        (user.cpf && user.cpf.includes(termo)) ||
                        (user.cidade && user.cidade.toLowerCase().includes(termo))
            );
        }
    }

});
