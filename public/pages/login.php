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
        $usuario = buscarUsuarioPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_regenerate_id();
            $_SESSION['usuario_id'] = $usuario['id'];
            redirecionar('principal.php');
        }

        $erro = 'E-mail ou senha incorretos. Verifique seus dados e tente novamente.';
    }
}

$raiz = '../';
$titulo = 'Entrar';
$estilos = ['login'];
$scripts = ['login'];
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container login">

        <section class="login-caixa">
            <?php mostrarMensagem(); ?>

            <h1>Entrar</h1>
            <p class="texto-auxiliar login-subtitulo">Acesse sua conta do ClimaTempo para acompanhar suas cidades.</p>

            <div class="login-erro" id="login-erro" role="alert" <?= $erro == '' ? 'hidden' : '' ?>>
                <strong id="login-erro-titulo">Não foi possível entrar</strong>
                <p id="login-erro-texto"><?= e($erro) ?></p>
            </div>

            <form class="login-form" id="login-form" method="post" action="login.php" novalidate>
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="ana.silva@exemplo.com" autocomplete="email" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Sua senha" autocomplete="current-password" required>

                <button type="submit" class="botao-primario">Entrar</button>
            </form>

            <p class="texto-auxiliar login-rodape">Não tem uma conta? <a href="cadastro.php">Criar conta</a></p>
        </section>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
