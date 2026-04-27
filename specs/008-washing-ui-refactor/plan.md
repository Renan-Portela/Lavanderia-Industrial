# Implementation Plan: Washing UI Refactor

**Branch**: `main` | **Date**: 2026-04-26 | **Spec**: [specs/008-washing-ui-refactor/spec.md](specs/008-washing-ui-refactor/spec.md)
**Input**: Feature specification from `/specs/008-washing-ui-refactor/spec.md`

## Summary

This feature refactors the Washing operational page (`lavagem.php`) to improve scan visibility and table clarity. Key changes include a detailed information card appearing upon scanning (showing client, material, units, and observations) and a reorganized table that displays the catalog description (SKU meaning) and quantities with units (kg/und.).

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, MySQLi
**Storage**: MySQL / MariaDB
**Testing**: Manual functional testing per quickstart.md
**Target Platform**: Web (Optimized for Industrial Tablets)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive UI (<1s load)
**Constraints**: Mobile-first design (Bootstrap 5)

## Constitution Check

- [x] **I. Digital Traceability**: Maintains end-to-end QR tracking.
- [x] **II. Process Integrity**: Strictly follows the Recebimento → Lavagem flow.
- [x] **III. Structured Simplicity**: Implemented using clean SQL JOINs and PHP conditionals.
- [x] **IV. Data Fidelity**: Accurate logging of quantities and units.
- [x] **V. Mobile-Responsive**: UI optimized for tablets using Bootstrap columns.

## Project Structure

### Documentation (this feature)

```text
specs/008-washing-ui-refactor/
├── plan.md              # This file
├── research.md          # Layout and query decisions
├── data-model.md        # UI Entity mapping
└── quickstart.md        # Verification steps
```

### Source Code (repository root)

```text
pages/
└── lavagem.php          # Main refactor target (SQL & HTML)
assets/
└── css/
    └── style.css        # Maintenance of existing operational styles
```

**Structure Decision**: Standard project layout maintained. Focus is on logic and layout within `lavagem.php`.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
