<?php
require_once __DIR__ . '/../../includes/iniciar.php';

if (isset($_GET['id'])) {
    $cidade = buscarCidade($_GET['id']);
} else {
    $cidade = primeiraCidade();
}

if (!$cidade) {
    mensagem('erro', 'Cidade não encontrada.');
    redirecionar('../index.php');
}

$raiz = '../';
$titulo = 'Previsão - ' . $cidade['nome'];
$estilos = ['preview'];
$pagina = 'previsao';
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container previsao">
        <?php mostrarMensagem(); ?>

        <section class="clima-atual">
            <span class="local">
                <i data-lucide="map-pin" aria-hidden="true"></i>
                <?= e($cidade['nome']) ?>, <?= e($cidade['estado']) ?>
            </span>

            <h1 class="clima-cidade"><?= e($cidade['nome']) ?></h1>
            <p class="texto-auxiliar-sm"><?= e($cidade['estado']) ?>, <?= e($cidade['pais']) ?></p>

            <div class="clima-temperatura">
                <i data-lucide="<?= e($cidade['icone']) ?>" class="icone-clima-grande" aria-hidden="true"></i>
                <span class="texto-temperatura"><?= e($cidade['temperatura']) ?>°C</span>
            </div>

            <h2 class="clima-condicao"><?= e($cidade['condicao']) ?></h2>
            <p class="texto-descricao"><?= e($cidade['descricao']) ?></p>

            <dl class="metricas">
                <div>
                    <dt class="texto-auxiliar-sm">Sensação</dt>
                    <dd><?= e($cidade['sensacao']) ?>°</dd>
                </div>
                <div>
                    <dt class="texto-auxiliar-sm">Vento</dt>
                    <dd><?= e($cidade['vento']) ?> km/h</dd>
                </div>
                <div>
                    <dt class="texto-auxiliar-sm">Umidade</dt>
                    <dd><?= e($cidade['umidade']) ?>%</dd>
                </div>
                <div>
                    <dt class="texto-auxiliar-sm">Visibilidade</dt>
                    <dd><?= e($cidade['visibilidade']) ?> km</dd>
                </div>
                <div>
                    <dt class="texto-auxiliar-sm">Pressão</dt>
                    <dd><?= e($cidade['pressao']) ?> hPa</dd>
                </div>
                <div>
                    <dt class="texto-auxiliar-sm">Máx. / Mín.</dt>
                    <dd><?= e($cidade['maxima']) ?>° / <?= e($cidade['minima']) ?>°</dd>
                </div>
            </dl>

            <p class="texto-auxiliar-sm">Atualizado às <?= date('H:i', strtotime($cidade['atualizado_em'])) ?></p>
        </section>

        <section class="painel">
            <h2 class="texto-titulo-secao">Previsão para hoje</h2>

            <div class="previsao-hoje">
                <div class="dia">
                    <strong>Hoje · <?= date('d/m') ?></strong>
                    <i data-lucide="<?= e($cidade['icone']) ?>" aria-hidden="true"></i>
                    <span class="dia-temperatura"><?= e($cidade['maxima']) ?>° / <?= e($cidade['minima']) ?>°</span>
                </div>

                <div class="dia-detalhes">
                    <h3><?= e($cidade['condicao']) ?></h3>
                    <p class="texto-auxiliar">Umidade: <?= e($cidade['umidade']) ?>%</p>
                    <p class="texto-auxiliar">Pressão: <?= e($cidade['pressao']) ?> hPa</p>
                    <p class="texto-auxiliar dia-vento">Vento: <?= e($cidade['vento']) ?> km/h</p>
                </div>
            </div>
        </section>

        <section class="painel painel-restrito">
            <p class="restrito-topo texto-auxiliar-sm">
                <i data-lucide="lock" aria-hidden="true"></i>
                Previsão completa · Acesso restrito
            </p>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <h2 class="restrito-titulo">Sua previsão completa está liberada</h2>
                <p class="texto-auxiliar">Veja os detalhes, os próximos dias e salve <?= e($cidade['nome']) ?> nas suas favoritas.</p>

                <div class="restrito-botoes">
                    <a href="principal.php?id=<?= $cidade['id'] ?>" class="botao-primario">Ver previsão completa</a>
                </div>
            <?php else: ?>
                <h2 class="restrito-titulo">Faça login para ver a previsão completa</h2>
                <p class="texto-auxiliar">Entre na sua conta ou cadastre-se para continuar. Os recursos disponíveis dependem do seu plano.</p>

                <div class="restrito-botoes">
                    <a href="login.php" class="botao-primario">Entrar</a>
                    <a href="cadastro.php" class="botao-contorno">Criar conta</a>
                </div>
            <?php endif; ?>
        </section>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
