<?php
require_once __DIR__ . '/../../includes/iniciar.php';

$email = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = campoPost('email');
    $senha = $_POST['senha'] ?? '';

    if ($email == '' || $senha == '') {
        $erro = 'Informe seu e-mail e sua senha para entrar.';
    } else {
        $admin = buscarAdminPorEmail($email);

        if ($admin && password_verify($senha, $admin['senha'])) {
            session_regenerate_id();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nome'] = $admin['nome'];
            redirecionar('index.php');
        }

        $erro = 'E-mail ou senha incorretos.';
    }
}

$raiz = '../';
$titulo = 'Painel';
$estilos = ['login', 'admin'];
$scripts = ['login'];
$painel = true;
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container login">

        <section class="login-caixa">
            <?php mostrarMensagem(); ?>

            <h1>Painel administrativo</h1>
            <p class="texto-auxiliar login-subtitulo">Área restrita para administradores do ClimaTempo.</p>

            <div class="login-erro" id="login-erro" role="alert" <?= $erro == '' ? 'hidden' : '' ?>>
                <strong id="login-erro-titulo">Não foi possível entrar</strong>
                <p id="login-erro-texto"><?= e($erro) ?></p>
            </div>

            <form class="login-form" id="login-form" method="post" action="login.php" novalidate>
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" autocomplete="username" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" autocomplete="current-password" required>

                <button type="submit" class="botao-primario">Entrar</button>
            </form>
        </section>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
