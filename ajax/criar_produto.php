<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Produto.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Método inválido.'
    ]);
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$fornecedorId = $_POST['fornecedor_id'] ?? '';

if (empty($nome)) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'O nome do produto é obrigatório.'
    ]);
    exit;
}

if (empty($preco)) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'O preço é obrigatório.'
    ]);
    exit;
}

$precoFormatado = str_replace(',', '.', $preco);

if (!is_numeric($precoFormatado) || $precoFormatado <= 0) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'O preço deve ser maior que zero.'
    ]);
    exit;
}

if (empty($fornecedorId)) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Selecione um fornecedor.'
    ]);
    exit;
}

$produtoObj = new Produto();

if (!$produtoObj->fornecedorExiste($fornecedorId)) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Fornecedor inválido.'
    ]);
    exit;
}

$cadastrou = $produtoObj->cadastrar(
    $fornecedorId,
    $nome,
    $descricao,
    $precoFormatado
);

if ($cadastrou) {
    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Produto cadastrado via AJAX com sucesso.'
    ]);
    exit;
}

echo json_encode([
    'status' => 'erro',
    'mensagem' => 'Erro ao cadastrar produto.'
]);