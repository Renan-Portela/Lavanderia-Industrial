# Implementation Plan: Expedition UI Refactor

**Branch**: `009-expedition-ui-refactor` | **Date**: 2026-04-26 | **Spec**: [specs/009-expedition-ui-refactor/spec.md](specs/009-expedition-ui-refactor/spec.md)
**Input**: Feature specification from `/specs/009-expedition-ui-refactor/spec.md`

## Summary

Refactor the Expedition page (`expedicao.php`) to implement a tabbed dashboard for sector management. This includes a detailed information card for scans and clickable table entries, mirroring the Washing UI enhancements. Operators will manage "Aguardando" and "Pronto para Entrega" workflows via Bootstrap tabs.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5 (Tabs, Grid), MySQLi
**Storage**: MySQL / MariaDB
**Testing**: Manual functional testing per quickstart.md
**Target Platform**: Web (Optimized for Tablets)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive UI (<1s load)
**Constraints**: Consistent UI with washing refactor

## Constitution Check

- [x] **I. Digital Traceability**: Enhances visibility of QR-tracked items in the final stage.
- [x] **II. Process Integrity**: Strictly follows the Lavagem → Expedição flow.
- [x] **III. Structured Simplicity**: Uses standard Bootstrap 5 tabs and clean SQL JOINs.
- [x] **IV. Data Fidelity**: Accurate unit and quantity display.
- [x] **V. Mobile-Responsive**: Tabbed interface optimized for floor tablets.

## Project Structure

### Documentation (this feature)

```text
specs/009-expedition-ui-refactor/
├── plan.md              # This file
├── research.md          # Design decisions
├── data-model.md        # UI State mapping
└── quickstart.md        # Verification steps
```

### Source Code (repository root)

```text
pages/
└── expedicao.php        # Main refactor target
```

**Structure Decision**: Mirror the logic of `lavagem.php` within `expedicao.php` for consistency, but with tabbed lists for sector specific visibility.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
