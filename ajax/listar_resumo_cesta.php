<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Cesta.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $usuarioId = $_SESSION['usuario_id'];

    $cestaObj = new Cesta();
    $resumo = $cestaObj->obterResumo($usuarioId);

    echo json_encode([
        'status' => 'sucesso',
        'dados' => [
            'total_itens' => $resumo['total_itens'] ?? 0,
            'valor_total' => $resumo['valor_total'] ?? 0
        ]
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}