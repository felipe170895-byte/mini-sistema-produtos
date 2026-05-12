<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Fornecedor.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: fornecedores_listar.php');
    exit;
}

$id = $_POST['id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$cnpj = trim($_POST['cnpj'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cnpjNumeros = preg_replace('/\D/', '', $cnpj);
$telefoneNumeros = preg_replace('/\D/', '', $telefone);

if (!$id) {
    header('Location: fornecedores_listar.php?erro=nao_encontrado');
    exit;
}

if (empty($nome)) {
    header('Location: fornecedores_editar.php?id=' . $id . '&erro=nome_obrigatorio');
    exit;
}

if (!empty($cnpj) && strlen($cnpjNumeros) !== 14) {
    header('Location: fornecedores_editar.php?id=' . $id . '&erro=cnpj_invalido');
    exit;
}

if (!empty($telefone) && !in_array(strlen($telefoneNumeros), [10, 11])) {
    header('Location: fornecedores_editar.php?id=' . $id . '&erro=telefone_invalido');
    exit;
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: fornecedores_editar.php?id=' . $id . '&erro=email_invalido');
    exit;
}

$fornecedorObj = new Fornecedor();

$fornecedor = $fornecedorObj->buscarPorId($id);

if (!$fornecedor) {
    header('Location: fornecedores_listar.php?erro=nao_encontrado');
    exit;
}

$atualizou = $fornecedorObj->atualizar(
    $id,
    $nome,
    $cnpj,
    $telefone,
    $email,
    $endereco
);

if ($atualizou) {
    header('Location: fornecedores_listar.php?sucesso=atualizado');
    exit;
}

header('Location: fornecedores_editar.php?id=' . $id . '&erro=erro_atualizar');
exit;