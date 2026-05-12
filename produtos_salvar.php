<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Produto.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: produtos_listar.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$fornecedorId = $_POST['fornecedor_id'] ?? '';

if (empty($nome)) {
    header('Location: produtos_novo.php?erro=nome_obrigatorio');
    exit;
}

if (empty($preco)) {
    header('Location: produtos_novo.php?erro=preco_obrigatorio');
    exit;
}

$precoFormatado = str_replace(',', '.', $preco);

if (!is_numeric($precoFormatado) || $precoFormatado <= 0) {
    header('Location: produtos_novo.php?erro=preco_invalido');
    exit;
}

if (empty($fornecedorId)) {
    header('Location: produtos_novo.php?erro=fornecedor_obrigatorio');
    exit;
}

$produtoObj = new Produto();

if (!$produtoObj->fornecedorExiste($fornecedorId)) {
    header('Location: produtos_novo.php?erro=fornecedor_invalido');
    exit;
}

$cadastrou = $produtoObj->cadastrar(
    $fornecedorId,
    $nome,
    $descricao,
    $precoFormatado
);

if ($cadastrou) {
    header('Location: produtos_listar.php?sucesso=cadastrado');
    exit;
}

header('Location: produtos_novo.php?erro=erro_cadastrar');
exit;