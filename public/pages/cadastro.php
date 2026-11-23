<?php
require_once __DIR__ . '/../../includes/iniciar.php';

$nome = '';
$email = '';
$erros = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = campoPost('nome');
    $email = strtolower(campoPost('email'));
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar-senha'] ?? '';

    $erros = validarCadastro($nome, $email, $senha, $confirmarSenha);

    if (count($erros) == 0) {
        $_SESSION['usuario_id'] = criarUsuario($nome, $email, $senha);
        mensagem('sucesso', 'Conta criada com sucesso!');
        redirecionar('perfil.php');
    }
}

$raiz = '../';
$titulo = 'Criar conta';
$estilos = ['login', 'cadastro'];
$scripts = ['cadastro'];
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container login">

        <section class="login-caixa">
            <h1>Criar conta</h1>
            <p class="texto-auxiliar login-subtitulo">Preencha seus dados para acessar o ClimaTempo. Todos os campos são obrigatórios.</p>

            <form class="login-form" id="cadastro-form" method="post" action="cadastro.php" novalidate>
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" value="<?= e($nome) ?>" placeholder="Ana Silva" autocomplete="name" maxlength="100" required aria-describedby="erro-nome" class="<?= isset($erros['nome']) ? 'campo-erro' : '' ?>">
                <p class="campo-mensagem" id="erro-nome" <?= isset($erros['nome']) ? '' : 'hidden' ?>>Erro: <?= e($erros['nome'] ?? '') ?></p>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="ana.silva@exemplo.com" autocomplete="email" maxlength="150" required aria-describedby="erro-email" class="<?= isset($erros['email']) ? 'campo-erro' : '' ?>">
                <p class="campo-mensagem" id="erro-email" <?= isset($erros['email']) ? '' : 'hidden' ?>>Erro: <?= e($erros['email'] ?? '') ?></p>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Sua senha" autocomplete="new-password" minlength="8" required aria-describedby="dica-senha erro-senha" class="<?= isset($erros['senha']) ? 'campo-erro' : '' ?>">
                <p class="campo-dica" id="dica-senha">Use pelo menos 8 caracteres.</p>
                <p class="campo-mensagem" id="erro-senha" <?= isset($erros['senha']) ? '' : 'hidden' ?>>Erro: <?= e($erros['senha'] ?? '') ?></p>

                <label for="confirmar-senha">Confirmar senha</label>
                <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Repita a senha" autocomplete="new-password" minlength="8" required aria-describedby="erro-confirmar-senha" class="<?= isset($erros['confirmar-senha']) ? 'campo-erro' : '' ?>">
                <p class="campo-mensagem" id="erro-confirmar-senha" <?= isset($erros['confirmar-senha']) ? '' : 'hidden' ?>>Erro: <?= e($erros['confirmar-senha'] ?? '') ?></p>

                <button type="submit" class="botao-primario">Criar conta</button>
                <p class="texto-auxiliar-sm cadastro-resumo" id="cadastro-resumo" role="alert" <?= count($erros) > 0 ? '' : 'hidden' ?>>Revise os campos indicados antes de continuar.</p>
            </form>

            <p class="texto-auxiliar login-rodape">Já tem uma conta? <a href="login.php">Entrar</a></p>
        </section>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
