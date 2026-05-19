<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Produto.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $produtoObj = new Produto();
    $produtos = $produtoObj->listarTodos();

    echo json_encode([
        'status' => 'sucesso',
        'dados' => $produtos
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}