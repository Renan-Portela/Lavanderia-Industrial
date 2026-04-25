<?php
/**
 * PHPUnit Bootstrap
 */

require_once __DIR__ . '/../vendor/autoload.php';

define('PHPUNIT_RUNNING', true);

// Mock ou configurações de DB para testes
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('DB_NAME')) define('DB_NAME', 'luvasul_db_test');
if (!defined('QR_CODE_DIR')) define('QR_CODE_DIR', __DIR__ . '/../qrcodes/');
