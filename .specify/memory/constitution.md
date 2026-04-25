<!--
Sync Impact Report:
- Version change: [TEMPLATIZED] → 1.0.0
- List of modified principles:
  - [PRINCIPLE_1_NAME] → I. Digital Traceability (QR Code First)
  - [PRINCIPLE_2_NAME] → II. Process Integrity (Strict Workflow)
  - [PRINCIPLE_3_NAME] → III. Structured Simplicity (No-Framework PHP)
  - [PRINCIPLE_4_NAME] → IV. Data Fidelity & Reporting
  - [PRINCIPLE_5_NAME] → V. Mobile-Responsive Operational Design
- Added sections: Technical & Security Constraints, Infrastructure & Deployment
- Removed sections: None
- Templates requiring updates:
  - .specify/templates/plan-template.md (✅ updated)
  - .specify/templates/spec-template.md (✅ updated)
  - .specify/templates/tasks-template.md (✅ updated)
- Follow-up TODOs: None
-->

# LuvaSul Lavanderia Industrial Constitution

## Core Principles

### I. Digital Traceability (QR Code First)
Every material entry MUST generate a unique QR Code for end-to-end tracking. Manual recording is strictly prohibited for core operational steps (Receiving, Washing, Expedition). This ensures a searchable, auditable digital trail for every item processed.

### II. Process Integrity (Strict Workflow)
Orders MUST follow the defined workflow: Recebimento → Lavagem → Expedição. The system MUST prevent out-of-order status updates. This constraint is non-negotiable to maintain data integrity and accurate operational reporting.

### III. Structured Simplicity (No-Framework PHP)
The application MUST use structured PHP without heavy frameworks to ensure the codebase remains accessible for long-term internal maintenance. Prioritize standard web primitives and Bootstrap 5 for the UI to minimize dependency bloat.

### IV. Data Fidelity & Reporting
All status changes and quantities MUST be logged accurately. Real-time dashboards and CSV exports are the primary source of truth for operational audits. Data persistence must favor consistency over availability in case of conflicts.

### V. Mobile-Responsive Operational Design
The interface MUST be fully responsive and optimized for touch-based interactions on the laundry floor using Bootstrap 5. Every operational screen must be usable on a standard tablet or mobile device.

## Technical & Security Constraints
The system requires PHP 7.4+ and MySQL 5.7+ with the GD extension enabled for image processing. All user inputs MUST be sanitized using MySQLi prepared statements to prevent SQL injection. Database credentials MUST be secured in config/config.php and never committed to source control (use .gitignore for local overrides).

## Infrastructure & Deployment
The qrcodes/ directory MUST have write permissions (777) for the web server user. QR Code generation defaults to the QR Server API but allows for local fallback via Composer. Development should use the PHP built-in server, while production targets Apache/Nginx.

## Governance
This constitution is the foundational document for LuvaSul software development. All feature implementations and refactors MUST align with these principles. Amendments require documented justification, a version bump, and a consistency check across all project templates.

All PRs and code reviews must verify compliance with these principles. Use GEMINI.md for specific runtime development guidance and standard command references.

**Version**: 1.0.0 | **Ratified**: 2026-04-24 | **Last Amended**: 2026-04-24
