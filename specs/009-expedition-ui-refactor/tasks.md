# Tasks: Expedition UI Refactor

**Input**: Design documents from `/specs/009-expedition-ui-refactor/`
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

- [ ] T001 [P] Backup current `pages/expedicao.php` for safe refactoring

## Phase 2: Foundational

- [ ] T002 Ensure `MaterialService` is included in `pages/expedicao.php`
- [ ] T003 [P] Verify `copyToClipboard` and `bootstrap.Tooltip` initialization in `assets/js/main.js`

## Phase 3: User Story 1 - Detailed Expedition Scan Information (Priority: P1)

### Story Goal
Show detailed order info (Client, Material, Unit, Observations) with a "Copiar" button upon scanning.

### Independent Test Criteria
Scan an order in Expedition; verify a card appears showing all details and a working "Copiar" button.

### Implementation

- [ ] T004 [US1] Implement detailed order fetch logic (with material JOIN) in `pages/expedicao.php` for scan results
- [ ] T005 [US1] Create the side-by-side UI layout (`col-md-6`) for scan input and info card in `pages/expedicao.php`
- [ ] T006 [US1] Add the "Copiar" button to the info card header in `pages/expedicao.php`
- [ ] T007 [US1] Implement conditional display for "OBS" field in the info card in `pages/expedicao.php`

**Checkpoint**: User Story 1 functional and verified.

## Phase 4: User Story 2 - Clickable Table & Enhanced View (Priority: P1)

### Story Goal
Transform the page into a tabbed dashboard with clickable IDs and catalog descriptions.

### Independent Test Criteria
Click an ID in the "Aguardando" or "Pronto" tab; verify details load in the info card.

### Implementation

- [ ] T008 [US2] Implement Bootstrap 5 Nav-Tabs structure in `pages/expedicao.php`
- [ ] T009 [US2] Create "Aguardando" list logic (status = 'Lavagem') with material JOIN in `pages/expedicao.php`
- [ ] T010 [US2] Create "Pronto p/ Entrega" list logic (status = 'Expedido') with material JOIN in `pages/expedicao.php`
- [ ] T011 [US2] Make Order IDs in both tabs clickable (Link to `expedicao.php?id=X`) in `pages/expedicao.php`
- [ ] T012 [US2] Format quantity with unit suffix (kg/und.) in both tab tables in `pages/expedicao.php`
- [ ] T013 [US2] Implement `GET['id']` logic to load order details into the info card in `pages/expedicao.php`

**Checkpoint**: User Story 2 functional and verified.

## Phase 5: Polish & Cross-cutting Concerns

- [ ] T014 [P] Verify responsiveness of the tabbed interface and info card on mobile/tablet
- [ ] T015 [P] Run full test suite to ensure no regressions in status transitions (Lavagem -> Expedido)

## Dependencies
- US1 and US2 depend on foundational logic (Phase 2).
- US2 list queries depend on the database schema from feature 007.

## Implementation Strategy
- **Scan Parity**: First implement US1 to match the new Washing UI behavior.
- **Sector Dashboard**: Implement US2 to add the tabs and clickable lookup features.
