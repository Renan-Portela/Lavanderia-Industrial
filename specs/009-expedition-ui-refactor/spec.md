# Feature Specification: Expedition UI Refactor

**Feature Branch**: `009-expedition-ui-refactor`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "faca as mesmas mudancas que foram feitas na tela de lavagem para a tela de expedicao."

## Clarifications

### Session 2026-04-26
- Q: Expedition Table Behavior → A: Dual view using Tabs (Abas).
- Q: Layout for dual lists → A: Option B (Tabs: "Aguardando Expedição" for items arrived in the sector, and "Pronto para Entrega" for processed items).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Detailed Expedition Scan Information (Priority: P1)

As an operator, when I scan an order QR code in the Expedition page, I want to see immediate details about the order so that I can verify the items before final delivery.

**Why this priority**: Quality control and verification at the final stage of the process.

**Independent Test**: Scan an order. Verify that Client, Material Name (from catalog), Quantity (with units), and Observations appear in a card next to the scan input.

**Acceptance Scenarios**:

1. **Given** a scanned order, **When** the information card is displayed, **Then** I MUST see a "Copiar" button that copies the order code to the clipboard.
2. **Given** a scanned order with observations, **When** the card is displayed, **Then** the observations MUST be visible.
3. **Given** a scanned order without observations, **When** the card is displayed, **Then** the "OBS" section MUST be hidden.

### User Story 2 - Clickable Table & Enhanced View (Priority: P1)

As an operator, I want to click on an order in the expedition lists to see its details without needing to scan.

**Why this priority**: Efficiency for manual lookups and batch processing.

**Independent Test**: Click an order ID in any of the tabs. Verify the page reloads and shows the detailed information card.

**Acceptance Scenarios**:

1. **Given** any expedition table tab, **When** I click an order ID, **Then** the page MUST show that order's details in the info card.
2. **Given** an expedition list, **When** viewing the "Descrição" column, **Then** it MUST show the name from the Material Catalog.
3. **Given** an expedition list, **When** viewing the "Quantidade" column, **Then** it MUST show the unit suffix (e.g., "10.00 kg").

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST display scanned order details (Client, Material Name, Quantity + Unit, Observations) in a side-by-side layout with the scan input on desktop.
- **FR-002**: System MUST implement a "Copiar" button in the scan info card to copy "PEDIDO-XXX" to the clipboard.
- **FR-003**: System MUST allow viewing order details by clicking the Order ID in any of the lists.
- **FR-004**: System MUST update expedition lists to show: ID (Link), Cliente, SKU, Descrição (Catalog Name), Quantidade (with unit), and Data.
- **FR-005**: System MUST hide the "Observações" section in the info card if empty.
- **FR-006**: System MUST implement a tabbed interface (Bootstrap 5 Nav-Tabs) in `pages/expedicao.php`.
- **FR-007**: Tab 1 ("Aguardando") MUST display orders with `status = 'Lavagem'` (incoming from washing).
- **FR-008**: Tab 2 ("Pronto p/ Entrega") MUST display orders with `status = 'Expedido'`.

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5).
- **NFR-002**: Table loading MUST use JOIN for catalog descriptions.

### Key Entities

- **Pedido (Order)**: Primary data source.
- **Material (Catalog)**: Source for SKU meaning.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: Navigation from table selection to detail view takes exactly 1 click.
- **SC-002**: 100% of order codes are copyable via the new button.
- **SC-003**: Operational visibility covers both incoming and outgoing sector flow via tabs.

## Assumptions

- [Assumption]: Uses the same `copyToClipboard` helper from `main.js`.
- [Assumption]: Database schema remains as updated in feature 007.
