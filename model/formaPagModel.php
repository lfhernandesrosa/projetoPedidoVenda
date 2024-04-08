<?php

require_once '../dbase/conection.php';

class formaPagamento {

    private $id;
    private $nome;
    private $status;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
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

    function setStatus($status): void {
        $this->status = $status;
    }

    public function ListaFormaPagByGet($listaPedido) {

        $pdo = dataBase::conexao();
        if ($listaPedido == 0) {
            $stmt = $pdo->prepare("SELECT id, nome, status FROM forma_pg");
        } else {
            $stmt = $pdo->prepare("SELECT id, nome, status FROM forma_pg WHERE status = 1");
        }
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $result1 = json_encode([
            'fpag' => $result
        ]);
    }

    public function FormaPagById($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id, nome, status
                                 FROM forma_pg                                 
                                WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return json_encode(['fpag' => $result]);
    }

    public function CadastroFormaPag($postFormaPag) {

        $this->setNome($postFormaPag['nome']);
        $this->setStatus($postFormaPag['status']);

        $nome = $this->getNome();
        $status = $this->getStatus();

        try {

            $pdo = dataBase::conexao();
            $sql = "INSERT INTO forma_pg (nome, status) VALUES (:nome, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } catch (PDOException $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function atualizaFormaPag($postFormaPag) {

        $this->setId($postFormaPag['id']);
        $this->setNome($postFormaPag['nome']);
        $this->setStatus($postFormaPag['status']);

        $id = $this->getId();
        $nome = $this->getNome();
        $status = $this->getStatus();

        try {

            $pdo = dataBase::conexao();
            $sql = "UPDATE forma_pg SET nome = :nome, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } catch (PDOException $e) {

            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function apagaFormaPag($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("DELETE FROM forma_pg WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = null;
    }

}
