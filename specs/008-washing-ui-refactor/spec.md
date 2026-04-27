# Feature Specification: Washing UI Refactor

**Feature Branch**: `008-washing-ui-refactor`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "vamos agora para tela de Lavagem, vamos fazer com que quando o cliente escanear um pedido ele aparece ao lado do menu de leitura de qr code informando o tipo do material, kg ou unidade, o cliente e qualquer descricao escrita no recebimento, se nao tiver nada escrito nao aparece esta parte de descricao escrita. ja na parte da tabela de pedidos, mostre o id cliente sku e na descricao sera descrito o que a sku significa, ou seja, somente a descricao de acordo com o catalogo, na parte de quantidade, mostrar se e unidade ou kg no item da tabela, por exemplo, 10 und. ou entao 100 kg. e o campo de data esta bom do jeito que esta."

## Clarifications

### Session 2026-04-26
- Q: Comportamento do Card de Informações → A: Único (Mostrar apenas os detalhes do pedido mais recentemente escaneado, pois a tabela abaixo já fornece o histórico operacional).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Detailed Scan Information (Priority: P1)

As an operator, when I scan an order QR code in the Washing page, I want to see immediate details about the order so that I can verify I have the correct batch and know its specific handling requirements.

**Why this priority**: Essential for process accuracy and quality control at the washing stage.

**Independent Test**: Scan a known order. Verify that the Material Type, Unit (KG/UN), Client Name, and Observations are displayed prominently next to the scan input.

**Acceptance Scenarios**:

1. **Given** a scanned order with observations, **When** the information card is displayed, **Then** I MUST see the "Observações" field with the content entered during receiving.
2. **Given** a scanned order without observations, **When** the information card is displayed, **Then** the "Observações" section MUST be hidden.
3. **Given** a scanned order, **When** the information card is displayed, **Then** the quantity MUST include the unit suffix (e.g., "15.00 kg" or "50 und.").
4. **Given** multiple sequential scans, **When** a new QR is read, **Then** the information card MUST update to show ONLY the current order details.

### User Story 2 - Clear Operational Table (Priority: P1)

As an operator, I want to see a clear list of orders currently in the washing process so that I can track the floor status at a glance.

**Why this priority**: Core operational visibility for the washing department.

**Independent Test**: View the "Pedidos em Lavagem" table. Verify the columns show ID, Client, SKU, SKU Meaning (Catalog Description), and Quantity with Units.

**Acceptance Scenarios**:

1. **Given** the "Pedidos em Lavagem" table, **When** viewing the "Descrição" column, **Then** it MUST show the name/description from the Material Catalog associated with that SKU.
2. **Given** the "Pedidos em Lavagem" table, **When** viewing the "Quantidade" column, **Then** it MUST show the formatted value followed by "kg" or "und.".

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST display scanned order details (Client, Material Type, Quantity + Unit, Observations) in a side-by-side layout with the QR input on desktop screens.
- **FR-002**: System MUST hide the "Observações" section in the scan info card if the field is empty or null in the database.
- **FR-003**: System MUST update the "Pedidos em Lavagem" table columns:
    - **ID**: Order ID.
    - **Cliente**: Client name.
    - **SKU**: Catalog SKU.
    - **Descrição**: Catalog Material Name (meaning of the SKU).
    - **Quantidade**: Formatted quantity with unit suffix (e.g., "10.00 kg" or "10 und.").
    - **Data**: Keep current formatting.
- **FR-004**: System MUST perform a JOIN with the `materiais` table to retrieve catalog descriptions for the table view.

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5). On mobile, information card should stack below the QR input.
- **NFR-002**: Data loading for the table MUST be efficient (JOIN on indexed columns).
- **NFR-003**: Labels and units MUST follow Portuguese (pt-BR) conventions.

### Key Entities

- **Pedido (Order)**: Primary source for scan info and table rows.
- **Material (Catalog)**: Source for SKU and SKU meaning (Description/Name).

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: 100% of scanned orders show correct units (KG/UN) as recorded during receiving.
- **SC-002**: Zero manual calculation needed by the operator to know the "meaning" of a SKU in the table.
- **SC-003**: 0% regression in the status transition logic (Recebido -> Lavagem).

## Assumptions

- [Assumption]: The `unidade` and `quantidade` (decimal) fields from feature 007 are available and populated.
- [Assumption]: "SKU Meaning" refers to the `nome` field in the `materiais` table.
- [Assumption]: Observations refer to the `observacao` field in the `pedidos` table.
