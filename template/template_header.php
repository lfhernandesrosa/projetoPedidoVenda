<?php
session_start();

if (!isset($_SESSION['usuarioId']) || empty($_SESSION['usuarioId'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Projeto L.F.H.R</title>
        <!-- Adicione o Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../template/css/template_style.css" rel="stylesheet">
    </head>
<body>