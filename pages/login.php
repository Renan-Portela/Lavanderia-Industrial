<?php
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/session_helper.php';
require_once __DIR__ . '/../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $result = executarQuery("SELECT id, username, password_hash, perfil FROM usuarios WHERE username = ?", [$username]);
        
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {
                SessionManager::login($user);
                setFlash('success', 'Bem-vindo(a), ' . htmlspecialchars($user['username']) . '!');
                header('Location: ../index.php');
                exit();
            }
        }
        setFlash('danger', 'Usuário ou senha inválidos.');
    } else {
        setFlash('danger', 'Por favor, preencha todos os campos.');
    }
}

$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LuvaSul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            background: white;
        }
    </style>
</head>
<body>
    <div class="login-card fade-in">
        <div class="text-center mb-4">
            <h2 class="fw-bold color-primary">LuvaSul</h2>
            <p class="text-muted">Lavanderia Industrial</p>
        </div>
        
        <?php 
        $flash = getFlash();
        if ($flash): ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <i class="bi <?php echo ($flash['type'] === 'danger' ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'); ?> me-2"></i>
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">Informe o usuário.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Informe a senha.</div>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
