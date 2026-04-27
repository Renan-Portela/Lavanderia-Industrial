# Research: Managerial Reports Refactor

## Decision 1: Unified Header & Dynamic Cards
- **Decision**: Refactor `relatorios.php` and `index.php` to use the same mini-stat card component layout. Update `index.php` to use Success (green) for 'Expedido' to match the reports' status theme.
- **Rationale**: Direct user request for aesthetic parity and dynamic behavior across both screens.
- **Implementation**: Create or unify CSS classes for `.mini-stat-card`. Ensure both pages fetch counts using similar logic.

## Decision 2: Contextual Side-Card Interaction
- **Decision**: Implement a side-by-side layout (col-md-6 / col-md-6) on the Reports page. Clicking a row ID or Client will trigger the display of the detailed order info card.
- **Rationale**: Reuses the successful interaction pattern from the Materials and operational pages (US1-008, US1-010).
- **Implementation**: Use `GET['id']` parameter logic to load the detailed view, same as `lavagem.php` and `materiais.php`.

## Decision 3: Managerial KPI Calculations
- **Decision**: 
    - **Processed Volume**: Sum of quantity for 'Expedido' orders.
    - **Lead Time (Primary)**: Average of `TIMESTAMPDIFF(HOUR, data_cadastro, data_expedicao)` for 'Expedido' status.
    - **Backlog**: Count of orders where `status != 'Expedido'`.
- **Rationale**: Provides clear operational velocity and bottleneck indicators for management.

## Decision 4: Simple OKR Indicator
- **Decision**: Display a comparison percentage vs. the previous calendar month's volume/lead-time.
- **Rationale**: Confirmed in clarification as a "simple comparison to previous month" to show trends without the pressure of hard fixed targets.
- **Implementation**: Run a secondary query to fetch the previous month's aggregates for the comparison.
