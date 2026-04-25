<?php
/**
 * SessionHelper Utility
 * Manages transient flash messages using PHP Sessions
 */

require_once __DIR__ . '/auth_helper.php';

function setFlash($type, $message) {
    SessionManager::init();
    $_SESSION['flash'] = [
        'type' => $type, // success, danger, warning, info
        'message' => $message
    ];
}

function getFlash() {
    SessionManager::init();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
