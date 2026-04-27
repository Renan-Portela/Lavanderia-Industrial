# Data Model: Washing UI Refactor

## UI Entities

### Order Info Card (Transient)
- **ID**: `pedidos.id`
- **Cliente**: `pedidos.cliente`
- **Material**: `materiais.nome` (fetched via JOIN)
- **Quantidade**: `pedidos.quantidade`
- **Unidade**: `pedidos.unidade`
- **Observações**: `pedidos.observacao`

### Washing Table Row
- **ID**: `pedidos.id`
- **Cliente**: `pedidos.cliente`
- **SKU**: `materiais.sku`
- **Descrição (SKU Meaning)**: `materiais.nome`
- **Quantidade**: Formatted `quantidade` + `unidade` (e.g., "10.00 kg")
- **Data**: `pedidos.data_cadastro`

## Relationships
- **Pedido (1) <-> Material (1)**: Joined by `pedidos.material_id = materiais.id`.
