# Feature Specification: UX Error Handling & Feedback

**Feature Branch**: `004-improve-error-handling`  
**Created**: 2026-04-25  
**Status**: Draft  
**Input**: User description: "Improve error handling and UX feedback"

## Clarifications

### Session 2026-04-25
- Q: Fixed position for success Toasts? → A: Top-Right (Standard).
- Q: Should success/error actions trigger a sound? → A: No (Visual only).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Structured Feedback (Priority: P1)

As an operator on the laundry floor, I want to receive clear, non-blocking visual feedback when an action succeeds (e.g., status updated) and explicit, helpful alerts when an action fails, so that I can continue my work without confusion.

**Why this priority**: Industrial environments are fast-paced. Raw PHP errors or lack of clear "success" signals cause double-entries and user frustration.

**Independent Test**: Perform a status update in `pages/lavagem.php` and verify a Bootstrap Toast appears in the top-right corner with a success message, rather than just refreshing the page or showing a static top-alert.

**Acceptance Scenarios**:

1. **Given** a successful database operation, **When** the page redirects or refreshes, **Then** a Bootstrap Toast MUST be displayed in the top-right corner with the success message.
2. **Given** a validation error (e.g., empty field), **When** I submit the form, **Then** a prominent Bootstrap Alert MUST appear with a clear explanation of the fix.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: **Centralized Feedback Utility**: System MUST implement a centralized way to pass success/error messages between redirects (e.g., using `$_SESSION['flash_message']`).
- **FR-002**: **Success Toasts**: All successful operations (Create, Update, Delete) MUST be acknowledged with a Bootstrap 5 Toast notification fixed to the top-right corner.
- **FR-003**: **Structured Error Alerts**: Blocking errors MUST be displayed using Bootstrap 5 Alerts with icons (bi-exclamation-triangle) to differentiate from success.
- **FR-004**: **Client-Side Validation**: Forms MUST use HTML5 validation and Bootstrap `needs-validation` styles to provide immediate feedback before server submission.

### Non-Functional Requirements

- **NFR-001**: **Mobile Visibility**: Feedback components MUST be large enough for easy reading and interaction on 10-inch tablets.
- **NFR-002**: **Auto-Dismiss**: Success Toasts MUST auto-dismiss after 5 seconds to reduce UI clutter. Error Alerts MUST remain until manually dismissed by the user.

### Key Entities

- **Flash Message**: Transient data structure containing `type` (success/error/info) and `message` string.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: 100% of CRUD operations in `materiais.php` and `recebimento.php` provide structured feedback.
- **SC-002**: Reduction in "Double Submit" errors due to clear visual confirmation of success.
- **SC-003**: UI consistency: All error/success messages use identical styling across all pages.

## Assumptions

- Bootstrap 5 and Bootstrap Icons are already included in the project.
- PHP Sessions are used for authentication and can be leveraged for flash messages.
