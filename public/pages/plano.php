<?php
require_once __DIR__ . '/../../includes/iniciar.php';

// Assinatura de exemplo, nenhum pagamento é feito
$usuario = exigirLogin();
$acao = $_POST['acao'] ?? '';

if ($acao == 'assinar') {
    alterarPlano($usuario['id'], 'premium');
    mensagem('sucesso', 'Assinatura Premium confirmada! Agora você pode ter até 5 cidades favoritas.');
}

if ($acao == 'cancelar') {
    if (podeCancelarPremium($usuario)) {
        alterarPlano($usuario['id'], 'gratuito');
        mensagem('sucesso', 'Assinatura cancelada. Você voltou para o plano Gratuito.');
    } else {
        mensagem('erro', 'O plano Gratuito permite até 3 favoritas. Remova algumas cidades antes de cancelar.');
    }
}

redirecionar('perfil.php');
