# Feature Specification: Market Readiness & SKU Standardization

**Feature Branch**: `001-market-readiness-sku-standardization`  
**Created**: 2026-04-24  
**Status**: Draft  
**Input**: User description: "Leia o README.md e analize todo o codigo para fazer com que este projeto fique pronto para o mercado. Investigue pontos de melhoria de acordo com melhores praticas, clean code e crie testes para fazer com que este projeto fique pronto para o mercado. Procure colocar padroes para os itens de lavagem usando uma logica sku."

## Clarifications

### Session 2026-04-24
- Q: What is the mandatory pattern for SKUs? → A: Hierarchical: `[CAT]-[MAT]-[SIZ]` (e.g., `GLV-IND-XL`).
- Q: Which pages exactly constitute "operational views" requiring authentication? → A: All internal: Everything except `login.php` and potentially `index.php` (Dashboard).
- Q: What hashing algorithm should be used for user passwords? → A: `password_hash()` with `PASSWORD_DEFAULT` (bcrypt).
- Q: Which local PHP library should be used for offline QR generation? → A: `chillerlan/php-qrcode`.
- Q: How should existing free-text `tipo_material` data be handled? → A: Create "Legacy" SKU for all old records.

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Material Standardization (Priority: P1)

As a laundry manager, I want to define a standardized catalog of items (materials) with unique SKUs so that the receiving process is consistent and error-free.

**Why this priority**: Crucial for tracking and inventory management. Prevents variation in data (e.g., "Luva", "Luv.", "Luvas") that breaks reporting.

**Independent Test**: Create a new material "Industrial Glove" with SKU "GLV-IND-01", then verify it appears as a selectable option in the receiving form.

**Acceptance Scenarios**:

1. **Given** the materials catalog is empty, **When** I add a material with name and SKU, **Then** it must be persisted in the database.
2. **Given** a duplicate SKU is entered, **When** I try to save, **Then** the system must reject it with a validation error.

---

### User Story 2 - Automated Quality Guard (Priority: P1)

As a developer/maintainer, I want to have a suite of automated tests for the core business logic (QR code generation and order status flow) so that I can deploy updates with confidence.

**Why this priority**: Essential for market readiness to ensure reliability and prevent regressions in industrial environments.

**Independent Test**: Run the automated test suite and see it verify the status transition from "Recebido" to "Lavagem".

**Acceptance Scenarios**:

1. **Given** a valid order ID, **When** I trigger QR generation, **Then** the output must be a valid image/link according to defined patterns.
2. **Given** an order in "Recebido" status, **When** it is processed for washing, **Then** its status must update to "Em Lavagem".

---

### User Story 3 - Secure Operational Access (Priority: P2)

As a system administrator, I want to require authentication for all operational pages so that only authorized personnel can record laundry steps.

**Why this priority**: Security is a market requirement to prevent unauthorized data tampering.

**Independent Test**: Attempt to access operational pages without logging in and verify redirection to a login page.

**Acceptance Scenarios**:

1. **Given** an unauthenticated session, **When** I access any operational URL, **Then** I am redirected to login.

### Edge Cases

- **Duplicate SKU Creation**: Attempting to create a material with an existing SKU.
- **Material Deletion with active orders**: Deleting a material that is referenced by existing orders.
- **Offline QR Generation**: Generating QR codes when external internet access is restricted.
- **Invalid Status Transitions**: Trying to skip steps (e.g., from Recebido directly to Expedido).

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: **Material Catalog**: System MUST provide a CRUD interface for materials including fields: Name, Description, and SKU.
- **FR-002**: **SKU Standardization**: Materials MUST have unique SKUs following the hierarchical pattern `[CAT]-[MAT]-[SIZ]` (e.g., `GLV-IND-XL`).
- **FR-003**: **Standardized Receiving**: The Receiving form MUST use a selection from the catalog for materials, replacing free-text input.
- **FR-004**: **Authentication System**: System MUST implement a secure login mechanism for all internal pages (everything except `login.php` and `index.php`).
- **FR-005**: **Automated Testing**: System MUST include automated tests covering:
  - QR Code generation logic.
  - Order status transition rules.
  - Material validation rules.

### Non-Functional Requirements

- **NFR-001**: **Architectural Separation**: Code MUST be refactored to separate business logic from UI presentation.
- **NFR-002**: **Reliable Tracking**: QR Code generation MUST use the local `chillerlan/php-qrcode` library to ensure operation without external internet access.
- **NFR-003**: **Data Integrity**: Database MUST use relational constraints between Pedidos and the new Materiais table.
- **NFR-004**: **Interface Responsiveness**: Every operational screen MUST be optimized for mobile and tablet use on the laundry floor.

### Key Entities

- **Material**: Represents a standardized item type. Attributes: `id`, `nome`, `sku`, `descricao`, `data_criacao`.
- **Pedido (Order)**: Updated to reference `material_id` instead of raw string `tipo_material`.
- **Usuario**: Represents system users. Attributes: `id`, `username`, `password_hash`, `perfil`.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: **Data Consistency**: 100% of new orders use standardized SKUs from the catalog.
- **SC-002**: **Reliability**: Codebase has >70% coverage of core business logic via automated tests.
- **SC-003**: **Security**: 0 operational pages accessible without authentication.
- **SC-004**: **Independence**: QR Codes generate successfully even without external internet access (using local library).

## Assumptions

- The current execution environment supports modern automated testing frameworks.
- The user will provide or approve the initial SKU naming convention for existing items.
- Migration of existing "raw string" material data will involve creating a "Legacy" SKU to maintain historical record integrity.
- Standard modern web primitives and a responsive CSS framework will be used for UI components.
