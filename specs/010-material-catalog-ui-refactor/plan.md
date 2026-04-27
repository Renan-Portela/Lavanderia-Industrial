# Implementation Plan: Material Catalog UI Refactor

**Branch**: `main` | **Date**: 2026-04-26 | **Spec**: [specs/010-material-catalog-ui-refactor/spec.md](specs/010-material-catalog-ui-refactor/spec.md)
**Input**: Feature specification from `/specs/010-material-catalog-ui-refactor/spec.md`

## Summary

Refactor the Materials Catalog page (`materiais.php`) to implement a searchable lookup interface and a detailed information card with local editing capabilities. This refactor aligns the administrative UI with the recently enhanced operational interfaces (Receiving, Washing, Expedition), focusing on "Structured Simplicity" and visual consistency.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5 (Grid, Radio Buttons), HTML5 Datalist, MySQLi
**Storage**: MySQL / MariaDB (Existing `materiais` table)
**Testing**: Manual functional testing per quickstart.md
**Target Platform**: Web (Optimized for Desktop/Tablet Admin)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive search and layout toggling (<200ms)
**Constraints**: Consistency with operational refactors (US1-007, US1-008)

## Constitution Check

- [x] **I. Digital Traceability**: Feature maintains integrity of SKUs used for tracking.
- [x] **II. Process Integrity**: Catalog management remains restricted to administrators.
- [x] **III. Structured Simplicity**: Uses native HTML5 datalists and standard CSS layouts.
- [x] **IV. Data Fidelity**: Accurate display and editing of catalog attributes.
- [x] **V. Mobile-Responsive**: UI optimized for floor tablets and mobile using Bootstrap columns.

## Project Structure

### Documentation (this feature)

```text
specs/010-material-catalog-ui-refactor/
├── plan.md              # This file
├── research.md          # Design and parity decisions
├── data-model.md        # UI State mapping
└── quickstart.md        # Verification steps
```

### Source Code (repository root)

```text
pages/
└── materiais.php        # Main refactor target
```

**Structure Decision**: Maintain `materiais.php` as the single management hub. Focus on logic and layout improvements within this file.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
