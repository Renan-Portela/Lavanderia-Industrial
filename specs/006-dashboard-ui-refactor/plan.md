# Implementation Plan: Dashboard UI Refactor

**Branch**: `main` | **Date**: 2026-04-26 | **Spec**: [specs/006-dashboard-ui-refactor/spec.md](specs/006-dashboard-ui-refactor/spec.md)
**Input**: Feature specification from `/specs/006-dashboard-ui-refactor/spec.md`

## Summary

This feature refactors the `index.php` dashboard to optimize space and improve usability. Key changes include moving status counters to the header row, arranging quick actions horizontally, and expanding the recent orders table with visual progress tracking.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, MySQLi
**Storage**: MySQL / MariaDB
**Testing**: Manual functional testing (Header alignment, horizontal flow, progress display)
**Target Platform**: Web (Optimized for Industrial Tablets)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive UI (<1s load)
**Constraints**: Mobile-responsive design (Bootstrap 5)

## Constitution Check

- [x] **I. Digital Traceability**: Feature does not affect QR code logic.
- [x] **II. Process Integrity**: Dashboard accurately reflects the Recebimento → Lavagem → Expedição flow.
- [x] **III. Structured Simplicity**: Implemented using clean HTML/PHP in `index.php` and CSS in `style.css`.
- [x] **IV. Data Fidelity**: Real-time counters and recent orders list are preserved.
- [x] **V. Mobile-Responsive**: UI optimized for mobile and tablets using Bootstrap 5.

## Project Structure

### Documentation (this feature)

```text
specs/006-dashboard-ui-refactor/
├── plan.md              # This file
├── research.md          # Layout decisions
├── data-model.md        # UI State logic
├── quickstart.md        # Verification steps
└── tasks.md             # Implementation tasks
```

### Source Code (repository root)

```text
index.php                # Main refactor target
assets/
└── css/
    └── style.css        # Dashboard specific styling updates
```

**Structure Decision**: No new files needed. Modifications centered on `index.php` and `assets/css/style.css`.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
