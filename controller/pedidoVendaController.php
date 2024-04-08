<?php

session_start();
require_once '../util/str.php';
require_once '../util/paginacao.php';
require_once '../model/pedidoVendaModel.php';
require_once 'resource/pedidoVendaRescource.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $pv = new pedidoVenda();

    if (isset($_GET['pagina'])) {
        if (!str::IsValidKey($_GET['pagina'])) {
            $_GET['pagina'] = paginacao::inicialPagina;
        }
    }

    if (isset($_GET['vendasPorPagina'])) {
        if (!str::IsValidKey($_GET['vendasPorPagina'])) {
            $_GET['vendasPorPagina'] = paginacao::limitePagina;
        }
    }

    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : paginacao::inicialPagina;
    $vendasPorPagina = isset($_GET['vendasPorPagina']) ? $_GET['vendasPorPagina'] : paginacao::limitePagina;
    $offset = ($pagina - 1) * $vendasPorPagina;

    /*
     * Se existir refencia lista o cliente
     */
    if (isset($_GET['id'])) {
        if (str::IsValidKey($_GET['id'])) {
            $id = $_GET['id'];
            echo $pv->VendasById($id);
            exit();
        }
    } else {
        echo $pv->ListaVendasByGet($offset, $vendasPorPagina);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));

    // Verifica se os dados foram recebidos corretamente
    if ($data) {
        // Recupera os valores enviados pelo Vue.js
        $itensVenda = $data->itens;
        $totalVenda = $data->total;
        $cliente = $data->cliente->id;
        $formaPagamento = $data->formaPagamento;

        $pv = new pedidoVenda();
        $pv->cadastroPedidoVenda($itensVenda, $cliente, $formaPagamento);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    if (isset($_GET['id'])) {
        if (!str::IsValidKey($_GET['id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("mensagem" => pedidoVendaRescource::LBL_TYPE_ID));
            exit();
        }
    }

    $pedidoDel = new pedidoVenda();
    $pedidoDel->apagaPedido($_GET['id']);
}

