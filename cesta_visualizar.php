<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Cesta.php';

$usuarioId = $_SESSION['usuario_id'];

$cestaObj = new Cesta();

$itens = $cestaObj->listarItens($usuarioId);
$resumo = $cestaObj->obterResumo($usuarioId);

$totalItens = $resumo['total_itens'] ?? 0;
$valorTotal = $resumo['valor_total'] ?? 0;

$mensagemSucesso = '';
$mensagemErro = '';

if (isset($_GET['sucesso'])) {
   if ($_GET['sucesso'] === 'removido') {
       $mensagemSucesso = 'Produto removido da cesta com sucesso.';
   }

   if ($_GET['sucesso'] === 'limpa') {
       $mensagemSucesso = 'Cesta limpa com sucesso.';
   }
}

if (isset($_GET['erro'])) {
   if ($_GET['erro'] === 'item_nao_encontrado') {
       $mensagemErro = 'Item não encontrado na cesta.';
   }

   if ($_GET['erro'] === 'erro_remover') {
       $mensagemErro = 'Erro ao remover item da cesta.';
   }

   if ($_GET['erro'] === 'erro_limpar') {
       $mensagemErro = 'Erro ao limpar cesta.';
   }
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

   <div class="d-flex justify-content-between align-items-center mb-4">
       <div>
           <h1 class="page-title mb-1">Minha Cesta</h1>
           <p class="text-muted mb-0">
               Confira os produtos selecionados.
           </p>
       </div>

       <a href="cesta_produtos.php" class="btn btn-primary">
           <i class="bi bi-plus-circle"></i>
           Adicionar Produtos
       </a>
   </div>

   <?php if (!empty($mensagemSucesso)): ?>
       <div class="alert alert-success">
           <?= htmlspecialchars($mensagemSucesso) ?>
       </div>
   <?php endif; ?>

   <?php if (!empty($mensagemErro)): ?>
       <div class="alert alert-danger">
           <?= htmlspecialchars($mensagemErro) ?>
       </div>
   <?php endif; ?>

   <div class="row g-4 mb-4">

       <div class="col-md-6">
           <div class="card shadow-sm">
               <div class="card-body d-flex align-items-center gap-3">
                   <div class="card-icon bg-warning-subtle text-warning">
                       <i class="bi bi-cart3"></i>
                   </div>
                   <div>
                       <p class="text-muted mb-0">Quantidade de produtos</p>
                       <h3 class="mb-0"><?= $totalItens ?></h3>
                   </div>
               </div>
           </div>
       </div>

       <div class="col-md-6">
           <div class="card shadow-sm">
               <div class="card-body d-flex align-items-center gap-3">
                   <div class="card-icon bg-info-subtle text-info">
                       <i class="bi bi-cash-stack"></i>
                   </div>
                   <div>
                       <p class="text-muted mb-0">Valor total</p>
                       <h3 class="mb-0">
                           R$ <?= number_format((float) $valorTotal, 2, ',', '.') ?>
                       </h3>
                   </div>
               </div>
           </div>
       </div>

   </div>

   <div class="card shadow-sm">
       <div class="card-body">

           <?php if (count($itens) === 0): ?>

               <div class="alert alert-info mb-0">
                   Sua cesta está vazia.
                   <a href="cesta_produtos.php" class="alert-link">
                       Clique aqui para selecionar produtos.
                   </a>
               </div>

           <?php else: ?>

               <div class="table-responsive">
                   <table class="table table-hover align-middle">
                       <thead class="table-primary">
                           <tr>
                               <th>Produto</th>
                               <th>Descrição</th>
                               <th>Fornecedor</th>
                               <th>Preço</th>
                               <th class="text-center">Ação</th>
                           </tr>
                       </thead>

                       <tbody>
                           <?php foreach ($itens as $item): ?>
                               <tr>
                                   <td>
                                       <strong><?= htmlspecialchars($item['produto_nome']) ?></strong>
                                   </td>

                                   <td>
                                       <?= htmlspecialchars($item['descricao'] ?? '-') ?>
                                   </td>

                                   <td>
                                       <?= htmlspecialchars($item['fornecedor_nome']) ?>
                                   </td>

                                   <td>
                                       R$ <?= number_format((float) $item['preco_unitario'], 2, ',', '.') ?>
                                   </td>

                                   <td class="text-center">
                                       <a
                                           href="cesta_remover.php?id=<?= $item['item_id'] ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Deseja remover este produto da cesta?')"
                                       >
                                           <i class="bi bi-trash"></i>
                                           Remover
                                       </a>
                                   </td>
                               </tr>
                           <?php endforeach; ?>
                       </tbody>

                   </table>
               </div>

               <div class="d-flex justify-content-between align-items-center mt-3">
                   <a href="cesta_produtos.php" class="btn btn-secondary">
                       <i class="bi bi-arrow-left"></i>
                       Voltar para produtos
                   </a>

                   <a
                       href="cesta_limpar.php"
                       class="btn btn-outline-danger"
                       onclick="return confirm('Tem certeza que deseja limpar toda a cesta?')"
                   >
                       <i class="bi bi-x-circle"></i>
                       Limpar Cesta
                   </a>
               </div>

           <?php endif; ?>

       </div>
   </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
