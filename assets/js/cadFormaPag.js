new Vue({
    el: '#app',
    data: {
        nome: '',
        status: '',
        mensagem: ''
    },
    created() {
        // Verifica se o parâmetro 'id' está presente na URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        if (id) {
            axios.get(`../controller/formaPagController.php?id=${id}`)
                    .then(response => {
                        const fpg = response.data.fpag[0];
                        this.nome = fpg.nome;
                        this.status = fpg.status;
                    })
                    .catch(error => {
                        console.error('Erro ao obter os dados do produto:', error);
                    });
        }
    },
    methods: {
        submitForm() {

            // Determinar se a requisição deve ser um POST ou PUT
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            const metodo = id ? 'PUT' : 'POST';

            axios({
                method: metodo,
                url: id ? `../controller/formaPagController.php?id=${id}` : '../controller/formaPagController.php',
                data: {
                    nome: this.nome,
                    status: this.status
                }
            })
                    .then(response => {

                        if (response.status === 200) {
                            this.nome = '';
                            this.status = '';
                            window.location.href = "forma_pg.php";
                        } else {
                            this.mensagem = 'Erro ao cadastrar forma de pagamento.';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        if (error.response.status === 400) {
                            this.mensagem = error.response.data.mensagem;
                        } else {
                            this.mensagem = 'Erro ao cadastrar forma de pagamento.';
                        }
                    });
        }
    }
});
