<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Produto.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Método inválido.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $id = $_POST['id'] ?? null;

    if (!$id) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'ID do produto não informado.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $produtoObj = new Produto();

    $produto = $produtoObj->buscarPorId($id);

    if (!$produto) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Produto não encontrado.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $totalItensCesta = $produtoObj->contarItensCesta($id);

    if ($totalItensCesta > 0) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Não é possível excluir este produto, pois ele já está vinculado a uma cesta.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $excluiu = $produtoObj->excluir($id);

    if ($excluiu) {
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Produto excluído via AJAX com sucesso.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao excluir produto.'
    ], JSON_UNESCAPED_UNICODE);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no servidor: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}