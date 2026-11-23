<?php
require_once __DIR__ . '/../../includes/iniciar.php';

exigirAdmin();

// Com id na URL edita a cidade, sem id cadastra uma nova
$id = $_GET['id'] ?? null;
$erros = [];

if ($id) {
    $cidade = buscarCidade($id);

    if (!$cidade) {
        mensagem('erro', 'Cidade não encontrada.');
        redirecionar('cidades.php');
    }
} else {
    $cidade = [
        'nome' => '',
        'estado' => '',
        'pais' => 'Brasil',
        'temperatura' => '',
        'sensacao' => '',
        'maxima' => '',
        'minima' => '',
        'condicao' => '',
        'icone' => 'cloud',
        'umidade' => '',
        'vento' => '',
        'pressao' => '',
        'visibilidade' => '',
        'descricao' => '',
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cidade = [
        'nome' => campoPost('nome'),
        'estado' => campoPost('estado'),
        'pais' => campoPost('pais'),
        'temperatura' => campoPost('temperatura'),
        'sensacao' => campoPost('sensacao'),
        'maxima' => campoPost('maxima'),
        'minima' => campoPost('minima'),
        'condicao' => campoPost('condicao'),
        'icone' => campoPost('icone'),
        'umidade' => campoPost('umidade'),
        'vento' => campoPost('vento'),
        'pressao' => campoPost('pressao'),
        'visibilidade' => campoPost('visibilidade'),
        'descricao' => campoPost('descricao'),
    ];

    $erros = validarCidade($cidade);

    if (count($erros) == 0) {
        if ($id) {
            atualizarCidade($id, $cidade);
            mensagem('sucesso', 'Cidade ' . $cidade['nome'] . ' atualizada.');
        } else {
            criarCidade($cidade);
            mensagem('sucesso', 'Cidade ' . $cidade['nome'] . ' cadastrada.');
        }

        redirecionar('cidades.php');
    }
}

$raiz = '../';
$titulo = $id ? 'Editar cidade' : 'Nova cidade';
$estilos = ['admin'];
$pagina = 'cidades';
$painel = true;
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container admin">
        <a href="cidades.php" class="admin-voltar"><i data-lucide="arrow-left" aria-hidden="true"></i> Voltar</a>

        <h1><?= $id ? 'Editar cidade' : 'Nova cidade' ?></h1>
        <p class="texto-auxiliar admin-subtitulo">Use apenas dados fictícios.</p>

        <?php if (count($erros) > 0): ?>
            <div class="alerta alerta-erro" role="alert">Revise os campos indicados antes de salvar.</div>
        <?php endif; ?>

        <form class="admin-form" method="post" novalidate>
            <fieldset>
                <legend>Localização</legend>

                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?= e($cidade['nome']) ?>" maxlength="60" required class="<?= isset($erros['nome']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['nome'])): ?>
                        <p class="campo-mensagem"><?= $erros['nome'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado" value="<?= e($cidade['estado']) ?>" maxlength="60" required class="<?= isset($erros['estado']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['estado'])): ?>
                        <p class="campo-mensagem"><?= $erros['estado'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="pais">País</label>
                    <input type="text" id="pais" name="pais" value="<?= e($cidade['pais']) ?>" maxlength="60" required class="<?= isset($erros['pais']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['pais'])): ?>
                        <p class="campo-mensagem"><?= $erros['pais'] ?></p>
                    <?php endif; ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>Condição atual</legend>

                <div class="campo">
                    <label for="condicao">Condição</label>
                    <input type="text" id="condicao" name="condicao" value="<?= e($cidade['condicao']) ?>" maxlength="60" placeholder="Algumas nuvens" required class="<?= isset($erros['condicao']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['condicao'])): ?>
                        <p class="campo-mensagem"><?= $erros['condicao'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="icone">Ícone</label>
                    <select id="icone" name="icone" required>
                        <?php foreach (iconesClima() as $icone => $nome): ?>
                            <option value="<?= $icone ?>" <?= $cidade['icone'] == $icone ? 'selected' : '' ?>><?= $nome ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($erros['icone'])): ?>
                        <p class="campo-mensagem"><?= $erros['icone'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="temperatura">Temperatura (°C)</label>
                    <input type="number" id="temperatura" name="temperatura" value="<?= e($cidade['temperatura']) ?>" min="-60" max="60" required class="<?= isset($erros['temperatura']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['temperatura'])): ?>
                        <p class="campo-mensagem"><?= $erros['temperatura'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="sensacao">Sensação térmica (°C)</label>
                    <input type="number" id="sensacao" name="sensacao" value="<?= e($cidade['sensacao']) ?>" min="-60" max="60" required class="<?= isset($erros['sensacao']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['sensacao'])): ?>
                        <p class="campo-mensagem"><?= $erros['sensacao'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="maxima">Máxima (°C)</label>
                    <input type="number" id="maxima" name="maxima" value="<?= e($cidade['maxima']) ?>" min="-60" max="60" required class="<?= isset($erros['maxima']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['maxima'])): ?>
                        <p class="campo-mensagem"><?= $erros['maxima'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="minima">Mínima (°C)</label>
                    <input type="number" id="minima" name="minima" value="<?= e($cidade['minima']) ?>" min="-60" max="60" required class="<?= isset($erros['minima']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['minima'])): ?>
                        <p class="campo-mensagem"><?= $erros['minima'] ?></p>
                    <?php endif; ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>Métricas</legend>

                <div class="campo">
                    <label for="umidade">Umidade (%)</label>
                    <input type="number" id="umidade" name="umidade" value="<?= e($cidade['umidade']) ?>" min="0" max="100" required class="<?= isset($erros['umidade']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['umidade'])): ?>
                        <p class="campo-mensagem"><?= $erros['umidade'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="vento">Vento (km/h)</label>
                    <input type="number" id="vento" name="vento" value="<?= e($cidade['vento']) ?>" min="0" max="300" required class="<?= isset($erros['vento']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['vento'])): ?>
                        <p class="campo-mensagem"><?= $erros['vento'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="pressao">Pressão (hPa)</label>
                    <input type="number" id="pressao" name="pressao" value="<?= e($cidade['pressao']) ?>" min="850" max="1100" required class="<?= isset($erros['pressao']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['pressao'])): ?>
                        <p class="campo-mensagem"><?= $erros['pressao'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo">
                    <label for="visibilidade">Visibilidade (km)</label>
                    <input type="number" id="visibilidade" name="visibilidade" value="<?= e($cidade['visibilidade']) ?>" min="0" max="50" required class="<?= isset($erros['visibilidade']) ? 'campo-erro' : '' ?>">
                    <?php if (isset($erros['visibilidade'])): ?>
                        <p class="campo-mensagem"><?= $erros['visibilidade'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="campo campo-largo">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" maxlength="500"><?= e($cidade['descricao']) ?></textarea>
                    <?php if (isset($erros['descricao'])): ?>
                        <p class="campo-mensagem"><?= $erros['descricao'] ?></p>
                    <?php endif; ?>
                </div>
            </fieldset>

            <div class="admin-form-botoes">
                <button type="submit" class="botao-primario">Salvar</button>
                <a href="cidades.php" class="botao-contorno">Cancelar</a>
            </div>
        </form>
    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
