<?php
require_once __DIR__ . '/../../includes/iniciar.php';

exigirAdmin();

$usuarios = listarUsuarios();

$raiz = '../';
$titulo = 'Usuários';
$estilos = ['admin'];
$pagina = 'usuarios';
$painel = true;
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container admin">
        <h1>Usuários cadastrados</h1>
        <p class="texto-auxiliar admin-subtitulo">Contas criadas pelo formulário de cadastro do site.</p>

        <section class="admin-painel">
            <div class="tabela-rolagem">
                <table class="admin-tabela">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Plano</th>
                            <th scope="col">Favoritas</th>
                            <th scope="col">Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= e($usuario['nome']) ?></td>
                                <td><?= e($usuario['email']) ?></td>
                                <td><span class="selo selo-<?= $usuario['plano'] ?>"><?= nomePlano($usuario['plano']) ?></span></td>
                                <td><?= $usuario['total_favoritas'] ?> de <?= limiteFavoritas($usuario['plano']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
