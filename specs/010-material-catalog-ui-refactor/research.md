# Research: Material Catalog UI Refactor

## Decision 1: Searchable Material Lookup
- **Decision**: Implement an HTML5 `<datalist>` populated with "SKU - Name" from all active materials.
- **Rationale**: Direct parity with the "Enhanced Order Receiving" implementation. Maintains "Structured Simplicity" by using native web elements.
- **Implementation**: The input field will allow searching by typing any part of the SKU or Name.

## Decision 2: Detailed Info Card & Local Edit
- **Decision**: Side-by-side layout (col-md-6) for lookup and details. The detail card will have a "Toggle Edit" button.
- **Rationale**: Parity with Washing and Expedition UIs. Centralizing edits in the card reduces page navigation and keeps context.
- **Implementation**: JS will handle toggling between "view mode" and "edit form" within the card.

## Decision 3: Wash Type Selection
- **Decision**: Use a Bootstrap 5 button group with Radio inputs for selecting "Água (A)" and "Seco (S)".
- **Rationale**: Parity with the UN/KG selector in Receiving. Provides a more modern and touch-friendly experience than a standard dropdown.

## Decision 4: Interactive Table
- **Decision**: Make table rows or primary identifiers (SKU/Name) clickable.
- **Rationale**: Fast navigation and improved user experience for administrators.
- **Implementation**: Add \`onclick\` handlers that trigger the same display logic as a search selection.
