# Tasks: Managerial Reports Refactor

**Input**: Design documents from `/specs/011-managerial-reports-refactor/`
**Prerequisites**: plan.md (required), spec.md (required)

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Parallelizable
- **[Story]**: US1, US2, etc.
- Include exact file paths in `pages/`, `includes/`, etc.

## Path Conventions (LuvaSul)

- **Pages**: `pages/*.php`
- **Common Logic**: `includes/*.php`
- **Assets**: `assets/css/style.css`, `assets/js/main.js`
- **Database**: `database.sql`

## Phase 1: Setup

- [ ] T001 [P] Backup current `pages/relatorios.php` and `index.php` for safe refactoring

## Phase 2: Foundational

- [ ] T002 [P] Unify `.mini-stat-card` and header layout CSS in `assets/css/style.css` for both Dashboard and Reports
- [ ] T003 [P] Standardize status color classes in `assets/css/style.css` (Success for 'Expedido'/'Concluído')

## Phase 3: User Story 1 - Unified Managerial Aesthetic (Priority: P1)

### Story Goal
Ensure Reports and Dashboard share the same visual header and status styling.

### Independent Test Criteria
Compare header stats and status badges on both pages; verify they use identical components and colors.

### Implementation

- [ ] T004 [US1] Refactor `index.php` header stats to use the standardized `.mini-stat-card` component
- [ ] T005 [US1] Update `index.php` to use the 'Success' color (green) for 'Expedido' count
- [ ] T006 [US1] Refactor `pages/relatorios.php` header to use the same mini-stat card structure as the Dashboard

**Checkpoint**: Aesthetic parity achieved.

## Phase 4: User Story 3 - KPI & OKR Focus (Priority: P2)

### Story Goal
Display managerial metrics (Volume, Lead Time, Backlog) with month-over-month comparison.

### Independent Test Criteria
Verify header cards in Reports show Volume Processado, Lead Time Médio, and Backlog with trend percentages.

### Implementation

- [ ] T007 [US3] Implement SQL logic in `pages/relatorios.php` to calculate Processed Volume and Backlog
- [ ] T008 [US3] Implement SQL logic in `pages/relatorios.php` to calculate Lead Time (Average hours for Expedido)
- [ ] T009 [US3] Implement secondary SQL query in `pages/relatorios.php` for previous month's metrics (OKR comparison)
- [ ] T010 [US3] Update header cards in `pages/relatorios.php` to display dynamic KPI values and trend percentages

**Checkpoint**: Managerial metrics functional.

## Phase 5: User Story 2 - Contextual Detail Flow (Priority: P1)

### Story Goal
Add side-card detail view triggered by clicking order/client in the reports table.

### Independent Test Criteria
Click an ID in the reports table; verify the side-card appears with full details.

### Implementation

- [ ] T011 [US2] Create the side-by-side UI layout (`col-md-6/col-md-6`) in `pages/relatorios.php`
- [ ] T012 [US2] Implement `GET['id']` logic in `pages/relatorios.php` to fetch and display the Detailed Info Card
- [ ] T013 [US2] Update reports table to make Order IDs and Clients clickable (Link to `relatorios.php?id=X`)
- [ ] T014 [US2] Ensure "Copiar" button is available in the detailed card in `pages/relatorios.php`

**Checkpoint**: Contextual drill-down verified.

## Phase 6: Polish & Cross-cutting Concerns

- [ ] T015 [P] Verify responsiveness of the dual-column layout on tablets and mobile devices
- [ ] T016 [P] Run full functional test suite to ensure no regressions in report filtering or CSV export

## Dependencies
- All implementation tasks depend on foundational CSS (Phase 2).
- US2 side-card relies on the logic established in US1 for header parity.

## Implementation Strategy
- **Aesthetic Sync First**: Complete Phase 3 to establish the common UI base.
- **KPI Engine**: Complete Phase 4 to populate the new header stats.
- **Interactivity**: Complete Phase 5 to add the drill-down capability.
