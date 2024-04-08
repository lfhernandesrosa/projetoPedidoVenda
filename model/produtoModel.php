<?php

require_once '../dbase/conection.php';

class produto {

    private $id;
    private $nome;
    private $quantidade;
    private $preco;
    private $status;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getPreco() {
        return $this->preco;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNome($nome): void {
        $this->nome = $nome;
    }

    function setQuantidade($quantidade): void {
        $this->quantidade = $quantidade;
    }

    function setPreco($preco): void {
        $this->preco = $preco;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    public function ListaProdutosByGet(int $offset, int $produtosPorPagina, $listaPedido) {


        $pdo = dataBase::conexao();
        if ($listaPedido == 0) {
            $stmt = $pdo->prepare("SELECT id, nome, quantidade, preco, status
                         FROM produto                                 
                        LIMIT :offset, :produtosPorPagina");
        } else {
            $stmt = $pdo->prepare("SELECT id, nome, quantidade, preco, status
                         FROM produto 
                         WHERE status = 1 AND quantidade > 0
                        LIMIT :offset, :produtosPorPagina");
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':produtosPorPagina', $produtosPorPagina, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        // Contagem total de usuários
        $stmt = $pdo->query("SELECT COUNT(*) FROM produto");
        $totalProdutos = $stmt->fetchColumn();
        $stmt = null;

        $totalPaginas = ceil($totalProdutos / $produtosPorPagina);

        return $result1 = json_encode([
            'produtos' => $result,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function ProdutoById($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id, nome, quantidade, preco, status
                                 FROM produto                                 
                                WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return json_encode(['produtos' => $result]);
    }

    public function CadastroProduto($postProduto) {

        $this->setNome($postProduto['nome']);
        $this->setQuantidade($postProduto['quantidade']);
        $this->setPreco($postProduto['preco']);
        $this->setStatus($postProduto['status']);

        $nome = $this->getNome();
        $qtde = $this->getQuantidade();
        $preco = $this->getPreco();
        $status = $this->getStatus();

        try {

            $pdo = dataBase::conexao();
            $sql = "INSERT INTO produto (nome, quantidade, preco, status) VALUES (:nome, :quantidade, :preco, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':quantidade', $qtde);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } catch (PDOException $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function atualizaProduto($postProduto) {

        $this->setId($postProduto['id']);
        $this->setNome($postProduto['nome']);
        $this->setQuantidade($postProduto['quantidade']);
        $this->setPreco($postProduto['preco']);
        $this->setStatus($postProduto['status']);

        try {

            $pdo = dataBase::conexao();
            $sql = "UPDATE produto SET nome = :nome, quantidade = :quantidade, preco = :preco, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->getId());
            $stmt->bindParam(':nome', $this->getNome());
            $stmt->bindParam(':quantidade', $this->getQuantidade());
            $stmt->bindParam(':preco', $this->getPreco());
            $stmt->bindParam(':status', $this->getStatus());
            $stmt->execute();
        } catch (PDOException $e) {

            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function apagaProduto($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("DELETE FROM produto WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = null;
    }

}
