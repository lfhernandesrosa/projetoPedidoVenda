new Vue({
    el: '#app',
    data: {
        nome: '',
        quantidade: '',
        preco: '',
        status: '',
        mensagem: ''
    },
    created() {
        // Verifica se o parâmetro 'id' está presente na URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        if (id) {
            axios.get(`../controller/produtoController.php?id=${id}`)
                    .then(response => {
                        const prod = response.data.produtos[0];
                        this.nome = prod.nome;
                        this.quantidade = prod.quantidade;
                        this.preco = prod.preco;
                        this.status = prod.status;
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

            // Enviar a requisição
            axios({
                method: metodo,
                url: id ? `../controller/produtoController.php?id=${id}` : '../controller/produtoController.php',
                data: {
                    nome: this.nome,
                    quantidade: this.quantidade,
                    preco: this.preco,
                    status: this.status
                }
            })
                    .then(response => {

                        if (response.status === 200) {
                            this.nome = '';
                            this.quantidade = '';
                            this.preco = '';
                            this.status = '';
                            window.location.href = "produto.php";
                        } else {
                            this.mensagem = 'Erro ao cadastrar produto.';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        if (error.response.status === 400) {
                            this.mensagem = error.response.data.mensagem;
                        } else {
                            this.mensagem = 'Erro ao cadastrar produto.';
                        }
                    });
        }
    }
});
