<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Fornecedor.php';

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
$cnpj = trim($_POST['cnpj'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');

if (!$id || empty($nome)) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'ID e nome são obrigatórios.'
   ]);
   exit;
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'E-mail inválido.'
   ]);
   exit;
}

$fornecedorObj = new Fornecedor();
$fornecedor = $fornecedorObj->buscarPorId($id);

if (!$fornecedor) {
   echo json_encode([
       'status' => 'erro',
       'mensagem' => 'Fornecedor não encontrado.'
   ]);
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
   echo json_encode([
       'status' => 'sucesso',
       'mensagem' => 'Fornecedor atualizado com sucesso.'
   ]);
   exit;
}

echo json_encode([
   'status' => 'erro',
   'mensagem' => 'Erro ao atualizar fornecedor.'
]);
