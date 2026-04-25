# Implementation Plan: SKU & Material Tracking with QR Code

**Branch**: `002-sku-material-tracking` | **Date**: 2026-04-25 | **Spec**: [specs/002-sku-material-tracking/spec.md](spec.md)
**Input**: Feature specification for hybrid SKU selection and free-text material description.

## Summary
Implement a hybrid entry system for receiving orders. Operators will select a standardized SKU from the catalog (ensuring category/size/wash pattern consistency) and provide a specific descriptive name for the item (e.g., "Luva Nitrílica Verde"). Digital traceability via QR Code is maintained for the entire workflow.

## Technical Context
- **Language/Version**: PHP 8.4+
- **Primary Dependencies**: Bootstrap 5, MySQLi, `chillerlan/php-qrcode` (local QR generation)
- **Storage**: MySQL / MariaDB
- **Testing**: PHPUnit for business logic (Order/Material consistency)
- **Target Platform**: Web (Mobile-responsive for laundry floor)
- **Project Type**: Structured PHP Web Application
- **Performance Goals**: Responsive UI, Offline-capable QR generation
- **Constraints**: Mobile-first design; STRICT process flow (Recebimento → Lavagem → Expedição)
- **Scale/Scope**: Industrial laundry; Hybrid SKU/Text catalog.

## Constitution Check
- [x] **I. Digital Traceability**: Maintains current QR code tracking per order.
- [x] **II. Process Integrity**: Updates operational pages (Lavagem/Expedicao) to respect the hybrid data model.
- [x] **III. Structured Simplicity**: Uses existing `MaterialService` and standard PHP patterns.
- [x] **IV. Data Fidelity**: Enforces mandatory SKU selection + specific description for accurate auditing.
- [x] **V. Mobile-Responsive**: UI refinements for the hybrid form using Bootstrap 5.

## Project Structure

### Documentation (this feature)
```text
specs/002-sku-material-tracking/
├── plan.md              # This file
├── research.md          # Hybrid entry strategy and data mapping
├── data-model.md        # Pedido table re-purposing (tipo_material as text field)
├── quickstart.md        # Setup instructions for hybrid tracking
└── tasks.md             # Implementation tasks
```

### Source Code (affected)
```text
includes/
├── material_service.php # Read catalog
└── order_service.php    # Handle hybrid data validation
pages/
├── recebimento.php      # Form update (Select + Text)
├── lavagem.php          # UI update (Display SKU + Name)
└── expedicao.php        # UI update (Display SKU + Name)
```

## Phases

### Phase 0: Research (Complete)
- Mapping `tipo_material` as the descriptive text field.
- Validation logic for hybrid mandatory fields.

### Phase 1: Design (Complete)
- Data model for hybrid Pedido.
- UI layout for mobile-friendly dual input.

### Phase 2: Implementation Planning (Next)
- Generate tasks for updating the receiving form.
- Generate tasks for operational UI data display.
- Generate tasks for verification tests.

## Complexity Tracking
| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
