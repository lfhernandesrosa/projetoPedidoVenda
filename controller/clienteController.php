<?php

session_start();
require_once '../util/str.php';
require_once '../util/paginacao.php';
require_once '../model/clienteModel.php';
require_once 'resource/clienteRescource.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['pagina'])) {
        if (!str::IsValidKey($_GET['pagina'])) {
            $_GET['pagina'] = paginacao::inicialPagina;
        }
    }

    if (isset($_GET['usuariosPorPagina'])) {
        if (!str::IsValidKey($_GET['usuariosPorPagina'])) {
            $_GET['usuariosPorPagina'] = paginacao::limitePagina;
        }
    }

    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : paginacao::inicialPagina;
    $usuariosPorPagina = isset($_GET['usuariosPorPagina']) ? $_GET['usuariosPorPagina'] : paginacao::limitePagina;
    $offset = ($pagina - 1) * $usuariosPorPagina;

    $clienteGet = new cliente();

    /*
     * Se existir refencia lista o cliente
     */

    if (isset($_GET['id'])) {
        if (str::IsValidKey($_GET['id'])) {
            $id = $_GET['id'];
            echo $clienteGet->ClienteById($id);
            exit();
        }
    } else {
        $clienteGet = new cliente();
        echo $clienteGet->ListaClienteByGet($offset, $usuariosPorPagina);
        exit();
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {

    $_POST = json_decode(file_get_contents("php://input"), true);

    if (str::IsNullOrEmptyString($_POST['nome'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_NAME));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['cpf'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_CPF));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['email'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_EMAIL));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['endereco'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_ADDRESS));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['numero'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_NUMBER));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['bairro'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_DISTRICT));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['cidade'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_CITY));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['estado'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_EMPTY_STATE));
        exit();
    }

    if (isset($_GET['id'])) {
        if (!str::IsValidKey($_GET['id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => clienteRescource::LBL_TYPE_ID));
            exit();
        }
    }


    $postCliente = array('nome' => $_POST['nome'],
        'cpf' => $_POST['cpf'],
        'email' => $_POST['email'],
        'cep' => $_POST['cep'],
        'endereco' => $_POST['endereco'],
        'numero' => $_POST['numero'],
        'bairro' => $_POST['bairro'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado']);

    $clientePost = new cliente();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $resp = $clientePost->CadastroCliente($postCliente);
        if ($resp == 400) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => "Ocorreu um erro no cadastro!"));
            exit();
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {

        $postCliente['id'] = $_GET['id'];
        $clientePost->atualizaCliente($postCliente);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {


    if (isset($_GET['id'])) {
        if (!str::IsValidKey($_GET['id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => clienteRescource::LBL_TYPE_ID));
            exit();
        }
    }

    $clienteDel = new cliente();
    $result = $clienteDel->apagaCliente($_GET['id']);

    if (!str::IsNullOrEmptyString($result)) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => clienteRescource::LBL_DELETE_CUSTOMER));
        exit();
    }
}

