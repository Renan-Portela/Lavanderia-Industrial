# Tasks: Market Readiness & SKU Standardization

**Feature**: Market Readiness & SKU Standardization  
**Priority**: P1  
**Status**: Ready for Implementation  
**Spec**: [specs/001-market-readiness-sku/spec.md](specs/001-market-readiness-sku/spec.md)

## Summary
Implement a standardized material catalog with unique SKUs following the `[CAT]-[MAT]-[SIZ]-[WASH]` pattern, secure role-based authentication (Admin/Operador), and automated testing. This phase focuses on operational reliability, data fidelity, and mobile-responsiveness for the laundry floor.

## Phase 1: Setup
Initialize the project infrastructure and testing harness.

- [x] T001 Initialize database migrations for new schema in `database.sql`
- [x] T002 Configure PHPUnit bootstrap and environment in `tests/bootstrap.php`
- [x] T003 [P] Add Bootstrap 5 and responsive base styles in `assets/css/style.css`
- [x] T004 [P] Initialize base JavaScript for client-side validation in `assets/js/main.js`

## Phase 2: Foundational
Blocking prerequisites for all user stories.

- [x] T005 [P] Create `materiais` table with SKU and `tipo_lavagem` fields in `database.sql`
- [x] T006 [P] Create `usuarios` table with `password_hash` and `perfil` fields in `database.sql`
- [x] T007 Implement database connection helper with MySQLi prepared statements in `conexao.php`
- [x] T008 Implement secure session and authentication helper in `includes/auth_helper.php`

## Phase 3: [US3] Secure Operational Access (P2)
Requirement: Authentication with role-based access to operational pages.

- [x] T009 [US3] Create dedicated login page with profile-aware redirection in `pages/login.php`
- [x] T010 [P] [US3] Update global header with auth checks and navigation guards in `includes/header.php`
- [x] T011 [US3] Implement redirection logic for unauthenticated users in all internal pages
- [x] T012 [US3] Create automated tests for login and role-based access in `tests/AuthTest.php`

## Phase 4: [US1] Material Standardization (P1)
Requirement: Standardized catalog with hierarchical SKUs and soft delete.

- [x] T013 [US1] Create Material service layer for CRUD and soft-delete logic in `includes/material_service.php`
- [x] T014 [US1] Create Material catalog management page (Admin only) in `pages/materiais.php`
- [x] T015 [P] [US1] Implement SKU pattern helper for `[CAT]-[MAT]-[SIZ]-[WASH]` in `includes/sku_helper.php`
- [x] T016 [US1] Update Receiving form to replace free-text with catalog selection in `pages/recebimento.php`
- [x] T017 [US1] Create automated tests for Material CRUD and SKU validation in `tests/MaterialTest.php`

## Phase 5: [US2] Automated Quality Guard (P1)
Requirement: Automated tests for QR generation and status flow.

- [x] T018 [US2] Refactor QR generation to use local `chillerlan/php-qrcode` library in `includes/qrcode_helper.php`
- [x] T019 [US2] Implement strict order status transition logic (Recebimento → Lavagem → Expedição) in `includes/order_service.php`
- [x] T020 [US2] Update Lavagem and Expedição operational pages to use new order logic in `pages/lavagem.php` and `pages/expedicao.php`
- [x] T021 [US2] Create automated tests for QR generation and status flow in `tests/OrderTest.php`

## Final Phase: Polish & Cross-Cutting
Cleanup and mobile optimization.

- [x] T022 Migrate existing legacy material data to standardized "Legacy" SKUs in `database.sql`
- [x] T023 [P] Optimize operational interfaces for touch interactions in `assets/css/style.css`
- [x] T024 Perform final end-to-end verification of the full laundry workflow

## Dependencies
1. Phase 1 must be completed before any testing tasks.
2. Phase 2 must be completed before any operational logic.
3. [US1] depends on Phase 2 database schema.
4. [US2] depends on [US1] standardized material mapping.

## Parallel Execution Examples
- [US3] T009 (Login UI) and [US1] T013 (Material Logic)
- [P] T003 (CSS) and [P] T004 (JS)
- [US2] T018 (QR Library) and [US1] T015 (SKU Helper)

## Implementation Strategy
- **MVP first**: Focus on Phase 1-4 to establish the secure, standardized receiving core.
- **Data Integrity**: Migration (T022) must be tested against a database snapshot before production.
- **Mobile First**: All operational screens (Recebimento, Lavagem, Expedição) must be verified on a mobile viewport.
