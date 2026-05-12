<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';

$mensagemErro = '';

if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'nome_obrigatorio') {
        $mensagemErro = 'O nome do fornecedor é obrigatório.';
    }

    if ($_GET['erro'] === 'cnpj_invalido') {
        $mensagemErro = 'O CNPJ deve conter 14 números.';
    }

    if ($_GET['erro'] === 'telefone_invalido') {
        $mensagemErro = 'O telefone deve conter 10 ou 11 números, incluindo o DDD.';
    }

    if ($_GET['erro'] === 'email_invalido') {
        $mensagemErro = 'Informe um e-mail válido.';
    }

    if ($_GET['erro'] === 'erro_cadastrar') {
        $mensagemErro = 'Erro ao cadastrar fornecedor.';
    }
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Novo Fornecedor</h1>
            <p class="text-muted mb-0">
                Cadastre um novo fornecedor no sistema.
            </p>
        </div>

        <a href="fornecedores_listar.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Voltar
        </a>
    </div>

    <?php if (!empty($mensagemErro)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($mensagemErro) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="fornecedores_salvar.php">

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do fornecedor *</label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        class="form-control" 
                        placeholder="Ex: Mercado Central"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input 
                     type="text" 
                     name="cnpj" 
                     id="cnpj" 
                     class="form-control mascara-cnpj" 
                    placeholder="Ex: 00.000.000/0001-00"
                    maxlength="18"
                    >
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input 
                      type="text" 
                      name="telefone" 
                      id="telefone" 
                      class="form-control mascara-telefone" 
                      placeholder="Ex: (45) 99999-9999"
                      maxlength="15"
                    >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control" 
                        placeholder="Ex: contato@fornecedor.com"
                    >
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input 
                        type="text" 
                        name="endereco" 
                        id="endereco" 
                        class="form-control" 
                        placeholder="Ex: Rua Brasil, 100"
                    >
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="fornecedores_listar.php" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i>
                        Salvar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>