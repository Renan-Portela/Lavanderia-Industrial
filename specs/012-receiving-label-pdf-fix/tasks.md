# Tasks: Receiving Label PDF Fix

**Input**: Design documents from `/specs/012-receiving-label-pdf-fix/`
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

- [x] T001 [P] Backup current `pages/gerar_etiqueta.php` for safe refactoring

## Phase 2: Foundational

- [x] T002 [P] Define label container and typography styles in `pages/gerar_etiqueta.php` using high-contrast black/white

## Phase 3: User Story 1 - Printing a reliable receiving label (Priority: P1)

### Story Goal
Generate a high-contrast, precisely sized label for thermal printers.

### Independent Test Criteria
Open `gerar_etiqueta.php?id=X`; verify the layout fits a 100x50mm area and the print dialog triggers automatically.

### Implementation

- [x] T003 [US1] Implement CSS `@page` rule for 100mm x 50mm dimensions in `pages/gerar_etiqueta.php`
- [x] T004 [US1] Refactor `pages/gerar_etiqueta.php` to use a side-by-side layout for details (left) and QR code (right)
- [x] T005 [US1] Update data fetching in `pages/gerar_etiqueta.php` to JOIN with `materiais` for catalog names
- [x] T006 [US1] Implement automatic browser print trigger using `window.onload` in `pages/gerar_etiqueta.php`
- [x] T007 [US1] Add a secondary "Imprimir" button for manual re-triggering, hidden during print, in `pages/gerar_etiqueta.php`
- [x] T008 [US1] Ensure "Observações" are only rendered if the field is not empty in `pages/gerar_etiqueta.php`
- [x] T009 [US1] Format quantity and units (e.g., "15,50 kg") according to catalog standards in `pages/gerar_etiqueta.php`

**Checkpoint**: Label generation functional and verified.

## Phase 4: Polish & Validation

- [x] T010 [P] Verify QR code scannability from a 100mm printout using a tablet device
- [x] T011 [P] Verify that all navigational elements (navbar, footer) are hidden in the print view

## Dependencies
- All implementation tasks depend on Phase 2 (Foundational Styles).

## Implementation Strategy
- **Isolation**: Focus all changes within `pages/gerar_etiqueta.php` to ensure the operational flow is not disturbed.
- **Hardware Parity**: Test primarily against the 100x50mm dimension constraint in browser print previews.
