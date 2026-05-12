<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Fornecedor.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: fornecedores_listar.php?erro=nao_encontrado');
    exit;
}

$fornecedorObj = new Fornecedor();

$fornecedor = $fornecedorObj->buscarPorId($id);

if (!$fornecedor) {
    header('Location: fornecedores_listar.php?erro=nao_encontrado');
    exit;
}

$totalProdutos = $fornecedorObj->contarProdutos($id);

if ($totalProdutos > 0) {
    header('Location: fornecedores_listar.php?erro=excluir_com_produtos');
    exit;
}

$excluiu = $fornecedorObj->excluir($id);

if ($excluiu) {
    header('Location: fornecedores_listar.php?sucesso=excluido');
    exit;
}

header('Location: fornecedores_listar.php?erro=erro_excluir');
exit;