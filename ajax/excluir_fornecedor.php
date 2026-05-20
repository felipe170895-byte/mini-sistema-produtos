<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Fornecedor.php';

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
            'mensagem' => 'ID do fornecedor não informado.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $fornecedorObj = new Fornecedor();

    $fornecedor = $fornecedorObj->buscarPorId($id);

    if (!$fornecedor) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Fornecedor não encontrado.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $totalProdutos = $fornecedorObj->contarProdutos($id);

    if ($totalProdutos > 0) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Não é possível excluir este fornecedor, pois ele possui produtos cadastrados.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $excluiu = $fornecedorObj->excluir($id);

    if ($excluiu) {
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Fornecedor excluído via AJAX com sucesso.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao excluir fornecedor.'
    ], JSON_UNESCAPED_UNICODE);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no servidor: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}