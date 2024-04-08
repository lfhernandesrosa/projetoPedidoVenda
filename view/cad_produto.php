<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Cadastro de Produto</div>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" v-model="nome" id="nome" class="form-input" placeholder="Nome" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="quantidade" class="form-label">Quantidade:</label>
                                <input type="text" v-model="quantidade" id="quantidade" class="form-input" placeholder="Quantidade" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="preco" class="form-label">Valor:</label>
                                <input type="preco" v-model="preco" id="preco" class="form-input" placeholder="Preço" required v-mask="'#.##0,00'">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status" class="form-label">Status:</label>
                                <select v-model="status" id="status" class="form-input" required>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
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
<script src="../assets/js/cadProduto.js"></script>