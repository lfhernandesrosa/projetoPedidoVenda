<?php

require_once '../dbase/conection.php';
require_once '../util/str.php';

class pedidoVenda {

    private $id;
    private $idCliente;
    private $idProduto;
    private $idFormaPg;
    private $quantidade;
    private $valor;
    private $total;
    private $data;
    private $pedido;
    private $sessao;

    function getId() {
        return $this->id;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdProduto() {
        return $this->idProduto;
    }

    function getIdFormaPg() {
        return $this->idFormaPg;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getValor() {
        return $this->valor;
    }

    function getTotal() {
        return $this->total;
    }

    function getData() {
        return $this->data;
    }

    function getPedido() {
        return $this->pedido;
    }

    function getSessao() {
        return $this->sessao;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setIdCliente($idCliente): void {
        $this->idCliente = $idCliente;
    }

    function setIdProduto($idProduto): void {
        $this->idProduto = $idProduto;
    }

    function setIdFormaPg($idFormaPg): void {
        $this->idFormaPg = $idFormaPg;
    }

    function setQuantidade($quantidade): void {
        $this->quantidade = $quantidade;
    }

    function setValor($valor): void {
        $this->valor = $valor;
    }

    function setTotal($total): void {
        $this->total = $total;
    }

    function setData($data): void {
        $this->data = $data;
    }

    function setPedido($pedido): void {
        $this->pedido = $pedido;
    }

    function setSessao($sessao): void {
        $this->sessao = $sessao;
    }

    public function ListaVendasByGet(int $offset, int $vendasPorPagina) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT V.id, 
                                      V.n_pedido, 
                                      C.nome AS nomeCli, 
                                      F.nome AS nomeForma, 
                                      DATE_FORMAT(data, '%d/%m/%Y') AS data,                                       
                                      SUM(V.quantidade * valor) AS total,
                                      D.nome AS nomePRO,
                                      V.quantidade AS qtdPro,
                                      V.valor AS valorPro,
                                      V.total AS totalPro
                                 FROM venda V
                                 LEFT OUTER JOIN cliente C ON (C.id = V.idCliente)
                                 LEFT OUTER JOIN produto D ON (D.id = V.idProduto)
                                 LEFT OUTER JOIN forma_pg F ON (F.id = V.idFormaPg)
                                 GROUP BY V.n_pedido
                                 ORDER BY V.n_pedido DESC                                 
                                 LIMIT :offset, :vendasPorPagina");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':vendasPorPagina', $vendasPorPagina, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        // Contagem total de usuários
        $stmt = $pdo->query("SELECT COUNT(*) FROM venda GROUP BY n_pedido");
        $totalVendas = $stmt->fetchColumn();
        $stmt = null;

        $totalPaginas = ceil($totalVendas / $vendasPorPagina);

        return $result1 = json_encode([
            'vendas' => $result,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function cadastroPedidoVenda($itensVenda, $cliente, $formaPagamento) {

        $this->setIdCliente($cliente);
        $this->setIdFormaPg($formaPagamento);
        $this->setData(date('Y-m-d'));
        $this->setSessao(str::randomToken(40));

        $pdo = dataBase::conexao();

        $stmt = $pdo->prepare("SELECT n_pedido FROM config ");
        $stmt->execute();
        $res_nPedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        $this->setPedido($res_nPedido[0]['n_pedido']);

        $token = $this->getSessao();
        $pedido = $this->getPedido();

        foreach ($itensVenda as $itenVenda) {

            $this->setIdProduto($itenVenda->produto->id);
            $this->setQuantidade(intval($itenVenda->quantidade));
            $this->setValor($itenVenda->produto->preco);
            $this->setTotal($this->getQuantidade() * $this->getValor());

            $clienteId = $this->getIdCliente();
            $produtoId = $this->getIdProduto();
            $formaPagId = $this->getIdFormaPg();
            $quantidade = $this->getQuantidade();
            $valor = $this->getValor();
            $total = $this->getTotal();
            $data = $this->getData();

            $stmt = $pdo->prepare("SELECT quantidade FROM produto WHERE id = :id");
            $stmt->bindParam(':id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            $res_qtd = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;

            $qtd_produto = $res_qtd[0]['quantidade'];

            if ($qtd_produto >= $quantidade) {
                try {

                    $sql = "INSERT INTO venda (n_pedido, IdCliente, idProduto, idFormaPg, quantidade, valor, total, data, sessao) VALUES (:n_pedido, :clienteId, :produtoId, :formaPagId, :quantidade, :valor, :total, :data, :sessao)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':n_pedido', $pedido);
                    $stmt->bindParam(':clienteId', $clienteId);
                    $stmt->bindParam(':produtoId', $produtoId);
                    $stmt->bindParam(':formaPagId', $formaPagId);
                    $stmt->bindParam(':quantidade', $quantidade);
                    $stmt->bindParam(':valor', $valor);
                    $stmt->bindParam(':total', $total);
                    $stmt->bindParam(':data', $data);
                    $stmt->bindParam(':sessao', $token);
                    $stmt->execute();

                    $qtdAtual = $qtd_produto - $quantidade;

                    $sql = "UPDATE produto SET  quantidade = :qtdAtual  WHERE id = :produtoId";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':produtoId', $produtoId);
                    $stmt->bindParam(':qtdAtual', $qtdAtual);
                    $stmt->execute();

                    $novo_pedido = $pedido + 1;
                    $sql = "UPDATE config SET n_pedido = :n_pedido";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':n_pedido', $novo_pedido);
                    $stmt->execute();

                    return json_encode(["success" => true, "message" => "Venda finalizada com sucesso!"]);
                } catch (PDOException $e) {

                    return json_encode(["success" => false, "message" => "Dados da venda não recebidos corretamente." . $e->getMessage()]);
                }
            } else {
                return json_encode(["success" => false, "message" => "Não existe estoque disponível."]);
            }
        }
    }

    public function apagaPedido($id) {

        $this->setId($id);
        $idVenda = $this->getId();

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT n_pedido FROM venda WHERE id = :id");
        $stmt->bindParam(':id', $idVenda, PDO::PARAM_INT);
        $stmt->execute();
        $n_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        $pedido = $n_pedido[0]['n_pedido'];

        $stmt = $pdo->prepare("SELECT id, n_pedido FROM venda WHERE n_pedido = :n_pedido");
        $stmt->bindParam(':n_pedido', $pedido, PDO::PARAM_INT);
        $stmt->execute();
        $n_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        foreach ($n_pedido as $pedido) {

            $idPedido = $pedido['id'];
            $nPedido = $pedido['n_pedido'];

            $stmt = $pdo->prepare("SELECT idProduto, quantidade FROM venda WHERE id = :id AND n_pedido = :n_pedido");
            $stmt->bindParam(':id', $idPedido, PDO::PARAM_INT);
            $stmt->bindParam(':n_pedido', $nPedido, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            $res_qtd = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;

            if ($count > 0) {

                $prod_venda = $res_qtd[0]['idProduto'];
                $qtd_venda = $res_qtd[0]['quantidade'];

                try {

                    $stmt = $pdo->prepare("SELECT quantidade FROM produto WHERE id = :prod_venda");
                    $stmt->bindParam(':prod_venda', $prod_venda, PDO::PARAM_INT);
                    $stmt->execute();
                    $res_prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;

                    $qtd_prod = $res_prod[0]['quantidade'];

                    $qtd_atualizada = $qtd_prod + $qtd_venda;

                    $pdo = dataBase::conexao();
                    $stmt = $pdo->prepare("DELETE FROM venda WHERE id = :id");
                    $stmt->bindParam(':id', $idPedido, PDO::PARAM_INT);
                    $exclusao_sucesso = $stmt->execute();
                    $stmt = null;

                    if ($exclusao_sucesso) {

                        $sql = "UPDATE produto SET  quantidade = :qtdAtual  WHERE id = :produtoId";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':produtoId', $prod_venda);
                        $stmt->bindParam(':qtdAtual', $qtd_atualizada);
                        $stmt->execute();
                    } else {
                        return json_encode(['success' => false, 'message' => 'Não foi possível atualizar o estoque']);
                    }
                } catch (Exception $ex) {
                    return json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            }
        }
    }

    public function VendasById($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id, n_pedido, idCliente, idProduto, idFormaPg, quantidade, valor, total
                                 FROM venda                                 
                                WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        $IdFormaPg = $result[0]['idFormaPg'];
        $IdCliente = $result[0]['idCliente'];
        $Npedido = $result[0]['n_pedido'];


        $stmt = $pdo->prepare("SELECT id, nome, status FROM forma_pg WHERE id = :id");
        $stmt->bindParam(':id', $IdFormaPg, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $fpg = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        $stmt = $pdo->prepare("SELECT id, nome, email, cpf, cep, endereco, numero, bairro, cidade, estado 
                                 FROM cliente                                 
                                WHERE id = :id");
        $stmt->bindParam(':id', $IdCliente, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        $stmt = $pdo->prepare("SELECT P.id, P.n_pedido, P.quantidade, P.valor, P.total, P.data, P.nome, total.total AS total
                                FROM (
                                    SELECT V.id, V.n_pedido, V.quantidade, V.valor, V.total, V.data, P.nome
                                    FROM venda V
                                    LEFT OUTER JOIN produto P ON (P.id = V.idProduto)
                                    WHERE n_pedido = :id
                                ) AS P
                                CROSS JOIN (
                                    SELECT SUM(V.total) AS total
                                    FROM venda V
                                    LEFT OUTER JOIN produto P ON (P.id = V.idProduto)
                                    WHERE n_pedido = :id
                                ) AS total");
        $stmt->bindParam(':id', $Npedido, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return json_encode(['fpag' => $fpg, 'clientes' => $clientes, 'itensVenda' => $produtos]);
    }

}
