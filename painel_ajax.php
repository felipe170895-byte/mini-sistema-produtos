<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

   <div class="mb-4">
       <h1 class="page-title mb-1">Painel AJAX</h1>
       <p class="text-muted mb-0">
           Esta página carrega e atualiza informações sem recarregar a tela.
       </p>
   </div>

   <div id="mensagemAjax"></div>

   <div class="row g-4">

       <div class="col-lg-6">
           <div class="card shadow-sm">
               <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                   <strong>
                       <i class="bi bi-truck"></i>
                       Fornecedores via AJAX
                   </strong>

                   <button class="btn btn-light btn-sm" onclick="carregarFornecedores()">
                       Atualizar
                   </button>
               </div>

               <div class="card-body">
                   <div id="listaFornecedores">
                       <p class="text-muted mb-0">Clique em atualizar para carregar fornecedores.</p>
                   </div>
               </div>
           </div>
       </div>

       <div class="col-lg-6">
           <div class="card shadow-sm">
               <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                   <strong>
                       <i class="bi bi-bag"></i>
                       Produtos via AJAX
                   </strong>

                   <button class="btn btn-light btn-sm" onclick="carregarProdutos()">
                       Atualizar
                   </button>
               </div>

               <div class="card-body">
                   <div id="listaProdutos">
                       <p class="text-muted mb-0">Clique em atualizar para carregar produtos.</p>
                   </div>
               </div>
           </div>
       </div>

   </div>

   <div class="card shadow-sm mt-4">
       <div class="card-header bg-warning d-flex justify-content-between align-items-center">
           <strong>
               <i class="bi bi-cart3"></i>
               Resumo da Cesta via AJAX
           </strong>

           <button class="btn btn-dark btn-sm" onclick="carregarResumoCesta()">
               Atualizar Resumo
           </button>
       </div>

       <div class="card-body">
           <div id="resumoCestaAjax">
               <p class="text-muted mb-0">Clique em atualizar para carregar o resumo da cesta.</p>
           </div>
       </div>
   </div>

   <div class="alert alert-info mt-4">
       <strong>Observação:</strong> esta tela demonstra o uso de AJAX com Fetch API para buscar e atualizar dados sem recarregar a página.
   </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
