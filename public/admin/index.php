<?php
require_once __DIR__ . '/../../includes/iniciar.php';

exigirAdmin();

$raiz = '../';
$titulo = 'Painel';
$estilos = ['admin'];
$pagina = 'painel';
$painel = true;
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container admin">
        <?php mostrarMensagem(); ?>

        <h1>Olá, <?= e($_SESSION['admin_nome']) ?></h1>
        <p class="texto-auxiliar admin-subtitulo">Gerencie as cidades do site e veja os usuários cadastrados.</p>

        <section class="admin-totais">
            <article class="admin-total">
                <span class="texto-auxiliar">Cidades</span>
                <strong><?= contar('cidades') ?></strong>
                <a href="cidades.php">Gerenciar cidades</a>
            </article>
            <article class="admin-total">
                <span class="texto-auxiliar">Usuários</span>
                <strong><?= contar('usuarios') ?></strong>
                <a href="usuarios.php">Ver cadastros</a>
            </article>
            <article class="admin-total">
                <span class="texto-auxiliar">Favoritas salvas</span>
                <strong><?= contar('favoritas') ?></strong>
                <a href="usuarios.php">Ver por usuário</a>
            </article>
        </section>
    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
