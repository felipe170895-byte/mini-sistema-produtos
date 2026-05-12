<?php

$paginaAtual = basename($_SERVER['PHP_SELF']);

function menuAtivo($pagina, $paginaAtual)
{
    return $pagina === $paginaAtual ? 'active' : '';
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>dashboard.php">
            <i class="bi bi-box-seam"></i>
            Gestão de Produtos
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link <?= menuAtivo('dashboard.php', $paginaAtual) ?>" href="<?= BASE_URL ?>dashboard.php">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= menuAtivo('fornecedores_listar.php', $paginaAtual) ?>" href="<?= BASE_URL ?>fornecedores_listar.php">
                        <i class="bi bi-truck"></i>
                        Fornecedores
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= menuAtivo('produtos_listar.php', $paginaAtual) ?>" href="<?= BASE_URL ?>produtos_listar.php">
                        <i class="bi bi-bag"></i>
                        Produtos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= menuAtivo('cesta_produtos.php', $paginaAtual) ?>" href="<?= BASE_URL ?>cesta_produtos.php">
                        <i class="bi bi-check2-square"></i>
                        Selecionar Produtos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= menuAtivo('cesta_visualizar.php', $paginaAtual) ?>" href="<?= BASE_URL ?>cesta_visualizar.php">
                        <i class="bi bi-cart3"></i>
                        Minha Cesta
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= menuAtivo('painel_ajax.php', $paginaAtual) ?>" href="<?= BASE_URL ?>painel_ajax.php">
                        <i class="bi bi-arrow-repeat"></i>
                        Painel AJAX
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-3 text-white">
                <span class="small">
                    <i class="bi bi-person-circle"></i>
                    <?= htmlspecialchars($nomeUsuario) ?>
                </span>

                <a href="<?= BASE_URL ?>logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i>
                    Sair
                </a>
            </div>

        </div>
    </div>
</nav>