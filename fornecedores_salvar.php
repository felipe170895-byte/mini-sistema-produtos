<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Fornecedor.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: fornecedores_listar.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$cnpj = trim($_POST['cnpj'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cnpjNumeros = preg_replace('/\D/', '', $cnpj);
$telefoneNumeros = preg_replace('/\D/', '', $telefone);

if (empty($nome)) {
    header('Location: fornecedores_novo.php?erro=nome_obrigatorio');
    exit;
}

if (!empty($cnpj) && strlen($cnpjNumeros) !== 14) {
    header('Location: fornecedores_novo.php?erro=cnpj_invalido');
    exit;
}

if (!empty($telefone) && (strlen($telefoneNumeros) !== 10 && strlen($telefoneNumeros) !== 11)) {
    header('Location: fornecedores_novo.php?erro=telefone_invalido');
    exit;
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: fornecedores_novo.php?erro=email_invalido');
    exit;
}

$fornecedorObj = new Fornecedor();

$cadastrou = $fornecedorObj->cadastrar(
    $nome,
    $cnpj,
    $telefone,
    $email,
    $endereco
);

if ($cadastrou) {
    header('Location: fornecedores_listar.php?sucesso=cadastrado');
    exit;
}

header('Location: fornecedores_novo.php?erro=erro_cadastrar');
exit;