# Research: Landing Page with Login

## Decision 1: Landing Page Layout
- **Decision**: Minimalist design with a header, services overview, and prominent login button.
- **Rationale**: Follows "Structured Simplicity" (Principle III) and was confirmed during clarification.
- **Alternatives considered**: Marketing-heavy banner (rejected for being too complex and less aligned with the constitution).

## Decision 2: Landing Page vs Dashboard (index.php)
- **Decision**: Use `index.php` as a controller using `SessionManager::isLoggedIn()`.
- **Rationale**: Simplest implementation without complex routing or moving files.
- **Implementation**: 
  ```php
  if (SessionManager::isLoggedIn()) {
      // Render Dashboard
  } else {
      // Render Landing Page
  }
  ```

## Decision 3: Branding & Assets
- **Decision**: Use existing Bootstrap Icons and `SITE_NAME` from config.
- **Rationale**: Ensures visual consistency with the rest of the application without adding new image dependencies.
- **Alternatives considered**: Custom logo image (rejected to avoid additional asset management).

## Decision 4: Responsive Design
- **Decision**: Use Bootstrap 5 grid and utility classes.
- **Rationale**: Mandated by Principle V of the constitution.
