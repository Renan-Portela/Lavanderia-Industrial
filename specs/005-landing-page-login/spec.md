# Feature Specification: Landing Page with Login

**Feature Branch**: `005-landing-page-login`  
**Created**: 2026-04-26  
**Status**: Draft  
**Input**: User description: "Crie uma landing page para este projeto e deixe um botao para fazer login"

## Clarifications

### Session 2026-04-26
- Q: Landing Page Content → A: Option A (Minimalist: Header, Service List - Recebimento, Lavagem, Expedição, and prominent Login button).
- Q: Access Control Strategy → A: Option A (Conditional rendering in `index.php` based on `SessionManager::isLoggedIn()`).
- Q: Site Logo and Branding → A: Option A (Icon-based: Use current Navbar branding - Bootstrap Icon + SITE_NAME).

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Public visitor accesses the site (Priority: P1)

A public visitor navigates to the root URL and sees a professional landing page describing the service instead of being immediately forced to log in.

**Why this priority**: Improves the first impression of the software and provides context to new users.

**Independent Test**: Open the root URL in an incognito browser window. The user should see a landing page, not the login form.

**Acceptance Scenarios**:

1. **Given** an unauthenticated user, **When** they visit `index.php`, **Then** they see a landing page with "Login" button.

### User Story 2 - User clicks Login button (Priority: P1)

The visitor decides to log in and clicks the prominent button on the landing page.

**Why this priority**: Essential for moving users into the operational part of the system.

**Independent Test**: Click the "Entrar" or "Login" button on the landing page.

**Acceptance Scenarios**:

1. **Given** the user is on the landing page, **When** they click the login button, **Then** they are redirected to `pages/login.php`.

---

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST allow access to the landing page without authentication.
- **FR-002**: System MUST display a landing page at `index.php` for unauthenticated users.
- **FR-003**: System MUST provide a "Login" button that redirects to the login page.
- **FR-004**: System MUST redirect authenticated users from the landing page to the Dashboard using `SessionManager::isLoggedIn()`.
- **FR-005**: Landing page MUST contain a brief overview of the LuvaSul industrial laundry services focusing on Recebimento, Lavagem, and Expedição.
- **FR-006**: Landing page MUST use the standard site branding (icon + SITE_NAME) for visual consistency.

### Non-Functional Requirements

- **NFR-001**: UI MUST be responsive (Bootstrap 5) for mobile and tablet use.
- **NFR-002**: Page MUST follow the "Structured Simplicity" principle from the Constitution.
- **NFR-003**: Landing page MUST load in under 1.5 seconds on a standard 4G connection.

### Key Entities

- **Landing Page**: The initial entry point for unauthenticated users.
- **User Session**: Determines whether to show the landing page or the dashboard.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: 100% of unauthenticated requests to the home page see the landing page instead of a redirect to login.
- **SC-002**: Navigation from landing page to login page takes exactly 1 click.

## Assumptions

- **A-001**: The existing `index.php` (Dashboard) logic will be wrapped in a conditional block based on session state.
- **A-002**: The content of the landing page will be in Portuguese (pt-BR).
- **A-003**: The landing page will use the existing `assets/css/style.css` for consistent styling.
