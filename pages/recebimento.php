<?php
$pageTitle = "Recebimento";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/session_helper.php';
require_once __DIR__ . '/../includes/qrcode_helper.php';
require_once __DIR__ . '/../includes/material_service.php';
require_once __DIR__ . '/../includes/order_service.php';

$pedido_criado = null;

// Buscar materiais do catálogo
$materiais_catalogo = MaterialService::getAll();

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente = trim($_POST['cliente'] ?? '');
    $material_id = intval($_POST['material_id'] ?? 0);
    $tipo_material = trim($_POST['tipo_material'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $observacao = trim($_POST['observacao'] ?? '');
    
    $formData = [
        'material_id' => $material_id,
        'tipo_material' => $tipo_material
    ];

    if (empty($cliente) || !OrderService::validateHybridData($formData) || $quantidade <= 0) {
        setFlash('danger', 'Por favor, preencha todos os campos obrigatórios corretamente.');
    } else {
        // Inserir pedido usando material_id e a descrição específica
        $sql = "INSERT INTO pedidos (cliente, material_id, tipo_material, quantidade, observacao, status) VALUES (?, ?, ?, ?, ?, 'Recebido')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisss", $cliente, $material_id, $tipo_material, $quantidade, $observacao);
        
        if ($stmt->execute()) {
            $pedido_id = $conn->insert_id;
            
            // Gerar QR Code
            $codigo_qr_texto = 'PEDIDO-' . $pedido_id;
            $nome_qr = gerarQRCode($codigo_qr_texto, 'pedido_' . $pedido_id . '.png');
            
            if ($nome_qr) {
                // Atualizar pedido com o caminho do QR Code
                $stmt2 = $conn->prepare("UPDATE pedidos SET codigo_qr = ? WHERE id = ?");
                $stmt2->bind_param("si", $nome_qr, $pedido_id);
                $stmt2->execute();
                $stmt2->close();
            }
            
            // Buscar pedido criado com join no material para exibição imediata
            $sql_buscar = "SELECT p.*, m.nome as material_nome, m.sku as material_sku 
                          FROM pedidos p 
                          LEFT JOIN materiais m ON p.material_id = m.id 
                          WHERE p.id = $pedido_id";
            $result = $conn->query($sql_buscar);
            $pedido_criado = $result->fetch_assoc();
            
            setFlash('success', 'Pedido #' . $pedido_id . ' cadastrado com sucesso! QR Code gerado.');
        } else {
            setFlash('danger', 'Erro ao cadastrar pedido: ' . $conn->error);
        }
        
        $stmt->close();
    }
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="page-title">
            <i class="bi bi-box-arrow-in-down"></i> Recebimento de Pedidos
        </h1>
    </div>
</div>

<?php if ($pedido_criado): ?>
<!-- Exibir QR Code após criação -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-success shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle"></i> Pedido Cadastrado com Sucesso!
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Dados do Pedido</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-25">ID do Pedido:</th>
                                <td><strong>#<?php echo $pedido_criado['id']; ?></strong></td>
                            </tr>
                            <tr>
                                <th>Cliente:</th>
                                <td><?php echo htmlspecialchars($pedido_criado['cliente']); ?></td>
                            </tr>
                            <tr>
                                <th>Descrição:</th>
                                <td><?php echo htmlspecialchars($pedido_criado['tipo_material']); ?></td>
                            </tr>
                            <tr>
                                <th>SKU Categoria:</th>
                                <td>
                                    <strong><?php echo htmlspecialchars($pedido_criado['material_nome']); ?></strong>
                                    <br><small class="text-muted">SKU: <?php echo $pedido_criado['material_sku']; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <th>Quantidade:</th>
                                <td><?php echo $pedido_criado['quantidade']; ?></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td><span class="badge bg-secondary"><?php echo $pedido_criado['status']; ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="qr-code-container">
                            <h5>QR Code do Pedido</h5>
                            <?php if ($pedido_criado['codigo_qr']): ?>
                                <img src="<?php echo obterCaminhoQRCode($pedido_criado['codigo_qr']); ?>" alt="QR Code" class="img-fluid border p-2 bg-white" style="max-height: 200px;">
                                <p class="mt-3 mb-3">
                                    <strong>Código:</strong> PEDIDO-<?php echo $pedido_criado['id']; ?>
                                </p>
                                <div class="d-grid gap-2">
                                    <button onclick="imprimirQRCode()" class="btn btn-outline-primary">
                                        <i class="bi bi-printer"></i> Imprimir QR Code
                                    </button>
                                </div>
                            <?php else: ?>
                                <p class="text-danger">Erro ao gerar QR Code</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Formulário de Recebimento -->
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <i class="bi bi-file-earmark-plus"></i> Novo Pedido
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cliente" name="cliente" required 
                               placeholder="Nome da empresa cliente" value="<?php echo isset($_POST['cliente']) ? htmlspecialchars($_POST['cliente']) : ''; ?>">
                        <div class="invalid-feedback">Por favor, informe o cliente.</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="material_id" class="form-label">SKU Categoria <span class="text-danger">*</span></label>
                            <select class="form-select" id="material_id" name="material_id" required>
                                <option value="" selected disabled>Selecione um SKU...</option>
                                <?php foreach ($materiais_catalogo as $m): ?>
                                    <option value="<?php echo $m['id']; ?>" <?php echo (isset($_POST['material_id']) && $_POST['material_id'] == $m['id']) ? 'selected' : ''; ?>>
                                        <?php echo $m['sku']; ?> (<?php echo htmlspecialchars($m['nome']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Selecione uma categoria SKU.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tipo_material" class="form-label">Descrição do Material <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tipo_material" name="tipo_material" required 
                                   placeholder="Ex: Luva Nitrílica Verde" value="<?php echo isset($_POST['tipo_material']) ? htmlspecialchars($_POST['tipo_material']) : ''; ?>">
                            <div class="invalid-feedback">Informe a descrição do item.</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" required 
                               min="1" placeholder="Quantidade de itens" value="<?php echo isset($_POST['quantidade']) ? htmlspecialchars($_POST['quantidade']) : ''; ?>">
                        <div class="invalid-feedback">A quantidade deve ser maior que zero.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacao" name="observacao" rows="3" 
                                  placeholder="Observações gerais sobre o pedido"><?php echo isset($_POST['observacao']) ? htmlspecialchars($_POST['observacao']) : ''; ?></textarea>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Salvar Pedido e Gerar QR Code
                        </button>
                        <a href="../index.php" class="btn btn-link text-muted">
                            <i class="bi bi-arrow-left"></i> Voltar ao Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
