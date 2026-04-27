# Research: Expedition UI Refactor

## Decision 1: Tabbed Interface Implementation
- **Decision**: Use Bootstrap 5 Nav-Tabs to separate "Aguardando" and "Pronto p/ Entrega".
- **Rationale**: Keeps the screen clean while providing full sector visibility, as decided in clarification.
- **Implementation**: One tab for orders in 'Lavagem' status (incoming) and another for 'Expedido' status (processed).

## Decision 2: Detailed Info Card
- **Decision**: Side-by-side layout for scan input and info card on desktop.
- **Rationale**: Parity with Washing UI for consistency.
- **Implementation**: Reuse CSS and logic from `lavagem.php` to show Client, Material, Units, and Observations.

## Decision 3: Quick Copy Feature
- **Decision**: Add a "Copiar" button in the Info Card header.
- **Rationale**: High operational value for labeling and secondary tracking.
- **Implementation**: Call `copiarCodigo('PEDIDO-XXX')` helper from `main.js`.

## Decision 4: Interactive Tables
- **Decision**: Make Order IDs in both tabs clickable.
- **Rationale**: Allows operators to quickly pull up details for manual verification.
- **Implementation**: Use `GET['id']` parameter to trigger the Info Card display.
