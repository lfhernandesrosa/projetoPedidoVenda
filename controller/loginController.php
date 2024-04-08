<?php

session_start();
require_once '../util/str.php';
require_once '../model/loginModel.php';
require_once 'resource/loginRescource.php';

$_POST = json_decode(file_get_contents("php://input"), true);
$login = new login();

if (isset($_POST['parametro'])) {
    if ($_POST['parametro'] = 1) {

        if (str::IsNullOrEmptyString($_POST['nome'])) {
            echo json_encode(['success' => false, 'message' => loginRescource::LBL_EMPTY_USER]);
            die();
        }

        if (str::IsNullOrEmptyString($_POST['username'])) {
            echo json_encode(['success' => false, 'message' => loginRescource::LBL_EMPTY_USER]);
            die();
        }

        if (str::IsNullOrEmptyString($_POST['password'])) {
            echo json_encode(['success' => false, 'message' => loginRescource::LBL_EMPTY_USER]);
            die();
        }

        $cadastro = array('nome' => $_POST['nome'],
            'username' => $_POST['username'],
            'password' => str::converterVirgulaParaPonto($_POST['password']));

        $res = $login->cadastroLogin($cadastro);

        if (str::isArrayNotEmtpy($res)) {
            echo json_encode(['success' => false, 'message' => loginRescource::LBL_ERROR_CAD]);
        } else {
            echo json_encode(['success' => true]);
        }
    }
} else {


    if (str::IsNullOrEmptyString($_POST['username'])) {
        echo json_encode(['success' => false, 'message' => loginRescource::LBL_EMPTY_USER]);
        die();
    }

    if (str::IsNullOrEmptyString($_POST['password'])) {
        echo json_encode(['success' => false, 'message' => loginRescource::LBL_EMPTY_PASS]);
        die();
    }

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $res = $login->ValidateLogin($user, $pass);

    if (!str::isArrayNotEmtpy($res)) {
        echo json_encode(['success' => false, 'message' => loginRescource::LBL_LOGIN_INCORRECT]);
    } else {

        foreach ($res as $item) {
            $_SESSION['usuarioId'] = $item['id'];
            $_SESSION['nome'] = $item['nome'];
        }
        echo json_encode(['success' => true]);
    }
}