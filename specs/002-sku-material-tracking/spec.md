# Feature Specification: SKU & Material Tracking with QR Code

**Feature Branch**: `002-sku-material-tracking`  
**Created**: 2026-04-24  
**Status**: Draft  
**Input**: User description: "mantenha a maneira de usar o qrcode para trackear a limpeza do produto e deixe um campo para selecao do sku e um campo para escrever o material."

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Hybrid Material Entry (Priority: P1)

As a receiving operator, I want to select a standardized SKU from a catalog and also provide a descriptive name for the material so that I can maintain standardization while capturing specific item details.

**Why this priority**: Essential for the new SKU logic while allowing flexibility for varied material descriptions within the same SKU category.

**Independent Test**: On the receiving page, select SKU "GLV-IND" from the dropdown and type "Latex Industrial Glove - Large" in the material field. Save and verify both are stored in the order.

**Acceptance Scenarios**:

1. **Given** a list of predefined SKUs, **When** I create a new order, **Then** I must be able to select a SKU and enter text in the material field.
2. **Given** no SKU is selected, **When** I try to save, **Then** the system must prompt for a SKU selection (assuming SKU is mandatory for tracking).

---

### User Story 2 - Continuity of QR Tracking (Priority: P1)

As a laundry operator, I want to scan the QR code of an item to update its status (e.g., to "Cleaning") so that the digital tracking matches the physical processing of the item.

**Why this priority**: Core requirement to maintain the existing workflow efficiency while adding the new data fields.

**Independent Test**: Generate a QR code for an order, scan it using the "Lavagem" page, and verify the status updates to "Em Lavagem".

**Acceptance Scenarios**:

1. **Given** an order with a generated QR code, **When** the code is scanned on the operational pages, **Then** the system identifies the specific order and its SKU/Material details.

---

### User Story 3 - Market Readiness Infrastructure (Priority: P2)

As a system owner, I want the system to be secure and tested so that it can be deployed in a professional industrial environment.

**Why this priority**: Alignment with general "ready for market" requirements (Auth, Clean Code, Tests).

**Independent Test**: Run automated tests for order creation and verify authentication is required to access the dashboard.

**Acceptance Scenarios**:

1. **Given** an unauthorized user, **When** they attempt to access receiving/tracking pages, **Then** they are blocked.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: **SKU Selection**: The system MUST provide a selection field (dropdown/autocomplete) populated from a standardized SKU catalog.
- **FR-002**: **Material Input**: The system MUST provide a free-text field for the material description.
- **FR-003**: **QR Tracking Integrity**: The system MUST maintain the current QR code scanning mechanism for status updates (Recebimento → Lavagem → Expedição).
- **FR-004**: **Authentication**: Access to all operational and reporting pages MUST require a valid user login.
- **FR-005**: **Automated Verification**: Core business logic (QR identification, status transitions, and data persistence) MUST be covered by automated tests.

### Non-Functional Requirements

- **NFR-001**: **Clean Architecture**: Code MUST be refactored to separate business logic from the view layer (Clean Code).
- **NFR-002**: **Responsive Operations**: Operational screens MUST be optimized for mobile/tablet use for scanning and input on the laundry floor.
- **NFR-003**: **Data Relational Integrity**: Orders MUST link to the SKU catalog using relational database constraints.

### Key Entities

- **SKU Catalog**: Standardized identifiers (e.g., `id`, `sku_code`, `category`).
- **Pedido (Order)**: References a `sku_id` and contains a text field `material_descricao`.
- **User**: Authentication credentials and roles.

### Edge Cases

- **Custom Material without SKU**: Handling items that don't fit existing SKU patterns (if allowed).
- **QR Code Scanning Failures**: Fallback mechanism for manual entry when scanning fails.
- **Concurrent Status Updates**: Preventing race conditions if multiple operators scan the same QR code.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: **Tracking Continuity**: 100% of orders continue to be tracked via QR code without regression.
- **SC-002**: **Data Enrichment**: Every new order recorded contains both a validated SKU and a descriptive material text.
- **SC-003**: **Zero Unauthorized Access**: No operational page is accessible without a verified session.
- **SC-004**: **Test Coverage**: Critical paths (receiving and status updates) have 100% automated test pass rate.

## Assumptions

- A baseline SKU catalog will be provided or initialized for common items.
- The existing database structure will be migrated to support the SKU/Material split.
- The QR Code helper remains the source of truth for tracking identification.
- Bootstrap 5 or a similar modern responsive framework is used for UI consistency.
