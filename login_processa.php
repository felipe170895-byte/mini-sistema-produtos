<?php

session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($email) || empty($senha)) {
    header('Location: ' . BASE_URL . 'login.php?erro=campos_obrigatorios');
    exit;
}

$usuarioObj = new Usuario();
$usuario = $usuarioObj->autenticar($email, $senha);

if ($usuario) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_email'] = $usuario['email'];

    header('Location: ' . BASE_URL . 'dashboard.php');
    exit;
}

header('Location: ' . BASE_URL . 'login.php?erro=login_invalido');
exit;