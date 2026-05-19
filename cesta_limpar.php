<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Cesta.php';

$usuarioId = $_SESSION['usuario_id'];

$cestaObj = new Cesta();

try {
   $limpou = $cestaObj->limparCesta($usuarioId);

   if ($limpou) {
       header('Location: cesta_visualizar.php?sucesso=limpa');
       exit;
   }

   header('Location: cesta_visualizar.php?erro=erro_limpar');
   exit;

} catch (PDOException $e) {
   header('Location: cesta_visualizar.php?erro=erro_limpar');
   exit;
}
