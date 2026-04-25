# Implementation Plan: Market Readiness & SKU Standardization

**Branch**: `001-market-readiness-sku-standardization` | **Date**: 2026-04-25 | **Spec**: [specs/001-market-readiness-sku/spec.md](specs/001-market-readiness-sku/spec.md)
**Input**: Feature specification for SKU standardization and market readiness.

## Summary
Implement a standardized material catalog with unique SKUs following the `[CAT]-[MAT]-[SIZ]-[WASH]` pattern. This includes architectural refactoring for authentication, automated testing, and local QR code generation. The plan specifically addresses professional PPE (EPI) requirements, distinguishing between dry cleaning (leather/raspa) and water washing (industrial PPE/cloths).

## Technical Context
- **Language/Version**: PHP 7.4+
- **Primary Dependencies**: Bootstrap 5, MySQLi, `chillerlan/php-qrcode` (local QR generation)
- **Storage**: MySQL / MariaDB
- **Testing**: PHPUnit for core business logic (QR generation, status flow, material validation)
- **Target Platform**: Web (Mobile-responsive for laundry floor)
- **Project Type**: Structured PHP Web Application
- **Performance Goals**: Responsive UI, Offline-capable QR generation
- **Constraints**: Mobile-first design; STRICT process flow (Recebimento → Lavagem → Expedição)
- **Scale/Scope**: Industrial laundry; Standardized SKU catalog for PPE (EPI) and industrial cloths.

## Constitution Check
- [x] **I. Digital Traceability**: Feature focuses on SKU standardization which is the foundation of traceability.
- [x] **II. Process Integrity**: SKU-based receiving ensures the workflow starts with correct data.
- [x] **III. Structured Simplicity**: No new frameworks proposed; using PHP + Bootstrap 5.
- [x] **IV. Data Fidelity**: SKU catalog prevents free-text errors, improving reporting accuracy.
- [x] **V. Mobile-Responsive**: UI requirements for receiving/catalog will use Bootstrap 5.

## Project Structure

### Documentation (this feature)
```text
specs/001-market-readiness-sku/
├── plan.md              # This file
├── research.md          # Industrial washing standards and SKU strategy
├── data-model.md        # Entities: Material, Pedido, Usuario
├── quickstart.md        # Setup instructions and seed data
└── tasks.md             # Implementation task list
```

### Source Code (repository root)
```text
assets/
├── css/style.css        # Responsive styles
├── js/main.js           # Client-side validation
config/
└── config.php           # Global settings
includes/
├── header.php           # Auth-aware navbar
├── qrcode_helper.php    # Local QR logic using chillerlan/php-qrcode
pages/
├── materiais.php        # Material CRUD
├── recebimento.php      # Updated SKU-based entry
├── login.php            # Security entry point
database.sql             # Migrations for materials/users tables
```

## Phases

### Phase 0: Research (Complete)
- Standards for leather/raspa dry cleaning vs industrial water washing.
- SKU naming strategy: `[CAT]-[MAT]-[SIZ]-[WASH]`.
- Placement of "Washing Method" as a Material property.

### Phase 1: Design (Complete)
- Data model for standardized materials.
- Authentication requirements.
- Quickstart guide for deployment.

### Phase 2: Implementation Planning (Next)
- Generate tasks for database migration.
- Generate tasks for catalog CRUD and auth implementation.
- Generate tasks for QR code refactoring and automated tests.

## Complexity Tracking
| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
