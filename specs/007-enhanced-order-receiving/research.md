# Research: Enhanced Order Receiving

## Decision 1: Database Schema Update
- **Decision**: Add `unidade` (ENUM 'UN', 'KG') and change `quantidade` to `DECIMAL(10,2)`.
- **Rationale**: Support for fractional weights (KG) and clear unit tracking.
- **Alternatives considered**: Storing as integer (grams) - rejected for complexity in display logic.

## Decision 2: Searchable Category Input
- **Decision**: Use HTML5 `<datalist>` combined with existing material data.
- **Rationale**: Follows "Structured Simplicity" (Principle III) by using standard web primitives instead of heavy JS libraries.
- **Implementation**: Populate `<datalist>` with "SKU - Name" format.

## Decision 3: Unit Selection UI
- **Decision**: Bootstrap 5 Button Group (Radio-style) for UN/KG selection.
- **Rationale**: Fast selection, touch-friendly for Principle V.

## Decision 4: Clipboard Copy
- **Decision**: Use `navigator.clipboard.api` in `assets/js/main.js`.
- **Rationale**: Modern, native browser support.

## Decision 5: Simplified PDF Label
- **Decision**: Create a dedicated `pages/gerar_etiqueta.php` using a minimal HTML/CSS layout optimized for `@media print`.
- **Rationale**: Complex PDF libraries (FPDF) are overkill for a simple label. Native browser print to PDF is more flexible and maintainable.
- **Alternatives considered**: FPDF (deferred to a later branch if needed).
