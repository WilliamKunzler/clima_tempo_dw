<?php
function conexao()
{
    static $pdo = null;

    if ($pdo == null) {
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NOME . ';charset=utf8mb4', DB_USUARIO, DB_SENHA);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            die('Erro ao conectar com o banco de dados.');
        }
    }

    return $pdo;
}
