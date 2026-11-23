<?php
require_once __DIR__ . '/../../includes/iniciar.php';

$premium = false;
if (isset($_SESSION['usuario_id'])) {
    $usuario = buscarUsuario($_SESSION['usuario_id']);
    $premium = $usuario['plano'] == 'premium';
}

$raiz = '../';
$titulo = 'Planos';
$estilos = ['planos'];
$scripts = ['planos'];
$pagina = 'planos';
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container planos">
        <?php mostrarMensagem(); ?>

        <h1>Plano</h1>
        <p class="texto-auxiliar planos-subtitulo">Compare os recursos e escolha seu plano.</p>

        <section class="painel-planos">
            <table class="tabela-planos">
                <thead>
                    <tr>
                        <th scope="col">Recursos</th>
                        <th scope="col">
                            <span class="plano-nome">Gratuito</span>
                            <span class="plano-preco">R$ 0/mês</span>
                        </th>
                        <th scope="col">
                            <span class="plano-nome">Premium</span>
                            <span class="plano-preco">R$ 14,90/mês</span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th scope="row">Previsão</th>
                        <td>1 dia</td>
                        <td>5 dias</td>
                    </tr>
                    <tr>
                        <th scope="row">Hora a hora</th>
                        <td>Não incluído</td>
                        <td>Incluído</td>
                    </tr>
                    <tr>
                        <th scope="row">Mapas do tempo</th>
                        <td>Não incluído</td>
                        <td>Incluído</td>
                    </tr>
                    <tr>
                        <th scope="row">Cidades favoritas</th>
                        <td>Até 3</td>
                        <td>Até 5</td>
                    </tr>
                    <tr>
                        <th scope="row">Preço mensal</th>
                        <td>R$ 0/mês</td>
                        <td>R$ 14,90/mês</td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <td></td>
                        <td class="texto-auxiliar-sm">Sem custo</td>
                        <td><button type="button" class="botao-primario" id="abrir-modal">Assinar</button></td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <aside class="aviso-planos">
            <strong>Premium: R$ 14,90 por mês</strong>
            <p class="texto-auxiliar-sm">Renovação mensal automática. Cancele quando quiser pelo seu perfil. Valores de exemplo para fins educacionais.</p>
        </aside>

    </main>

    <div id="modal-assinatura" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-titulo">
        <div class="modal-fundo" data-fechar-modal></div>

        <div class="modal-caixa">
            <div class="modal-topo">
                <h2 id="modal-titulo" class="modal-titulo">Confirmar assinatura</h2>
                <button type="button" class="modal-fechar" aria-label="Fechar" data-fechar-modal>
                    <i data-lucide="x" aria-hidden="true"></i>
                </button>
            </div>

            <p class="texto-auxiliar modal-texto">Confira os detalhes antes de assinar o plano Premium do ClimaTempo.</p>

            <div class="modal-resumo">
                <div class="modal-resumo-topo">
                    <strong>Premium</strong>
                    <strong>R$ 14,90/mês</strong>
                </div>
                <ul>
                    <li>Previsão para 5 dias</li>
                    <li>Previsão hora a hora e mapas</li>
                    <li>Até 5 cidades favoritas</li>
                </ul>
            </div>

            <p class="texto-auxiliar-sm">Cobrança de R$ 14,90 por mês, com renovação automática. Você pode cancelar pelo Perfil. Assinatura de exemplo para fins educacionais.</p>

            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <p class="texto-auxiliar-sm modal-aviso">Você precisa entrar na sua conta para assinar.</p>
                <a href="login.php" class="botao-primario modal-botao">Entrar para assinar</a>
            <?php elseif ($premium): ?>
                <p class="texto-auxiliar-sm modal-aviso">Você já é assinante Premium.</p>
                <a href="perfil.php" class="botao-primario modal-botao">Ir para o perfil</a>
            <?php else: ?>
                <form method="post" action="plano.php">
                    <input type="hidden" name="acao" value="assinar">
                    <button type="submit" class="botao-primario modal-botao">Confirmar assinatura</button>
                </form>
            <?php endif; ?>
            <button type="button" class="botao-contorno modal-botao" data-fechar-modal>Cancelar</button>
        </div>
    </div>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
