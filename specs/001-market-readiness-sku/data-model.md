# Data Model: Market Readiness & SKU Standardization

## Entities

### Material (Standardized SKU Catalog)
Represents a unique type of item that can be processed.

| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `id` | INT (PK) | Auto-increment identifier | |
| `nome` | VARCHAR(255) | Display name (e.g., "Luva de Raspa GG") | Required, Unique |
| `sku` | VARCHAR(50) | Unique SKU [CAT]-[MAT]-[SIZ] | Required, Unique, Pattern Match |
| `tipo_lavagem` | ENUM | 'AGUA' or 'SECO' | Required |
| `descricao` | TEXT | Optional details | |
| `data_criacao` | TIMESTAMP | Creation record | |

### Pedido (Order) - Updated
Represents a laundry order/item.

| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `id` | INT (PK) | Auto-increment identifier | |
| `material_id` | INT (FK) | Reference to `material.id` | Required |
| `quantidade` | INT | Number of items | > 0 |
| `cliente` | VARCHAR(255) | Name of the customer | Required |
| `status` | ENUM | 'Recebido', 'Lavagem', 'Expedido' | Required |
| `data_entrada` | TIMESTAMP | Entry time | |
| `qr_code_path` | VARCHAR(255) | Path to generated image | |

### Usuario (Authentication)
| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `id` | INT (PK) | | |
| `username` | VARCHAR(50) | | Unique |
| `password_hash`| VARCHAR(255) | Hashed password | bcrypt |
| `perfil` | ENUM | 'Admin', 'Operador' | |

## Relationships
- **Material 1:N Pedido**: One material type can be associated with many orders.
- **Pedido N:1 Usuario**: (Optional) To track who created the order.

## State Transitions (Process Flow)
1. **Recebido**: Initial state upon entry.
2. **Lavagem**: After receiving, before expedition.
3. **Expedido**: Final state, item returned to client.

*Constraint*: Status cannot skip 'Lavagem' or revert from 'Expedido' to 'Recebido'.
