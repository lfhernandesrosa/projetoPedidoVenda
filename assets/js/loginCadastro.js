new Vue({
    el: '#app',
    data: {
        nome: '',
        username: '',
        password: '',
        parametro: '',
        mensagem: '',
        errorMessage: ''
    },
    methods: {
        cadastrarUsuario() {
            axios.post('controller/loginController.php', {
                nome: this.nome,
                username: this.username,
                password: this.password,
                parametro: '1'
            })
                    .then(response => {

                        if (response.data.success) {

                            this.nome = '';
                            this.username = '';
                            this.password = '';

                            this.mensagem = 'Usuário cadastrado com sucesso!';
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 3000);
                        } else {

                            this.errorMessage = response.data.message;
                        }
                    })
                    .catch(error => {
                        this.errorMessage = 'Ocorreu um erro ao cadastrar o usuário.';
                    });
        }
    }
});