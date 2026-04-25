<?php
/**
 * SessionManager Class
 * Centralizes authentication and session logic
 */

class SessionManager {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
    }

    public static function login($user) {
        self::init();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['perfil'] = $user['perfil'];
        session_regenerate_id(true);
    }

    public static function logout() {
        self::init();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            @setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        @session_destroy();
    }

    public static function isLoggedIn() {
        self::init();
        return isset($_SESSION['user_id']);
    }

    public static function getRole() {
        self::init();
        return $_SESSION['perfil'] ?? null;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            if (defined('PHPUNIT_RUNNING')) {
                throw new Exception("Redirect to login.php");
            }
            header('Location: login.php');
            exit();
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (self::getRole() !== 'Admin') {
            if (defined('PHPUNIT_RUNNING')) {
                throw new Exception("Acesso negado: Somente administradores.");
            }
            http_response_code(403);
            die("Acesso negado: Somente administradores.");
        }
    }
}
