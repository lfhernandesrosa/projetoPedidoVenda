<?php
require_once '../template/template_header.php';
require_once '../template/template_menu.php';
?>
<div class="page-title">Clientes</div>
<div class="page-content d-flex justify-content-center">
    <div class="container">
        <div id="app">     
            <div class="text-right mb-3">
                <button class="btn btn-primary" @click="cadastrarCliente">Cadastrar</button>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" v-model="termoBusca" placeholder="Buscar cliente...">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in usuariosFiltrados" :key="index">
                        <td>{{ user.nome }}</td>
                        <td>{{ user.cpf }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.cidade }}</td>
                        <td>{{ user.estado }}</td>
                        <td>
                            <button @click="abrirEdicao(user)" class="btn btn-sm btn-primary">Editar</button>
                            <button @click="excluirUsuario(user.id)" class="btn btn-sm btn-danger">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': paginaAtual === 1 }">
                        <button class="page-link" @click="paginaAnterior">&laquo; Anterior</button>
                    </li>
                    <li v-for="page in totalPaginas" :key="page" class="page-item" :class="{ 'active': paginaAtual === page }">
                        <button class="page-link" @click="irParaPagina(page)">{{ page }}</button>
                    </li>
                    <li class="page-item" :class="{ 'disabled': paginaAtual === totalPaginas }">
                        <button class="page-link" @click="proximaPagina">Próxima &raquo;</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php
require_once '../template/template_footer.php';
?>
<script src="../assets/js/cliente.js"></script>