# Tasks: Enhanced Order Receiving

**Input**: Design documents from `/specs/007-enhanced-order-receiving/`
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

- [x] T001 [P] Create backup of database schema (`database.sql`)
- [x] T002 [P] Backup current `pages/recebimento.php` for reference

## Phase 2: Foundational

- [x] T003 Update `database.sql` to change `pedidos.quantidade` to `DECIMAL(10,2)` and add `unidade` column
- [x] T004 Update `conexao.php` to include the schema update in `inicializarDB()`
- [x] T005 [P] Add CSS styles for radio button group and print layout in `assets/css/style.css`

## Phase 3: User Story 1 - Searchable Category Selection (Priority: P1)

### Story Goal
Enable operators to find material categories by typing SKU or Name using a searchable input.

### Independent Test Criteria
Type SKU snippet or partial Name in "Categoria" field; verify filtered suggestions appear correctly.

### Implementation

- [x] T006 [US1] Implement HTML5 `<datalist>` in `pages/recebimento.php` populated with Materials (SKU + Name)
- [x] T007 [US1] Refactor `pages/recebimento.php` to use the searchable category input instead of a standard select

## Phase 4: User Story 2 - Flexible Units of Measurement (Priority: P1)

### Story Goal
Support UN/KG selection via Radio Buttons with decimal precision for weight.

### Independent Test Criteria
Select "KG", enter "15.75", save; verify value and unit are stored correctly in DB.

### Implementation

- [x] T008 [US2] Add Radio Button group (UN/KG) to `pages/recebimento.php` form
- [x] T009 [US2] Update quantity input in `pages/recebimento.php` to support decimal step (`step="0.01"`)
- [x] T010 [US2] Update PHP processing logic in `pages/recebimento.php` to save the selected unit and decimal quantity
- [x] T011 [US2] Update `index.php` and `pages/relatorios.php` tables to display units alongside quantities (e.g., "10.00 KG")

## Phase 5: User Story 3 - Clipboard Quick Copy (Priority: P2)

### Story Goal
Allow one-click copying of order codes to the system clipboard.

### Independent Test Criteria
Click an order ID in any table; verify "PEDIDO-XXX" is copied and toast feedback appears.

### Implementation

- [x] T012 [P] [US3] Implement `copyToClipboard` JS helper in `assets/js/main.js` using the Clipboard API
- [x] T013 [US3] Add `onclick` triggers to order IDs in `index.php` and `pages/recebimento.php` (success view)

## Phase 6: User Story 4 - Simplified Printer PDF (Priority: P2)

### Story Goal
Provide a minimal, printer-friendly label layout for shipments.

### Independent Test Criteria
Click "Imprimir"; verify the generated view is clean, monochrome-friendly, and contains all relevant order details.

### Implementation

- [x] T014 [US4] Create `pages/gerar_etiqueta.php` with a minimal HTML structure for printing
- [x] T015 [US4] Apply `@media print` styles to `assets/css/style.css` to hide nav/footer and optimize label layout
- [x] T016 [US4] Update the "Imprimir" button in `pages/recebimento.php` to point to the new label page

## Phase 7: Polish & Validation

- [x] T017 [P] Remove the mandatory "Descrição do Material" requirement and ensure "Observações" is optional
- [x] T018 [P] Verify responsiveness of the refactored receiving form on tablets
- [x] T019 Run full test suite to ensure no regressions in order flow

## Dependencies
- US1 and US2 depend on Phase 2 (DB Schema).
- US4 depends on US2 (to show correct units on the label).

## Implementation Strategy
1. **Database First**: Run schema updates (T003, T004).
2. **Form Refactor**: Implement searchable input and radio buttons (T006-T010).
3. **Display Update**: Update all tables to show units (T011).
4. **Features**: Add clipboard (T012-T013) and print label (T014-T016).
