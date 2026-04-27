# Research: Receiving Label PDF Fix

## Decision 1: Label Dimensions and CSS Print Rules
- **Decision**: Target 100mm x 50mm using CSS `@page { size: 100mm 50mm; margin: 0; }`.
- **Rationale**: This is a standard size for thermal label printers. Setting margins to zero in the CSS and controlling content padding via container elements provides maximum reliability across browser print engines.
- **Alternatives considered**: Fixed pixel widths (rejected due to inconsistent DPI handling across printers).

## Decision 2: QR Code Legibility
- **Decision**: Dedicate a clear 40mm square area for the QR Code on the right side of the label. Use high-contrast black/white without borders.
- **Rationale**: Guarantees fast scanning on industrial floor tablets under various lighting conditions.
- **Implementation**: Fetch the pre-generated QR code image path via `obterCaminhoQRCode`.

## Decision 3: Automatic Print Trigger
- **Decision**: Add `window.onload = function() { window.print(); }` to the label page.
- **Rationale**: Minimizes operational friction. The operator clicks "Print" in the app, and the browser dialog opens immediately.
- **Implementation**: Include a fallback "Print" button for manual re-triggering.

## Decision 4: Monochrome-First Design
- **Decision**: Avoid all Bootstrap colors, shadows, and gradients. Use standard black text on white background with simple 1pt borders where needed.
- **Rationale**: Thermal printers are binary (on/off). Grayscales or colors results in "dithering" which makes QR codes and small text unreadable.
