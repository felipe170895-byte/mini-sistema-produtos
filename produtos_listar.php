<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Produto.php';

$produtoObj = new Produto();
$produtos = $produtoObj->listarTodos();

$mensagemSucesso = '';
$mensagemErro = '';

if (isset($_GET['sucesso'])) {
    if ($_GET['sucesso'] === 'cadastrado') {
        $mensagemSucesso = 'Produto cadastrado com sucesso.';
    }

    if ($_GET['sucesso'] === 'atualizado') {
        $mensagemSucesso = 'Produto atualizado com sucesso.';
    }

    if ($_GET['sucesso'] === 'excluido') {
        $mensagemSucesso = 'Produto excluído com sucesso.';
    }
}

if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'nao_encontrado') {
        $mensagemErro = 'Produto não encontrado.';
    }

    if ($_GET['erro'] === 'produto_em_cesta') {
        $mensagemErro = 'Não é possível excluir este produto, pois ele já está vinculado a uma cesta.';
    }

    if ($_GET['erro'] === 'erro_excluir') {
        $mensagemErro = 'Erro ao excluir produto.';
    }
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Produtos</h1>
            <p class="text-muted mb-0">
                Gerencie os produtos cadastrados no sistema.
            </p>
        </div>

        <a href="produtos_novo.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Novo Produto
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

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (count($produtos) === 0): ?>

                <div class="alert alert-info mb-0">
                    Nenhum produto cadastrado.
                </div>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Fornecedor</th>
                                <th>Preço</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td><?= $produto['id'] ?></td>

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

                                    <td class="text-center">
                                        <a 
                                            href="produtos_editar.php?id=<?= $produto['id'] ?>" 
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        <a 
                                            href="produtos_excluir.php?id=<?= $produto['id'] ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            <?php endif; ?>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>