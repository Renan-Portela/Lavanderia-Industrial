# Feature Specification: Dashboard UI Refactor

**Feature Branch**: `006-dashboard-ui-refactor`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "vamos refatorar as telas, vamos comecar pelo dashboard, gostaria que nela os cards de quantidades, gostaria que ele fiquem ao lado do h1 page title, e onde os cards estao atualmente que fiquem as acoes rapidas elas ficariam melhor na horizontal mas sobre esta parte faca da melhor forma, abaixo destes cards coloque os pedidos recentes de maneira que fique de rapida visualizacao."

## Clarifications

### Session 2026-04-26
- Q: Visual Style for Header Counters → A: Option B (Mini-stat cards) enriched with icons and tooltips.
- Q: Format of Recent Orders → A: Option A (Full-width enriched table) including a visual progress indicator for each order.

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Optimized Dashboard Layout (Priority: P1)

As an industrial laundry operator, I want to see a more compact and actionable dashboard so that I can quickly monitor system status and perform daily tasks without excessive scrolling.

**Why this priority**: The dashboard is the primary workspace. Optimizing layout reduces cognitive load and operational friction.

**Independent Test**: Log in to the system. Verify that quantity counters are in the top header row, quick action buttons are horizontal across the main content area, and the recent orders list occupies the full width below them.

**Acceptance Scenarios**:

1. **Given** an authenticated user, **When** they access the dashboard, **Then** the page title and status counters (Recebidos, Lavagem, Expedição, Concluídos) MUST be displayed on the same horizontal row using mini-cards with icons.
2. **Given** the dashboard content, **When** viewing the "Quick Actions" section, **Then** the primary action buttons MUST be arranged horizontally across the page width.
3. **Given** the dashboard content, **When** viewing "Recent Orders", **Then** the table MUST occupy the full available width and include a visual progress bar or indicator for each order lifecycle.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST display the four main status counters (Recebidos, Lavagem, Expedição, Concluídos) as mini-stat cards integrated into the top header row next to the page title, including icons and descriptive tooltips.
- **FR-002**: System MUST display quick action buttons (Novo Recebimento, Iniciar Lavagem, Expedir Pedido, Relatórios) in a horizontal grid or row layout in the primary dashboard area.
- **FR-003**: System MUST display the "Recent Orders" table below the quick actions, expanding to the full container width.
- **FR-004**: System MUST include a visual progress indicator (e.g., progress bar or stepped indicator) within the "Recent Orders" table for each entry.
- **FR-005**: System MUST maintain real-time accuracy of counters and recent orders list as per current functionality.

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5), ensuring counters stack gracefully on mobile devices.
- **NFR-002**: Workflow MUST align with LuvaSul process integrity (Principle II).
- **NFR-003**: The refactored layout MUST improve vertical space utilization by at least 20% on standard tablet resolutions.

### Key Entities

- **Dashboard**: The main operational view for logged-in users.
- **Status Counters**: Aggregated counts of orders in each lifecycle stage.
- **Recent Orders**: A list of the most recently created or updated orders.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: "Recent Orders" visible on initial page load without scrolling on 1080p displays.
- **SC-002**: Average time to locate and click a "Quick Action" is reduced (qualitative assessment of "horizontal" accessibility).
- **SC-003**: Progress status of any order can be identified in under 1 second of visual scanning.

## Assumptions

- [Assumption]: Bootstrap 5 flexbox utilities will be used for the header alignment.
- [Assumption]: The current SQL queries for counters and recent orders remain unchanged.
- [Assumption]: Mobile responsiveness will prioritize stacking counters above the title if space is insufficient.
