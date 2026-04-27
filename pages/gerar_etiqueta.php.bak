<?php
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/session_helper.php';
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../includes/qrcode_helper.php';

SessionManager::requireLogin();

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("ID do pedido inválido.");
}

// Buscar dados do pedido
$sql = "SELECT p.*, m.nome as material_nome, m.sku as material_sku 
        FROM pedidos p 
        LEFT JOIN materiais m ON p.material_id = m.id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pedido = $result->fetch_assoc();

if (!$pedido) {
    die("Pedido não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Etiqueta Pedido #<?php echo $id; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: white; margin: 0; padding: 0; }
        .label-container {
            width: 100mm;
            border: 2px solid #000;
            padding: 5mm;
            margin: 10px auto;
            font-family: Arial, sans-serif;
        }
        .label-header {
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 5mm;
            padding-bottom: 2mm;
        }
        .label-header h1 { margin: 0; font-size: 18pt; }
        .label-body { display: flex; align-items: center; }
        .label-details { flex: 1; font-size: 12pt; }
        .label-qr { width: 40mm; text-align: right; }
        .label-qr img { width: 100%; border: 1px solid #eee; }
        .label-footer {
            margin-top: 5mm;
            padding-top: 2mm;
            border-top: 1px dashed #000;
            font-size: 10pt;
            text-align: center;
        }
        @media print {
            .no-print { display: none !important; }
            .label-container { border: 1px solid #000; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print text-center py-3">
        <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
        <button onclick="window.close()" class="btn btn-secondary">Fechar</button>
    </div>

    <div class="label-container">
        <div class="label-header">
            <h1><?php echo SITE_NAME; ?></h1>
        </div>
        <div class="label-body">
            <div class="label-details">
                <p><strong>PEDIDO:</strong> #<?php echo $pedido['id']; ?></p>
                <p><strong>CLIENTE:</strong> <?php echo htmlspecialchars($pedido['cliente']); ?></p>
                <p><strong>MATERIAL:</strong> <?php echo htmlspecialchars($pedido['material_nome'] ?? $pedido['tipo_material']); ?></p>
                <p><strong>QTD:</strong> <?php echo number_format($pedido['quantidade'], 2, ',', '.'); ?> <?php echo $pedido['unidade']; ?></p>
                <p><strong>DATA:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['data_cadastro'])); ?></p>
            </div>
            <div class="label-qr">
                <img src="<?php echo obterCaminhoQRCode($pedido['codigo_qr']); ?>" alt="QR Code">
                <div style="font-size: 8pt; margin-top: 2mm;">PEDIDO-<?php echo $pedido['id']; ?></div>
            </div>
        </div>
        <?php if (!empty($pedido['observacao'])): ?>
        <div class="label-footer">
            <strong>OBS:</strong> <?php echo htmlspecialchars($pedido['observacao']); ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
