<?php
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/session_helper.php';
require_once __DIR__ . '/../conexao.php';

// Inicializar banco de dados (Migrações automáticas se necessário)
$conn = inicializarDB();

// Proteção global: Redirecionar se não estiver logado (exceto página de login e index.php)
$public_pages = ['login.php', 'index.php'];
if (!in_array(basename($_SERVER['PHP_SELF']), $public_pages)) {
    SessionManager::requireLogin();
}

// Garantir que o diretório de QR codes existe
if (!file_exists(QR_CODE_DIR)) {
    mkdir(QR_CODE_DIR, 0755, true);
}

// Determinar o caminho base (raiz do projeto)
$base_path = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- CSS Customizado -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">
                <i class="bi bi-house-door-fill"></i> <?php echo SITE_NAME; ?>
            </a>
            
            <?php if (SessionManager::isLoggedIn()): ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>index.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recebimento.php' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/recebimento.php">
                            <i class="bi bi-box-arrow-in-down"></i> Recebimento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lavagem.php' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/lavagem.php">
                            <i class="bi bi-droplet"></i> Lavagem
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'expedicao.php' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/expedicao.php">
                            <i class="bi bi-box-arrow-up"></i> Expedição
                        </a>
                    </li>
                    
                    <?php if (SessionManager::getRole() === 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'materiais.php' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/materiais.php">
                            <i class="bi bi-tags"></i> Catálogo
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'relatorios.php' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/relatorios.php">
                            <i class="bi bi-file-earmark-text"></i> Relatórios
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuário'); ?> 
                            <span class="badge bg-light text-primary ms-1"><?php echo SessionManager::getRole(); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?php echo $base_path; ?>logout.php">
                                    <i class="bi bi-box-arrow-right"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php else: ?>
            <div class="ms-auto">
                <a href="<?php echo $base_path; ?>pages/login.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <!-- Feedback Global (Flash Messages) -->
        <?php 
        $flash = getFlash();
        if ($flash): 
            if ($flash['type'] === 'success'): ?>
                <!-- Success Toast -->
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
                    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?php echo htmlspecialchars($flash['message']); ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Alert for errors/warnings -->
                <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                    <i class="bi <?php echo ($flash['type'] === 'danger' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill'); ?> me-2"></i>
                    <?php echo htmlspecialchars($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
