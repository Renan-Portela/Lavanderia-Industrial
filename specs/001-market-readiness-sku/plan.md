# Implementation Plan: Market Readiness & SKU Standardization

**Branch**: `001-market-readiness-sku-standardization` | **Date**: 2026-04-24 | **Spec**: [specs/001-market-readiness-sku/spec.md](specs/001-market-readiness-sku/spec.md)
**Input**: Feature specification from `/specs/001-market-readiness-sku/spec.md`

## Summary

Standardize laundry operations by introducing a Material Catalog with unique SKUs, implementing an authentication system for operational security, and establishing an automated testing suite for core business logic. This ensures data fidelity, process integrity, and market readiness.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, MySQLi, GD Extension, `chillerlan/php-qrcode` (Offline)
**Storage**: MySQL / MariaDB
**Testing**: PHPUnit
**Target Platform**: Web (Apache/Nginx or PHP built-in server)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive UI (<1s load), Instant QR Code generation
**Constraints**: Mobile-first design for laundry floor operations; No-framework PHP
**Scale/Scope**: Industrial laundry operations
**Authentication**: Simple session-based auth with `password_hash(PASSWORD_DEFAULT)` (bcrypt)
**SKU Logic**: Hierarchical alphanumeric pattern `[CAT]-[MAT]-[SIZ]`
**Architecture**: Service-oriented helpers in `src/` (managed by Composer)
**Migration**: Existing items mapped to a new "Legacy" SKU to preserve history.

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

- [x] **I. Digital Traceability**: Feature enhances tracking by standardizing materials via SKUs and offline QR generation.
- [x] **II. Process Integrity**: Standardized materials and status transition rules ensure consistent workflow data.
- [x] **III. Structured Simplicity**: Implementation uses structured PHP with PSR-4 autoloading for clarity.
- [x] **IV. Data Fidelity**: SKUs and Legacy migration strategy prevent data variation and improve reporting.
- [x] **V. Mobile-Responsive**: All new interfaces will use Bootstrap 5 and be optimized for mobile/tablet use.

## Project Structure

### Documentation (this feature)

```text
specs/001-market-readiness-sku/
├── plan.md              # This file
├── research.md          # Phase 0 output
├── data-model.md        # Phase 1 output
├── quickstart.md        # Phase 1 output
├── contracts/           # Phase 1 output
└── tasks.md             # Phase 2 output
```

### Source Code (repository root)

```text
assets/
├── css/                 # Stylesheets (style.css)
├── js/                  # JavaScript (main.js)
└── images/              # Media assets
config/
└── config.php           # Global settings
includes/
├── header.php           # Navbar and metadata
├── footer.php           # Scripts and closing tags
└── qrcode_helper.php    # QR logic
src/                     # NEW: Business logic classes (PSR-4)
├── Auth/
├── Material/
└── Order/
pages/
├── material_catalog.php # NEW: Material CRUD
├── login.php            # NEW: Authentication
└── [existing-pages].php # Updated with auth and SKU selection
qrcodes/                 # Generated QR images
conexao.php              # DB connection
index.php                # Dashboard
database.sql             # Schema updates (materials table, users table)
```

**Structure Decision**: Standard project layout maintained. New pages added to `pages/`, business logic moved to `src/` with Composer autoloading.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
