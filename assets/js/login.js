new Vue({
    el: '#app',
    data: {
        username: '',
        password: '',
        errorMessage: ''
    },
    methods: {
        login() {
            fetch('controller/loginController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: this.username,
                    password: this.password
                })
            })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redireciona para a página de sucesso após o login
                            window.location.href = 'view/index.php';
                        } else {
                            // Exibe a mensagem de erro retornada pelo backend
                            this.errorMessage = data.message;
                        }
                    })
            console.log(response.json())
                    .catch(error => {
                        this.errorMessage = 'Erro durante o login. Por favor, tente novamente mais tarde.';
                    });
        },
        cadastro() {
            window.location.href = 'cadastroLogin.php';
        }
    }
});
