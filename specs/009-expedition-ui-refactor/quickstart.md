# Quickstart: Expedition UI Refactor

## Verification Steps

### Test 1: Tabbed Navigation
1. Go to `pages/expedicao.php`.
2. Verify two tabs: "Aguardando" and "Pronto p/ Entrega".
3. Switch between tabs and ensure the correct orders are listed (based on status).

### Test 2: Scanned Information & Copy
1. Scan a QR code or enter a valid ID.
2. Verify the side-by-side card with full details (Client, Material Name, Units).
3. Click "Copiar" and verify "PEDIDO-XXX" is in the clipboard.

### Test 3: Click-to-View Detail
1. In either table tab, click an Order ID (e.g., #123).
2. Verify the page reloads and the Info Card displays that order's details.

### Test 4: Catalog Descriptions
1. Verify the "Descrição" column in both tables shows the full material name from the catalog (not legacy notes).
