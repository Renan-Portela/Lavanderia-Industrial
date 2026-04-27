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
    $material_search = trim($_POST['material_search'] ?? '');
    $quantidade = floatval($_POST['quantidade'] ?? 0);
    $unidade = $_POST['unidade'] ?? 'UN';
    $observacao = trim($_POST['observacao'] ?? '');
    
    // Tentar encontrar o material_id a partir do input de busca
    $material_id = 0;
    
    // 1. Tentar formato do datalist: "SKU - Nome"
    if (preg_match('/^(.+?)\s-\s/', $material_search, $matches)) {
        $sku_search = $matches[1];
        foreach ($materiais_catalogo as $m) {
            if ($m['sku'] === $sku_search) {
                $material_id = $m['id'];
                break;
            }
        }
    }
    
    // 2. Se não encontrou, buscar por SKU exato ou Nome exato
    if ($material_id === 0) {
        foreach ($materiais_catalogo as $m) {
            if (strcasecmp($m['sku'], $material_search) === 0 || strcasecmp($m['nome'], $material_search) === 0) {
                $material_id = $m['id'];
                // Atualizar o search para o formato padrão para consistência visual
                $material_search = $m['sku'] . ' - ' . $m['nome'];
                break;
            }
        }
    }

    if (empty($cliente) || $material_id === 0 || $quantidade <= 0) {
        $error_msg = 'Por favor, preencha todos os campos obrigatórios corretamente.';
        if ($material_id === 0 && !empty($material_search)) {
            $error_msg .= ' A categoria "' . htmlspecialchars($material_search) . '" não foi encontrada no catálogo.';
        }
        setFlash('danger', $error_msg);
    } else {
        // Inserir pedido
        $sql = "INSERT INTO pedidos (cliente, material_id, tipo_material, quantidade, unidade, observacao, status) VALUES (?, ?, '', ?, ?, ?, 'Recebido')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sidss", $cliente, $material_id, $quantidade, $unidade, $observacao);
        
        if ($stmt->execute()) {
            $pedido_id = $conn->insert_id;
            
            // Gerar QR Code
            $codigo_qr_texto = 'PEDIDO-' . $pedido_id;
            $nome_qr = gerarQRCode($codigo_qr_texto, 'pedido_' . $pedido_id . '.png');
            
            if ($nome_qr) {
                $stmt2 = $conn->prepare("UPDATE pedidos SET codigo_qr = ? WHERE id = ?");
                $stmt2->bind_param("si", $nome_qr, $pedido_id);
                $stmt2->execute();
                $stmt2->close();
            }
            
            // Buscar pedido criado para exibição
            $sql_buscar = "SELECT p.*, m.nome as material_nome, m.sku as material_sku 
                          FROM pedidos p 
                          LEFT JOIN materiais m ON p.material_id = m.id 
                          WHERE p.id = $pedido_id";
            $result = $conn->query($sql_buscar);
            $pedido_criado = $result->fetch_assoc();
            
            setFlash('success', 'Pedido #' . $pedido_id . ' cadastrado com sucesso!');
            
            // Limpar campos para novo cadastro se desejar, ou manter preenchido
            // Aqui optamos por limpar apenas se o usuário clicar em "Cadastrar Outro" no card de sucesso
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
<div class="row mb-4 fade-in">
    <div class="col-12">
        <div class="card border-success shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle"></i> Pedido Cadastrado com Sucesso!
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h5>Dados do Pedido</h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="w-25">Código:</th>
                                <td>
                                    <span class="copyable-code badge bg-light text-dark border p-2" 
                                          onclick="copiarCodigo('PEDIDO-<?php echo $pedido_criado['id']; ?>')" 
                                          title="Clique para copiar">
                                        PEDIDO-<?php echo $pedido_criado['id']; ?> <i class="bi bi-clipboard ms-1"></i>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Cliente:</th>
                                <td><?php echo htmlspecialchars($pedido_criado['cliente']); ?></td>
                            </tr>
                            <tr>
                                <th>Categoria:</th>
                                <td>
                                    <strong><?php echo htmlspecialchars($pedido_criado['material_nome']); ?></strong>
                                    <small class="text-muted">(SKU: <?php echo $pedido_criado['material_sku']; ?>)</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Quantidade:</th>
                                <td><strong><?php echo number_format($pedido_criado['quantidade'], 2, ',', '.'); ?> <?php echo $pedido_criado['unidade']; ?></strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5 text-center border-start">
                        <div class="qr-code-display mb-3">
                            <img src="<?php echo obterCaminhoQRCode($pedido_criado['codigo_qr']); ?>" alt="QR Code" class="img-fluid border p-2 bg-white" style="max-height: 150px;">
                        </div>
                        <div class="d-grid gap-2">
                            <a href="gerar_etiqueta.php?id=<?php echo $pedido_criado['id']; ?>" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-printer"></i> Imprimir Etiqueta
                            </a>
                            <a href="recebimento.php" class="btn btn-link btn-sm">Cadastrar Outro</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <i class="bi bi-file-earmark-plus"></i> Novo Recebimento
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cliente" name="cliente" required 
                               placeholder="Nome da empresa" value="<?php echo isset($_POST['cliente']) && !$pedido_criado ? htmlspecialchars($_POST['cliente']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="material_search" class="form-label">Categoria (Pesquise por SKU ou Nome) <span class="text-danger">*</span></label>
                        <input list="materiaisOptions" class="form-control" id="material_search" name="material_search" 
                               placeholder="Digite para filtrar..." required autocomplete="off"
                               value="<?php echo isset($_POST['material_search']) && !$pedido_criado ? htmlspecialchars($_POST['material_search']) : ''; ?>">
                        <datalist id="materiaisOptions">
                            <?php foreach ($materiais_catalogo as $m): ?>
                                <option value="<?php echo $m['sku'] . ' - ' . $m['nome']; ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unidade de Medida <span class="text-danger">*</span></label>
                            <div class="unit-selection-group">
                                <input type="radio" class="btn-check" name="unidade" id="unit_un" value="UN" <?php echo (!isset($_POST['unidade']) || $_POST['unidade'] == 'UN') ? 'checked' : ''; ?>>
                                <label class="btn btn-outline-primary" for="unit_un">UN / Pares</label>

                                <input type="radio" class="btn-check" name="unidade" id="unit_kg" value="KG" <?php echo (isset($_POST['unidade']) && $_POST['unidade'] == 'KG') ? 'checked' : ''; ?>>
                                <label class="btn btn-outline-primary" for="unit_kg">Quilos (KG)</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="quantidade" class="form-label">Quantidade <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" step="0.01" min="0.01" required
                                   value="<?php echo isset($_POST['quantidade']) && !$pedido_criado ? htmlspecialchars($_POST['quantidade']) : ''; ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="observacao" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Detalhes adicionais (opcional)"><?php echo isset($_POST['observacao']) && !$pedido_criado ? htmlspecialchars($_POST['observacao']) : ''; ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Registrar Recebimento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function copiarCodigo(texto) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(texto).then(() => {
            alert('Código ' + texto + ' copiado!');
        });
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
