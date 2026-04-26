<?php
require_once __DIR__ . '/includes/auth_helper.php';

if (SessionManager::isLoggedIn()):
    $pageTitle = "Dashboard";
    require_once __DIR__ . '/includes/header.php';

    // Buscar contadores
    $sql_recebidos = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'Recebido'";
    $sql_lavagem = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'Em Lavagem'";
    $sql_expedicao = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'Pronto para Expedição'";
    $sql_concluidos = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'Concluído'";

    $result_recebidos = $conn->query($sql_recebidos);
    $result_lavagem = $conn->query($sql_lavagem);
    $result_expedicao = $conn->query($sql_expedicao);
    $result_concluidos = $conn->query($sql_concluidos);

    $total_recebidos = $result_recebidos->fetch_assoc()['total'];
    $total_lavagem = $result_lavagem->fetch_assoc()['total'];
    $total_expedicao = $result_expedicao->fetch_assoc()['total'];
    $total_concluidos = $result_concluidos->fetch_assoc()['total'];
?>

<!-- Refactored Header with Inline Stats -->
<div class="row align-items-center mb-4">
    <div class="col-xl-4 col-lg-12">
        <h1 class="page-title mb-0 border-0">
            <i class="bi bi-speedometer2"></i> Dashboard
        </h1>
    </div>
    <div class="col-xl-8 col-lg-12 mt-3 mt-xl-0">
        <div class="header-stats justify-content-xl-end">
            <div class="mini-stat-card border-secondary" title="Total de pedidos recebidos aguardando processamento">
                <i class="bi bi-box-arrow-in-down text-secondary"></i>
                <div class="stat-value"><?php echo $total_recebidos; ?></div>
                <div class="stat-label">Recebidos</div>
            </div>
            <div class="mini-stat-card border-warning" title="Pedidos atualmente em processo de lavagem">
                <i class="bi bi-droplet text-warning"></i>
                <div class="stat-value"><?php echo $total_lavagem; ?></div>
                <div class="stat-label">Lavagem</div>
            </div>
            <div class="mini-stat-card border-info" title="Pedidos prontos para entrega ao cliente">
                <i class="bi bi-box-arrow-up text-info"></i>
                <div class="stat-value"><?php echo $total_expedicao; ?></div>
                <div class="stat-label">Expedição</div>
            </div>
            <div class="mini-stat-card border-success" title="Pedidos finalizados e entregues">
                <i class="bi bi-check-circle text-success"></i>
                <div class="stat-value"><?php echo $total_concluidos; ?></div>
                <div class="stat-label">Concluídos</div>
            </div>
        </div>
    </div>
</div>

<hr class="mb-4">

<!-- Horizontal Quick Actions -->
<div class="row g-3 quick-actions-row">
    <div class="col-md-3 col-sm-6">
        <a href="pages/recebimento.php" class="btn btn-primary btn-lg w-100 h-100 d-flex align-items-center justify-content-center py-3">
            <i class="bi bi-box-arrow-in-down me-2"></i> Novo Recebimento
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="pages/lavagem.php" class="btn btn-warning btn-lg w-100 h-100 d-flex align-items-center justify-content-center py-3">
            <i class="bi bi-droplet me-2"></i> Iniciar Lavagem
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="pages/expedicao.php" class="btn btn-info btn-lg w-100 h-100 d-flex align-items-center justify-content-center py-3">
            <i class="bi bi-box-arrow-up me-2"></i> Expedir Pedido
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="pages/relatorios.php" class="btn btn-secondary btn-lg w-100 h-100 d-flex align-items-center justify-content-center py-3">
            <i class="bi bi-file-earmark-text me-2"></i> Relatórios
        </a>
    </div>
</div>

<!-- Full-width Recent Orders with Progress -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history"></i> Pedidos Recentes</span>
                <span class="badge bg-light text-primary">Últimos 10</span>
            </div>
            <div class="card-body">
                <?php
                $sql_recentes = "SELECT * FROM pedidos ORDER BY data_cadastro DESC LIMIT 10";
                $result_recentes = $conn->query($sql_recentes);
                
                if ($result_recentes->num_rows > 0) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-hover align-middle">';
                    echo '<thead><tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Material</th>
                            <th>Status</th>
                            <th style="width: 200px;">Progresso</th>
                            <th>Data</th>
                          </tr></thead>';
                    echo '<tbody>';
                    while ($row = $result_recentes->fetch_assoc()) {
                        $badge_class = '';
                        $progress_pct = 0;
                        $progress_color = 'bg-secondary';
                        
                        switch($row['status']) {
                            case 'Recebido': 
                                $badge_class = 'bg-secondary'; 
                                $progress_pct = 33;
                                $progress_color = 'bg-secondary';
                                break;
                            case 'Em Lavagem': 
                                $badge_class = 'bg-warning'; 
                                $progress_pct = 66;
                                $progress_color = 'bg-warning';
                                break;
                            case 'Pronto para Expedição': 
                                $badge_class = 'bg-info'; 
                                $progress_pct = 100;
                                $progress_color = 'bg-info';
                                break;
                            case 'Concluído': 
                                $badge_class = 'bg-success'; 
                                $progress_pct = 100;
                                $progress_color = 'bg-success';
                                break;
                        }
                        
                        echo '<tr>';
                        echo '<td><strong>#' . $row['id'] . '</strong></td>';
                        echo '<td>' . htmlspecialchars($row['cliente']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['tipo_material']) . '</td>';
                        echo '<td><span class="badge ' . $badge_class . '">' . $row['status'] . '</span></td>';
                        echo '<td>
                                <div class="progress" style="height: 8px;" title="' . $progress_pct . '% concluído">
                                    <div class="progress-bar ' . $progress_color . '" role="progressbar" style="width: ' . $progress_pct . '%" aria-valuenow="' . $progress_pct . '" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>';
                        echo '<td>' . date('d/m/Y H:i', strtotime($row['data_cadastro'])) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                    echo '</div>';
                } else {
                    echo '<p class="text-muted text-center py-4">Nenhum pedido cadastrado ainda.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
    $conn->close();
    require_once __DIR__ . '/includes/footer.php';
else:
    $pageTitle = "Bem-vindo";
    require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<div class="landing-hero fade-in">
    <div class="container">
        <h1><?php echo SITE_NAME; ?></h1>
        <p>Soluções Industriais em Lavanderia com Rastreabilidade Digital.</p>
        <a href="pages/login.php" class="btn btn-light btn-landing-login">
            <i class="bi bi-box-arrow-in-right"></i> Acessar Sistema
        </a>
    </div>
</div>

<!-- Services Section -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="service-card slide-in-up">
                <div class="service-icon">
                    <i class="bi bi-box-arrow-in-down"></i>
                </div>
                <h3>Recebimento</h3>
                <p>Triagem e identificação digital de materiais via QR Code para rastreabilidade total.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card slide-in-up" style="animation-delay: 0.1s;">
                <div class="service-icon">
                    <i class="bi bi-droplet"></i>
                </div>
                <h3>Lavagem</h3>
                <p>Processos industriais otimizados com controle rigoroso de insumos e tempo.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card slide-in-up" style="animation-delay: 0.2s;">
                <div class="service-icon">
                    <i class="bi bi-box-arrow-up"></i>
                </div>
                <h3>Expedição</h3>
                <p>Conferência final e entrega ágil, garantindo a integridade do processo LuvaSul.</p>
            </div>
        </div>
    </div>
</div>

<div class="container text-center mb-5 fade-in">
    <hr>
    <p class="text-muted">LuvaSul Lavanderia Industrial - Eficiência e Tecnologia em Cada Fibra.</p>
</div>

<?php
    require_once __DIR__ . '/includes/footer.php';
endif;
?>
