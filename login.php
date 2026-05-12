<?php

require_once __DIR__ . '/includes/header.php';

$mensagemErro = '';
$mensagemSucesso = '';

if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'login_invalido') {
        $mensagemErro = 'E-mail ou senha inválidos.';
    }

    if ($_GET['erro'] === 'campos_obrigatorios') {
        $mensagemErro = 'Preencha e-mail e senha.';
    }

    if ($_GET['erro'] === 'acesso_negado') {
        $mensagemErro = 'Faça login para acessar o sistema.';
    }
}

if (isset($_GET['sucesso'])) {
    if ($_GET['sucesso'] === 'logout') {
        $mensagemSucesso = 'Você saiu do sistema com sucesso.';
    }
}
?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="card shadow">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">
                        <i class="bi bi-box-seam"></i>
                        Gestão de Produtos
                    </h2>
                    <p class="text-muted mb-0">
                        Acesse sua conta para continuar.
                    </p>
                </div>

                <?php if (!empty($mensagemErro)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($mensagemErro) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mensagemSucesso)): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($mensagemSucesso) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login_processa.php">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control" 
                            placeholder="Digite seu e-mail"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input 
                            type="password" 
                            name="senha" 
                            id="senha" 
                            class="form-control" 
                            placeholder="Digite sua senha"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Entrar
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="cadastro_usuario.php" class="text-decoration-none">
                        Criar uma nova conta
                    </a>
                </div>

                <hr>

                <div class="alert alert-info small mb-0">
                    <strong>Usuário de teste:</strong><br>
                    E-mail: admin@email.com<br>
                    Senha: 123456
                </div>

            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>