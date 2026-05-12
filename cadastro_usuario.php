<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Usuario.php';

$mensagemErro = '';
$mensagemSucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $confirmarSenha = trim($_POST['confirmar_senha'] ?? '');

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
        $mensagemErro = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagemErro = 'Informe um e-mail válido.';
    } elseif ($senha !== $confirmarSenha) {
        $mensagemErro = 'As senhas não conferem.';
    } else {
        $usuario = new Usuario();

        if ($usuario->emailExiste($email)) {
            $mensagemErro = 'Este e-mail já está cadastrado.';
        } else {
            $cadastrou = $usuario->cadastrar($nome, $email, $senha);

            if ($cadastrou) {
                $mensagemSucesso = 'Usuário cadastrado com sucesso. Agora você já pode fazer login.';
            } else {
                $mensagemErro = 'Erro ao cadastrar usuário.';
            }
        }
    }
}
?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">
                        <i class="bi bi-person-plus"></i>
                        Criar Conta
                    </h2>
                    <p class="text-muted mb-0">
                        Cadastre-se para acessar o sistema.
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

                <form method="POST" action="cadastro_usuario.php">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input 
                            type="text" 
                            name="nome" 
                            id="nome" 
                            class="form-control" 
                            placeholder="Digite seu nome"
                            required
                        >
                    </div>

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

                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar senha</label>
                        <input 
                            type="password" 
                            name="confirmar_senha" 
                            id="confirmar_senha" 
                            class="form-control" 
                            placeholder="Confirme sua senha"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i>
                        Cadastrar
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none">
                        Já tenho conta. Fazer login.
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?><?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/classes/Usuario.php';

$mensagemErro = '';
$mensagemSucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $confirmarSenha = trim($_POST['confirmar_senha'] ?? '');

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
        $mensagemErro = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagemErro = 'Informe um e-mail válido.';
    } elseif ($senha !== $confirmarSenha) {
        $mensagemErro = 'As senhas não conferem.';
    } else {
        $usuario = new Usuario();

        if ($usuario->emailExiste($email)) {
            $mensagemErro = 'Este e-mail já está cadastrado.';
        } else {
            $cadastrou = $usuario->cadastrar($nome, $email, $senha);

            if ($cadastrou) {
                $mensagemSucesso = 'Usuário cadastrado com sucesso. Agora você já pode fazer login.';
            } else {
                $mensagemErro = 'Erro ao cadastrar usuário.';
            }
        }
    }
}
?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">
                        <i class="bi bi-person-plus"></i>
                        Criar Conta
                    </h2>
                    <p class="text-muted mb-0">
                        Cadastre-se para acessar o sistema.
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

                <form method="POST" action="cadastro_usuario.php">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input 
                            type="text" 
                            name="nome" 
                            id="nome" 
                            class="form-control" 
                            placeholder="Digite seu nome"
                            required
                        >
                    </div>

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

                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar senha</label>
                        <input 
                            type="password" 
                            name="confirmar_senha" 
                            id="confirmar_senha" 
                            class="form-control" 
                            placeholder="Confirme sua senha"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i>
                        Cadastrar
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none">
                        Já tenho conta. Fazer login.
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>