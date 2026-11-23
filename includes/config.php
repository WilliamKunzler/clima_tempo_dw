<?php
// No Docker os dados vêm do docker-compose.yml. No XAMPP usa root sem senha.
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NOME', getenv('DB_NOME') ?: 'clima_tempo');
define('DB_USUARIO', getenv('DB_USUARIO') ?: 'root');
define('DB_SENHA', getenv('DB_SENHA') ?: '');

date_default_timezone_set('America/Sao_Paulo');
