<?php
require_once __DIR__ . '/../../includes/iniciar.php';

$usuario = exigirLogin();

$cidadeId = filter_var($_POST['cidade_id'] ?? '', FILTER_VALIDATE_INT);
$acao = $_POST['acao'] ?? '';

// Volta para a página de onde veio
$voltar = 'perfil.php';
if (($_POST['voltar'] ?? '') == 'principal') {
    $voltar = 'principal.php?id=' . $cidadeId;
}

if (!$cidadeId || !buscarCidade($cidadeId)) {
    mensagem('erro', 'Escolha uma cidade.');
    redirecionar($voltar);
}

if ($acao == 'adicionar') {
    if (ehFavorita($usuario['id'], $cidadeId)) {
        mensagem('erro', 'Esta cidade já está nas suas favoritas.');
    } elseif (!podeAdicionarFavorita($usuario)) {
        mensagem('erro', 'Limite de favoritas atingido. O plano ' . nomePlano($usuario['plano']) . ' permite até ' . limiteFavoritas($usuario['plano']) . ' cidades.');
    } else {
        adicionarFavorita($usuario['id'], $cidadeId);
        mensagem('sucesso', 'Cidade adicionada às favoritas.');
    }
}

if ($acao == 'remover') {
    removerFavorita($usuario['id'], $cidadeId);
    mensagem('sucesso', 'Cidade removida das favoritas.');
}

redirecionar($voltar);
