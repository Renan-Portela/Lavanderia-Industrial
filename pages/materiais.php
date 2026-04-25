<?php
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/material_service.php';
require_once __DIR__ . '/../includes/sku_helper.php';

SessionManager::requireAdmin();

$success = '';
$error = '';

// Processar Ações (Create, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create' || $action === 'update') {
        $data = [
            'nome' => $_POST['nome'] ?? '',
            'sku' => $_POST['sku'] ?? '',
            'tipo_lavagem' => $_POST['tipo_lavagem'] ?? '',
            'descricao' => $_POST['descricao'] ?? ''
        ];
        
        if (!SKUHelper::validate($data['sku'])) {
            $error = 'SKU inválido. Use o padrão CAT-MAT-SIZ-WASH (ex: GLV-IND-XL-A).';
        } else {
            if ($action === 'create') {
                if (MaterialService::create($data)) {
                    $success = 'Material criado com sucesso!';
                } else {
                    $error = 'Erro ao criar material. Verifique se o SKU já existe.';
                }
            } else {
                $id = $_POST['id'] ?? 0;
                if (MaterialService::update($id, $data)) {
                    $success = 'Material atualizado com sucesso!';
                } else {
                    $error = 'Erro ao atualizar material.';
                }
            }
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        if (MaterialService::delete($id)) {
            $success = 'Material desativado com sucesso!';
        } else {
            $error = 'Erro ao desativar material.';
        }
    }
}

$materials = MaterialService::getAll();
$pageTitle = 'Catálogo de Materiais';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header slide-in-up">
    <h1><i class="bi bi-tags"></i> Catálogo de Materiais</h1>
    <p>Gerencie os itens padronizados para o processo de lavagem.</p>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-plus-circle"></i> Novo Material</span>
    </div>
    <div class="card-body">
        <form method="POST" class="row g-3 needs-validation" novalidate>
            <input type="hidden" name="action" value="create">
            <div class="col-md-4">
                <label for="nome" class="form-label">Nome do Material</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Luva de Raspa GG" required>
            </div>
            <div class="col-md-3">
                <label for="sku" class="form-label">SKU (CAT-MAT-SIZ-WASH)</label>
                <input type="text" class="form-control" id="sku" name="sku" placeholder="Ex: GLV-RSP-GG-S" required>
            </div>
            <div class="col-md-2">
                <label for="tipo_lavagem" class="form-label">Lavagem</label>
                <select class="form-select" id="tipo_lavagem" name="tipo_lavagem" required>
                    <option value="" selected disabled>Escolha...</option>
                    <option value="A">Água (A)</option>
                    <option value="S">Seco (S)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao">
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Adicionar ao Catálogo</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-table"></i> Itens Cadastrados
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>SKU</th>
                        <th>Lavagem</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($materials)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhum material cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($materials as $m): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($m['nome']); ?></td>
                                <td><code class="fw-bold"><?php echo htmlspecialchars($m['sku']); ?></code></td>
                                <td>
                                    <span class="badge <?php echo $m['tipo_lavagem'] == 'A' ? 'bg-info' : 'bg-warning text-dark'; ?>">
                                        <?php echo $m['tipo_lavagem'] == 'A' ? 'Água' : 'Seco'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($m['descricao']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja desativar este material?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Desativar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
