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

$unit_display = strtolower($pedido['unidade'] ?? 'un');
if ($unit_display === 'un') $unit_display = 'und.';
$formatted_qty = number_format($pedido['quantidade'], 2, ',', '.') . ' ' . $unit_display;
$display_material = $pedido['material_nome'] ?? $pedido['tipo_material'];
if (empty($display_material)) $display_material = "N/A";

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Etiqueta Pedido #<?php echo $id; ?></title>
    <style>
        /* Base styles for screen preview */
        body { 
            background: #f0f0f0; 
            margin: 0; 
            padding: 20px; 
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }
        
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .btn {
            background: #000;
            color: #fff;
            border: 1px solid #000;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Label Container - 100mm x 50mm strict */
        .label-container {
            width: 96mm; /* slightly less than 100mm to account for padding/borders safely */
            height: 46mm; /* slightly less than 50mm */
            background: #fff;
            padding: 2mm;
            margin: 0 auto;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Visible on screen */
            display: flex;
            flex-direction: column;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .label-header {
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 1mm;
            padding-bottom: 1mm;
            flex-shrink: 0;
        }
        
        .label-header h1 { 
            margin: 0; 
            font-size: 14pt; 
            font-weight: 900;
            text-transform: uppercase;
        }

        .label-body { 
            display: flex; 
            flex-direction: row;
            align-items: stretch;
            flex-grow: 1;
            gap: 2mm;
        }

        .label-details { 
            flex: 1; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .label-details p {
            margin: 0 0 1mm 0;
            font-size: 9pt;
            line-height: 1.2;
            word-break: break-word;
        }
        
        .label-details p.large-id {
            font-size: 14pt;
            font-weight: 900;
            margin-bottom: 2mm;
        }

        .label-details strong {
            font-weight: bold;
        }

        .label-qr { 
            width: 35mm;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .label-qr img { 
            width: 100%; 
            height: auto;
            max-height: 35mm;
            object-fit: contain;
            image-rendering: pixelated; /* Optimize for thermal */
        }

        /* Print Media Queries */
        @media print {
            @page {
                size: 100mm 50mm;
                margin: 0;
            }
            body { 
                background: #fff !important; 
                margin: 0 !important; 
                padding: 0 !important; 
            }
            .no-print { 
                display: none !important; 
            }
            .label-container { 
                border: none !important; /* Remove screen border */
                margin: 0 !important;
                width: 100mm !important;
                height: 50mm !important;
                box-shadow: none !important;
            }
            /* Force pure black and white */
            * {
                color: #000 !important;
                background-color: transparent !important;
                box-shadow: none !important;
                text-shadow: none !important;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print">
        <button onclick="window.print()" class="btn">Imprimir Etiqueta</button>
        <button onclick="window.close()" class="btn" style="background:#fff; color:#000; margin-left:10px;">Fechar Janela</button>
    </div>

    <div class="label-container">
        <div class="label-header">
            <h1><?php echo SITE_NAME; ?></h1>
        </div>
        <div class="label-body">
            <div class="label-details">
                <p class="large-id">PEDIDO-<?php echo $pedido['id']; ?></p>
                <p><strong>CLI:</strong> <?php echo htmlspecialchars($pedido['cliente']); ?></p>
                <p><strong>MAT:</strong> <?php echo htmlspecialchars($display_material); ?></p>
                <p><strong>QTD:</strong> <?php echo $formatted_qty; ?></p>
                <p><strong>DAT:</strong> <?php echo date('d/m/y H:i', strtotime($pedido['data_cadastro'])); ?></p>
                <?php if (!empty(trim($pedido['observacao']))): ?>
                    <p style="font-size: 8pt; border-top: 1px dashed #000; padding-top: 1mm; margin-top: 1mm;">
                        <strong>OBS:</strong> <?php echo htmlspecialchars(substr($pedido['observacao'], 0, 50)) . (strlen($pedido['observacao']) > 50 ? '...' : ''); ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="label-qr">
                <img src="<?php echo obterCaminhoQRCode($pedido['codigo_qr']); ?>" alt="QR Code PEDIDO-<?php echo $pedido['id']; ?>">
            </div>
        </div>
    </div>
</body>
</html>
