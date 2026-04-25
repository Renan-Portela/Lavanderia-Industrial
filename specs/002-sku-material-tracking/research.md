# Research: SKU & Material Tracking Refinement

## Decision 1: Hybrid Material Data Strategy
- **Decision**: Store the specific material description in the existing `tipo_material` column in the `pedidos` table, while using `material_id` for the standardized SKU reference.
- **Rationale**: The `tipo_material` column is already present and used for legacy data. Re-purposing it as the "free-text descriptive field" maintains backward compatibility with reports while satisfying the new requirement for item-specific details (e.g., "Latex Industrial Glove - XL").
- **Alternatives considered**: Adding a new `material_custom_name` field. Rejected because `tipo_material` is redundant once `material_id` is mandatory for categorization.

## Decision 2: QR Code Scanning Workflow
- **Decision**: Maintain the current QR logic (`PEDIDO-{ID}`) but update the operational views to display the hybrid info (SKU Code + Custom Description).
- **Rationale**: Digital traceability Principle I requires every entry to have a QR. The current system already does this efficiently.
- **Alternatives considered**: Generating SKU-specific QR codes. Rejected because tracking is per-order, not per-material-type.

## Decision 3: UI for Hybrid Input
- **Decision**: Use a "Select + Text" pattern on the receiving form. The select field will pull from `MaterialService::getAll()`, and a required text input will capture the specific item name.
- **Rationale**: Satisfies FR-001 and FR-002 while ensuring data fidelity (Principle IV).
