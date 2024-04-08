<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Cadastro de Cliente</div>
<div class="page-content">
    <div class="container">
        <div id="app" class="row">
            <div class="text-right mb-3">
                <button class="btn btn-secondary" onclick="goBack()">Voltar</button>
            </div>
            <div v-if="mensagem" class="message">{{ mensagem }}</div>
            <div class="col-md-12 form-column">
                <form @submit.prevent="submitForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" v-model="nome" id="nome" class="form-input" placeholder="Nome" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf" class="form-label">CPF:</label>
                                <input type="text" v-model="cpf" id="cpf" class="form-input" placeholder="CPF" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" v-model="email" id="email" class="form-input" placeholder="Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cep" class="form-label">CEP:</label>
                                <input type="text" v-model="cep" id="cep" class="form-input" placeholder="CEP" required @blur="buscarEndereco">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="endereco" class="form-label">Endereço:</label>
                                <input type="text" v-model="endereco" id="endereco" class="form-input" placeholder="Endereço" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero" class="form-label">Número:</label>
                                <input type="text" v-model="numero" id="numero" class="form-input" placeholder="Número" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bairro" class="form-label">Bairro:</label>
                                <input type="text" v-model="bairro" id="bairro" class="form-input" placeholder="Bairro" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cidade" class="form-label">Cidade:</label>
                                <input type="text" v-model="cidade" id="cidade" class="form-input" placeholder="Cidade" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado:</label>
                                <input type="text" v-model="estado" id="estado" class="form-input" placeholder="Estado" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="form-button">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/template_footer.php';
?>
<script src="../assets/js/cadCliente.js"></script>