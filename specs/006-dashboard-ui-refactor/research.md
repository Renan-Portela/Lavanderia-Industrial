# Research: Dashboard UI Refactor

## Decision 1: Header Counters Implementation
- **Decision**: Use a flex container in the header to place the page title and status mini-cards on the same line.
- **Rationale**: Aligns with the requirement to save vertical space. Using Bootstrap 5 flexbox utilities makes this responsive and clean.
- **Alternatives considered**: Simple badges (Option A in clarification), but mini-cards with icons (Option B) provide better visual feedback.

## Decision 2: Horizontal Quick Actions
- **Decision**: Implement Quick Actions as a horizontal row of buttons or compact cards below the header.
- **Rationale**: Improves accessibility and visual flow on industrial tablets.
- **Implementation**: Use `.d-flex` or `.row` with `.col` to arrange the current actions horizontally.

## Decision 3: Enriched Recent Orders Table
- **Decision**: Expand the Recent Orders table to full width and include a visual progress indicator.
- **Rationale**: Requested by the user for "fast visualization".
- **Implementation**: The progress indicator will be a small stepped UI or a progress bar based on the 3 main stages: Recebido -> Lavagem -> Expedido.

## Decision 4: Mobile Responsiveness
- **Decision**: Ensure the header mini-cards stack above or below the title on small screens.
- **Rationale**: Principle V (Mobile-Responsive Design) requires usability on mobile devices where horizontal space is limited.
