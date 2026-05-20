<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="mb-4">
        <h1 class="page-title mb-1">Painel AJAX</h1>
        <p class="text-muted mb-0">
            Esta página permite cadastrar, listar e atualizar dados sem recarregar a tela.
        </p>
    </div>

    <div id="mensagemAjax"></div>

    <!-- FORMULÁRIOS DE CADASTRO VIA AJAX -->
    <div class="row g-4 mb-4">

        <!-- Novo Fornecedor via AJAX -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>
                        <i class="bi bi-plus-circle"></i>
                        Novo Fornecedor via AJAX
                    </strong>
                </div>

                <div class="card-body">

                    <div class="mb-2">
                        <label class="form-label">Nome *</label>
                        <input 
                            type="text" 
                            id="novo-fornecedor-nome" 
                            class="form-control"
                            placeholder="Ex: Mercado Central"
                        >
                    </div>

                    <div class="mb-2">
                        <label class="form-label">CNPJ</label>
                        <input 
                            type="text" 
                            id="novo-fornecedor-cnpj" 
                            class="form-control mascara-cnpj" 
                            maxlength="18"
                            placeholder="Ex: 00.000.000/0001-00"
                        >
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Telefone</label>
                        <input 
                            type="text" 
                            id="novo-fornecedor-telefone" 
                            class="form-control mascara-telefone" 
                            maxlength="15"
                            placeholder="Ex: (45) 99999-9999"
                        >
                    </div>

                    <div class="mb-2">
                        <label class="form-label">E-mail</label>
                        <input 
                            type="email" 
                            id="novo-fornecedor-email" 
                            class="form-control"
                            placeholder="Ex: contato@fornecedor.com"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input 
                            type="text" 
                            id="novo-fornecedor-endereco" 
                            class="form-control"
                            placeholder="Ex: Rua Brasil, 100"
                        >
                    </div>

                    <button type="button" class="btn btn-primary" onclick="criarFornecedorAjax()">
                        <i class="bi bi-check-circle"></i>
                        Cadastrar Fornecedor via AJAX
                    </button>

                </div>
            </div>
        </div>

        <!-- Novo Produto via AJAX -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong>
                        <i class="bi bi-plus-circle"></i>
                        Novo Produto via AJAX
                    </strong>
                </div>

                <div class="card-body">

                    <div class="mb-2">
                        <label class="form-label">Nome *</label>
                        <input 
                            type="text" 
                            id="novo-produto-nome" 
                            class="form-control"
                            placeholder="Ex: Arroz 5kg"
                        >
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Descrição</label>
                        <textarea 
                            id="novo-produto-descricao" 
                            class="form-control"
                            rows="2"
                            placeholder="Ex: Pacote de arroz tipo 1"
                        ></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Preço *</label>
                        <input 
                            type="text" 
                            id="novo-produto-preco" 
                            class="form-control" 
                            placeholder="Ex: 25,90"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fornecedor *</label>
                        <select id="novo-produto-fornecedor" class="form-select">
                            <option value="">Carregando fornecedores...</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-success" onclick="criarProdutoAjax()">
                        <i class="bi bi-check-circle"></i>
                        Cadastrar Produto via AJAX
                    </button>

                </div>
            </div>
        </div>

    </div>

    <!-- LISTAGENS VIA AJAX -->
    <div class="row g-4">

        <!-- Fornecedores via AJAX -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <strong>
                        <i class="bi bi-truck"></i>
                        Fornecedores via AJAX
                    </strong>

                    <button type="button" class="btn btn-light btn-sm" onclick="carregarFornecedores()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Atualizar
                    </button>
                </div>

                <div class="card-body">
                    <div id="listaFornecedores">
                        <p class="text-muted mb-0">
                            Clique em atualizar para carregar fornecedores.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produtos via AJAX -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <strong>
                        <i class="bi bi-bag"></i>
                        Produtos via AJAX
                    </strong>

                    <button type="button" class="btn btn-light btn-sm" onclick="carregarProdutos()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Atualizar
                    </button>
                </div>

                <div class="card-body">
                    <div id="listaProdutos">
                        <p class="text-muted mb-0">
                            Clique em atualizar para carregar produtos.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RESUMO DA CESTA VIA AJAX -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
            <strong>
                <i class="bi bi-cart3"></i>
                Resumo da Cesta via AJAX
            </strong>

            <button type="button" class="btn btn-dark btn-sm" onclick="carregarResumoCesta()">
                <i class="bi bi-arrow-clockwise"></i>
                Atualizar Resumo
            </button>
        </div>

        <div class="card-body">
            <div id="resumoCestaAjax">
                <p class="text-muted mb-0">
                    Clique em atualizar para carregar o resumo da cesta.
                </p>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <strong>Observação:</strong> esta tela demonstra o uso de AJAX com JavaScript Fetch API.
        Os dados são enviados e carregados sem recarregar a página inteira.
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>