# Quickstart: Receiving Label PDF Fix

## Verification Steps

### Test 1: Dimensions and Sizing
1. Open `pages/recebimento.php` and create a test order.
2. Click "Imprimir Etiqueta".
3. In the Chrome/Edge print preview:
   - Check if **Paper Size** automatically selects "Custom" or matches the 100x50mm target.
   - Verify that no content is cut off at the edges.

### Test 2: Content Accuracy
1. Verify the ID matches the order (e.g., #123).
2. Ensure the Material Name from the catalog is displayed correctly.
3. Confirm the Quantity includes the unit (kg/und).

### Test 3: QR Code Contrast
1. Visually check that the QR code is sharp black/white with no blur or gray tints.
2. Attempt to scan the screen (or printout) with an industrial scanner/tablet.

### Test 4: Dynamic Observation Field
1. Print an order WITH observations -> Verify text appears.
2. Print an order WITHOUT observations -> Verify no empty space or "OBS:" label appears.
