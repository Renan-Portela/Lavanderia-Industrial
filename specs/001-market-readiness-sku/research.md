# Research: Market Readiness & SKU Standardization

## Decision: Testing Framework
- **Chosen**: **PHPUnit**
- **Rationale**: Industry standard, extensive documentation, and easy integration even in no-framework projects.
- **Alternatives considered**:
  - Pest: Excellent, but requires PHP 8.1+. Project currently targets 7.4+.
  - SimpleTest: Lightweight but less modern and lacks some reporting features of PHPUnit.
  - Manual asserts: Rejected as it doesn't scale for market readiness.

## Decision: Authentication Mechanism
- **Chosen**: **Session-based with bcrypt hashing**
- **Rationale**: Simple, secure, and fits perfectly with structured PHP. Uses native `password_hash()` and `password_verify()`.
- **Alternatives considered**:
  - JWT: Overkill for this monolithic application.
  - Hardcoded credentials: Rejected as insecure and not scalable.

## Decision: SKU Standardization Pattern
- **Chosen**: `[CAT]-[MAT]-[SIZ]` (e.g., `GLV-IND-XL`)
- **Rationale**: Concise, human-readable, and follows industrial laundry best practices.
  - `CAT`: Category (3 chars)
  - `MAT`: Material/Type (3 chars)
  - `SIZ`: Size (1-3 chars)
- **Alternatives considered**:
  - Sequential numbers only: Rejected as they lack descriptive value for operators.
  - Free-text: Current state, rejected for data inconsistency.

## Decision: Architectural Refactoring
- **Chosen**: **Service-oriented helpers in `includes/`**
- **Rationale**: Separation of business logic from UI.
  - Initialize Composer to provide PSR-4 autoloading.
  - Move core logic (Status transitions, QR generation, Material validation) into classes under `src/`.
  - UI pages in `pages/` will use these services.
- **Alternatives considered**:
  - Full Framework (Laravel/Slim): Rejected due to Constitution Principle III (Structured Simplicity).
  - Procedural logic in pages: Current state, rejected as it makes automated testing nearly impossible.
