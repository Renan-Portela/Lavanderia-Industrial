# Quickstart: Enhanced Order Receiving

## Verification Steps

### Test 1: Searchable Categories
1. Go to `pages/recebimento.php`.
2. Click the Category input.
3. Type a few characters of a SKU or Name.
4. Verify the filtered list appears.

### Test 2: Unit Selection
1. Select a category.
2. Toggle between **UN** and **KG** buttons.
3. Enter "10.5" when **KG** is selected.
4. Save the order and verify the quantity is stored as `10.50 KG`.

### Test 3: Clipboard Copy
1. Locate an order in the dashboard table or success message.
2. Click the order code (e.g., #123).
3. Paste (`Ctrl+V`) into a text editor.
4. Verify "PEDIDO-123" is pasted.

### Test 4: Simplified Label
1. Create a new order.
2. Click the "Imprimir Etiqueta" button.
3. Verify the layout is minimal and prints clearly without dark backgrounds.
