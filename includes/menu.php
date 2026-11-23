<button type="button" class="menu-botao" aria-expanded="false" aria-controls="menu" aria-label="Abrir menu">
    <i data-lucide="menu" aria-hidden="true"></i>
</button>

<nav class="menu" id="menu">
    <?php if ($painel): ?>
        <?php if (isset($_SESSION['admin_id'])): ?>
            <a href="index.php" class="<?= $pagina == 'painel' ? 'ativo' : '' ?>">Painel</a>
            <a href="cidades.php" class="<?= $pagina == 'cidades' ? 'ativo' : '' ?>">Cidades</a>
            <a href="usuarios.php" class="<?= $pagina == 'usuarios' ? 'ativo' : '' ?>">Usuários</a>
            <a href="logout.php" class="botao-contorno">Sair</a>
        <?php else: ?>
            <a href="../index.php">Voltar ao site</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="<?= $raiz ?>pages/preview.php" class="<?= $pagina == 'previsao' ? 'ativo' : '' ?>">Previsão</a>
        <a href="<?= $raiz ?>pages/planos.php" class="<?= $pagina == 'planos' ? 'ativo' : '' ?>">Plano</a>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="<?= $raiz ?>pages/perfil.php" class="<?= $pagina == 'perfil' ? 'ativo' : '' ?>">Perfil</a>
            <a href="<?= $raiz ?>pages/logout.php" class="botao-contorno">Sair</a>
        <?php else: ?>
            <a href="<?= $raiz ?>pages/login.php" class="botao-contorno">Entrar</a>
        <?php endif; ?>
    <?php endif; ?>
</nav>