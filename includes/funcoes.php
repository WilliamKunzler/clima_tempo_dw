<?php
// Escapa o texto antes de mostrar no HTML
function e($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function redirecionar($pagina)
{
    header('Location: ' . $pagina);
    exit;
}

function campoPost($nome)
{
    return trim($_POST[$nome] ?? '');
}

// Mensagem guardada na sessão para aparecer na próxima página
function mensagem($tipo, $texto)
{
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

function mostrarMensagem()
{
    if (!isset($_SESSION['mensagem'])) {
        return;
    }

    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);

    echo '<div class="alerta alerta-' . e($mensagem['tipo']) . '" role="alert">' . e($mensagem['texto']) . '</div>';
}

// Páginas do usuário: sem login volta para o login
function exigirLogin()
{
    $usuario = null;

    if (isset($_SESSION['usuario_id'])) {
        $usuario = buscarUsuario($_SESSION['usuario_id']);
    }

    if (!$usuario) {
        mensagem('erro', 'Faça login para continuar.');
        redirecionar('login.php');
    }

    return $usuario;
}

// Páginas do painel: sem login de administrador volta para o login do painel
function exigirAdmin()
{
    if (!isset($_SESSION['admin_id'])) {
        mensagem('erro', 'Entre como administrador para acessar o painel.');
        redirecionar('login.php');
    }
}

function saudacao()
{
    $hora = date('H');

    if ($hora < 12) {
        return 'Bom dia';
    }

    if ($hora < 18) {
        return 'Boa tarde';
    }

    return 'Boa noite';
}

function nomePlano($plano)
{
    if ($plano == 'premium') {
        return 'Premium';
    }

    return 'Gratuito';
}