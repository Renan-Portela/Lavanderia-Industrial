# Implementation Plan: Receiving Label PDF Fix

**Branch**: `main` | **Date**: 2026-04-26 | **Spec**: [specs/012-receiving-label-pdf-fix/spec.md](specs/012-receiving-label-pdf-fix/spec.md)
**Input**: Feature specification from `/specs/012-receiving-label-pdf-fix/spec.md`

## Summary

This feature fixes and optimizes the order receiving label (`gerar_etiqueta.php`) to be fully compatible with thermal label printers. It implements strict 100mm x 50mm CSS print rules, monochrome-only design for high-contrast QR codes, and automatic browser print triggering to minimize operational steps at the receiving gate.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: CSS Media Print, Bootstrap Icons (Monochrome), MySQLi
**Storage**: MySQL / MariaDB (Order & Material lookup)
**Testing**: Manual print preview verification (100x50mm target)
**Target Platform**: Web (Optimized for label printing)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Instant layout render (<200ms)
**Constraints**: Pure CSS/HTML printing (No heavy PDF libraries)

## Constitution Check

- [x] **I. Digital Traceability**: Essential fix to ensure physical labels match digital tracking.
- [x] **II. Process Integrity**: Occurs strictly at the "Recebimento" stage.
- [x] **III. Structured Simplicity**: Uses standard browser print capabilities instead of external PDF engines.
- [x] **IV. Data Fidelity**: Accurate fetching of material names and quantities.
- [x] **V. Mobile-Responsive**: Print layout scales correctly; UI trigger is touch-friendly.

## Project Structure

### Documentation (this feature)

```text
specs/012-receiving-label-pdf-fix/
├── plan.md              # This file
├── research.md          # Printer sizing decisions
├── data-model.md        # Print-time fields
└── quickstart.md        # Verification steps
```

### Source Code (repository root)

```text
pages/
└── gerar_etiqueta.php   # Main refactor target
```

**Structure Decision**: Keep all printing logic centralized in `gerar_etiqueta.php` to avoid bloating standard UI pages.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
