# Tasks: Washing UI Refactor

**Input**: Design documents from `/specs/008-washing-ui-refactor/`
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

- [ ] T001 [P] Backup current `pages/lavagem.php` for safe refactoring

## Phase 2: Foundational

- [ ] T002 Update `pages/lavagem.php` to include `includes/material_service.php` early in the process
- [ ] T003 [P] Ensure CSS classes for the side-by-side layout and formatted units are defined in `assets/css/style.css`

## Phase 3: User Story 1 - Detailed Scan Information (Priority: P1)

### Story Goal
Show detailed order info (Client, Material, Unit, Observations) side-by-side with the scan input.

### Independent Test Criteria
Scan an order; verify a card appears showing "15.00 kg" (if kg) and observations only if they exist.

### Implementation

- [ ] T004 [US1] Refactor `pages/lavagem.php` scan result logic to fetch material name via JOIN or `MaterialService`
- [ ] T005 [US1] Update `pages/lavagem.php` UI to use a 2-column layout (`col-md-6`) for the scan form and info card
- [ ] T006 [US1] Implement conditional display for the "Observações" field in the info card in `pages/lavagem.php`
- [ ] T007 [US1] Format quantity with unit suffix (kg/und.) in the info card in `pages/lavagem.php`

**Checkpoint**: User Story 1 functional and verified.

## Phase 4: User Story 2 - Clear Operational Table (Priority: P1)

### Story Goal
Update the washing table to show catalog descriptions and formatted quantities.

### Independent Test Criteria
View table; verify "Descrição" column shows catalog material name and "Quantidade" shows "10 und." or "100 kg".

### Implementation

- [ ] T008 [US2] Update SQL query in `pages/lavagem.php` to JOIN `pedidos` with `materiais` for catalog names
- [ ] T009 [US2] Rename table column "SKU Categoria" to "SKU" and "Descrição" to "Significado SKU" (or similar) in `pages/lavagem.php`
- [ ] T010 [US2] Update table body in `pages/lavagem.php` to display `material_nome` in the description column
- [ ] T011 [US2] Format quantity with unit suffix in the table rows in `pages/lavagem.php`

**Checkpoint**: User Story 2 functional and verified.

## Phase 5: Polish & Cross-cutting Concerns

- [ ] T012 [P] Verify responsive stacking of the info card on mobile devices in `pages/lavagem.php`
- [ ] T013 [P] Run full functional test suite to ensure no regressions in order status transitions

## Dependencies
- US1 and US2 depend on foundational logic (Phase 2).
- US2 depends on the database schema from feature 007 (already in main).

## Implementation Strategy
- **Scan Card First**: Complete US1 to provide immediate value for operators during scanning.
- **Table Cleanup**: Apply US2 changes to standardize the view for all items in process.
