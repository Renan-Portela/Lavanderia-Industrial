<?php
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/material_service.php';
require_once __DIR__ . '/../includes/sku_helper.php';
require_once __DIR__ . '/../includes/session_helper.php';

SessionManager::requireAdmin();

$material_selecionado = null;
$view_mode = 'idle'; // idle, view, edit, add

// Buscar materiais do catálogo para o datalist e tabela
$materials = MaterialService::getAll();

// Processar visualização por ID (via clique na tabela ou redirect)
if (isset($_GET['id'])) {
    $id_ver = intval($_GET['id']);
    $material_selecionado = MaterialService::getById($id_ver);
    if ($material_selecionado) {
        $view_mode = 'view';
        if (isset($_GET['edit'])) $view_mode = 'edit';
    }
}

// Processar Ações (Create, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create' || $action === 'update') {
        $data = [
            'nome' => $_POST['nome'] ?? '',
            'sku' => strtoupper(trim($_POST['sku'] ?? '')),
            'tipo_lavagem' => $_POST['tipo_lavagem'] ?? '',
            'descricao' => $_POST['descricao'] ?? ''
        ];
        
        if (!SKUHelper::validate($data['sku'])) {
            setFlash('danger', 'SKU inválido. Use o padrão CAT-MAT-SIZ-WASH (ex: GLV-IND-XL-A).');
        } else {
            if ($action === 'create') {
                if (MaterialService::create($data)) {
                    setFlash('success', 'Material "' . htmlspecialchars($data['nome']) . '" adicionado com sucesso!');
                    header('Location: materiais.php');
                    exit();
                } else {
                    setFlash('danger', 'Erro ao criar material. Verifique se o SKU já existe.');
                }
            } else {
                $id = intval($_POST['id'] ?? 0);
                if (MaterialService::update($id, $data)) {
                    setFlash('success', 'Material atualizado com sucesso!');
                    header('Location: materiais.php?id=' . $id);
                    exit();
                } else {
                    setFlash('danger', 'Erro ao atualizar material.');
                }
            }
        }
    } elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if (MaterialService::delete($id)) {
            setFlash('success', 'Material desativado com sucesso!');
        } else {
            setFlash('danger', 'Erro ao desativar material.');
        }
        header('Location: materiais.php');
        exit();
    } elseif ($action === 'search') {
        $search = trim($_POST['material_search'] ?? '');
        if (preg_match('/^(.+?)\s-\s/', $search, $matches)) {
            $sku_search = $matches[1];
            foreach ($materials as $m) {
                if ($m['sku'] === $sku_search) {
                    header('Location: materiais.php?id=' . $m['id']);
                    exit();
                }
            }
        } else {
            // Tentar busca exata por SKU ou Nome
            foreach ($materials as $m) {
                if (strcasecmp($m['sku'], $search) === 0 || strcasecmp($m['nome'], $search) === 0) {
                    header('Location: materiais.php?id=' . $m['id']);
                    exit();
                }
            }
        }
        setFlash('warning', 'Material "' . htmlspecialchars($search) . '" não encontrado.');
    }
}

// Se clicou em "Novo Material"
if (isset($_GET['new'])) {
    $view_mode = 'add';
}

$pageTitle = 'Catálogo de Materiais';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row align-items-center mb-4 slide-in-up">
    <div class="col-md-6">
        <h1 class="page-title mb-0 border-0">
            <i class="bi bi-tags"></i> Catálogo de Materiais
        </h1>
        <p class="text-muted mb-0">Gerencie os itens padronizados para o processo de lavagem.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="materiais.php?new=1" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Material
        </a>
    </div>
</div>

<div class="row mb-4">
    <!-- Coluna de Busca e Cadastro -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light">
                <i class="bi bi-search"></i> Pesquisar Material
            </div>
            <div class="card-body">
                <form method="POST" class="mb-0">
                    <input type="hidden" name="action" value="search">
                    <div class="input-group input-group-lg">
                        <input list="materiaisOptions" class="form-control" id="material_search" name="material_search" 
                               placeholder="SKU ou Nome..." required autocomplete="off">
                        <datalist id="materiaisOptions">
                            <?php foreach ($materials as $m): ?>
                                <option value="<?php echo $m['sku'] . ' - ' . $m['nome']; ?>">
                            <?php endforeach; ?>
                        </datalist>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <?php if ($view_mode === 'add'): ?>
                <hr class="my-4">
                <h5 class="mb-3">Cadastrar Novo Material</h5>
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Material <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Luva de Raspa GG" required>
                    </div>
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU (CAT-MAT-SIZ-WASH) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sku" name="sku" placeholder="Ex: GLV-RSP-GG-S" required 
                               pattern="^[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+-[AS]$">
                        <div class="form-text">Padrão: 3 letras - 3 letras - Tam - Lavagem</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Lavagem <span class="text-danger">*</span></label>
                        <div class="unit-selection-group">
                            <input type="radio" class="btn-check" name="tipo_lavagem" id="wash_a" value="A" checked>
                            <label class="btn btn-outline-info" for="wash_a">Água (A)</label>

                            <input type="radio" class="btn-check" name="tipo_lavagem" id="wash_s" value="S">
                            <label class="btn btn-outline-warning" for="wash_s">Seco (S)</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="descricao" class="form-label">Descrição Adicional</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="2"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Salvar Material
                        </button>
                        <a href="materiais.php" class="btn btn-link text-muted">Cancelar</a>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Coluna de Detalhes e Edição -->
    <div class="col-lg-6 mb-4">
        <?php if ($material_selecionado): ?>
        <div class="card shadow-sm h-100 border-primary fade-in">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle"></i> Detalhes do Material</span>
                <div>
                    <button class="btn btn-sm btn-light text-primary fw-bold me-2" onclick="copiarCodigo('<?php echo $material_selecionado['sku']; ?>')">
                        <i class="bi bi-clipboard"></i> Copiar SKU
                    </button>
                    <?php if ($view_mode === 'view'): ?>
                        <a href="?id=<?php echo $material_selecionado['id']; ?>&edit=1" class="btn btn-sm btn-light border-white">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <?php if ($view_mode === 'view'): ?>
                    <table class="table table-borderless">
                        <tr>
                            <th class="w-25 text-muted">Nome:</th>
                            <td class="fs-5 fw-bold"><?php echo htmlspecialchars($material_selecionado['nome']); ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">SKU:</th>
                            <td><code class="fs-6 fw-bold"><?php echo htmlspecialchars($material_selecionado['sku']); ?></code></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Lavagem:</th>
                            <td>
                                <span class="badge <?php echo $material_selecionado['tipo_lavagem'] == 'A' ? 'bg-info' : 'bg-warning text-dark'; ?> fs-6">
                                    <?php echo $material_selecionado['tipo_lavagem'] == 'A' ? 'Água (A)' : 'Seco (S)'; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Descrição:</th>
                            <td><?php echo nl2br(htmlspecialchars($material_selecionado['descricao'] ?: 'Sem descrição adicional.')); ?></td>
                        </tr>
                    </table>
                <?php else: // Edit Mode ?>
                    <form method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $material_selecionado['id']; ?>">
                        <div class="mb-3">
                            <label for="edit_nome" class="form-label">Nome do Material</label>
                            <input type="text" class="form-control" id="edit_nome" name="nome" 
                                   value="<?php echo htmlspecialchars($material_selecionado['nome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="edit_sku" name="sku" 
                                   value="<?php echo htmlspecialchars($material_selecionado['sku']); ?>" required
                                   pattern="^[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+-[AS]$">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Lavagem</label>
                            <div class="unit-selection-group">
                                <input type="radio" class="btn-check" name="tipo_lavagem" id="edit_wash_a" value="A" <?php echo $material_selecionado['tipo_lavagem'] == 'A' ? 'checked' : ''; ?>>
                                <label class="btn btn-outline-info" for="edit_wash_a">Água (A)</label>

                                <input type="radio" class="btn-check" name="tipo_lavagem" id="edit_wash_s" value="S" <?php echo $material_selecionado['tipo_lavagem'] == 'S' ? 'checked' : ''; ?>>
                                <label class="btn btn-outline-warning" for="edit_wash_s">Seco (S)</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="edit_descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="edit_descricao" name="descricao" rows="3"><?php echo htmlspecialchars($material_selecionado['descricao']); ?></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Atualizar Dados
                            </button>
                            <a href="?id=<?php echo $material_selecionado['id']; ?>" class="btn btn-link text-muted">Cancelar</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="card shadow-sm h-100 border-dashed d-flex align-items-center justify-content-center bg-light">
            <div class="text-center p-5">
                <i class="bi bi-search fs-1 text-muted opacity-50"></i>
                <p class="text-muted mt-3">Selecione um material na busca ou na tabela para ver detalhes e editar.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow-sm slide-in-up" style="animation-delay: 0.1s;">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <span><i class="bi bi-table"></i> Itens Cadastrados no Sistema</span>
        <span class="badge bg-primary"><?php echo count($materials); ?> Material(is)</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome do Material</th>
                        <th>SKU</th>
                        <th>Lavagem</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($materials)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Nenhum material cadastrado no catálogo.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($materials as $m): ?>
                            <tr>
                                <td>
                                    <a href="?id=<?php echo $m['id']; ?>" class="fw-bold text-decoration-none">
                                        <?php echo htmlspecialchars($m['nome']); ?>
                                    </a>
                                </td>
                                <td><code class="fw-bold"><?php echo htmlspecialchars($m['sku']); ?></code></td>
                                <td>
                                    <span class="badge <?php echo $m['tipo_lavagem'] == 'A' ? 'bg-info' : 'bg-warning text-dark'; ?>">
                                        <?php echo $m['tipo_lavagem'] == 'A' ? 'Água' : 'Seco'; ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="?id=<?php echo $m['id']; ?>&edit=1" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja desativar este material?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Desativar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
