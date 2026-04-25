# Tasks: UX Error Handling & Feedback

**Input**: Design documents from `/specs/004-ux-error-handling/`
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

- [x] T001 [P] Create backup of database schema (`database.sql`)
- [x] T002 [P] Verify `session_start()` is called in `includes/auth_helper.php` or `config/config.php`

## Phase 2: Foundational

- [x] T003 [P] Create `includes/session_helper.php` with `setFlash()` and `getFlash()` functions
- [x] T004 [P] Update `assets/js/main.js` to initialize Bootstrap 5 Toasts and enable `needs-validation` client-side feedback
- [x] T005 [P] Add global Toast container and Alert display logic in `includes/header.php`

## Phase 3: User Story 1 - Structured Feedback (Priority: P1)

### Implementation

- [x] T006 [US1] Refactor `pages/login.php` to use the new session-based feedback system
- [x] T007 [US1] Refactor `pages/materiais.php` to use `setFlash()` for success/error messages instead of local variables
- [x] T008 [US1] Update `pages/recebimento.php` to implement session-based feedback for order creation
- [x] T009 [US1] Update `pages/lavagem.php` and `pages/expedicao.php` to show Toasts on successful status transitions
- [x] T010 [US1] Ensure all forms in operational pages use Bootstrap 5 `needs-validation` class

**Checkpoint**: User Story 1 functional and verified. Success Toasts appear top-right; Error Alerts appear in-page.

## Final Phase: Polish & Cross-Cutting Concerns

- [x] T011 [P] Audit all `pages/` for any remaining raw PHP error echoes and replace with standardized alerts
- [x] T012 [P] Verify Toast auto-dismiss timing (5s) and Alert manual dismissal on 10-inch tablet resolution

## Dependencies

1. Phase 2 (Foundational) must be completed before Phase 3 (User Stories) to provide the utility functions and UI components.

## Parallel Execution Examples

- T003 (PHP logic) and T004 (JS logic)
- T011 (Audit) and T012 (UX Verification)

## Implementation Strategy

- **MVP first**: Implement the session helper and header display logic first so that refactoring of existing pages can proceed incrementally.
- **Incremental delivery**: User Story 1 covers all operational pages, which can be updated one by one.
