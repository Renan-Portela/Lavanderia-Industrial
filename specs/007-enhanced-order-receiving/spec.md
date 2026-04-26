# Feature Specification: Enhanced Order Receiving

**Feature Branch**: `007-enhanced-order-receiving`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "vamos agora ir para a tela de Recebimento de pedidos, vamos modificar o item obrigatorio de descricao do material, e na parte de selecao de sku se for possivel, deixe uma forma de escrever ou o inicio do sku ou o inicio do material para selecionar ele deixe o titulo como categoria e o operador/funcionario seleciona ou pelo sku ou pelo material, na parte de quantidade de material temos um problema, porque, caso o item que for selecionado for por exemplo botas, serao pares de unidade o meio de contar a quantidade, agora, se for por exemplo, pano azul de usinagem, sera a quantidade em kg, e se for luvas, dependendo da quantidade e mais facil selecionar por kg ao inves de unidades. como vamos deixar o campo de descricao do material somente deixe o campo de observacoes. Quando preencher um recebimento, vamos colocar um botao para copiar o pedido, este botao ou quando ver os pedidos em forma de tabela vamos fazer com que quando o operador clicar em um pedido o codigo do pedido sera copiado para o clipboard do computador. o pdf para imprimir precisa ser funcional para uma impressora simples, entao tente modificar como o pdf sera gerado para a impressao, caso isso ser muito complexo para este escopo de agora, crie uma outra branch para resolver isso depois."

## Clarifications

### Session 2026-04-26
- Q: Schema de Unidades de Medida → A: Adicionar coluna `unidade` (ENUM 'UN', 'KG') na tabela `pedidos` e alterar `quantidade` para `DECIMAL(10,2)`.
- Q: Seleção de Unidade na UI → A: Usar **Radio Buttons** para o operador escolher entre UN (Unidades/Pares) e KG (Quilos).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Searchable Category Selection (Priority: P1)

As an operator, I want to find a material category by typing either its SKU or its name so that I can quickly register a shipment without scrolling through a long list.

**Why this priority**: Speed and accuracy at the receiving gate.

**Independent Test**: Type "LUV" in the Category field and see both "Luvas" and any SKU starting with "LUV" appearing in suggestions.

**Acceptance Scenarios**:

1. **Given** the receiving form, **When** I type in the "Categoria" field, **Then** the system filters existing Materials by Name and SKU.

### User Story 2 - Flexible Units of Measurement (Priority: P1)

As an operator, I want the system to handle different units (KG vs Units) via radio buttons so that I can record quantities accurately according to the material's nature.

**Why this priority**: Essential for inventory accuracy (boots in pairs, cloths/gloves often in kg).

**Independent Test**: Select "KG" radio button and enter "12.50"; verify the value is saved exactly as entered.

**Acceptance Scenarios**:

1. **Given** the receiving form, **When** I select "UN" or "KG", **Then** the system records that specific unit for the order.
2. **Given** an entry in KG, **When** I enter a decimal value, **Then** the system stores it with two decimal places.

### User Story 3 - Clipboard Quick Copy (Priority: P2)

As an operator, I want to click on an order code to copy it to my clipboard so that I can easily paste it into other tracking documents or labels.

**Why this priority**: Operational efficiency and reduction of manual typing errors.

**Independent Test**: Click an order code in the table and verify it can be pasted into a text editor.

**Acceptance Scenarios**:

1. **Given** a list of orders or a success message, **When** I click the order code, **Then** the system copies "PEDIDO-XXX" to the clipboard.

### User Story 4 - Simplified Printer PDF (Priority: P2)

As an operator, I want a PDF label that is simple and works with basic printers so that I can physically tag shipments.

**Why this priority**: Physical tracking requires legible labels.

**Independent Test**: Generate the PDF and verify it prints clearly on a standard black and white printer without heavy graphics.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST provide a searchable input (Datalist or searchable select) for "Categoria" filtering by SKU or Name.
- **FR-002**: System MUST remove the mandatory "Descrição do Material" requirement and field, replacing it with an optional "Observações" field.
- **FR-003**: System MUST support dynamic units (KG and UN) selected via **Radio Buttons**.
- **FR-004**: System MUST store the unit type (`unidade`) and a decimal quantity (`quantidade`) in the database.
- **FR-005**: System MUST implement a "Click-to-Copy" feature for order codes using the Clipboard API.
- **FR-006**: System MUST generate a simplified, printer-friendly PDF label for orders.

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5).
- **NFR-002**: Clipboard copy MUST provide visual feedback (e.g., small toast or icon change).
- **NFR-003**: Searchable select MUST respond within 200ms for up to 1000 items.

### Key Entities

- **Pedido (Order)**: Stores `quantidade` (Decimal) and `unidade` (ENUM).
- **Material (Category)**: Source for the searchable list.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: Time to register an order reduced by 30% due to searchable categories and removed fields.
- **SC-002**: 100% of order codes clicked are successfully copied to clipboard.
- **SC-003**: PDF labels are readable on standard 300dpi office printers.

## Assumptions

- [Assumption]: Database schema for `pedidos` will be updated via migration or script.
- [Assumption]: JavaScript is enabled for the Searchable Select, Radio Button logic, and Clipboard functionality.
