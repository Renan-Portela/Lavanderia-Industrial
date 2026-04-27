# Data Model: Expedition UI Refactor

## UI State Transitions

### Tab 1: Aguardando Expedição
- **Query**: `SELECT p.*, m.sku, m.nome FROM pedidos p LEFT JOIN materiais m ON p.material_id = m.id WHERE p.status = 'Lavagem'`
- **Goal**: List items that have arrived from washing and are ready to be scanned out.

### Tab 2: Pronto para Entrega
- **Query**: `SELECT p.*, m.sku, m.nome FROM pedidos p LEFT JOIN materiais m ON p.material_id = m.id WHERE p.status = 'Expedido'`
- **Goal**: List items already processed in the expedition sector.

### Detailed Info Card
- **Data Source**: Single order lookup with material JOIN.
- **Fields**: ID, Client, Material (Catalog Name), Quantity + Unit, Observations.

## Formatted Fields
- **Quantity**: Displayed as `number_format(val, 2) + unit` (e.g., "5.50 kg", "10 und.").
