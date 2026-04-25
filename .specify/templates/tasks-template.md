---
description: "Task list template for LuvaSul feature implementation"
---

# Tasks: [FEATURE NAME]

**Input**: Design documents from `/specs/[###-feature-name]/`
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

- [ ] T001 [P] Create backup of database schema (`database.sql`)
- [ ] T002 [P] Configure any new constants in `config/config.php`

## Phase 2: Foundational

- [ ] T003 Update `database.sql` with new tables/columns
- [ ] T004 Apply database changes to local environment
- [ ] T005 Create helper functions in `includes/` if needed

## Phase 3: User Story 1 - [Title] (Priority: P1)

### Implementation

- [ ] T006 [P] [US1] Create UI structure in `pages/[feature].php`
- [ ] T007 [US1] Implement DB interaction logic
- [ ] T008 [US1] Integrate with QR Code helper if applicable
- [ ] T009 [US1] Ensure Bootstrap 5 responsiveness

**Checkpoint**: User Story 1 functional and verified.
