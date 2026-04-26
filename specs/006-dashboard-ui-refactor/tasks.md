# Tasks: Dashboard UI Refactor

**Input**: Design documents from `/specs/006-dashboard-ui-refactor/`
**Prerequisites**: plan.md (required), spec.md (required)

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Parallelizable
- **[Story]**: US1, US2, etc.
- Include exact file paths in `pages/`, `includes/`, etc.

## Path Conventions (LuvaSul)

- **Pages**: `pages/*.php`
- **Common Logic**: `includes/*.php`
- **Assets**: `assets/css/style.css`, `assets/js/main.js`
- **Database**: `database.sql`

## Phase 1: Setup

- [x] T001 [P] Backup current `index.php` for safe refactoring

## Phase 2: Foundational

- [x] T002 [P] Define mini-stat card and horizontal action styles in `assets/css/style.css`
- [x] T003 [P] Define progress indicator CSS in `assets/css/style.css` for order tracking

## Phase 3: User Story 1 - Optimized Dashboard Layout (Priority: P1)

### Story Goal
Refactor the dashboard layout to be more compact, moving counters to the header and organizing actions horizontally.

### Independent Test Criteria
Log in and verify: title and counters are on one row, actions are horizontal, and recent orders table is full-width with progress bars.

### Implementation

- [x] T004 [US1] Refactor `index.php` header to use a flex container for the page title and mini-stat cards
- [x] T005 [US1] Implement tooltips for mini-stat cards in `index.php` to provide status descriptions
- [x] T006 [US1] Reposition "Quick Actions" in `index.php` into a horizontal row/grid layout below the header
- [x] T007 [US1] Expand "Recent Orders" table in `index.php` to 100% width, removing the side-by-side card layout
- [x] T008 [US1] Add "Progresso" column to recent orders table in `index.php` with visual indicators (Bootstrap progress bars)
- [x] T009 [US1] Update `index.php` responsiveness utilities to ensure counters stack correctly on mobile devices

**Checkpoint**: User Story 1 functional and verified.

## Phase 4: Polish & Cross-cutting Concerns

- [x] T010 [P] Fine-tune spacing and alignment of header elements for various tablet resolutions
- [x] T011 [P] Verify performance impact of new CSS and DOM structure (target <1s load)

## Dependencies
- All implementation tasks (T004-T009) depend on foundational styles (T002, T003).

## Implementation Strategy
- **Incremental Refactor**: Apply header changes first (T004, T005), followed by actions (T006), then table (T007, T008).
- **Mobile First**: Continuously test responsiveness during layout changes.
