<?php

session_start();
require_once '../util/str.php';
require_once '../util/paginacao.php';
require_once '../model/produtoModel.php';
require_once 'resource/produtoRescource.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['pagina'])) {
        if (!str::IsValidKey($_GET['pagina'])) {
            $_GET['pagina'] = paginacao::inicialPagina;
        }
    }

    if (isset($_GET['produtosPorPagina'])) {
        if (!str::IsValidKey($_GET['produtosPorPagina'])) {
            $_GET['produtosPorPagina'] = paginacao::limitePagina;
        }
    }

    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : paginacao::inicialPagina;
    $produtosPorPagina = isset($_GET['produtosPorPagina']) ? $_GET['produtosPorPagina'] : paginacao::limitePagina;
    $offset = ($pagina - 1) * $produtosPorPagina;

    $produtoGet = new produto();

    /*
     * Se existir refencia lista o cliente
     */
    if (isset($_GET['id'])) {
        if (str::IsValidKey($_GET['id'])) {
            $id = $_GET['id'];
            echo $produtoGet->ProdutoById($id);
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

        echo $produtoGet->ListaProdutosByGet($offset, $produtosPorPagina, $listaPedido);
        exit();
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {

    $_POST = json_decode(file_get_contents("php://input"), true);

    if (str::IsNullOrEmptyString($_POST['nome'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => produtoRescource::LBL_EMPTY_NAME));
        exit();
    }

    if (!str::IsValidKey($_POST['quantidade'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => produtoRescource::LBL_EMPTY_CPF));
        exit();
    }

    if (str::IsNullOrEmptyString($_POST['preco'])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("mensagem" => produtoRescource::LBL_EMPTY_EMAIL));
        exit();
    }

    if (isset($_GET['id'])) {
        if (!str::IsValidKey($_GET['id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => produtoRescource::LBL_TYPE_ID));
            exit();
        }
    }


    $postProduto = array('nome' => $_POST['nome'],
        'quantidade' => $_POST['quantidade'],
        'preco' => str::converterVirgulaParaPonto($_POST['preco']),
        'status' => $_POST['status']);

    $produtoPost = new produto();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $resp = $produtoPost->CadastroProduto($postProduto);
        if ($resp == 400) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => "Ocorreu um erro no cadastro!"));
            exit();
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {

        $postProduto['id'] = $_GET['id'];
        $produtoPost->atualizaProduto($postProduto);
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

    $produtoDel = new produto();
    $produtoDel->apagaProduto($_GET['id']);
}

