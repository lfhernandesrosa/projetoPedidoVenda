<h2>O Projeto</h2>
        <p>Nesta aplicação você irá encontrar:</p>
        <ul>
            <li>Cadastro de Cliente</li>
            <li>Cadastro de Produto</li>
            <li>Cadastro de Forma de Pagamento</li>
            <li>Realizar Pedido de Venda</li>
        </ul>
        <div>Utilizando as tecnologias, Vue.js, PHP e banco de dados MySQL</div>

# Documentação 

## Instalação
Para o funcionamento da aplicação, basta subir em uma base de dados Mysql o arquivo que se encontra em dbbase -> desafio.sql e alterar as configurações do arquivo dbsae -> config.php

## Estrutura do Projeto
O projeto foi dividido da seguinte forma:
  - Frontend utilizando Vue.js / HTML
  - Backend utilizando PHP 7.2
  - Banco de dados MySQL
  - A dinâmica geral da aplicação consiste no modelo MCV
  - O acesso a aplicação só é possível através de login


### Autenticação de Usuário
Rota: /index.php

Método: POST

Corpo da Solicitação: Objeto JSON contendo username e password

Quando logado o sistema irá redirecionar para a página inicial do sistema na Rota: /view/index.php

### Cadastro de Usuário - Acesso a aplicação
Rota: /cadastroLogin.php

Método: POST

Corpo da Solicitação: Objeto JSON contendo nome, username e password

Após 3 segundos é redirecionado para a página de login para o usuário inserir as credencias cadastradas

### Cliente
Rota: /view/cliente.php

Método: GET

Retorna todos os Clientes cadastrados.

Disponibiliza uma busca da relação de clientes podendo pesquisar através do Nome, CPF, E-mail, Cidade e é disponibilizado os botões:
    - Cadastrar
    - Editar
    - Excluir

#### Cliente - Cadastro

Rota: /view/cad_Cliente.php
Método: POST

Nesta página através do código HTML é requerido todos os campos porém para maior segurança é validada também estas informações no backend.

Foi disponibilizada as validações do campo CPF e E-mail e realizada o consumo da API viacep. Ao inserir a informação no campo CEP todos os campos complementares são preenchidos, sendo:
    - Endereço
    - Bairro
    - Cidade
    - Estado
    
Através do Vue.js (/assets/js/cliente.js) é chamado o backend do tipo controller (../controller/clienteController.php) onde se faz as validações do campo e após validado é chamado o modelo (../model/clienteController.php) para realizar a inserção do cadastro

#### Cliente - Editar
Rota: /view/cad_Cliente.php?id=

Método: PUT

É preenchido todos os campos ocorrendo as mesmas validações e integrações do item cadastro

#### Cliente - Excluir
Rota: /view/cad_Cliente.php

Método: DELETE

É chamado o controller (../controller/clienteController.php?id=) que faz a validação da referência e faz a solicitação para o Modelo.

No modelo é feita uma validação se existe venda para o cliente indicado, se existir o sistema não permite a exclusão.

### Produto
Rota: /view/produto.php

Método: GET

Retorna todos os Produtos cadastrados.

Disponibiliza uma busca dos produtos através do nome dos itens e é disponibilizado os botões:
    - Cadastrar
    - Editar
    - Excluir

#### Produto - Cadastro
Rota: /view/cad_produto.php

Método: POST

Nesta tela édisponibilizado os campos:
    - Nome
    - Quantidade
    - Valor
    - Status
O campo Status é importante caso o usuário deixe a opção como "Inativo" o produto não será listado na opção de produto na tela de pedido de venda assim como o campo Quantidade se o mesmo estiver com o valor 0 não estará disponível no pedido de venda

#### Produto - Editar
Rota: /view/cad_produto.php?id=

Método: PUT

#### Produto - Excluir
Rota: /view/cad_produto.php

Método: DELETE

### Forma de Pagamento
Rota: /view/forma_pg.php

Método: GET

Retorna todas as formas de pagamento cadastradas.

#### Forma de Pagamento - Cadastro
Rota: /view/cad_FormaPg.php

Método: POST

Nesta tela édisponibilizado os campos:
    - Nome
    - Status
    
Caso a opção estiver como inátivo o mesmo não será listado no pedido de venda

#### Forma de Pagamento - Editar
Rota: /view/cad_formaPg.php?id=

Método: PUT

#### Forma de Pagamento - Excluir
Rota: /view/cad_formaPg.php?id=

Método: DELETE

### Pedido de Venda
Rota: /view/pedidoVenda.php

Método: GET

Retorna todos os Pedidos cadastrados.

Disponibiliza uma busca da relação de clientes podendo pesquisar através do Nome e é disponibilizado os botões:
    - Novo Pedido
    - Ver Pedido
    - Excluir

#### Pedido de Venda - Novo Pedido
Rota: /view/cad_pedidoVenda.php

Método: POST

Inicialmente é apresentando os campos:
    - Cliente
    - Forma de Pagamento
    - Produto
    - Quantidade
    
Em cada uma destas opções é realizada uma chamada através do arquivo  "../assets/js/cadPedidoVenda.js" que faz uma solicitação no controller de cada item com sua validação e chamado o modelo para retornar o elenco de opções.

Caso o usuário não informe as informações e clique sobre o botão "Adicionar Produto" o mesmo é informado através de alertas para o seu preenchimento.

Quando o usuário seleciona todas as opções e clica sobre o botão "Adicionar Produto" é exibido em tela os "Itens da Venda" contendo o produto, quantidade escolhida e o subtotal.

O sistema através do vue.js faz a validação do estoque do item e informa ao usuário caso a quantidade desejada do produto não esteja disponível e apresenta a quantidade atual.

Em tela o  usuário poderá excluir o item e com isso o valor total do pedido é recalculado e a quantidade reservada retornada.

Após clicar sobre o botão "Finalizar Venda" é decrementado do estoque do produto.

#### Pedido de Venda - Ver Pedido
Rota: /view/ver_pedidoVenda.php?id=53

Método: GET

É gerado um demonstrativo do pedido

#### Pedido de Venda - Excluir
Rota: /view/pedidoVenda.php?id=53

Método: DELETE

Com a requisição é excluido o pedido e retornado ao estoque a quantidade anterior

