<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/auth_helper.php';

class AuthTest extends TestCase {
    protected function setUp(): void {
        $_SESSION = [];
    }

    public function testLoginSetsSession() {
        $user = ['id' => 1, 'username' => 'admin', 'perfil' => 'Admin'];
        @SessionManager::login($user);
        
        $this->assertTrue(SessionManager::isLoggedIn());
        $this->assertEquals('Admin', SessionManager::getRole());
        $this->assertEquals(1, $_SESSION['user_id']);
    }

    public function testLogoutClearsSession() {
        $_SESSION['user_id'] = 1;
        @SessionManager::logout();
        
        $this->assertFalse(SessionManager::isLoggedIn());
        $this->assertEmpty($_SESSION);
    }

    public function testRequireAdminBlocksOperador() {
        $_SESSION['user_id'] = 2;
        $_SESSION['perfil'] = 'Operador';
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Acesso negado');
        SessionManager::requireAdmin();
    }

    public function testRequireLoginRedirectsWhenNotLogged() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Redirect to login.php');
        SessionManager::requireLogin();
    }
}
