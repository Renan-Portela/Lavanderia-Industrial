<?php
// Configurações do Banco de Dados
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'root');
define('DB_NAME', getenv('DB_NAME') ?: 'luvasul_db');

// Configurações do Sistema
define('SITE_NAME', 'LuvaSul - Lavanderia Industrial');
define('QR_CODE_DIR', __DIR__ . '/../qrcodes/');
?>

