# Feature Specification: Managerial Reports Refactor

**Feature Branch**: `011-managerial-reports-refactor`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "agora vamos para a tela de relatorios, faca ela parecer esteticamente como a de dashboards (na tela de dashboards vamos fazer com que os status tenham cores parecidas com as cores dos status da tela de relatorios e faca os cards ficarem dinamicos na tela de dashboards e tambem os cards na tela de relatorios) eu gostei da maneira que ficou o fluxo de interacao na tela de materiais, vamos adaptar a tela de relatorios um fluxo parecido quando se clica em algum pedido ou cliente etc. basicamente vamos fazer com que nesta tela fiquem os relatorios relevantes para a gerencia, portanto foque em exibir os kpis e okrs relevantes de variavel nivel de granulacao."

## Clarifications

### Session 2026-04-26
- Q: Cálculo do Lead Time Médio → A: Opção A como métrica primária (Pedidos Expedidos), com as opções B (Tempo de Fluxo) e C (Tempo por Etapa) disponíveis como indicadores opcionais/detalhados.
- Q: Visualização de OKRs → A: Média comparativa simples em relação ao mês anterior. O objetivo é ver o progresso sem a pressão de metas fixas que se tornam inalcançáveis, mantendo o foco na tendência de melhoria.

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Unified Managerial Aesthetic (Priority: P1)

As a manager, I want the Reports screen to share the same visual language as the Dashboard (header-inline stats, dynamic cards) so that I have a cohesive experience across all monitoring views.

**Why this priority**: Brand and UI consistency reduces friction and makes the system feel more professional.

**Independent Test**: Navigate between Dashboard and Reports. Verify that header layout, stat indicators, and status colors (badges/labels) are identical.

**Acceptance Scenarios**:

1. **Given** the Reports page, **When** it loads, **Then** it MUST show dynamic summary cards at the top (Total, Pending, Completed) matching the Dashboard's header-stat style.
2. **Given** any status badge (e.g., "Expedido"), **When** viewed on either Dashboard or Reports, **Then** the color MUST be consistent (e.g., Success green for Expedido).

### User Story 2 - Contextual Detail Flow (Priority: P1)

As a manager, I want to click on an order or client in the reports table to see full details in a side-card so that I can drill down into specific data without losing my place in the list.

**Why this priority**: High-density data requires contextual drill-down for efficient decision-making. Matches the "Materials" interaction pattern.

**Independent Test**: Click an Order ID or Client Name in the reports table. Verify that a side-card (Detailed Info Card) appears with full order history and attributes.

**Acceptance Scenarios**:

1. **Given** the report list, **When** I click a row or identifier, **Then** the system MUST display a side-by-side layout (col-md-6/col-md-6) with the detailed record on the right.

### User Story 3 - KPI & OKR Focus (Priority: P2)

As a manager, I want to see high-level metrics like throughput and lead time so that I can monitor business performance at different levels of granularity.

**Why this priority**: Operational reporting is for operators; managerial reporting is for strategy and optimization.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST refactor the Reports page header to use inline stats (mini-stat cards) identical to the Dashboard.
- **FR-002**: System MUST unify status colors across the whole application (Recebido: Secondary, Lavagem: Warning, Expedido/Concluído: Success).
- **FR-003**: System MUST implement a side-by-side interaction pattern for Reports: Table on left, Detailed Card on right (parity with Materials page).
- **FR-004**: System MUST update the Reports table to be clickable (identifiers like ID, Client).
- **FR-005**: System MUST display Managerial KPIs in the dynamic cards:
    - Total Processed Volume.
    - Average Processing Time (Lead Time) - Primary: Completed orders; Optional: Open orders and per-step breakdown.
    - Pending Backlog.
- **FR-006**: System MUST display a simple OKR indicator showing the average volume/performance compared to the previous month.
- **FR-007**: System MUST allow filtering reports by time range (granularity: daily, weekly, monthly).

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5).
- **NFR-002**: Complex KPI calculations MUST be optimized to load the page in under 2 seconds.

### Key Entities

- **Report Record**: The granular data row.
- **KPI Metrics**: Aggregated business signals.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: 100% color consistency for status badges between Dashboard and Reports.
- **SC-002**: Drill-down to order details takes 1 click and 0 page transitions (in-page reload or JS toggle).
- **SC-003**: Reports page aesthetics are rated "Identical" in structure to Dashboard by stakeholders.

## Assumptions

- [Assumption]: Lead time is calculated as (Expedido Data - Cadastro Data).
- [Assumption]: Dashboard header logic will be extracted or mirrored to ensure exact parity.
- [Assumption]: Side-card implementation follows the pattern established in feature 010.
