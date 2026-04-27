<?php
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/session_helper.php';
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../includes/qrcode_helper.php';

SessionManager::init();

if (!SessionManager::isLoggedIn()) {
    die("Erro: Sessão encerrada.");
}

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("Erro: ID do pedido inválido.");
}

$conn = inicializarDB();

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
    die("Erro: Pedido não encontrado.");
}

$unit_display = htmlspecialchars(strtolower($pedido['unidade'] ?? 'un'));
if ($unit_display === 'un') $unit_display = 'und.';
$formatted_qty = number_format($pedido['quantidade'], 2, ',', '.') . ' ' . $unit_display;
$display_material = htmlspecialchars($pedido['material_nome'] ?? $pedido['tipo_material']);
if (empty($display_material)) $display_material = "N/A";

$qr_path = obterCaminhoQRCode($pedido['codigo_qr']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Etiqueta #<?php echo $id; ?> - LuvaSul</title>
    <!-- Bootstrap 5 CSS para os controles na tela -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Estilos de Visualização (Padrão LuvaSul) */
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .no-print {
            width: 100%;
            background: #fff;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #0d6efd;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        .label-preview-title {
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Container da Etiqueta - 100mm x 50mm */
        .label-container {
            width: 100mm;
            height: 50mm;
            background: #fff;
            border: 1px solid #000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: flex;
            padding: 4mm;
            box-sizing: border-box;
            align-items: center;
            overflow: hidden;
            position: relative;
            border-radius: 4px;
        }

        .details { 
            flex: 1; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #000;
        }

        .qr-section { 
            width: 35mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-left: 1px dashed #ddd;
            padding-left: 2mm;
        }

        .qr-section img { 
            width: 100%; 
            height: auto;
            image-rendering: pixelated;
        }

        h1 { 
            font-size: 14pt; 
            font-weight: 800;
            margin: 0 0 2px 0; 
            border-bottom: 2px solid #000;
            text-transform: uppercase;
        }

        .order-id { 
            font-size: 16pt; 
            font-weight: 900; 
            margin: 2px 0 6px 0;
        }

        p { font-size: 10pt; line-height: 1.2; margin: 1px 0; }
        .obs-box { 
            font-size: 8pt; 
            border-top: 1px dashed #000; 
            margin-top: 3px; 
            padding-top: 2px;
            font-style: italic;
        }

        /* CONFIGURAÇÃO DE IMPRESSÃO (Rigorosa para Etiqueta) */
        @media print {
            @page { 
                size: 100mm 50mm; 
                margin: 0; 
            }
            
            html, body {
                width: 100mm;
                height: 50mm;
                background: #fff !important;
                overflow: hidden;
            }

            .no-print { display: none !important; }

            .label-container { 
                width: 100mm !important;
                height: 50mm !important;
                border: none !important;
                margin: 0 !important;
                padding: 4mm !important;
                box-shadow: none !important;
                position: absolute;
                top: 0;
                left: 0;
                border-radius: 0;
            }
            
            .qr-section { border-left: none; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <h3 class="label-preview-title"><i class="bi bi-printer-fill"></i> Pré-visualização de Impressão</h3>
        <div class="alert alert-light border d-inline-block py-2 px-4 mb-3">
            <i class="bi bi-info-circle text-primary"></i> A etiqueta será impressa em papel <strong>100x50mm</strong>.
        </div>
        <br>
        <button onclick="window.print()" class="btn btn-primary btn-lg px-5 shadow-sm">
            <i class="bi bi-printer"></i> IMPRIMIR ETIQUETA
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary btn-lg ms-2">
            FECHAR
        </button>
    </div>

    <!-- Estrutura da Etiqueta -->
    <div class="label-container">
        <div class="details">
            <h1><?php echo SITE_NAME; ?></h1>
            <div class="order-id">PEDIDO #<?php echo $pedido['id']; ?></div>
            <p><strong>CLIENTE:</strong> <?php echo htmlspecialchars($pedido['cliente']); ?></p>
            <p><strong>MATERIAL:</strong> <?php echo htmlspecialchars($display_material); ?></p>
            <p><strong>QUANTIDADE:</strong> <?php echo $formatted_qty; ?></p>
            <p><strong>DATA:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['data_cadastro'])); ?></p>
            
            <?php if (!empty(trim($pedido['observacao']))): ?>
                <div class="obs-box">
                    <strong>OBS:</strong> <?php echo htmlspecialchars(substr($pedido['observacao'], 0, 50)); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="qr-section">
            <img src="<?php echo $qr_path; ?>" alt="QR Code">
            <div style="font-size: 8pt; font-weight: bold; margin-top: 3px;">PEDIDO-<?php echo $pedido['id']; ?></div>
        </div>
    </div>

    <script>
        // Disparar automaticamente
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 600);
        };
    </script>
</body>
</html>
