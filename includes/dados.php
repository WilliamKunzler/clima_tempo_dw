<?php
// Cidades

function listarCidades($busca = '')
{
    $sql = conexao()->prepare('SELECT * FROM cidades WHERE nome LIKE ? OR estado LIKE ? ORDER BY nome');
    $sql->execute(['%' . $busca . '%', '%' . $busca . '%']);
    return $sql->fetchAll();
}

function buscarCidade($id)
{
    $sql = conexao()->prepare('SELECT * FROM cidades WHERE id = ?');
    $sql->execute([$id]);
    return $sql->fetch();
}

function primeiraCidade()
{
    $sql = conexao()->query('SELECT * FROM cidades ORDER BY nome LIMIT 1');
    return $sql->fetch();
}

function criarCidade($cidade)
{
    $sql = conexao()->prepare('INSERT INTO cidades (nome, estado, pais, temperatura, sensacao, maxima, minima, condicao, icone, umidade, vento, pressao, visibilidade, descricao)
        VALUES (:nome, :estado, :pais, :temperatura, :sensacao, :maxima, :minima, :condicao, :icone, :umidade, :vento, :pressao, :visibilidade, :descricao)');
    $sql->execute($cidade);
}

function atualizarCidade($id, $cidade)
{
    $sql = conexao()->prepare('UPDATE cidades SET nome = :nome, estado = :estado, pais = :pais, temperatura = :temperatura,
        sensacao = :sensacao, maxima = :maxima, minima = :minima, condicao = :condicao, icone = :icone, umidade = :umidade,
        vento = :vento, pressao = :pressao, visibilidade = :visibilidade, descricao = :descricao WHERE id = :id');
    $cidade['id'] = $id;
    $sql->execute($cidade);
}

function excluirCidade($id)
{
    $sql = conexao()->prepare('DELETE FROM cidades WHERE id = ?');
    $sql->execute([$id]);
}

// Usuários

function buscarUsuario($id)
{
    $sql = conexao()->prepare('SELECT * FROM usuarios WHERE id = ?');
    $sql->execute([$id]);
    return $sql->fetch();
}

function buscarUsuarioPorEmail($email)
{
    $sql = conexao()->prepare('SELECT * FROM usuarios WHERE email = ?');
    $sql->execute([$email]);
    return $sql->fetch();
}

function criarUsuario($nome, $email, $senha)
{
    $sql = conexao()->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
    $sql->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
    return conexao()->lastInsertId();
}

function alterarPlano($id, $plano)
{
    $sql = conexao()->prepare('UPDATE usuarios SET plano = ? WHERE id = ?');
    $sql->execute([$plano, $id]);
}

function listarUsuarios()
{
    $sql = conexao()->query('SELECT usuarios.*, COUNT(favoritas.cidade_id) AS total_favoritas
        FROM usuarios
        LEFT JOIN favoritas ON favoritas.usuario_id = usuarios.id
        GROUP BY usuarios.id
        ORDER BY usuarios.criado_em DESC');
    return $sql->fetchAll();
}

// Favoritas

function listarFavoritas($usuarioId)
{
    $sql = conexao()->prepare('SELECT cidades.* FROM favoritas
        JOIN cidades ON cidades.id = favoritas.cidade_id
        WHERE favoritas.usuario_id = ?
        ORDER BY cidades.nome');
    $sql->execute([$usuarioId]);
    return $sql->fetchAll();
}

function contarFavoritas($usuarioId)
{
    $sql = conexao()->prepare('SELECT COUNT(*) FROM favoritas WHERE usuario_id = ?');
    $sql->execute([$usuarioId]);
    return $sql->fetchColumn();
}

function ehFavorita($usuarioId, $cidadeId)
{
    $sql = conexao()->prepare('SELECT COUNT(*) FROM favoritas WHERE usuario_id = ? AND cidade_id = ?');
    $sql->execute([$usuarioId, $cidadeId]);
    return $sql->fetchColumn() > 0;
}

function adicionarFavorita($usuarioId, $cidadeId)
{
    $sql = conexao()->prepare('INSERT INTO favoritas (usuario_id, cidade_id) VALUES (?, ?)');
    $sql->execute([$usuarioId, $cidadeId]);
}

function removerFavorita($usuarioId, $cidadeId)
{
    $sql = conexao()->prepare('DELETE FROM favoritas WHERE usuario_id = ? AND cidade_id = ?');
    $sql->execute([$usuarioId, $cidadeId]);
}

// Administradores

function buscarAdminPorEmail($email)
{
    $sql = conexao()->prepare('SELECT * FROM administradores WHERE email = ?');
    $sql->execute([$email]);
    return $sql->fetch();
}

function contar($tabela)
{
    $sql = conexao()->query('SELECT COUNT(*) FROM ' . $tabela);
    return $sql->fetchColumn();
}
