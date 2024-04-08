<?php

session_start();
require_once '../util/str.php';
require_once '../model/formaPagModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $formPagGet = new formaPagamento();

    if (isset($_GET['id'])) {

        if (str::IsValidKey($_GET['id'])) {
            $id = $_GET['id'];
            echo $formPagGet->FormaPagById($id);
            exit();
        }
    } else {

        if (isset($_GET['pedidoVenda'])) {
            if ($_GET['pedidoVenda'] == 1) {
                $listaPedido = 1;
            }
        } else {
            $listaPedido = 0;
        }

        echo $formPagGet->ListaFormaPagByGet($listaPedido);
        exit();
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {

    $_POST = json_decode(file_get_contents("php://input"), true);

    if (str::IsNullOrEmptyString($_POST['nome'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => "nome não pode ser vazio"));
        exit();
    }

    if (isset($_GET['id'])) {
        if (!str::IsValidKey($_GET['id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => "Não tem referencia"));
            exit();
        }
    }


    $postFormaPag = array('nome' => $_POST['nome'],
        'status' => $_POST['status']);

    $formaPagPost = new formaPagamento();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $resp = $formaPagPost->CadastroFormaPag($postFormaPag);
        if ($resp == 400) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => "Ocorreu um erro no cadastro!"));
            exit();
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {

        $postFormaPag['id'] = $_GET['id'];
        $formaPagPost->atualizaFormaPag($postFormaPag);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {


    if (isset($_GET['id'])) {
        if (!str::IsValidKey($_GET['id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => produtoRescource::LBL_TYPE_ID));
            exit();
        }
    }

    $formaPagDel = new formaPagamento();
    $formaPagDel->apagaFormaPag($_GET['id']);
}

