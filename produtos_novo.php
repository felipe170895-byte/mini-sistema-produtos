<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Fornecedor.php';

$fornecedorObj = new Fornecedor();
$fornecedores = $fornecedorObj->listarTodos();

$mensagemErro = '';

if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'nome_obrigatorio') {
        $mensagemErro = 'O nome do produto é obrigatório.';
    }

    if ($_GET['erro'] === 'preco_obrigatorio') {
        $mensagemErro = 'O preço do produto é obrigatório.';
    }

    if ($_GET['erro'] === 'preco_invalido') {
        $mensagemErro = 'O preço deve ser maior que zero.';
    }

    if ($_GET['erro'] === 'fornecedor_obrigatorio') {
        $mensagemErro = 'Selecione um fornecedor.';
    }

    if ($_GET['erro'] === 'fornecedor_invalido') {
        $mensagemErro = 'Fornecedor selecionado é inválido.';
    }

    if ($_GET['erro'] === 'erro_cadastrar') {
        $mensagemErro = 'Erro ao cadastrar produto.';
    }
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Novo Produto</h1>
            <p class="text-muted mb-0">
                Cadastre um produto e relacione com um fornecedor.
            </p>
        </div>

        <a href="produtos_listar.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Voltar
        </a>
    </div>

    <?php if (!empty($mensagemErro)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($mensagemErro) ?>
        </div>
    <?php endif; ?>

    <?php if (count($fornecedores) === 0): ?>

        <div class="alert alert-warning">
            Para cadastrar produtos, primeiro cadastre pelo menos um fornecedor.
        </div>

        <a href="fornecedores_novo.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Cadastrar Fornecedor
        </a>

    <?php else: ?>

        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST" action="produtos_salvar.php">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do produto *</label>
                        <input 
                            type="text" 
                            name="nome" 
                            id="nome" 
                            class="form-control" 
                            placeholder="Ex: Arroz 5kg"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea 
                            name="descricao" 
                            id="descricao" 
                            class="form-control" 
                            rows="3"
                            placeholder="Ex: Pacote de arroz tipo 1"
                        ></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço *</label>
                        <input 
                            type="text" 
                            name="preco" 
                            id="preco" 
                            class="form-control" 
                            placeholder="Ex: 25,90"
                            required
                        >
                        <small class="text-muted">
                            Use ponto ou vírgula. Exemplo: 25.90 ou 25,90.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="fornecedor_id" class="form-label">Fornecedor *</label>
                        <select name="fornecedor_id" id="fornecedor_id" class="form-select" required>
                            <option value="">Selecione um fornecedor</option>

                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <option value="<?= $fornecedor['id'] ?>">
                                    <?= htmlspecialchars($fornecedor['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="produtos_listar.php" class="btn btn-secondary">
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

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>