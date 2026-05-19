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

$id = $_POST['id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$fornecedorId = $_POST['fornecedor_id'] ?? '';

if (!$id || empty($nome) || empty($preco) || empty($fornecedorId)) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'ID, nome, preço e fornecedor são obrigatórios.'
   ]);
   exit;
}

$precoFormatado = str_replace(',', '.', $preco);

if (!is_numeric($precoFormatado) || $precoFormatado <= 0) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'Preço inválido.'
   ]);
   exit;
}

$produtoObj = new Produto();

$produto = $produtoObj->buscarPorId($id);

if (!$produto) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'Produto não encontrado.'
   ]);
   exit;
}

if (!$produtoObj->fornecedorExiste($fornecedorId)) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'Fornecedor inválido.'
   ]);
   exit;
}

$atualizou = $produtoObj->atualizar(
   $id,
   $fornecedorId,
   $nome,
   $descricao,
   $precoFormatado
);

if ($atualizou) {
   echo json_encode([
       'status' => 'sucesso',
       'mensagem' => 'Produto atualizado com sucesso.'
   ]);
   exit;
}

echo json_encode([
   'status' => 'erro',
   'mensagem' => 'Erro ao atualizar produto.'
]);
