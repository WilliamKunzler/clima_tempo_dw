<?php
require_once __DIR__ . '/../../includes/iniciar.php';

exigirAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cidade = buscarCidade($_POST['id'] ?? 0);

    if ($cidade) {
        excluirCidade($cidade['id']);
        mensagem('sucesso', 'Cidade ' . $cidade['nome'] . ' excluída.');
    }

    redirecionar('cidades.php');
}

$busca = trim($_GET['busca'] ?? '');
$cidades = listarCidades($busca);

$raiz = '../';
$titulo = 'Cidades';
$estilos = ['admin'];
$pagina = 'cidades';
$painel = true;
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container admin">
        <?php mostrarMensagem(); ?>

        <div class="admin-painel-topo">
            <div>
                <h1>Cidades</h1>
                <p class="texto-auxiliar admin-subtitulo">As cidades cadastradas aparecem no feed e nas páginas de previsão.</p>
            </div>
            <a href="cidade-form.php" class="botao-primario">Nova cidade</a>
        </div>

        <section class="admin-painel">
            <form class="admin-filtro" method="get" action="cidades.php">
                <label for="busca">Buscar</label>
                <input type="search" id="busca" name="busca" value="<?= e($busca) ?>" placeholder="Nome ou estado">
                <button type="submit" class="botao-contorno">Buscar</button>
            </form>

            <?php if (count($cidades) == 0): ?>
                <p class="texto-auxiliar">Nenhuma cidade encontrada.</p>
            <?php else: ?>
                <div class="tabela-rolagem">
                    <table class="admin-tabela">
                        <thead>
                            <tr>
                                <th scope="col">Cidade</th>
                                <th scope="col">Condição</th>
                                <th scope="col">Temperatura</th>
                                <th scope="col">Máx. / Mín.</th>
                                <th scope="col" class="coluna-acoes">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cidades as $cidade): ?>
                                <tr>
                                    <td>
                                        <strong><?= e($cidade['nome']) ?></strong>
                                        <span class="texto-auxiliar-sm"><?= e($cidade['estado']) ?>, <?= e($cidade['pais']) ?></span>
                                    </td>
                                    <td><?= e($cidade['condicao']) ?></td>
                                    <td><?= $cidade['temperatura'] ?>°C</td>
                                    <td><?= $cidade['maxima'] ?>° / <?= $cidade['minima'] ?>°</td>
                                    <td class="admin-acoes">
                                        <a href="cidade-form.php?id=<?= $cidade['id'] ?>" class="botao-contorno">Editar</a>
                                        <form method="post" action="cidades.php">
                                            <input type="hidden" name="id" value="<?= $cidade['id'] ?>">
                                            <button type="submit" class="botao-perigo">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
