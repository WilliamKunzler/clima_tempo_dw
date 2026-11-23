<?php
// Antes de incluir, a página define $raiz, $titulo, $estilos e $pagina
$estilos = $estilos ?? [];
$pagina = $pagina ?? '';
$painel = $painel ?? false;
$buscaTopo = $buscaTopo ?? true;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?> - Clima Tempo</title>
    <link rel="stylesheet" href="<?= $raiz ?>assets/css/style.css">
    <?php foreach ($estilos as $estilo): ?>
        <link rel="stylesheet" href="<?= $raiz ?>assets/css/<?= $estilo ?>.css">
    <?php endforeach; ?>
</head>

<body>

    <header class="cabecalho">
        <div class="container cabecalho-conteudo">
            <a href="<?= $raiz ?>index.php" class="marca">
                <img src="<?= $raiz ?>assets/img/logo.svg" alt="Logo do ClimaTempo: nuvem azul com sol amarelo" class="logo" width="28" height="28">
                <span class="texto-marca">ClimaTempo</span>
            </a>

            <?php if (!$painel && $buscaTopo): ?>
                <form class="busca busca-pequena" role="search" action="<?= $raiz ?>index.php" method="get">
                    <i data-lucide="search" class="icone-busca" aria-hidden="true"></i>
                    <input type="search" name="busca" placeholder="Pesquisar cidade" aria-label="Pesquisar cidade">
                </form>
            <?php endif; ?>

            <?php require __DIR__ . '/menu.php'; ?>
        </div>
    </header>