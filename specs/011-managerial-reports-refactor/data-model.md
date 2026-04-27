# Data Model: Managerial Reports Refactor

## Aggregated Metrics (KPIs)

### 1. Processed Volume
- **Source**: `pedidos`
- **Logic**: `SUM(quantidade)` where `status = 'Expedido'` within time range.

### 2. Lead Time (Efficiency)
- **Source**: `pedidos`
- **Logic**: `AVG(TIMESTAMPDIFF(SECOND, data_cadastro, data_expedicao))` for 'Expedido' status.
- **Display**: Converted to hours/days for readability.

### 3. Current Backlog
- **Source**: `pedidos`
- **Logic**: `COUNT(*)` where `status IN ('Recebido', 'Lavagem')`.

## Comparative OKR Data
- **Target**: Previous month's Processed Volume.
- **Calculation**: `((Current_Month_Volume / Previous_Month_Volume) - 1) * 100`.

## UI Relationship
- **Table Row (1) -> Detail Card (1)**: Contextual drill-down on ID click.
