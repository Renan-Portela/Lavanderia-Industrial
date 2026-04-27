# Feature Specification: Material Catalog UI Refactor

**Feature Branch**: `010-material-catalog-ui-refactor`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "vamos deixar a tela de catalogo de materiais parecido com o do recebimento de materiais e vamos melhorar a interface parecida com as de lavagem e de expedicao."

## Clarifications

### Session 2026-04-26
- Q: Edição de Materiais → A: Edição local no card de detalhes (Ação transforma visualização em formulário).
- Q: Seleção de Tipo de Lavagem → A: Uso de **Radio Buttons** (Estilo de Botão Bootstrap) para Água (A) e Seco (S), mantendo consistência com o seletor de UN/KG do Recebimento.
- Q: Organização do Formulário de Cadastro → A: Sob demanda (O formulário de "Novo Material" fica oculto por padrão e aparece ao clicar em um botão de ação).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Searchable Material Lookup (Priority: P1)

As an administrator, I want to quickly find a material by searching for its name or SKU so that I can view its details or verify its existence before adding a new one.

**Why this priority**: Improves administrative efficiency and prevents duplicate entries.

**Independent Test**: Go to the Materials page. Type a partial SKU or Name in the search field. Verify that suggestions appear. Select one and verify the detailed information card is populated.

**Acceptance Scenarios**:

1. **Given** the material catalog, **When** I type in the searchable input, **Then** I MUST see a filtered list of materials by SKU and Name.
2. **Given** a selected material from the list, **When** I confirm the selection, **Then** the page MUST display a detailed info card with its attributes.

### User Story 2 - Side-by-Side Detailed View & Edit (Priority: P1)

As an administrator, I want to see a detailed card of a material alongside the lookup interface and be able to edit it directly so that I can manage the catalog efficiently.

**Why this priority**: Visual consistency with operational pages and centralized management.

**Independent Test**: Search for a material. Click "Editar" in the info card. Change the wash type using radio buttons and save. Verify the update.

**Acceptance Scenarios**:

1. **Given** a selected material, **When** the info card is displayed, **Then** I MUST see a "Copiar SKU" button and an "Editar" button.
2. **Given** the edit mode, **When** I select the wash type, **Then** I MUST use radio buttons (Water/Dry).

### User Story 3 - Interactive Inventory Table (Priority: P2)

As an administrator, I want to click on items in the inventory table to pull up their full details into the information card.

**Why this priority**: Fast navigation between listed items and their detailed settings.

**Independent Test**: Click a Name or SKU in the "Itens Cadastrados" table. Verify the information card updates with that item's details.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST implement a searchable input using `<datalist>` to filter materials by Name or SKU (parity with Receiving).
- **FR-002**: System MUST display material details in a side-by-side layout card when selected or scanned.
- **FR-003**: System MUST implement a "Copiar SKU" button in the info card.
- **FR-004**: System MUST allow triggering the detailed view and edit mode from the inventory table.
- **FR-005**: System MUST use **Radio Buttons** for selecting "Tipo de Lavagem" (Água/Seco) in both Create and Edit forms.
- **FR-006**: System MUST hide the "Add Material" form by default, showing it only upon explicit user action (e.g., "Novo Material" button).
- **FR-007**: System MUST allow editing material attributes directly within the context of the detailed info card.

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5).
- **NFR-002**: Page MUST follow the "Structured Simplicity" principle.

### Key Entities

- **Material (Catalog)**: Source for the searchable list, detailed view, and CRUD operations.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: Time to find and update a specific material configuration reduced by 40%.
- **SC-002**: Visual consistency (Radio buttons, side-cards) maintained across Catalog, Receiving, Washing, and Expedition.
- **SC-003**: Zero regression in Material CRUD operations.

## Assumptions

- [Assumption]: Reuses `copyToClipboard` helper from `main.js`.
- [Assumption]: "SKU" refers to the CAT-MAT-SIZ-WASH standard.
