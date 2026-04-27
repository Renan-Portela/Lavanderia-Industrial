# Quickstart: Washing UI Refactor

## Verification Steps

### Test 1: Detailed Scan Results
1. Navigate to `pages/lavagem.php`.
2. Scan a QR code or enter a valid ID (e.g., `PEDIDO-1`).
3. Verify the info card appears on the right side.
4. Check that **Quantidade** shows the unit (e.g., `10,00 KG`).
5. Ensure **Observações** only appears if the order has them.

### Test 2: Table Columns & SKU Meaning
1. View the "Pedidos em Lavagem" table.
2. Verify the **Descrição** column shows the material name from the catalog (not a raw description).
3. Verify the **Quantidade** column shows the unit suffix (e.g., `50 und.`).

### Test 3: Responsiveness
1. Open the page on a mobile device or tablet.
2. Verify the info card stacks below the QR input.
3. Check that the table is scrollable or fits the screen.
