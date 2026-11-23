<?php
require_once __DIR__ . '/../../includes/iniciar.php';

$usuario = exigirLogin();
$favoritas = listarFavoritas($usuario['id']);
$limite = limiteFavoritas($usuario['plano']);
$limiteAtingido = count($favoritas) >= $limite;

// Cidades que ainda não estão nas favoritas
$idsFavoritas = array_column($favoritas, 'id');
$outrasCidades = [];
foreach (listarCidades() as $cidade) {
    if (!in_array($cidade['id'], $idsFavoritas)) {
        $outrasCidades[] = $cidade;
    }
}

$raiz = '../';
$titulo = 'Perfil';
$estilos = ['perfil'];
$pagina = 'perfil';
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container perfil">
        <?php mostrarMensagem(); ?>

        <h1>Perfil</h1>
        <p class="texto-auxiliar perfil-subtitulo">Gerencie sua conta, seu plano e suas cidades favoritas.</p>

        <div class="perfil-grade">

            <div class="perfil-coluna">
                <section class="cartao">
                    <div class="conta-topo">
                        <span class="avatar"><?= e(strtoupper(substr($usuario['nome'], 0, 1))) ?></span>
                        <h2 class="cartao-titulo">Dados da conta</h2>
                    </div>

                    <dl class="conta-dados">
                        <div>
                            <dt class="texto-auxiliar">Nome</dt>
                            <dd><?= e($usuario['nome']) ?></dd>
                        </div>
                        <div>
                            <dt class="texto-auxiliar">E-mail</dt>
                            <dd><?= e($usuario['email']) ?></dd>
                        </div>
                    </dl>
                </section>

                <section class="cartao">
                    <h2 class="cartao-titulo">Plano atual</h2>
                    <div class="plano-topo">
                        <strong class="plano-nome"><?= nomePlano($usuario['plano']) ?></strong>
                        <span class="selo">Ativo</span>
                    </div>

                    <?php if ($usuario['plano'] == 'premium'): ?>
                        <p class="plano-preco">R$ 14,90/mês</p>
                        <p class="texto-auxiliar">Previsão de 5 dias, hora a hora, mapas e até 5 cidades favoritas.</p>
                        <form method="post" action="plano.php">
                            <input type="hidden" name="acao" value="cancelar">
                            <button type="submit" class="botao-contorno plano-botao">Cancelar Premium</button>
                        </form>
                    <?php else: ?>
                        <p class="plano-preco">R$ 0/mês</p>
                        <p class="texto-auxiliar">Previsão do dia e até 3 cidades favoritas.</p>
                        <a href="planos.php" class="botao-contorno plano-botao">Mudar plano</a>
                    <?php endif; ?>
                </section>
            </div>

            <section class="cartao">
                <div class="favoritas-topo">
                    <h2 class="cartao-titulo">Cidades favoritas</h2>
                    <span class="texto-auxiliar"><?= count($favoritas) ?> de <?= $limite ?></span>
                </div>
                <p class="texto-auxiliar favoritas-subtitulo">Seus locais salvos no ClimaTempo.</p>

                <ul class="favoritas">
                    <?php foreach ($favoritas as $cidade): ?>
                        <li class="favorita">
                            <i data-lucide="star" aria-hidden="true"></i>
                            <a href="principal.php?id=<?= $cidade['id'] ?>"><?= e($cidade['nome']) ?>, <?= e($cidade['estado']) ?></a>
                            <form method="post" action="favoritos.php" class="form-remover">
                                <input type="hidden" name="acao" value="remover">
                                <input type="hidden" name="cidade_id" value="<?= $cidade['id'] ?>">
                                <button type="submit" class="link-remover">Remover</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($limiteAtingido): ?>
                    <div class="aviso-limite">
                        <strong>Limite de favoritas atingido</strong>
                        <p class="texto-auxiliar-sm">Você já tem <?= count($favoritas) ?> de <?= $limite ?> cidades no plano <?= nomePlano($usuario['plano']) ?>. Remova uma cidade para adicionar outra.</p>
                    </div>
                <?php endif; ?>

                <form class="adicionar" method="post" action="favoritos.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <label for="nova-cidade">Adicionar cidade</label>
                    <select id="nova-cidade" name="cidade_id" required <?= $limiteAtingido ? 'disabled' : '' ?>>
                        <option value="">Escolha uma cidade</option>
                        <?php foreach ($outrasCidades as $cidade): ?>
                            <option value="<?= $cidade['id'] ?>"><?= e($cidade['nome']) ?>, <?= e($cidade['estado']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($limiteAtingido): ?>
                        <button type="submit" class="botao-desativado" disabled>Adicionar</button>
                    <?php else: ?>
                        <button type="submit" class="botao-primario">Adicionar</button>
                    <?php endif; ?>
                </form>
            </section>

        </div>

        <a href="logout.php" class="botao-contorno botao-sair">Sair</a>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
