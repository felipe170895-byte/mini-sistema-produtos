<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Produto.php';
require_once __DIR__ . '/classes/Fornecedor.php';

$produtoObj = new Produto();
$fornecedorObj = new Fornecedor();

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: produtos_listar.php?erro=nao_encontrado');
    exit;
}

$produto = $produtoObj->buscarPorId($id);

if (!$produto) {
    header('Location: produtos_listar.php?erro=nao_encontrado');
    exit;
}

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

    if ($_GET['erro'] === 'erro_atualizar') {
        $mensagemErro = 'Erro ao atualizar produto.';
    }
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Editar Produto</h1>
            <p class="text-muted mb-0">
                Atualize os dados do produto selecionado.
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

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="produtos_atualizar.php">

                <input type="hidden" name="id" value="<?= $produto['id'] ?>">

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do produto *</label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        class="form-control" 
                        value="<?= htmlspecialchars($produto['nome']) ?>"
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
                    ><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço *</label>
                    <input 
                        type="text" 
                        name="preco" 
                        id="preco" 
                        class="form-control" 
                        value="<?= number_format((float) $produto['preco'], 2, ',', '.') ?>"
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
                            <option 
                                value="<?= $fornecedor['id'] ?>"
                                <?= $fornecedor['id'] == $produto['fornecedor_id'] ? 'selected' : '' ?>
                            >
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
                        Atualizar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>