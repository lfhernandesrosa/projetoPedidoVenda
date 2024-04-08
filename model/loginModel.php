<?php

require_once '../dbase/conection.php';

class login {

    private $id;
    private $nome;
    private $usuario;
    private $senha;
    private $status;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
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

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setSenha($senha): void {
        $this->senha = $senha;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function ValidateLogin($user, $pass) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id, nome 
                                 FROM login                                 
                                WHERE usuario = :user 
                                  AND senha = :pass
                                  AND status = 1", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute([':user' => $user, ':pass' => $pass]);
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $result;
    }

    function cadastroLogin($cadastro) {

        $this->setNome($cadastro['nome']);
        $this->setUsuario($cadastro['username']);
        $this->setSenha($cadastro['password']);
        $this->setStatus(1);

        $nome = $this->getNome();
        $usuario = $this->getUsuario();
        $senha = $this->getSenha();
        $status = $this->getStatus();

        try {
            $pdo = dataBase::conexao();
            $sql = "INSERT INTO login (nome, usuario, senha, status) VALUES (:nome, :usuario, :senha, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } catch (PDOException $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
