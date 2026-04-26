# Data Model: Enhanced Order Receiving

## Schema Updates

### Table: `pedidos`
- **quantidade**: Change from `INT` to `DECIMAL(10,2)`.
- **unidade**: Add column `ENUM('UN', 'KG') NOT NULL DEFAULT 'UN'`.
- **tipo_material**: Remains for specific material notes (though mandatory requirement removed).
- **observacao**: Optional text field.

## State Transitions
- **Recebido**: Quantity stored with specific unit.
- **Display**: All tables (Dashboard, Relatórios) must show `quantidade` followed by `unidade`.
