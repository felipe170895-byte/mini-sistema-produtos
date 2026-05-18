<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Cesta.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header('Location: cesta_produtos.php');
   exit;
}

$usuarioId = $_SESSION['usuario_id'];
$produtosSelecionados = $_POST['produtos'] ?? [];

if (empty($produtosSelecionados)) {
   header('Location: cesta_produtos.php?erro=nenhum_produto');
   exit;
}

$cestaObj = new Cesta();

try {
   $resultado = $cestaObj->adicionarProdutos($usuarioId, $produtosSelecionados);

   if ($resultado['adicionados'] > 0 || $resultado['duplicados'] > 0) {
       header(
           'Location: cesta_produtos.php?sucesso=adicionado' .
           '&adicionados=' . $resultado['adicionados'] .
           '&duplicados=' . $resultado['duplicados']
       );
       exit;
   }

   header('Location: cesta_produtos.php?erro=erro_adicionar');
   exit;

} catch (PDOException $e) {
   header('Location: cesta_produtos.php?erro=erro_adicionar');
   exit;
}
