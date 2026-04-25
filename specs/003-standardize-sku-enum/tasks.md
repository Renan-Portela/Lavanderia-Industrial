# Tasks: Standardize SKU and Enum Patterns

**Feature**: Standardize SKU and Enum Patterns  
**Priority**: P1  
**Status**: Ready for Implementation  
**Spec**: [specs/003-standardize-sku-enum/spec.md](specs/003-standardize-sku-enum/spec.md)

## Summary
Standardize the SKU pattern to `[CAT]-[MAT]-[SIZ]-[WASH]` and the `tipo_lavagem` ENUM to `'A'` (Agua) and `'S'` (Seco) across all technical artifacts. This phase focuses on documentation alignment, database schema consistency, and helper logic updates to prevent implementation ambiguity.

## Phase 1: Setup
Initialize the standardization process and documentation alignment.

- [ ] T001 [P] Create backup of current `database.sql` before schema updates
- [ ] T002 [P] Update `specs/001-market-readiness-sku/spec.md` with unified SKU pattern `[CAT]-[MAT]-[SIZ]-[WASH]`
- [ ] T003 [P] Update `specs/001-market-readiness-sku/plan.md` to reflect standardized SKU and ENUM patterns

## Phase 2: Foundational
Blocking prerequisites for documentation and logic alignment.

- [ ] T004 [P] Update `specs/001-market-readiness-sku/data-model.md` entities (`Material`, `Pedido`) with standardized ENUMs and FKs
- [ ] T005 [P] Update `specs/001-market-readiness-sku/tasks.md` to include explicit `material_id` FK steps in Phase 2
- [ ] T006 Update `database.sql` to standardize `tipo_lavagem` ENUM to ('A', 'S') and add `material_id` to `pedidos`

## Phase 3: User Story 1 - Unified Data Pattern (Priority: P1)
**Goal**: All technical documentation and core logic follow the `[CAT]-[MAT]-[SIZ]-[WASH]` and ('A', 'S') patterns.

### Implementation

- [ ] T007 [P] [US1] Update SKU generation pattern in `includes/sku_helper.php` to include `[WASH]` suffix
- [ ] T008 [P] [US1] Update Material management form in `pages/materiais.php` to use 'A' and 'S' options
- [ ] T009 [US1] Update Material service logic in `includes/material_service.php` to handle standardized ENUM values
- [ ] T010 [US1] Update Material validation in `tests/MaterialTest.php` to verify the new SKU pattern (excluding legacy items)
- [ ] T011 [US1] Update Order service in `includes/order_service.php` to utilize `material_id` FK association

**Checkpoint**: SKU pattern `[CAT]-[MAT]-[SIZ]-A` (or -S) is correctly generated and stored.

## Final Phase: Polish & Cross-Cutting
Cleanup and verification.

- [ ] T012 Verify all cross-references between Spec, Plan, and Data Model have 100% terminology alignment
- [ ] T013 Perform final database integrity check to ensure `pedidos` table correctly links to `materiais`
- [ ] T014 [P] Update `quickstart.md` in Feature 001 to reflect the standardized migration path

## Dependencies
1. Phase 1 & 2 must be completed before Story-specific implementation.
2. [US1] T011 (Order Service) depends on T006 (Database migration).

## Parallel Execution Examples
- T002 (Spec update) and T003 (Plan update)
- T007 (SKU Helper) and T008 (UI Form)
- T001 (Backup) and T004 (Data Model update)

## Implementation Strategy
- **MVP first**: Align all documentation artifacts first to provide a clear source of truth.
- **Data Integrity**: Database migrations (T006) must be applied to the master schema to ensure all subsequent development inherits the standard.
- **Verification**: Functional verification focuses on SKU pattern matching and ENUM constraints.
