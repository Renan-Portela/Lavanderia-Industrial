# Data Model: Market Readiness & SKU Standardization

## Entities

### Material
Represents a standardized item that can be processed.
- `id` (INT, PK, AUTO_INCREMENT)
- `name` (VARCHAR(100), NOT NULL): Display name (e.g., "Industrial Glove")
- `sku` (VARCHAR(50), UNIQUE, NOT NULL): Standardized SKU (e.g., `GLV-IND-XL`)
- `description` (TEXT): Detailed description
- `category_prefix` (VARCHAR(10)): e.g., `GLV`
- `material_prefix` (VARCHAR(10)): e.g., `IND`
- `size_prefix` (VARCHAR(10)): e.g., `XL`
- `created_at` (DATETIME, DEFAULT CURRENT_TIMESTAMP)

### User
Represents an authorized personnel with system access.
- `id` (INT, PK, AUTO_INCREMENT)
- `username` (VARCHAR(50), UNIQUE, NOT NULL)
- `password_hash` (VARCHAR(255), NOT NULL): Hashed using bcrypt
- `created_at` (DATETIME, DEFAULT CURRENT_TIMESTAMP)

### Order (Updated)
Existing `pedidos` table with standardized material reference.
- `id` (INT, PK, AUTO_INCREMENT)
- `cliente` (VARCHAR(100), NOT NULL)
- `material_id` (INT, FK): Reference to `materials.id`
- `tipo_material` (VARCHAR(100), NOT NULL): Denormalized `materials.name` for historical records
- `quantidade` (INT, NOT NULL)
- `observacao` (TEXT)
- `status` (VARCHAR(30), DEFAULT 'Recebido')
- `codigo_qr` (VARCHAR(255))
- `data_cadastro` (DATETIME, DEFAULT CURRENT_TIMESTAMP)

## Relationships
- `Order` belongs to `Material` (Many-to-One)

## Validation Rules
- `Material.sku`: Must be unique and follow the `[CAT]-[MAT]-[SIZ]` pattern.
- `User.password_hash`: Must be generated using `password_hash()` with `PASSWORD_DEFAULT`.
- `Order.status`: Must only transition in the order `Recebido` -> `Lavagem` -> `Expedição`.
