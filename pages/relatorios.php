<?php
// Verificar se é exportação CSV ANTES de incluir o header
if (isset($_GET['exportar']) && $_GET['exportar'] == 'csv') {
    // Inicializar conexão para exportação
    require_once __DIR__ . '/../conexao.php';
    $conn = inicializarDB();
    
    $filtro_status = $_GET['status'] ?? 'todos';
    $pedidos = [];
    
    // Buscar pedidos com filtro e join no material para SKU
    $sql = "SELECT p.*, m.sku as material_sku, m.nome as material_nome FROM pedidos p 
            LEFT JOIN materiais m ON p.material_id = m.id 
            WHERE 1=1";
    
    if ($filtro_status != 'todos') {
        $sql .= " AND p.status = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $filtro_status);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);
    }
    
    while ($row = $result->fetch_assoc()) {
        $pedidos[] = $row;
    }
    
    if (isset($stmt)) {
        $stmt->close();
    }
    
    // Enviar headers antes de qualquer output
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=relatorio_pedidos_' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    
    // BOM para UTF-8 (Excel)
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Cabeçalho
    fputcsv($output, ['ID', 'Cliente', 'SKU', 'Categoria', 'Descrição Extra', 'Quantidade', 'Unidade', 'Status', 'Data de Cadastro'], ';', '"', '\\');
    
    // Dados
    foreach ($pedidos as $pedido) {
        fputcsv($output, [
            $pedido['id'],
            $pedido['cliente'],
            $pedido['material_sku'] ?? 'N/A',
            $pedido['material_nome'] ?? 'N/A',
            $pedido['tipo_material'],
            str_replace('.', ',', $pedido['quantidade']),
            $pedido['unidade'],
            $pedido['status'],
            date('d/m/Y H:i', strtotime($pedido['data_cadastro']))
        ], ';', '"', '\\');
    }
    
    fclose($output);
    $conn->close();
    exit;
}

// Se não for exportação, continuar normalmente
$pageTitle = "Relatórios";
require_once __DIR__ . '/../includes/header.php';

$filtro_status = $_GET['status'] ?? 'todos';
$pedidos = [];

// Buscar pedidos com filtro
$sql = "SELECT p.*, m.sku as material_sku, m.nome as material_nome FROM pedidos p 
        LEFT JOIN materiais m ON p.material_id = m.id 
        WHERE 1=1";

if ($filtro_status != 'todos') {
    $sql .= " AND p.status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filtro_status);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

if (isset($stmt)) {
    $stmt->close();
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="page-title">
            <i class="bi bi-file-earmark-text"></i> Relatórios
        </h1>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-funnel"></i> Filtros
            </div>
            <div class="card-body">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Filtrar por Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="todos" <?php echo $filtro_status == 'todos' ? 'selected' : ''; ?>>Todos os Status</option>
                            <option value="Recebido" <?php echo $filtro_status == 'Recebido' ? 'selected' : ''; ?>>Recebido</option>
                            <option value="Lavagem" <?php echo $filtro_status == 'Lavagem' ? 'selected' : ''; ?>>Lavagem</option>
                            <option value="Expedido" <?php echo $filtro_status == 'Expedido' ? 'selected' : ''; ?>>Expedido</option>
                        </select>
                    </div>
                    <div class="col-md-8 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i> Filtrar
                        </button>
                        <a href="?status=<?php echo $filtro_status; ?>&exportar=csv" class="btn btn-success">
                            <i class="bi bi-download"></i> Exportar CSV
                        </a>
                        <a href="relatorios.php" class="btn btn-secondary ms-2">
                            <i class="bi bi-arrow-clockwise"></i> Limpar Filtros
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas Rápidas -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="text-muted">Total de Pedidos</h5>
                <h2 class="text-primary"><?php echo count($pedidos); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="text-muted">Em Processo (Lavagem)</h5>
                <h2 class="text-warning"><?php echo count(array_filter($pedidos, fn($p) => $p['status'] == 'Lavagem')); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="text-muted">Expedidos</h5>
                <h2 class="text-success"><?php echo count(array_filter($pedidos, fn($p) => $p['status'] == 'Expedido')); ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de Pedidos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-list-ul"></i> Lista de Pedidos</span>
                <span class="badge bg-primary"><?php echo count($pedidos); ?> registro(s)</span>
            </div>
            <div class="card-body">
                <?php if (count($pedidos) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Categoria</th>
                                <th>Quantidade</th>
                                <th>Status</th>
                                <th>Data de Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): 
                                $badge_class = '';
                                switch($pedido['status']) {
                                    case 'Recebido': $badge_class = 'bg-secondary'; break;
                                    case 'Lavagem': $badge_class = 'bg-warning text-dark'; break;
                                    case 'Expedido': $badge_class = 'bg-success'; break;
                                }
                                $display_cat = ($pedido['material_sku'] ? $pedido['material_sku'] . ' - ' : '') . ($pedido['material_nome'] ?? 'Sem Categoria');
                            ?>
                            <tr>
                                <td>
                                    <span class="copyable-code fw-bold" onclick="copiarCodigo('PEDIDO-<?php echo $pedido['id']; ?>')" title="Clique para copiar">
                                        #<?php echo $pedido['id']; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                                <td><?php echo htmlspecialchars($display_cat); ?></td>
                                <td><strong><?php echo number_format($pedido['quantidade'], 2, ',', '.'); ?> <?php echo $pedido['unidade']; ?></strong></td>
                                <td>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo $pedido['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($pedido['data_cadastro'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <p class="text-center text-muted py-4">Nenhum pedido encontrado com os filtros selecionados.</p>
                <?php endif; ?>
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
