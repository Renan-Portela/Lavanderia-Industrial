# Research: UX Error Handling & Feedback

## Decision: Flash Message Implementation
**Decision**: Use `$_SESSION['flash']` array to store transient messages.
**Rationale**: Simple, effective for PRG (Post-Redirect-Get) pattern. No database overhead.
**Format**: `$_SESSION['flash'] = ['type' => 'success|danger|warning', 'message' => '...']`

## Decision: Feedback Components
**Decision**: 
- **Success**: Bootstrap 5 Toasts (Top-Right, Auto-dismiss 5s).
- **Error**: Bootstrap 5 Alerts (Inside form/top of page, manual dismiss).
**Rationale**: Toasts are non-intrusive for success. Alerts ensure critical errors aren't missed.

## Decision: JS Implementation for Toasts
**Decision**: Initialize Toasts in `assets/js/main.js`.
**Rationale**: Centralized JS allows any page to trigger toasts by rendering the standard HTML structure.
