# Implementation Plan: Standardize SKU and Enum Patterns

**Branch**: `003-standardize-sku-enum` | **Date**: 2026-04-25 | **Spec**: [specs/003-standardize-sku-enum/spec.md](specs/003-standardize-sku-enum/spec.md)
**Input**: Fix inconsistencies in SKU patterns and ENUM values across 001-market-readiness-sku docs.

## Summary
Standardize the SKU pattern to `[CAT]-[MAT]-[SIZ]-[WASH]` and the `tipo_lavagem` ENUM to `'A'` (Agua) and `'S'` (Seco) across all technical artifacts. This alignment ensures data fidelity and prevents implementation ambiguity between documentation and database schema.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, MySQLi, GD Extension (QR Server API default)
**Storage**: MySQL / MariaDB
**Testing**: Manual functional testing or as specified in tasks
**Target Platform**: Web (Apache/Nginx or PHP built-in server)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive UI (<1s load), Instant QR Code generation
**Constraints**: Mobile-first design for laundry floor operations
**Scale/Scope**: Industrial laundry operations

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

- [x] **I. Digital Traceability**: Standardizing the SKU pattern `[CAT]-[MAT]-[SIZ]-[WASH]` enhances traceability by explicitly including the washing method.
- [x] **II. Process Integrity**: Standardized data patterns ensure the Recebimento → Lavagem → Expedição flow starts with unambiguous data.
- [x] **III. Structured Simplicity**: The standardization is documented using standard technical artifacts without adding library overhead.
- [x] **IV. Data Fidelity**: ENUM standardization ('A'/'S') and Foreign Key alignment improve database consistency.
- [x] **V. Mobile-Responsive**: No UI changes requested, but all standardized pages will maintain Bootstrap 5 responsive design.

## Project Structure

### Documentation (this feature)

```text
specs/003-standardize-sku-enum/
├── plan.md              # This file
├── research.md          # SKU pattern and ENUM research
├── data-model.md        # Unified data model
├── quickstart.md        # Migration and update steps
└── tasks.md             # Implementation task list (generated via /speckit.tasks)
```

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
