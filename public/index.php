<?php
require_once __DIR__ . '/../includes/iniciar.php';

$busca = trim($_GET['busca'] ?? '');
$cidades = listarCidades($busca);

$raiz = '';
$titulo = 'Início';
$estilos = ['index'];
$scripts = ['index'];
$buscaTopo = false;
require __DIR__ . '/../includes/header.php';
?>

    <main class="container">
        <?php mostrarMensagem(); ?>

        <section class="hero">
            <h1 class="hero-titulo"><?= e(saudacao()) ?>. Como está o tempo?</h1>

            <form class="busca busca-grande" role="search" action="index.php" method="get">
                <i data-lucide="search" class="icone-busca" aria-hidden="true"></i>
                <input type="search" name="busca" value="<?= e($busca) ?>" placeholder="Pesquisar cidade" aria-label="Pesquisar cidade">
            </form>

            <ul class="atalhos">
                <li>
                    <a href="pages/preview.php" class="atalho">
                        <span class="atalho-icone">
                            <i data-lucide="cloud-sun" aria-hidden="true"></i>
                        </span>
                        Previsão
                    </a>
                </li>
                <li>
                    <a href="#feed" class="atalho">
                        <span class="atalho-icone">
                            <i data-lucide="newspaper" aria-hidden="true"></i>
                        </span>
                        Notícias
                    </a>
                </li>
                <li>
                    <a href="pages/planos.php" class="atalho">
                        <span class="atalho-icone">
                            <i data-lucide="layout-grid" aria-hidden="true"></i>
                        </span>
                        Plano
                    </a>
                </li>
                <li>
                    <a href="pages/perfil.php" class="atalho">
                        <span class="atalho-icone">
                            <i data-lucide="star" aria-hidden="true"></i>
                        </span>
                        Favoritas
                    </a>
                </li>
            </ul>
        </section>

        <section class="feed" id="feed">
            <div class="feed-cabecalho">
                <?php if ($busca == ''): ?>
                    <h2 class="texto-titulo-secao">Meu feed</h2>
                <?php else: ?>
                    <h2 class="texto-titulo-secao">Resultados para "<?= e($busca) ?>"</h2>
                <?php endif; ?>

                <?php if ($busca != ''): ?>
                    <a href="index.php" class="filtro texto-auxiliar">Limpar busca</a>
                <?php endif; ?>
            </div>

            <?php if (count($cidades) == 0): ?>
                <p class="texto-auxiliar feed-vazio">Nenhuma cidade encontrada. Tente outro nome.</p>
            <?php endif; ?>

            <p class="texto-auxiliar feed-vazio" id="filtro-vazio" hidden>Nenhuma cidade encontrada. Tente outro nome.</p>

            <div class="feed-grade">

                <?php foreach ($cidades as $cidade): ?>
                    <article class="card card-clima">
                        <div class="card-clima-topo">
                            <h3 class="card-clima-cidade"><?= e($cidade['nome']) ?>, <?= e($cidade['estado']) ?></h3>
                            <span class="texto-auxiliar">Clima</span>
                        </div>

                        <div class="card-clima-temperatura">
                            <i data-lucide="<?= e($cidade['icone']) ?>" class="icone-clima" aria-hidden="true"></i>
                            <span class="texto-temperatura"><?= e($cidade['temperatura']) ?>°C</span>
                        </div>

                        <p class="texto-corpo"><?= e($cidade['condicao']) ?> · Sensação de <?= e($cidade['sensacao']) ?>°</p>
                        <p class="texto-corpo">Máx. <?= e($cidade['maxima']) ?>° · Mín. <?= e($cidade['minima']) ?>°</p>
                        <p class="texto-auxiliar-sm card-clima-atualizado">Atualizado às <?= date('H:i', strtotime($cidade['atualizado_em'])) ?></p>

                        <a href="pages/preview.php?id=<?= $cidade['id'] ?>" class="botao-primario">Ver previsão</a>
                    </article>
                <?php endforeach; ?>

                <?php if ($busca == ''): ?>
                    <article class="card card-noticia">
                        <div class="imagem-placeholder">
                            <i data-lucide="image" aria-hidden="true"></i>
                            <span class="texto-auxiliar">Imagem da notícia</span>
                        </div>
                        <div class="card-noticia-conteudo">
                            <p class="texto-auxiliar">Notícias do tempo · há 25 min</p>
                            <h3 class="card-titulo">Tempo firme marca o início da semana no Nordeste</h3>
                            <p class="texto-auxiliar">Veja os destaques e acompanhe as informações da sua região.</p>
                        </div>
                    </article>

                    <article class="card card-anuncio">
                        <span class="etiqueta">Anúncio</span>
                        <div class="imagem-placeholder imagem-anuncio">
                            <i data-lucide="image" aria-hidden="true"></i>
                            <span class="texto-auxiliar">Espaço publicitário</span>
                        </div>
                        <h3 class="card-titulo">Conteúdo patrocinado</h3>
                        <p class="texto-auxiliar">Publicidade de exemplo · Parceiro</p>
                    </article>
                <?php endif; ?>

            </div>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
