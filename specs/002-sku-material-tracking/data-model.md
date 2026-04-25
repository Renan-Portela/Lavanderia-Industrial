# Data Model: Hybrid SKU & Material Tracking

## Entities

### Pedido (Order) - Refined
Represents a tracked laundry item with standardized category and specific description.

| Field | Type | Description |
|-------|------|-------------|
| `material_id` | INT (FK) | Reference to `materiais.id` (provides the Standardized SKU). |
| `tipo_material` | VARCHAR(100) | Specific description of the item (e.g., "Luva de Raspa Punho 20cm"). |
| `status` | ENUM | 'Recebido', 'Lavagem', 'Expedido'. |

## Relationships
- **Material 1:N Pedido**: One SKU category can have multiple specific item entries.

## UI Data Representation
When displaying an order in "Lavagem" or "Expedição":
- **Header**: Standard SKU (from catalog)
- **Detail**: Custom Description (from `tipo_material` field)
- **ID**: `PEDIDO-{ID}` (from QR code)
