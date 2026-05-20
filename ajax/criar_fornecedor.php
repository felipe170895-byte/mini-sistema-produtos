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

    $nome = trim($_POST['nome'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    $cnpjNumeros = preg_replace('/\D/', '', $cnpj);
    $telefoneNumeros = preg_replace('/\D/', '', $telefone);

    if (empty($nome)) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'O nome do fornecedor é obrigatório.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!empty($cnpj) && strlen($cnpjNumeros) !== 14) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'O CNPJ deve conter 14 números.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!empty($telefone) && !in_array(strlen($telefoneNumeros), [10, 11])) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'O telefone deve conter 10 ou 11 números, incluindo o DDD.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Informe um e-mail válido.'
        ], JSON_UNESCAPED_UNICODE);
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
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Fornecedor cadastrado via AJAX com sucesso.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao cadastrar fornecedor no banco de dados.'
    ], JSON_UNESCAPED_UNICODE);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no servidor: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}