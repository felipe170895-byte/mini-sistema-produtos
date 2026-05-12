<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Produto.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: produtos_listar.php');
    exit;
}

$id = $_POST['id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$fornecedorId = $_POST['fornecedor_id'] ?? '';

if (!$id) {
    header('Location: produtos_listar.php?erro=nao_encontrado');
    exit;
}

if (empty($nome)) {
    header('Location: produtos_editar.php?id=' . $id . '&erro=nome_obrigatorio');
    exit;
}

if (empty($preco)) {
    header('Location: produtos_editar.php?id=' . $id . '&erro=preco_obrigatorio');
    exit;
}

$precoFormatado = str_replace(',', '.', $preco);

if (!is_numeric($precoFormatado) || $precoFormatado <= 0) {
    header('Location: produtos_editar.php?id=' . $id . '&erro=preco_invalido');
    exit;
}

if (empty($fornecedorId)) {
    header('Location: produtos_editar.php?id=' . $id . '&erro=fornecedor_obrigatorio');
    exit;
}

$produtoObj = new Produto();

$produto = $produtoObj->buscarPorId($id);

if (!$produto) {
    header('Location: produtos_listar.php?erro=nao_encontrado');
    exit;
}

if (!$produtoObj->fornecedorExiste($fornecedorId)) {
    header('Location: produtos_editar.php?id=' . $id . '&erro=fornecedor_invalido');
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
    header('Location: produtos_listar.php?sucesso=atualizado');
    exit;
}

header('Location: produtos_editar.php?id=' . $id . '&erro=erro_atualizar');
exit;