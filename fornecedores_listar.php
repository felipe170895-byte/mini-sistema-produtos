<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Fornecedor.php';

$fornecedorObj = new Fornecedor();
$fornecedores = $fornecedorObj->listarTodos();

$mensagemSucesso = '';
$mensagemErro = '';

if (isset($_GET['sucesso'])) {
    if ($_GET['sucesso'] === 'cadastrado') {
        $mensagemSucesso = 'Fornecedor cadastrado com sucesso.';
    }

    if ($_GET['sucesso'] === 'atualizado') {
        $mensagemSucesso = 'Fornecedor atualizado com sucesso.';
    }

    if ($_GET['sucesso'] === 'excluido') {
        $mensagemSucesso = 'Fornecedor excluído com sucesso.';
    }
}

if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'excluir_com_produtos') {
        $mensagemErro = 'Não é possível excluir este fornecedor, pois ele possui produtos cadastrados.';
    }

    if ($_GET['erro'] === 'nao_encontrado') {
        $mensagemErro = 'Fornecedor não encontrado.';
    }

    if ($_GET['erro'] === 'erro_excluir') {
        $mensagemErro = 'Erro ao excluir fornecedor.';
    }
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Fornecedores</h1>
            <p class="text-muted mb-0">
                Gerencie os fornecedores cadastrados no sistema.
            </p>
        </div>

        <a href="fornecedores_novo.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Novo Fornecedor
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

            <?php if (count($fornecedores) === 0): ?>

                <div class="alert alert-info mb-0">
                    Nenhum fornecedor cadastrado.
                </div>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Endereço</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <tr>
                                    <td><?= $fornecedor['id'] ?></td>

                                    <td>
                                        <strong><?= htmlspecialchars($fornecedor['nome']) ?></strong>
                                    </td>

                                    <td><?= htmlspecialchars($fornecedor['cnpj'] ?? '-') ?></td>

                                    <td><?= htmlspecialchars($fornecedor['telefone'] ?? '-') ?></td>

                                    <td><?= htmlspecialchars($fornecedor['email'] ?? '-') ?></td>

                                    <td><?= htmlspecialchars($fornecedor['endereco'] ?? '-') ?></td>

                                    <td class="text-center">
                                        <a 
                                            href="fornecedores_editar.php?id=<?= $fornecedor['id'] ?>" 
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        <a 
                                            href="fornecedores_excluir.php?id=<?= $fornecedor['id'] ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')"
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