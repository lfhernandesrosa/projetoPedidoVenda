<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login de Acesso</title>
        <link rel="stylesheet" href="template/css/login_style.css">
    </head>
    <body>
        <div id="app">
            <h1>Login de Acesso</h1>
            <form @submit.prevent="login" method="post">
                <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
                <label for="username">Usuário:</label><br>
                <input type="text" id="username" name="username" v-model="username" required>
                <label for="password">Senha:</label><br>
                <input type="password" id="password" name="password" v-model="password" required>
                <button type="submit">Entrar</button>
            </form>
            <div>
                <button @click="cadastro" class="grey-button">Fazer Cadastro</button>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>    
        <script src="assets/js/login.js"></script>
    </body>
</html>