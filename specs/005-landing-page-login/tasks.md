# Tasks: Landing Page with Login

**Input**: Design documents from `/specs/005-landing-page-login/`
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

- [x] T001 [P] Ensure session constants and `SessionManager` are available via `includes/auth_helper.php`

## Phase 2: Foundational

- [x] T002 [P] Add landing page section styles to `assets/css/style.css` (Hero, Service Cards, Login Button)

## Phase 3: User Story 1 - Public visitor accesses the site (Priority: P1)

### Story Goal
Provide a minimalist entry point at `index.php` for unauthenticated users highlighting core services.

### Independent Test Criteria
Open root URL in incognito window; verify landing page with services (Recebimento, Lavagem, Expedição) and "Entrar" button appears.

### Implementation

- [x] T003 [US1] Wrap existing dashboard logic in `index.php` with `if (SessionManager::isLoggedIn()):` check
- [x] T004 [US1] Implement landing page HTML structure in `index.php` (else block) using Bootstrap 5 grid
- [x] T005 [US1] Add service overview sections (Recebimento, Lavagem, Expedição) to landing page in `index.php`
- [x] T006 [US1] Implement "Entrar" button in landing page section of `index.php` pointing to `pages/login.php`
- [x] T007 [US1] Update `includes/header.php` to hide operational navigation links when user is not logged in

**Checkpoint**: User Story 1 functional and verified.

## Phase 4: User Story 2 - User clicks Login button (Priority: P1)

### Story Goal
Ensure smooth transition from public landing page to secure operational login.

### Independent Test Criteria
Click "Entrar" on landing page; verify redirection to `pages/login.php` and successful dashboard access after auth.

### Implementation

- [x] T008 [US2] Verify `pages/login.php` redirects to `index.php` (Dashboard view) upon successful authentication
- [x] T009 [US2] Ensure standard site branding (icon + SITE_NAME) is visible and consistent on landing page

**Checkpoint**: User Story 2 functional and verified.

## Phase 5: Polish & Cross-cutting Concerns

- [x] T010 [P] Verify Bootstrap 5 responsiveness for landing page on mobile and tablet devices
- [x] T011 [P] Verify landing page load performance (target <1.5s)
- [x] T012 Remove any temporary debugging code or placeholders

## Dependencies
- US1 (Public Landing Page) must be implemented to provide the button for US2.
- All US1 tasks depend on T002 (Foundational Styles).

## Implementation Strategy
1. **MVP**: Implement T003 and T004 first to establish the conditional view.
2. **Incremental**: Add service descriptions (T005) then style (T002).
3. **Validation**: Test incognito vs logged-in state after each major change to `index.php`.
