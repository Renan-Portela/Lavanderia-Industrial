# Implementation Plan: Landing Page with Login

**Branch**: `main` | **Date**: 2026-04-26 | **Spec**: [specs/005-landing-page-login/spec.md](specs/005-landing-page-login/spec.md)
**Input**: Feature specification from `/specs/005-landing-page-login/spec.md`

## Summary

The landing page will provide a professional entry point for unauthenticated users, explaining the core services of LuvaSul (Recebimento, Lavagem, Expedição) and providing a clear path to login. Technically, `index.php` will act as a conditional controller, rendering either the Landing Page or the existing Dashboard based on the user's session state.

## Technical Context

**Language/Version**: PHP 7.4+
**Primary Dependencies**: Bootstrap 5, MySQLi
**Storage**: MySQL / MariaDB (Existing `pedidos` table for dashboard stats)
**Testing**: Manual functional testing (Incognito for landing page, Authenticated for dashboard)
**Target Platform**: Web
**Project Type**: Structured PHP Web Application
**Performance Goals**: <1s load for landing page.
**Constraints**: Mobile-first design (Principle V).
**Scale/Scope**: Industrial laundry operations.

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

- [x] **I. Digital Traceability**: Feature does not interfere with QR tracking.
- [x] **II. Process Integrity**: Landing page highlights the correct workflow (Recebimento → Lavagem → Expedição).
- [x] **III. Structured Simplicity**: Implemented using basic PHP conditional logic in `index.php`. No frameworks added.
- [x] **IV. Data Fidelity**: Session state accurately determines the view.
- [x] **V. Mobile-Responsive**: UI built with Bootstrap 5 components.

## Project Structure

### Documentation (this feature)

```text
specs/005-landing-page-login/
├── plan.md              # This file
├── research.md          # Research findings
├── data-model.md        # Session and view state
├── quickstart.md        # Verification steps
├── contracts/           # Internal view logic
└── tasks.md             # Implementation tasks
```

### Source Code (repository root)

```text
index.php                # UPDATED: Conditional rendering logic
includes/
├── header.php           # UPDATED: Navbar logic for unauthenticated users
└── footer.php           # Standard footer
assets/
└── css/
    └── style.css        # Minimalist landing page styles
```

**Structure Decision**: Maintain `index.php` as the root entry point to avoid breaking existing bookmarks or internal links.

## Complexity Tracking

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [N/A]     | [N/A]      | [N/A]                               |
