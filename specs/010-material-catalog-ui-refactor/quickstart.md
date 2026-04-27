# Quickstart: Material Catalog UI Refactor

## Verification Steps

### Test 1: Search and Select
1. Navigate to \`pages/materiais.php\`.
2. Type a partial SKU (e.g., "GLV") in the search field.
3. Select an item from the datalist.
4. Verify the Detail Card appears with the correct information.

### Test 2: In-Card Editing
1. Select a material to open the Detail Card.
2. Click the "Editar" button.
3. Change the Wash Type using the Radio Buttons (Água/Seco).
4. Save and verify the update reflects in the card and the inventory table.

### Test 3: "Add New" Workflow
1. Click the "Novo Material" button.
2. Verify the registration form appears (and search/detail card might be hidden or moved).
3. Fill in details and save.

### Test 4: Clipboard Integration
1. Open a material's Detail Card.
2. Click "Copiar SKU".
3. Verify the SKU is in the clipboard.

### Test 5: Table Interactivity
1. Click a material name in the "Itens Cadastrados" table.
2. Verify the Detail Card opens for that specific material.
