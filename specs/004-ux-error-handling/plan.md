# Implementation Plan: UX Error Handling & Feedback

**Branch**: `004-improve-error-handling` | **Date**: 2026-04-25 | **Spec**: [specs/004-ux-error-handling/spec.md](specs/004-ux-error-handling/spec.md)
**Input**: Improve error handling and UX feedback

## Summary
Implement a centralized flash message system using PHP sessions and Bootstrap 5 UI components. Success messages will trigger auto-dismissing Toasts (Top-Right), while errors will use prominent Alerts. This ensures clear, non-blocking feedback for operators on the laundry floor.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, Bootstrap Icons, PHP Sessions
**Storage**: Transient (PHP Session)
**Testing**: Manual functional testing of CRUD redirects
**Target Platform**: Web (Mobile/Tablet optimized)
**Project Type**: Structured PHP Web Application
**Performance Goals**: Instant feedback (<100ms JS init)
**Constraints**: No external libraries beyond current stack

## Constitution Check

- [x] **I. Digital Traceability**: Improved feedback confirms successful QR scanning and entry.
- [x] **II. Process Integrity**: Error alerts block out-of-order or invalid status updates.
- [x] **III. Structured Simplicity**: Uses standard PHP sessions and Bootstrap 5; no heavy JS frameworks.
- [x] **IV. Data Fidelity**: Clear errors prevent invalid data entry.
- [x] **V. Mobile-Responsive**: Bootstrap 5 components optimized for touch interaction on tablets.

## Project Structure

### Documentation (this feature)

```text
specs/004-ux-error-handling/
├── plan.md              # This file
├── research.md          # Feedback component decisions
├── data-model.md        # Session data structure
└── tasks.md             # Generated via /speckit.tasks
```

### Source Code Changes

```text
assets/
├── js/main.js           # Toast initialization & Client-side validation
includes/
├── header.php           # Global alert/toast container & Session check
└── session_helper.php   # NEW: Flash message getter/setter
pages/
└── materials.php        # Refactor to use new feedback system
```

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
