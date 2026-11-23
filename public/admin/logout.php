<?php
require_once __DIR__ . '/../../includes/iniciar.php';

unset($_SESSION['admin_id']);
unset($_SESSION['admin_nome']);

redirecionar('login.php');
