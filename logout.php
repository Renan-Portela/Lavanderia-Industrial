<?php
require_once __DIR__ . '/includes/auth_helper.php';
SessionManager::logout();
header('Location: pages/login.php');
exit();
