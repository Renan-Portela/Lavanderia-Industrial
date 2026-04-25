<?php
$pageTitle = "Expedição";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/order_service.php';

$mensagem = '';
$tipo_mensagem = '';
$pedido = null;

// Processar leitura do QR Code
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo_qr = trim($_POST['codigo_qr'] ?? '');
    
    if (empty($codigo_qr)) {
        $mensagem = 'Por favor, informe o código do QR Code.';
        $tipo_mensagem = 'danger';
    } else {
        $pedido = OrderService::getByQRCode($codigo_qr);
        
        if ($pedido) {
            if ($pedido['status'] == 'Lavagem') {
                if (OrderService::updateStatus($pedido['id'], 'Expedido')) {
                    $pedido['status'] = 'Expedido';
                    $mensagem = 'Pedido expedido com sucesso!';
                    $tipo_mensagem = 'success';
                } else {
                    $mensagem = 'Erro ao atualizar status.';
                    $tipo_mensagem = 'danger';
                }
            } else if ($pedido['status'] == 'Expedido') {
                $mensagem = 'Este pedido já foi expedido.';
                $tipo_mensagem = 'info';
            } else {
                $mensagem = 'Este pedido não está pronto para expedição. Status atual: ' . $pedido['status'];
                $tipo_mensagem = 'warning';
            }
        } else {
            $mensagem = 'Pedido não encontrado ou código inválido.';
            $tipo_mensagem = 'danger';
        }
    }
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="page-title">
            <i class="bi bi-box-arrow-up"></i> Expedição
        </h1>
    </div>
</div>

<?php if ($mensagem): ?>
<div class="alert alert-<?php echo $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($mensagem); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-qr-code-scan"></i> Leitura de QR Code
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="codigo_qr" class="form-label">Código do QR Code</label>
                        <input type="text" class="form-control form-control-lg" id="codigo_qr" name="codigo_qr" 
                               placeholder="PEDIDO-123 ou escaneie o QR Code" required autofocus>
                        <small class="form-text text-muted">Digite o código ou escaneie o QR Code do pedido</small>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="bi bi-check-circle"></i> Concluir Expedição
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php if ($pedido): ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="bi bi-info-circle"></i> Informações do Pedido
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID do Pedido:</th>
                        <td><strong>#<?php echo $pedido['id']; ?></strong></td>
                    </tr>
                    <tr>
                        <th>Cliente:</th>
                        <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                    </tr>
                    <tr>
                        <th>Material:</th>
                        <td><?php echo htmlspecialchars($pedido['tipo_material']); ?></td>
                    </tr>
                    <tr>
                        <th>Quantidade:</th>
                        <td><?php echo $pedido['quantidade']; ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge <?php echo $pedido['status'] == 'Expedido' ? 'bg-success' : 'bg-info'; ?>">
                                <?php echo $pedido['status']; ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-list-ul"></i> Pedidos Prontos para Expedição
            </div>
            <div class="card-body">
                <?php
                $sql = "SELECT * FROM pedidos WHERE status = 'Lavagem' ORDER BY data_cadastro DESC";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-hover">';
                    echo '<thead><tr><th>ID</th><th>Cliente</th><th>Tipo</th><th>Quantidade</th><th>Data</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>#' . $row['id'] . '</td>';
                        echo '<td>' . htmlspecialchars($row['cliente']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['tipo_material']) . '</td>';
                        echo '<td>' . $row['quantidade'] . '</td>';
                        echo '<td>' . date('d/m/Y H:i', strtotime($row['data_cadastro'])) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                    echo '</div>';
                } else {
                    echo '<p class="text-muted">Nenhum pedido aguardando expedição (em lavagem).</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
