# Implementation Plan: Managerial Reports Refactor

**Branch**: `main` | **Date**: 2026-04-26 | **Spec**: [specs/011-managerial-reports-refactor/spec.md](specs/011-managerial-reports-refactor/spec.md)
**Input**: Feature specification from `/specs/011-managerial-reports-refactor/spec.md`

## Summary

Refactor the Reports page (`relatorios.php`) to unify the managerial aesthetic with the Dashboard, including identical header mini-stat cards and status colors. Implement a side-card interaction pattern for contextual data drill-down (ID click) and introduce dynamic KPI/OKR monitoring focused on volume, lead time, and month-over-month performance trends.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, MySQLi
**Storage**: MySQL / MariaDB (Existing `pedidos` table)
**Testing**: Manual functional testing per quickstart.md
**Target Platform**: Web (Optimized for Management Tablets/Desktop)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Responsive UI (<1.5s load for reports)
**Constraints**: Zero-JS framework constraint maintained (Structured PHP)

## Constitution Check

- [x] **I. Digital Traceability**: Feature displays auditable tracking data for management.
- [x] **II. Process Integrity**: Reports respect and display the correct operational flow.
- [x] **III. Structured Simplicity**: Uses clean SQL aggregates and standard Bootstrap components.
- [x] **IV. Data Fidelity**: Accurate calculation of KPIs (Lead Time, Volume).
- [x] **V. Mobile-Responsive**: Drill-down layout optimized for touch-based floor tablets.

## Project Structure

### Documentation (this feature)

```text
specs/011-managerial-reports-refactor/
├── plan.md              # This file
├── research.md          # KPI and aesthetic decisions
├── data-model.md        # Metric aggregation logic
├── quickstart.md        # Verification steps
└── tasks.md             # Implementation tasks
```

### Source Code (repository root)

```text
pages/
└── relatorios.php       # Main refactor target (Layout, SQL, interaction)
index.php                # UPDATE: Sync aesthetic (stat colors)
assets/css/
└── style.css            # UPDATE: Refine .mini-stat-card classes for consistency
```

**Structure Decision**: Refactor `relatorios.php` and `index.php` to share CSS patterns for the header, ensuring exact visual parity as requested.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
