new Vue({
    el: '#app',
    data: {
        nome: '',
        cpf: '',
        email: '',
        cep: '',
        endereco: '',
        numero: '',
        bairro: '',
        cidade: '',
        estado: '',
        mensagem: ''
    },
    created() {
        // Verifica se o parâmetro 'id' está presente na URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        if (id) {
            axios.get(`../controller/clienteController.php?id=${id}`)
                    .then(response => {
                        const cliente = response.data.clientes[0];
                        this.nome = cliente.nome;
                        this.cpf = cliente.cpf;
                        this.email = cliente.email;
                        this.cep = cliente.cep;
                        this.endereco = cliente.endereco;
                        this.numero = cliente.numero;
                        this.bairro = cliente.bairro;
                        this.cidade = cliente.cidade;
                        this.estado = cliente.estado;
                    })
                    .catch(error => {
                        console.error('Erro ao obter os dados do cliente:', error);
                    });
        }
    },
    methods: {
        submitForm() {

            if (!this.validarCPF(this.cpf)) {
                this.mensagem = 'CPF inválido!';
                return;
            }

            if (!this.validarEmail(this.email)) {
                this.mensagem = 'Email inválido!';
                return;
            }

            // Determinar se a requisição deve ser um POST ou PUT
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            const metodo = id ? 'PUT' : 'POST';

            // Enviar a requisição
            axios({
                method: metodo,
                url: id ? '../controller/clienteController.php?id=${id}' : '../controller/clienteController.php',
                data: {
                    nome: this.nome,
                    cpf: this.cpf,
                    email: this.email,
                    cep: this.cep,
                    endereco: this.endereco,
                    numero: this.numero,
                    bairro: this.bairro,
                    cidade: this.cidade,
                    estado: this.estado
                }
            })
                    .then(response => {

                        if (response.status === 200) {

                            this.nome = '';
                            this.cpf = '';
                            this.email = '';
                            this.cep = '';
                            this.endereco = '';
                            this.numero = '';
                            this.bairro = '';
                            this.cidade = '';
                            this.estado = '';

                            window.location.href = "cliente.php";
                        } else {
                            this.mensagem = 'Erro ao cadastrar cliente.';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        if (error.response.status === 400) {
                            this.mensagem = error.response.data.mensagem;
                        } else {
                            this.mensagem = 'Erro ao cadastrar cliente.';
                        }
                    });
        },
        validarCPF(cpf) {
            // Remove caracteres não numéricos
            cpf = cpf.replace(/[^\d]+/g, '');

            // Verifica se o CPF tem 11 dígitos
            if (cpf.length !== 11) {
                return false;
            }

            // Verifica se todos os dígitos são iguais
            if (/^(\d)\1+$/.test(cpf)) {
                return false;
            }

            // Calcula o primeiro dígito verificador
            let soma = 0;
            for (let i = 0; i < 9; i++) {
                soma += parseInt(cpf.charAt(i)) * (10 - i);
            }
            let resto = 11 - (soma % 11);
            let digitoVerificador1 = (resto === 10 || resto === 11) ? 0 : resto;

            // Verifica se o primeiro dígito verificador está correto
            if (digitoVerificador1 !== parseInt(cpf.charAt(9))) {
                return false;
            }

            // Calcula o segundo dígito verificador
            soma = 0;
            for (let i = 0; i < 10; i++) {
                soma += parseInt(cpf.charAt(i)) * (11 - i);
            }
            resto = 11 - (soma % 11);
            let digitoVerificador2 = (resto === 10 || resto === 11) ? 0 : resto;

            // Verifica se o segundo dígito verificador está correto
            if (digitoVerificador2 !== parseInt(cpf.charAt(10))) {
                return false;
            }
            return true;
        },
        validarEmail(email) {
            // Expressão regular para validar e-mail
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regexEmail.test(email);
        },
        buscarEndereco() {
            axios.get(`https://viacep.com.br/ws/${this.cep}/json/`)
                    .then(response => {
                        this.endereco = response.data.logradouro;
                        this.bairro = response.data.bairro;
                        this.cidade = response.data.localidade;
                        this.estado = response.data.uf;
                    })
                    .catch(error => {
                        console.error(error);
                        this.endereco = '';
                        this.bairro = '';
                        this.cidade = '';
                        this.estado = '';
                    });
        }
    }
});
