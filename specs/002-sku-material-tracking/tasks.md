# Tasks: SKU & Material Tracking with QR Code

**Feature**: SKU & Material Tracking with QR Code
**Priority**: P1
**Status**: Ready for Implementation
**Spec**: [specs/002-sku-material-tracking/spec.md](spec.md)

## Summary
Implement a hybrid tracking system that combines standardized SKU categorization with specific item descriptions. Operators will select a SKU from the catalog and provide a descriptive name for the item. This ensures digital traceability while capturing granular operational data.

## Phase 1: Setup
Initialization of the feature context and testing harness.

- [ ] T001 Initialize PHPUnit test case for hybrid tracking in `tests/HybridTrackingTest.php`

## Phase 2: Foundational
Blocking prerequisites for core user stories.

- [ ] T002 Update `includes/order_service.php` with data validation for hybrid fields (SKU + Name)

## Phase 3: [US1] Hybrid Material Entry (P1)
Requirement: Select SKU from catalog and provide a free-text descriptive name.

- [ ] T003 [P] [US1] Add "Descrição do Material" text input to receiving form in `pages/recebimento.php`
- [ ] T004 [US1] Update POST processing in `pages/recebimento.php` to save user-provided description into `tipo_material`
- [ ] T005 [US1] Implement automated test for hybrid order persistence in `tests/HybridTrackingTest.php`

## Phase 4: [US2] Continuity of QR Tracking (P1)
Requirement: Maintain QR workflow while displaying enriched hybrid data.

- [ ] T006 [P] [US2] Update operational detail view in `pages/lavagem.php` to display SKU and Description
- [ ] T007 [P] [US2] Update operational detail view in `pages/expedicao.php` to display SKU and Description
- [ ] T008 [US2] Verify QR scanning correctly identifies and displays hybrid data on the laundry floor

## Phase 5: [US3] Market Readiness Infrastructure (P2)
Requirement: Security, clean code, and test coverage.

- [ ] T009 [US3] Refactor data access in reports to use the new hybrid model in `pages/relatorios.php`
- [ ] T010 [US3] Finalize test suite coverage for SKU/Material data fidelity

## Final Phase: Polish & Cross-Cutting
Cleanup and mobile optimization.

- [ ] T011 [P] Optimize hybrid input form for mobile touch targets in `assets/css/style.css`
- [ ] T012 Perform end-to-end verification of the hybrid receiving and tracking workflow

## Dependencies
1. [US1] depends on Phase 2 validation logic.
2. [US2] depends on [US1] data being correctly persisted.
3. [US3] depends on [US2] operational continuity.

## Parallel Execution Examples
- [US1] T003 (UI) and [US1] T005 (Tests)
- [US2] T006 (UI Lavagem) and [US2] T007 (UI Expedição)

## Implementation Strategy
- **MVP first**: Focus on Phase 1-3 to enable recording orders with the new hybrid model.
- **Incremental Display**: Once data is saved, update operational pages to show it.
- **Validation**: Ensure existing orders (Legacy) still render correctly without the new fields.
