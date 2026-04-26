# Data Model: Dashboard UI Refactor

## UI State Transitions

### Status Counters (Header)
- **Recebidos**: Displays count of orders with `status = 'Recebido'`.
- **Lavagem**: Displays count of orders with `status = 'Em Lavagem'`.
- **Expedição**: Displays count of orders with `status = 'Pronto para Expedição'`.
- **Concluídos**: Displays count of orders with `status = 'Concluído'`.

### Recent Orders Table
- **Columns**: ID, Cliente, Status, Progresso (Visual), Data Cadastro.
- **Progresso Logic**:
    - `Recebido` -> 33%
    - `Em Lavagem` -> 66%
    - `Pronto para Expedição` -> 100% (or special completed state)
    - `Concluído` -> 100% (Success color)

## Key Entities (No change to schema)
- **pedidos**: Primary source for counters and recent list.
- **usuarios**: Session management for dashboard access.
