# Research: SKU and Enum Standardization

## Decision: Unified SKU Pattern
**Standard**: `[CAT]-[MAT]-[SIZ]-[WASH]`
**Rationale**: Explicitly including the washing method in the SKU prevents processing errors on the laundry floor. A 'SECO' (Dry Clean) item will have a distinct identifier from an 'AGUA' (Water Wash) item even if they share Category, Material, and Size.

## Decision: Washing ENUM Values
**Standard**: `'A'` (Agua) and `'S'` (Seco)
**Rationale**: Brief characters are easier to map directly into SKUs and save storage space. They align with common industrial marking standards (A/S).
**Alternatives Considered**: 
- 'AGUA'/'SECO': Rejected because 'A'/'S' is more concise for SKU generation.
- 1/2 (numeric): Rejected for lack of readability in raw database queries.

## Decision: Database Foreign Key Integration
**Standard**: Add `material_id` to `pedidos` table and establish a Foreign Key to `materiais.id`.
**Rationale**: Ensures data fidelity. Standardized receiving must link orders to the material catalog to inherit the correct SKU pattern and washing requirements.
