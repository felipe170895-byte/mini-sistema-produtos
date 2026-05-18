<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Produto.php';
require_once __DIR__ . '/classes/Cesta.php';

$usuarioId = $_SESSION['usuario_id'];

$produtoObj = new Produto();
$cestaObj = new Cesta();

$produtos = $produtoObj->listarTodos();
$resumo = $cestaObj->obterResumo($usuarioId);

$totalItens = $resumo['total_itens'] ?? 0;
$valorTotal = $resumo['valor_total'] ?? 0;

$mensagemSucesso = '';
$mensagemErro = '';
$mensagemAviso = '';

if (isset($_GET['erro'])) {
   if ($_GET['erro'] === 'nenhum_produto') {
       $mensagemErro = 'Selecione pelo menos um produto para adicionar à cesta.';
   }

   if ($_GET['erro'] === 'erro_adicionar') {
       $mensagemErro = 'Erro ao adicionar produtos à cesta.';
   }
}

if (isset($_GET['sucesso'])) {
   if ($_GET['sucesso'] === 'adicionado') {
       $adicionados = $_GET['adicionados'] ?? 0;
       $mensagemSucesso = $adicionados . ' produto(s) adicionado(s) à cesta com sucesso.';
   }
}

if (isset($_GET['duplicados']) && $_GET['duplicados'] > 0) {
   $mensagemAviso = $_GET['duplicados'] . ' produto(s) já estavam na cesta e não foram duplicados.';
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

   <div class="d-flex justify-content-between align-items-center mb-4">
       <div>
           <h1 class="page-title mb-1">Selecionar Produtos</h1>
           <p class="text-muted mb-0">
               Escolha os produtos que deseja incluir na sua cesta.
           </p>
       </div>

       <a href="cesta_visualizar.php" class="btn btn-outline-primary">
           <i class="bi bi-cart3"></i>
           Ver Minha Cesta
       </a>
   </div>

   <?php if (!empty($mensagemSucesso)): ?>
       <div class="alert alert-success">
           <?= htmlspecialchars($mensagemSucesso) ?>
       </div>
   <?php endif; ?>

   <?php if (!empty($mensagemAviso)): ?>
       <div class="alert alert-warning">
           <?= htmlspecialchars($mensagemAviso) ?>
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
                       <p class="text-muted mb-0">Itens na cesta</p>
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
                       <p class="text-muted mb-0">Valor atual da cesta</p>
                       <h3 class="mb-0">
                           R$ <?= number_format((float) $valorTotal, 2, ',', '.') ?>
                       </h3>
                   </div>
               </div>
           </div>
       </div>

   </div>

   <form method="POST" action="cesta_adicionar.php">

       <div class="card shadow-sm">
           <div class="card-body">

               <?php if (count($produtos) === 0): ?>

                   <div class="alert alert-info mb-0">
                       Nenhum produto cadastrado. Cadastre produtos antes de montar a cesta.
                   </div>

               <?php else: ?>

                   <div class="table-responsive">
                       <table class="table table-hover align-middle">
                           <thead class="table-primary">
                               <tr>
                                   <th style="width: 70px;">Selecionar</th>
                                   <th>Produto</th>
                                   <th>Descrição</th>
                                   <th>Fornecedor</th>
                                   <th>Preço</th>
                                   <th>Status</th>
                               </tr>
                           </thead>

                           <tbody>
                               <?php foreach ($produtos as $produto): ?>
                                   <?php
                                       $jaNaCesta = $cestaObj->produtoEstaNaCestaAberta($usuarioId, $produto['id']);
                                   ?>

                                   <tr>
                                       <td class="text-center">
                                           <input
                                               type="checkbox"
                                               name="produtos[]"
                                               value="<?= $produto['id'] ?>"
                                               class="form-check-input"
                                               <?= $jaNaCesta ? 'disabled' : '' ?>
                                           >
                                       </td>

                                       <td>
                                           <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                                       </td>

                                       <td>
                                           <?= htmlspecialchars($produto['descricao'] ?? '-') ?>
                                       </td>

                                       <td>
                                           <?= htmlspecialchars($produto['fornecedor_nome']) ?>
                                       </td>

                                       <td>
                                           R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?>
                                       </td>

                                       <td>
                                           <?php if ($jaNaCesta): ?>
                                               <span class="badge bg-success">
                                                   Já está na cesta
                                               </span>
                                           <?php else: ?>
                                               <span class="badge bg-secondary">
                                                   Disponível
                                               </span>
                                           <?php endif; ?>
                                       </td>
                                   </tr>

                               <?php endforeach; ?>
                           </tbody>
                       </table>
                   </div>

                   <div class="d-flex justify-content-end gap-2 mt-3">
                       <a href="dashboard.php" class="btn btn-secondary">
                           Voltar
                       </a>

                       <button type="submit" class="btn btn-primary">
                           <i class="bi bi-cart-plus"></i>
                           Adicionar à cesta
                       </button>
                   </div>

               <?php endif; ?>

           </div>
       </div>

   </form>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
