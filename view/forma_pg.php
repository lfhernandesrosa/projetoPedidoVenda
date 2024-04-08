<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Formas de Pagamentos</div>
<div class="page-content d-flex justify-content-center">
    <div class="container">
        <div id="app">     
            <div class="text-right mb-3 p_right">
                <button class="btn btn-primary" @click="cadastrarFormaPag">Cadastrar</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(fpag, index) in fpagFiltrados" :key="index">
                        <td class="p_left">{{ fpag.nome }}</td>
                        <td>{{ fpag.status == 1 ? 'Ativo' : 'Inativo' }}</td>
                        <td>
                            <button @click="abrirEdicao(fpag)" class="btn btn-sm btn-primary">Editar</button>
                            <button @click="excluirFPag(fpag.id)" class="btn btn-sm btn-danger">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require_once '../template/template_footer.php';
?>
<script src="../assets/js/fpag.js"></script>