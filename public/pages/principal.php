<?php
require_once __DIR__ . '/../../includes/iniciar.php';

$usuario = exigirLogin();
$favoritas = listarFavoritas($usuario['id']);

if (isset($_GET['id'])) {
    $cidade = buscarCidade($_GET['id']);
} elseif (count($favoritas) > 0) {
    $cidade = $favoritas[0];
} else {
    $cidade = primeiraCidade();
}

if (!$cidade) {
    mensagem('erro', 'Cidade não encontrada.');
    redirecionar('../index.php');
}

$favorita = ehFavorita($usuario['id'], $cidade['id']);

$raiz = '../';
$titulo = $cidade['nome'];
$estilos = ['principal'];
$pagina = 'previsao';
require __DIR__ . '/../../includes/header.php';
?>

    <main class="container principal">
        <?php mostrarMensagem(); ?>

        <ul class="cidades">
            <?php foreach ($favoritas as $item): ?>
                <li class="cidade-chip <?= $item['id'] == $cidade['id'] ? 'ativa' : '' ?>">
                    <a href="principal.php?id=<?= $item['id'] ?>" class="chip-link">
                        <i data-lucide="star" class="chip-favorita" aria-hidden="true"></i>
                        <?= e($item['nome']) ?>
                        <i data-lucide="<?= e($item['icone']) ?>" aria-hidden="true"></i>
                        <?= $item['temperatura'] ?>°
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <section class="atual">
            <div class="atual-topo">
                <div>
                    <h1><?= e($cidade['nome']) ?></h1>
                    <p class="texto-auxiliar"><?= e($cidade['estado']) ?>, <?= e($cidade['pais']) ?></p>
                </div>

                <form method="post" action="favoritos.php">
                    <input type="hidden" name="cidade_id" value="<?= $cidade['id'] ?>">
                    <input type="hidden" name="voltar" value="principal">
                    <?php if ($favorita): ?>
                        <input type="hidden" name="acao" value="remover">
                        <button type="submit" class="botao-icone favoritada" aria-label="Remover dos favoritos">
                            <i data-lucide="star" aria-hidden="true"></i>
                        </button>
                    <?php else: ?>
                        <input type="hidden" name="acao" value="adicionar">
                        <button type="submit" class="botao-icone" aria-label="Adicionar aos favoritos">
                            <i data-lucide="star" aria-hidden="true"></i>
                        </button>
                    <?php endif; ?>
                </form>
            </div>

            <div class="atual-corpo">
                <div>
                    <div class="atual-temperatura">
                        <i data-lucide="<?= e($cidade['icone']) ?>" class="atual-icone" aria-hidden="true"></i>
                        <span class="texto-temperatura"><?= $cidade['temperatura'] ?></span>
                        <span class="atual-unidade">°C</span>
                    </div>
                    <h2 class="atual-condicao"><?= e($cidade['condicao']) ?></h2>
                    <p class="texto-corpo">Sensação térmica <?= $cidade['sensacao'] ?>°</p>
                    <p class="texto-corpo">Máx. <?= $cidade['maxima'] ?>° · Mín. <?= $cidade['minima'] ?>°</p>
                </div>

                <p class="atual-descricao"><?= e($cidade['descricao']) ?></p>
            </div>

            <dl class="atual-metricas">
                <div>
                    <dt>Qualidade do ar</dt>
                    <dd><span class="ponto-verde"></span>Boa</dd>
                </div>
                <div>
                    <dt>Vento</dt>
                    <dd><?= $cidade['vento'] ?> km/h</dd>
                </div>
                <div>
                    <dt>Umidade</dt>
                    <dd><?= $cidade['umidade'] ?>%</dd>
                </div>
                <div>
                    <dt>Visibilidade</dt>
                    <dd><?= $cidade['visibilidade'] ?> km</dd>
                </div>
                <div>
                    <dt>Pressão</dt>
                    <dd><?= $cidade['pressao'] ?> hPa</dd>
                </div>
                <div>
                    <dt>Sensação</dt>
                    <dd><?= $cidade['sensacao'] ?>°</dd>
                </div>
            </dl>

            <p class="texto-auxiliar-sm">Atualizado às <?= date('H:i', strtotime($cidade['atualizado_em'])) ?></p>
        </section>

        <section class="painel">
            <h2 class="painel-titulo">Previsão para 5 dias</h2>

            <ul class="dias">
                <li class="dia selecionado">
                    <strong>Hoje</strong>
                    <span class="dia-data">03/11</span>
                    <i data-lucide="cloud-sun" class="icone-nuvem" aria-hidden="true"></i>
                    <span class="dia-temp"><?= $cidade['maxima'] ?>° <span><?= $cidade['minima'] ?>°</span></span>
                    <span class="dia-chuva"></span>
                    <span class="dia-condicao"><?= e($cidade['condicao']) ?></span>
                </li>
                <li class="dia">
                    <strong>Qua</strong>
                    <span class="dia-data">04/11</span>
                    <i data-lucide="cloud-sun" class="icone-nuvem" aria-hidden="true"></i>
                    <span class="dia-temp">31° <span>25°</span></span>
                    <span class="dia-chuva">20%</span>
                    <span class="dia-condicao">Algumas nuvens</span>
                </li>
                <li class="dia">
                    <strong>Qui</strong>
                    <span class="dia-data">05/11</span>
                    <span class="icone-sol"></span>
                    <span class="dia-temp">33° <span>25°</span></span>
                    <span class="dia-chuva"></span>
                    <span class="dia-condicao">Céu limpo</span>
                </li>
                <li class="dia">
                    <strong>Sex</strong>
                    <span class="dia-data">06/11</span>
                    <span class="icone-sol"></span>
                    <span class="dia-temp">34° <span>25°</span></span>
                    <span class="dia-chuva"></span>
                    <span class="dia-condicao">Céu limpo</span>
                </li>
                <li class="dia">
                    <strong>Sáb</strong>
                    <span class="dia-data">07/11</span>
                    <span class="icone-sol"></span>
                    <span class="dia-temp">33° <span>26°</span></span>
                    <span class="dia-chuva"></span>
                    <span class="dia-condicao">Céu limpo</span>
                </li>
                <li class="dia">
                    <strong>Dom</strong>
                    <span class="dia-data">08/11</span>
                    <span class="icone-sol"></span>
                    <span class="dia-temp">32° <span>26°</span></span>
                    <span class="dia-chuva"></span>
                    <span class="dia-condicao">Céu limpo</span>
                </li>
            </ul>

            <div class="abas-linha">
                <div class="abas">
                    <button type="button" class="aba ativa">Temperatura</button>
                    <button type="button" class="aba">Precipitação</button>
                    <button type="button" class="aba">Vento</button>
                    <button type="button" class="aba">Umidade</button>
                    <button type="button" class="aba">Nebulosidade</button>
                    <button type="button" class="aba">Pressão</button>
                </div>
                <span class="texto-auxiliar-sm">Próximas 24 horas</span>
            </div>

            <svg class="grafico" viewBox="0 0 1000 170" aria-label="Gráfico de temperatura das próximas 24 horas">
                <defs>
                    <linearGradient id="area-temperatura" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="#F39C33" stop-opacity="0.25" />
                        <stop offset="1" stop-color="#F39C33" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <line class="grade" x1="0" y1="20" x2="1000" y2="20" />
                <line class="grade" x1="0" y1="80" x2="1000" y2="80" />
                <line class="grade" x1="0" y1="140" x2="1000" y2="140" />
                <polygon points="30,128 140,129 250,130 360,132 400,124 450,72 560,70 680,70 760,72 820,96 920,108 970,120 970,165 30,165" fill="url(#area-temperatura)" stroke="none" />
                <polyline class="linha-sensacao" points="30,128 140,128 250,126 360,128 400,120 450,64 560,58 620,52 680,48 760,60 820,82 920,96 970,120" />
                <polyline class="linha-temperatura" points="30,128 140,129 250,130 360,132 400,124 450,72 560,70 680,70 760,72 820,96 920,108 970,120" />
                <rect x="352" y="148" width="18" height="17" rx="3" class="barra-chuva" />
                <text x="30" y="118">26°</text>
                <text x="140" y="118">26°</text>
                <text x="250" y="116">26°</text>
                <text x="360" y="122">25°</text>
                <text x="450" y="56">31°</text>
                <text x="560" y="50">31°</text>
                <text x="680" y="44">31°</text>
                <text x="820" y="74">29°</text>
                <text x="970" y="108">27°</text>
            </svg>
            <div class="grafico-horas texto-auxiliar-sm">
                <span>21:00</span><span>00:00</span><span>03:00</span><span>06:00</span><span>09:00</span><span>12:00</span><span>15:00</span><span>18:00</span><span>21:00</span>
            </div>

            <ul class="legenda texto-auxiliar-sm">
                <li><span class="legenda-cor cor-chuva"></span>Chance de chuva</li>
                <li><span class="legenda-cor cor-temp"></span>Temperatura</li>
                <li><span class="legenda-cor cor-sensa"></span>Sensação</li>
            </ul>

            <ul class="horas">
                <li class="hora"><span>21:00</span><i data-lucide="cloud-moon" aria-hidden="true"></i><strong>26°</strong><span class="hora-chuva">0%</span><span>↙21 km/h</span></li>
                <li class="hora"><span>00:00</span><i data-lucide="cloud" aria-hidden="true"></i><strong>26°</strong><span class="hora-chuva">0%</span><span>↙22 km/h</span></li>
                <li class="hora"><span>03:00</span><i data-lucide="cloud-moon" aria-hidden="true"></i><strong>26°</strong><span class="hora-chuva">0%</span><span>←18 km/h</span></li>
                <li class="hora"><span>06:00</span><i data-lucide="cloud-sun" class="icone-nuvem" aria-hidden="true"></i><strong>25°</strong><span class="hora-chuva">20%</span><span>←15 km/h</span></li>
                <li class="hora"><span>09:00</span><i data-lucide="cloud" aria-hidden="true"></i><strong>31°</strong><span class="hora-chuva">0%</span><span>←19 km/h</span></li>
                <li class="hora"><span>12:00</span><i data-lucide="cloud-sun" class="icone-nuvem" aria-hidden="true"></i><strong>31°</strong><span class="hora-chuva">0%</span><span>↙19 km/h</span></li>
                <li class="hora"><span>15:00</span><span class="icone-sol"></span><strong>31°</strong><span class="hora-chuva">0%</span><span>↙25 km/h</span></li>
                <li class="hora"><span>18:00</span><span class="icone-lua"></span><strong>29°</strong><span class="hora-chuva">0%</span><span>↙23 km/h</span></li>
                <li class="hora"><span>21:00</span><span class="icone-lua"></span><strong>27°</strong><span class="hora-chuva">0%</span><span>↙25 km/h</span></li>
            </ul>

            <dl class="resumo-dia">
                <div><dt>Condição</dt><dd><?= e($cidade['condicao']) ?></dd></div>
                <div><dt>Máxima / mínima</dt><dd><?= $cidade['maxima'] ?>° / <?= $cidade['minima'] ?>°</dd></div>
                <div><dt>Chance de chuva</dt><dd>0%</dd></div>
                <div><dt>Precipitação total</dt><dd>0,0 mm</dd></div>
                <div><dt>Vento máx. / rajadas</dt><dd><?= $cidade['vento'] ?> km/h / <?= $cidade['vento'] * 2 ?> km/h</dd></div>
                <div><dt>Umidade média</dt><dd><?= $cidade['umidade'] ?>%</dd></div>
                <div><dt>Nebulosidade média</dt><dd>19%</dd></div>
                <div><dt>Pressão média</dt><dd><?= $cidade['pressao'] ?> hPa</dd></div>
            </dl>
        </section>

        <section class="detalhes">
            <h2 class="detalhes-titulo">Detalhes do clima</h2>

            <div class="detalhes-grade">

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="wind" aria-hidden="true"></i>Vento</h3>
                    <div class="vento">
                        <svg class="grafico bussola" viewBox="0 0 100 100" aria-hidden="true">
                            <circle cx="50" cy="50" r="44" class="bussola-aro" />
                            <circle cx="50" cy="50" r="36" class="bussola-interno" />
                            <text x="50" y="22">N</text>
                            <text x="50" y="86">S</text>
                            <text x="20" y="54">O</text>
                            <text x="80" y="54">L</text>
                            <line x1="66" y1="40" x2="30" y2="62" class="bussola-seta" />
                            <polygon points="30,62 34,53 40,60" class="bussola-ponta" />
                        </svg>
                        <div>
                            <strong class="detalhe-valor"><?= $cidade['vento'] ?> km/h</strong>
                            <p class="texto-auxiliar-sm">Brisa moderada</p>
                        </div>
                    </div>
                    <p class="texto-auxiliar-sm">De ENE (63°) · rajadas de 44 km/h</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="droplet" aria-hidden="true"></i>Umidade</h3>
                    <strong class="detalhe-valor"><?= $cidade['umidade'] ?>%</strong>
                    <div class="barra"><span style="width: <?= $cidade['umidade'] ?>%"></span></div>
                    <p class="texto-auxiliar-sm">Ponto de orvalho de 23°. Ar bastante úmido.</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="sun" aria-hidden="true"></i>Sol</h3>
                    <svg class="grafico sol" viewBox="0 0 160 80" aria-hidden="true">
                        <path d="M20 66 A60 60 0 0 1 140 66" class="sol-arco" />
                        <line x1="10" y1="66" x2="150" y2="66" class="grade" />
                        <circle cx="140" cy="66" r="5" class="sol-ponto" />
                        <text x="30" y="78">05:23</text>
                        <text x="140" y="78">17:36</text>
                    </svg>
                    <p class="texto-auxiliar-sm">Duração do dia: <strong>12h 13min</strong></p>
                    <p class="texto-auxiliar-sm">O sol já se pôs</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="moon" aria-hidden="true"></i>Lua</h3>
                    <div class="lua">
                        <span class="lua-fase"></span>
                        <div>
                            <strong>Lua minguante</strong>
                            <p class="texto-auxiliar-sm">Iluminação 35%</p>
                        </div>
                    </div>
                    <p class="texto-auxiliar-sm">Próxima lua cheia em 21 dias · lua nova em 6 dias</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="gauge" aria-hidden="true"></i>Pressão</h3>
                    <svg class="grafico pressao" viewBox="0 0 160 100" aria-hidden="true">
                        <path d="M20 85 A60 60 0 0 1 140 85" class="pressao-fundo" />
                        <path d="M20 85 A60 60 0 0 1 96 27" class="pressao-valor" />
                        <line x1="80" y1="85" x2="100" y2="42" class="pressao-ponteiro" />
                        <circle cx="80" cy="85" r="4" class="pressao-centro" />
                        <text x="24" y="98">Baixa</text>
                        <text x="138" y="98">Alta</text>
                    </svg>
                    <strong class="detalhe-valor centro"><?= $cidade['pressao'] ?> hPa</strong>
                    <p class="texto-auxiliar-sm centro">Estável · nível do solo 1010 hPa</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="eye" aria-hidden="true"></i>Visibilidade</h3>
                    <strong class="detalhe-valor"><?= $cidade['visibilidade'] ?> km</strong>
                    <div class="barra"><span style="width: <?= min(100, $cidade['visibilidade'] * 10) ?>%"></span></div>
                    <p class="texto-auxiliar-sm">Visibilidade excelente.</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="cloud" aria-hidden="true"></i>Nebulosidade</h3>
                    <strong class="detalhe-valor">19%</strong>
                    <div class="barra barra-cinza"><span style="width: 19%"></span></div>
                    <p class="texto-auxiliar-sm">Algumas nuvens.</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="cloud-rain" aria-hidden="true"></i>Precipitação</h3>
                    <strong class="detalhe-valor">0,1 mm</strong>
                    <p class="texto-auxiliar-sm">Previstos nas próximas 24 horas (chance máxima de 20%).</p>
                    <p class="texto-auxiliar-sm">Última hora: 0,0 mm</p>
                </article>

                <article class="detalhe">
                    <h3 class="detalhe-titulo"><i data-lucide="thermometer" aria-hidden="true"></i>Sensação térmica</h3>
                    <strong class="detalhe-valor"><?= $cidade['sensacao'] ?>°</strong>
                    <p class="texto-auxiliar-sm">Temperatura percebida pelo corpo.</p>
                    <p class="texto-auxiliar-sm">Real: <?= $cidade['temperatura'] ?>° · Mín. <?= $cidade['minima'] ?>° / Máx. <?= $cidade['maxima'] ?>° observadas</p>
                </article>

                <article class="detalhe detalhe-ar">
                    <h3 class="detalhe-titulo"><i data-lucide="leaf" aria-hidden="true"></i>Qualidade do ar</h3>
                    <div class="ar-topo">
                        <span class="ar-indice">1</span>
                        <div>
                            <strong>Boa</strong>
                            <p class="texto-auxiliar-sm">Qualidade do ar satisfatória, pouco ou nenhum risco.</p>
                        </div>
                    </div>

                    <div class="ar-escala"><span class="ar-marcador" style="left: 10%"></span></div>
                    <div class="ar-escala-legenda texto-auxiliar-sm">
                        <span>Boa</span><span>Moderada</span><span>Muito ruim</span>
                    </div>

                    <dl class="poluentes">
                        <div><dt>PM2,5</dt><dd>1,7 <small>µg/m³</small></dd></div>
                        <div><dt>PM10</dt><dd>4,4 <small>µg/m³</small></dd></div>
                        <div><dt>O₃</dt><dd>36,9 <small>µg/m³</small></dd></div>
                        <div><dt>NO₂</dt><dd>1,2 <small>µg/m³</small></dd></div>
                        <div><dt>SO₂</dt><dd>0,2 <small>µg/m³</small></dd></div>
                        <div><dt>CO</dt><dd>159,0 <small>µg/m³</small></dd></div>
                        <div><dt>NH₃</dt><dd>1,2 <small>µg/m³</small></dd></div>
                    </dl>

                    <p class="texto-auxiliar-sm">Previsão da qualidade do ar</p>
                    <ul class="ar-previsao">
                        <li>Hoje<span class="ar-boa">Boa</span></li>
                        <li>Qua<span class="ar-razoavel">Razoável</span></li>
                        <li>Qui<span class="ar-razoavel">Razoável</span></li>
                        <li>Sex<span class="ar-razoavel">Razoável</span></li>
                        <li>Sáb<span class="ar-razoavel">Razoável</span></li>
                    </ul>
                </article>

            </div>
        </section>


    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
