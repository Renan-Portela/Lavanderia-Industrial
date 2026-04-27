<?php
$pageTitle = "Lavagem";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/order_service.php';
require_once __DIR__ . '/../includes/material_service.php';
require_once __DIR__ . '/../includes/session_helper.php';

$pedido = null;

// Processar visualização por ID (via clique na tabela)
if (isset($_GET['id'])) {
    $id_ver = intval($_GET['id']);
    $pedido = OrderService::getById($id_ver);
    if ($pedido) {
        $material = MaterialService::getById($pedido['material_id']);
        $pedido['material_sku'] = $material['sku'] ?? 'N/A';
        $pedido['material_nome'] = $material['nome'] ?? 'N/A';
    }
}

// Processar leitura do QR Code
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo_qr = trim($_POST['codigo_qr'] ?? '');
    
    if (empty($codigo_qr)) {
        setFlash('danger', 'Por favor, informe o código do QR Code.');
    } else {
        $pedido = OrderService::getByQRCode($codigo_qr);
        
        if ($pedido) {
            // Buscar informações completas do material do catálogo
            $material = MaterialService::getById($pedido['material_id']);
            $pedido['material_sku'] = $material['sku'] ?? 'N/A';
            $pedido['material_nome'] = $material['nome'] ?? 'N/A';
            
            if ($pedido['status'] == 'Recebido') {
                if (OrderService::updateStatus($pedido['id'], 'Lavagem')) {
                    $pedido['status'] = 'Lavagem';
                    setFlash('success', 'Lavagem iniciada com sucesso para o pedido #' . $pedido['id'] . '!');
                } else {
                    setFlash('danger', 'Erro ao atualizar status do pedido.');
                }
            } else if ($pedido['status'] == 'Lavagem') {
                setFlash('info', 'Este pedido já está em lavagem.');
            } else {
                setFlash('warning', 'Este pedido não pode ser iniciado na lavagem. Status atual: ' . $pedido['status']);
            }
        } else {
            setFlash('danger', 'Pedido não encontrado ou código inválido.');
        }
    }
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="page-title">
            <i class="bi bi-droplet"></i> Lavagem
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light">
                <i class="bi bi-qr-code-scan"></i> Leitura de QR Code
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="codigo_qr" class="form-label">Código do QR Code</label>
                        <input type="text" class="form-control form-control-lg" id="codigo_qr" name="codigo_qr" 
                               placeholder="PEDIDO-123 ou escaneie o QR Code" required autofocus autocomplete="off">
                        <small class="form-text text-muted">Digite o código ou escaneie o QR Code do pedido</small>
                    </div>
                    <div class="d-grid mt-auto">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-play-circle"></i> Iniciar Lavagem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php if ($pedido): ?>
    <div class="col-md-6 mb-4 fade-in">
        <div class="card shadow-sm border-warning h-100">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle"></i> Informações do Pedido</span>
                <button class="btn btn-sm btn-light border-dark" onclick="copiarCodigo('PEDIDO-<?php echo $pedido['id']; ?>')">
                    <i class="bi bi-clipboard"></i> Copiar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th class="w-25 text-muted">ID:</th>
                        <td><span class="fs-5 fw-bold text-dark">#<?php echo $pedido['id']; ?></span></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Cliente:</th>
                        <td><span class="fs-6"><?php echo htmlspecialchars($pedido['cliente']); ?></span></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Material:</th>
                        <td>
                            <div class="fw-bold"><?php echo htmlspecialchars($pedido['material_nome']); ?></div>
                            <small class="text-muted">SKU: <?php echo htmlspecialchars($pedido['material_sku']); ?></small>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">QTD:</th>
                        <td>
                            <span class="badge bg-primary fs-6">
                                <?php echo number_format($pedido['quantidade'], 2, ',', '.') . ' ' . strtolower($pedido['unidade'] ?? 'un'); ?>
                            </span>
                        </td>
                    </tr>
                    <?php if (!empty(trim($pedido['observacao']))): ?>
                    <tr>
                        <th class="text-muted">OBS:</th>
                        <td>
                            <div class="alert alert-warning p-2 mb-0 mt-1">
                                <i class="bi bi-exclamation-triangle me-1"></i> <?php echo nl2br(htmlspecialchars($pedido['observacao'])); ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row mt-2">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span><i class="bi bi-list-ul"></i> Pedidos em Lavagem</span>
            </div>
            <div class="card-body">
                <?php
                $sql = "SELECT p.*, m.sku as material_sku, m.nome as material_nome FROM pedidos p 
                        LEFT JOIN materiais m ON p.material_id = m.id 
                        WHERE p.status = 'Lavagem' ORDER BY p.data_cadastro DESC";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-hover align-middle">';
                    echo '<thead><tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>SKU</th>
                            <th>Significado SKU</th>
                            <th>Quantidade</th>
                            <th>Data</th>
                          </tr></thead>';
                    echo '<tbody>';
                    while ($row = $result->fetch_assoc()) {
                        $display_material = $row['material_nome'] ?? $row['tipo_material'];
                        if (empty($display_material)) $display_material = "N/A";
                        
                        $unit_display = strtolower($row['unidade'] ?? 'un');
                        if ($unit_display === 'un') $unit_display = 'und.';
                        
                        echo '<tr>';
                        echo '<td><a href="lavagem.php?id=' . $row['id'] . '" class="fw-bold text-decoration-none">#' . $row['id'] . '</a></td>';
                        echo '<td>' . htmlspecialchars($row['cliente']) . '</td>';
                        echo '<td><code>' . htmlspecialchars($row['material_sku']) . '</code></td>';
                        echo '<td>' . htmlspecialchars($display_material) . '</td>';
                        echo '<td><strong>' . number_format($row['quantidade'], 2, ',', '.') . ' ' . $unit_display . '</strong></td>';
                        echo '<td>' . date('d/m/Y H:i', strtotime($row['data_cadastro'])) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                    echo '</div>';
                } else {
                    echo '<p class="text-muted text-center py-3">Nenhum pedido em lavagem no momento.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
