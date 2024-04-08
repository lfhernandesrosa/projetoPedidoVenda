<?php

require_once '../dbase/conection.php';

class cliente {

    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getNumero() {
        return $this->numero;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCep() {
        return $this->cep;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNome($nome): void {
        $this->nome = $nome;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    function setEndereco($endereco): void {
        $this->endereco = $endereco;
    }

    function setNumero($numero): void {
        $this->numero = $numero;
    }

    function setBairro($bairro): void {
        $this->bairro = $bairro;
    }

    function setCidade($cidade): void {
        $this->cidade = $cidade;
    }

    function setEstado($estado): void {
        $this->estado = $estado;
    }

    function setCep($cep): void {
        $this->cep = $cep;
    }

    public function ListaClienteByGet(int $offset, int $usuarioPorPagina) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id, nome, email, cpf, cep, endereco, numero, bairro, cidade, estado 
                         FROM cliente                                 
                        LIMIT :offset, :usuarioPorPagina");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':usuarioPorPagina', $usuarioPorPagina, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        // Contagem total de usuários
        $stmt = $pdo->query("SELECT COUNT(*) FROM cliente");
        $totalUsuarios = $stmt->fetchColumn();
        $stmt = null;

        $totalPaginas = ceil($totalUsuarios / $usuarioPorPagina);

        return $result1 = json_encode([
            'clientes' => $result,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function ClienteById($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id, nome, email, cpf, cep, endereco, numero, bairro, cidade, estado 
                                 FROM cliente                                 
                                WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return json_encode(['clientes' => $result]);
    }

    public function CadastroCliente($postCliente) {

        $this->setNome($postCliente['nome']);
        $this->setCpf($postCliente['cpf']);
        $this->setEmail($postCliente['email']);
        $this->setCep($postCliente['cep']);
        $this->setEndereco($postCliente['endereco']);
        $this->setNumero($postCliente['numero']);
        $this->setBairro($postCliente['bairro']);
        $this->setCidade($postCliente['cidade']);
        $this->setEstado($postCliente['estado']);

        try {

            $pdo = dataBase::conexao();
            $sql = "INSERT INTO cliente (nome, cpf, email, cep, endereco, numero, bairro, cidade, estado) VALUES (:nome, :cpf, :email, :cep, :endereco, :numero, :bairro, :cidade, :estado )";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $this->getNome());
            $stmt->bindParam(':cpf', $this->getCpf());
            $stmt->bindParam(':email', $this->getEmail());
            $stmt->bindParam(':cep', $this->getCep());
            $stmt->bindParam(':endereco', $this->getEndereco());
            $stmt->bindParam(':numero', $this->getNumero());
            $stmt->bindParam(':bairro', $this->getBairro());
            $stmt->bindParam(':cidade', $this->getCidade());
            $stmt->bindParam(':estado', $this->getEstado());
            $stmt->execute();
        } catch (PDOException $e) {

            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function atualizaCliente($postCliente) {

        $this->setId($postCliente['id']);
        $this->setNome($postCliente['nome']);
        $this->setCpf($postCliente['cpf']);
        $this->setEmail($postCliente['email']);
        $this->setCep($postCliente['cep']);
        $this->setEndereco($postCliente['endereco']);
        $this->setNumero($postCliente['numero']);
        $this->setBairro($postCliente['bairro']);
        $this->setCidade($postCliente['cidade']);
        $this->setEstado($postCliente['estado']);

        //VERIFICAR MODO CERTO

        try {

            $pdo = dataBase::conexao();
            $sql = "UPDATE cliente SET nome = :nome, cpf = :cpf, email = :email, cep = :cep, endereco = :endereco, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->getId());
            $stmt->bindParam(':nome', $this->getNome());
            $stmt->bindParam(':cpf', $this->getCpf());
            $stmt->bindParam(':email', $this->getEmail());
            $stmt->bindParam(':cep', $this->getCep());
            $stmt->bindParam(':endereco', $this->getEndereco());
            $stmt->bindParam(':numero', $this->getNumero());
            $stmt->bindParam(':bairro', $this->getBairro());
            $stmt->bindParam(':cidade', $this->getCidade());
            $stmt->bindParam(':estado', $this->getEstado());
            $stmt->execute();
        } catch (PDOException $e) {

            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function apagaCliente($id) {

        $pdo = dataBase::conexao();
        $stmt = $pdo->prepare("SELECT id 
                                 FROM venda                      
                                WHERE idCliente = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count == 0) {

            $stmt = $pdo->prepare("DELETE FROM cliente WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
        } else {
            return json_encode(['success' => false, 'message' => 'Este cliente não pode ser excluido pois já existe pedido de venda']);
        }
    }

}
