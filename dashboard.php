<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Database.php';

$conn = Database::conectar();

$usuarioId = $_SESSION['usuario_id'];
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';

$totalFornecedores = 0;
$totalProdutos = 0;
$totalItensCesta = 0;
$valorTotalCesta = 0;
$erroDashboard = '';

try {
    // Total de fornecedores
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM fornecedores");
    $totalFornecedores = $stmt->fetch()['total'];

    // Total de produtos
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM produtos");
    $totalProdutos = $stmt->fetch()['total'];

    // Buscar cesta aberta do usuário
    $sql = "
        SELECT 
            c.id AS cesta_id,
            COUNT(ci.id) AS total_itens,
            COALESCE(SUM(ci.preco_unitario), 0) AS valor_total
        FROM cestas c
        LEFT JOIN cesta_itens ci ON ci.cesta_id = c.id
        WHERE c.usuario_id = ?
        AND c.status = 'aberta'
        GROUP BY c.id
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuarioId]);
    $cesta = $stmt->fetch();

    if ($cesta) {
        $totalItensCesta = $cesta['total_itens'];
        $valorTotalCesta = $cesta['valor_total'];
    }

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
                Bem-vindo, <?= htmlspecialchars($nomeUsuario) ?>.
            </p>
        </div>

        <div>
            <a href="cesta_visualizar.php" class="btn btn-outline-primary">
                <i class="bi bi-cart3"></i>
                Ver Minha Cesta
            </a>
        </div>
    </div>

    <?php if (!empty($erroDashboard)): ?>
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
                        <h3 class="mb-0">
                            R$ <?= number_format((float) $valorTotalCesta, 2, ',', '.') ?>
                        </h3>
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

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Resumo do sistema</h5>

            <p class="mb-2">
                Este sistema permite gerenciar fornecedores, produtos e cestas de produtos.
            </p>

            <p class="mb-0 text-muted">
                Use o menu superior para navegar entre as funcionalidades.
            </p>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>