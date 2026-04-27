# Feature Specification: Receiving Label PDF Fix

**Feature Branch**: `012-receiving-label-pdf-fix`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "vamos agora focar no relatorio em pdf do recebimento de pedidos, ele nao esta funcionando, preciso que ele mostre informacoes que uma impressora de etiquetas vai utilizar e que possa ser mandada para ela imprimir."

## Clarifications

### Session 2026-04-26
- Q: QR Code Tracking Format → A: Option A (Standard: `PEDIDO-[ID]`, e.g., `PEDIDO-42`). Matches the existing logic in `OrderService::getByQRCode`.

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Printing a reliable receiving label (Priority: P1)

As an operator, after receiving a batch of materials, I want to print a physical label that I can attach to the shipment so that it can be identified throughout the process.

**Why this priority**: Physical identification is the backbone of the "Digital Traceability" principle. If labels don't print, the process breaks.

**Independent Test**: Create an order, click "Imprimir Etiqueta". The printer dialog should open with a layout precisely sized for a 100mm x 50mm (or similar standard) label.

**Acceptance Scenarios**:

1. **Given** a successfully registered order, **When** I click the print button, **Then** a high-contrast label view MUST be generated.
2. **Given** the label view, **When** viewed on screen or printed, **Then** the QR Code MUST be large enough to be easily scanned by operational tablets.
3. **Given** a label printer with specific margins, **When** the PDF is generated, **Then** it MUST respect a "Safe Zone" to prevent information from being cut off.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST generate a dedicated print view for orders at `pages/gerar_etiqueta.php`.
- **FR-002**: System MUST use a standard label dimension (e.g., 100mm x 50mm) as the primary layout target.
- **FR-003**: System MUST include the following fields on the label: Order ID (Large), Client Name, Material Type/Name, Quantity (with unit), and Date.
- **FR-004**: System MUST display a high-contrast QR Code representing the text `PEDIDO-[ID]`.
- **FR-005**: System MUST include "Observações" on the label only if they are not empty.
- **FR-006**: System MUST ensure the print layout is monochrome-friendly (no shades of gray or complex gradients).

### Non-Functional Requirements

- **NFR-001**: The layout MUST use `@page` CSS rules to define the size for the printer.
- **NFR-002**: The page MUST trigger the browser's print dialog automatically upon loading (optional but recommended for speed).
- **NFR-003**: The design MUST be optimized for low-resolution thermal label printers (e.g., 203 DPI).

### Key Entities

- **Pedido (Order)**: Primary data source.
- **QR Code**: Generated tracking identifier.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: QR codes printed on a thermal printer are scannable by a tablet 100% of the time.
- **SC-002**: 0% of information is cut off when printing on a standard 100mm width label.
- **SC-003**: Average time from "Finish Receiving" to "Label Printed" is under 5 seconds.

## Assumptions

- [Assumption]: The user is using a modern browser (Chrome/Edge/Firefox) that supports `@media print` and `@page` CSS rules.
- [Assumption]: The label printer is configured as the system's default or is manually selected.
- [Assumption]: Standard thermal label size is 100mm x 50mm.
