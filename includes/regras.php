<?php
// Regra 1: plano Gratuito pode ter até 3 cidades favoritas e o Premium até 5
function limiteFavoritas($plano)
{
    if ($plano == 'premium') {
        return 5;
    }

    return 3;
}

function podeAdicionarFavorita($usuario)
{
    return contarFavoritas($usuario['id']) < limiteFavoritas($usuario['plano']);
}

// Quem tem mais de 3 favoritas não pode voltar para o Gratuito
function podeCancelarPremium($usuario)
{
    return contarFavoritas($usuario['id']) <= limiteFavoritas('gratuito');
}

// Regra 2: não pode existir duas contas com o mesmo e-mail
function emailJaCadastrado($email)
{
    return buscarUsuarioPorEmail($email) != false;
}

function validarCadastro($nome, $email, $senha, $confirmarSenha)
{
    $erros = [];

    if ($nome == '') {
        $erros['nome'] = 'Informe seu nome completo.';
    } elseif (mb_strlen($nome) > 100) {
        $erros['nome'] = 'O nome pode ter no máximo 100 caracteres.';
    }

    if ($email == '') {
        $erros['email'] = 'Informe seu e-mail.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'Informe um e-mail válido.';
    } elseif (emailJaCadastrado($email)) {
        $erros['email'] = 'Este e-mail já está cadastrado.';
    }

    if ($senha == '') {
        $erros['senha'] = 'Informe uma senha.';
    } elseif (strlen($senha) < 8) {
        $erros['senha'] = 'A senha precisa ter 8 caracteres ou mais.';
    }

    if ($confirmarSenha == '') {
        $erros['confirmar-senha'] = 'Confirme sua senha.';
    } elseif ($confirmarSenha != $senha) {
        $erros['confirmar-senha'] = 'As senhas não coincidem.';
    }

    return $erros;
}

function iconesClima()
{
    return [
        'sun' => 'Sol',
        'cloud-sun' => 'Sol entre nuvens',
        'cloud' => 'Nublado',
        'cloud-moon' => 'Nuvens (noite)',
        'moon' => 'Céu limpo (noite)',
        'cloud-rain' => 'Chuva',
        'cloud-lightning' => 'Tempestade',
        'cloud-fog' => 'Neblina',
    ];
}

function validarCidade($cidade)
{
    $erros = [];

    $textos = ['nome' => 'o nome', 'estado' => 'o estado', 'pais' => 'o país', 'condicao' => 'a condição'];

    foreach ($textos as $campo => $nome) {
        if ($cidade[$campo] == '') {
            $erros[$campo] = 'Informe ' . $nome . '.';
        } elseif (mb_strlen($cidade[$campo]) > 60) {
            $erros[$campo] = 'Use no máximo 60 caracteres.';
        }
    }

    if (!array_key_exists($cidade['icone'], iconesClima())) {
        $erros['icone'] = 'Escolha um ícone da lista.';
    }

    // [mínimo, máximo] de cada campo numérico
    $limites = [
        'temperatura' => [-60, 60],
        'sensacao' => [-60, 60],
        'maxima' => [-60, 60],
        'minima' => [-60, 60],
        'umidade' => [0, 100],
        'vento' => [0, 300],
        'pressao' => [850, 1100],
        'visibilidade' => [0, 50],
    ];

    foreach ($limites as $campo => $limite) {
        $valor = filter_var($cidade[$campo], FILTER_VALIDATE_INT);

        if ($valor === false || $valor < $limite[0] || $valor > $limite[1]) {
            $erros[$campo] = 'Informe um número entre ' . $limite[0] . ' e ' . $limite[1] . '.';
        }
    }

    if (!isset($erros['maxima']) && !isset($erros['minima']) && $cidade['minima'] > $cidade['maxima']) {
        $erros['minima'] = 'A mínima não pode ser maior que a máxima.';
    }

    if (mb_strlen($cidade['descricao']) > 500) {
        $erros['descricao'] = 'Use no máximo 500 caracteres.';
    }

    return $erros;
}
