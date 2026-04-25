# Data Model: Standardized SKU & Enum Patterns

## Entities

### Material (Standardized SKU Catalog)
| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `id` | INT (PK) | Auto-increment identifier | |
| `nome` | VARCHAR(255) | Display name | Required, Unique |
| `sku` | VARCHAR(50) | Unique SKU [CAT]-[MAT]-[SIZ]-[WASH] | Required, Unique, Pattern Match |
| `tipo_lavagem` | ENUM('A', 'S') | 'A' (Agua), 'S' (Seco) | Required |
| `descricao` | TEXT | Optional details | |
| `data_criacao` | TIMESTAMP | Creation record | |

### Pedido (Order)
| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `id` | INT (PK) | Auto-increment identifier | |
| `material_id` | INT (FK) | Reference to `material.id` | Required |
| `quantidade` | INT | Number of items | > 0 |
| `cliente` | VARCHAR(255) | Name of the customer | Required |
| `status` | ENUM('Recebido', 'Lavagem', 'Expedido') | | Required |
| `data_entrada` | TIMESTAMP | Entry time | |
| `qr_code_path` | VARCHAR(255) | Path to generated image | |

## Relationships
- **Material 1:N Pedido**: Orders MUST link to a Material record to ensure SKU traceability.

## State Transitions
1. **Recebido** -> **Lavagem** -> **Expedido** (Strict sequence mandated by Constitution Principle II)
