<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Produto.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: produtos_listar.php?erro=nao_encontrado');
    exit;
}

$produtoObj = new Produto();

$produto = $produtoObj->buscarPorId($id);

if (!$produto) {
    header('Location: produtos_listar.php?erro=nao_encontrado');
    exit;
}

$totalItensCesta = $produtoObj->contarItensCesta($id);

if ($totalItensCesta > 0) {
    header('Location: produtos_listar.php?erro=produto_em_cesta');
    exit;
}

$excluiu = $produtoObj->excluir($id);

if ($excluiu) {
    header('Location: produtos_listar.php?sucesso=excluido');
    exit;
}

header('Location: produtos_listar.php?erro=erro_excluir');
exit;