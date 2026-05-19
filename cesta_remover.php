<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Cesta.php';

$usuarioId = $_SESSION['usuario_id'];
$itemId = $_GET['id'] ?? null;

if (!$itemId) {
   header('Location: cesta_visualizar.php?erro=item_nao_encontrado');
   exit;
}

$cestaObj = new Cesta();

try {
   $removeu = $cestaObj->removerItem($usuarioId, $itemId);

   if ($removeu) {
       header('Location: cesta_visualizar.php?sucesso=removido');
       exit;
   }

   header('Location: cesta_visualizar.php?erro=erro_remover');
   exit;

} catch (PDOException $e) {
   header('Location: cesta_visualizar.php?erro=erro_remover');
   exit;
}
