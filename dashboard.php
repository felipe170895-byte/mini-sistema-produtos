<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Database.php';

$conn = Database::conectar();

$totalFornecedores = 0;
$totalProdutos = 0;
$totalItensCesta = 0;
$valorTotalCesta = 0;

try {
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM fornecedores");
    $totalFornecedores = $stmt->fetch()['total'];

    $stmt = $conn->query("SELECT COUNT(*) AS total FROM produtos");
    $totalProdutos = $stmt->fetch()['total'];

} catch (PDOException $e) {
    $erroDashboard = $e->getMessage();
}

require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Dashboard</h1>
            <p class="text-muted mb-0">
                Bem-vindo ao Mini Sistema de Gestão de Produtos.
            </p>
        </div>
    </div>

    <?php if (isset($erroDashboard)): ?>
        <div class="alert alert-danger">
            Erro ao carregar informações do dashboard: <?= htmlspecialchars($erroDashboard) ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card card-dashboard shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="card-icon bg-primary-subtle text-primary">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Fornecedores</p>
                        <h3 class="mb-0"><?= $totalFornecedores ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="card-icon bg-success-subtle text-success">
                        <i class="bi bi-bag"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Produtos</p>
                        <h3 class="mb-0"><?= $totalProdutos ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="card-icon bg-warning-subtle text-warning">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Itens na Cesta</p>
                        <h3 class="mb-0"><?= $totalItensCesta ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="card-icon bg-info-subtle text-info">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Valor da Cesta</p>
                        <h3 class="mb-0">R$ <?= number_format($valorTotalCesta, 2, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Acesso rápido</h5>

            <div class="row g-3">

                <div class="col-md-3">
                    <a href="fornecedores_listar.php" class="btn btn-primary w-100">
                        <i class="bi bi-truck"></i>
                        Fornecedores
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="produtos_listar.php" class="btn btn-success w-100">
                        <i class="bi bi-bag"></i>
                        Produtos
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="cesta_produtos.php" class="btn btn-warning w-100">
                        <i class="bi bi-check2-square"></i>
                        Selecionar Produtos
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="painel_ajax.php" class="btn btn-info w-100 text-white">
                        <i class="bi bi-arrow-repeat"></i>
                        Painel AJAX
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <strong>Observação:</strong> nesta etapa estamos testando apenas o layout base.
        A autenticação real será ativada na próxima parte.
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>