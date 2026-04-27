# Tasks: Material Catalog UI Refactor

**Input**: Design documents from `/specs/010-material-catalog-ui-refactor/`
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

- [x] T001 [P] Backup current `pages/materiais.php` for safe refactoring

## Phase 2: Foundational

- [x] T002 Ensure `MaterialService` is fully utilized for state management in `pages/materiais.php`
- [x] T003 [P] Verify `copyToClipboard` JS helper availability in `assets/js/main.js`

## Phase 3: User Story 1 - Searchable Material Lookup (Priority: P1)

### Story Goal
Implement a searchable input for materials (SKU or Name) similar to the order receiving interface.

### Independent Test Criteria
Type SKU or Name in search; verify suggestions appear and selection loads the material details.

### Implementation

- [x] T004 [US1] Implement HTML5 `<datalist>` in `pages/materiais.php` populated with materials (SKU + Name)
- [x] T005 [US1] Create the searchable input field in `pages/materiais.php` using the datalist
- [x] T006 [US1] Add PHP logic in `pages/materiais.php` to fetch material details based on the search input or a `GET['id']` parameter

**Checkpoint**: Searchable lookup functional.

## Phase 4: User Story 2 - Side-by-Side Detailed View & Edit (Priority: P1)

### Story Goal
Display a detailed info card with local editing and wash type radio buttons.

### Independent Test Criteria
Select material; verify side-by-side card appears. Click "Editar"; verify radio buttons (Água/Seco) and save functionality.

### Implementation

- [x] T007 [US2] Create the side-by-side UI layout (`col-md-6`) for search/add and detail card in `pages/materiais.php`
- [x] T008 [US2] Implement the Detailed Info Card in `pages/materiais.php` with "View Mode" showing all attributes
- [x] T009 [US2] Add the "Copiar SKU" button with `copyToClipboard` trigger in `pages/materiais.php`
- [x] T010 [US2] Implement the "Edit Mode" toggle and form within the detail card in `pages/materiais.php`
- [x] T011 [US2] Use Bootstrap 5 Radio Button groups for "Tipo de Lavagem" (Água/Seco) in both create and edit forms

**Checkpoint**: Detail card and local editing verified.

## Phase 5: User Story 3 - Interactive Inventory Table (Priority: P2)

### Story Goal
Make inventory table items clickable to load details into the card.

### Independent Test Criteria
Click an item in the inventory table; verify the page reloads (or updates) showing that item's details in the card.

### Implementation

- [x] T012 [US3] Wrap Material Name or SKU in the inventory table with links to `materiais.php?id=X`
- [x] T013 [US3] Implement the "Add New Material" button to toggle visibility of the creation form, hiding it by default

**Checkpoint**: Table interactivity and on-demand creation form functional.

## Phase 6: Polish & Cross-cutting Concerns

- [x] T014 [P] Verify responsiveness of the refactored layout on mobile/tablet devices
- [x] T015 [P] Run full functional test suite to ensure no regressions in Material CRUD operations
