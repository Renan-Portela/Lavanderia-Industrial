# Feature Specification: Standardize SKU and Enum Patterns

**Feature Branch**: `003-standardize-sku-enum`  
**Created**: 2026-04-25  
**Status**: Draft  
**Input**: User description: "Fix inconsistencies in SKU patterns and ENUM values across 001-market-readiness-sku docs"

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Unified Data Pattern (Priority: P1)

As a developer and system maintainer, I want all technical documentation (specs, plans, and data models) to use consistent naming and data patterns so that I can implement the database and business logic without ambiguity.

**Why this priority**: Prevents implementation errors where the database might use one format (e.g., "AGUA/SECO") while the application logic expects another (e.g., "A/S").

**Independent Test**: Verify that the generated SKU for an item with water washing follows the `[CAT]-[MAT]-[SIZ]-A` pattern across the materials catalog and receiving reports.

**Acceptance Scenarios**:

1. **Given** a material with water washing, **When** its SKU is generated, **Then** it MUST include the 'A' suffix.
2. **Given** the documentation for the Materials table, **When** reviewing the washing type field, **Then** it MUST clearly define the ENUM as ('A', 'S').

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: **Unified SKU Pattern**: All documentation MUST standardize the SKU pattern as `[CAT]-[MAT]-[SIZ]-[WASH]`.
- **FR-002**: **Washing ENUM Standardization**: The material washing type ENUM MUST be standardized as 'A' (Agua) and 'S' (Seco) across all artifacts.
- **FR-003**: **Database Migration Alignment**: Task lists MUST explicitly include the structural changes for the `pedidos` table (adding `material_id`) to ensure data fidelity.

### Non-Functional Requirements

- **NFR-001**: **Document Consistency**: Cross-referencing between Spec, Plan, and Data Model MUST have 100% terminology alignment.
- **NFR-002**: **Process Integrity**: Any updates to the task list MUST preserve the strict workflow defined in LuvaSul Constitution Principle II.

### Key Entities

- **Specification/Plan/Data Model**: The core documentation artifacts being unified.
- **Material Catalog**: The entity most affected by the pattern standardization.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: 100% agreement on SKU pattern format across `spec.md`, `plan.md`, and `data-model.md`.
- **SC-002**: Zero ambiguity in the `tipo_lavagem` ENUM definition across technical artifacts.
- **SC-003**: `tasks.md` contains explicit steps for `pedidos` table foreign key updates.

## Assumptions

- The decision to use 'A'/'S' for ENUM values is preferred for brevity and direct SKU mapping.
- Existing documentation for Feature 001 will be updated to reflect these unified standards.
