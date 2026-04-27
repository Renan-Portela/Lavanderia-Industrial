# Research: Washing UI Refactor

## Decision 1: Detailed Scan Information Display
- **Decision**: Use a side-by-side layout (col-md-6) for the QR scanner and the Order Info Card.
- **Rationale**: Provides immediate feedback to the operator. Follows the clarified requirement of showing only the most recent scan details.
- **Implementation**: Info Card will display Client, Material (Catalog Name), Quantity (with units), and Observations (only if non-empty).

## Decision 2: Unit Suffix Formatting
- **Decision**: Implement a helper-like logic or inline formatting to append "kg" or "und." based on the `unidade` column.
- **Rationale**: Aligns with the requirement for clear operational density (e.g., "15.00 kg").
- **Implementation**: `number_format($row['quantidade'], 2) . ' ' . strtolower($row['unidade'])`.

## Decision 3: SKU Meaning (Catalog Description)
- **Decision**: Update the SQL query in `pages/lavagem.php` to JOIN `pedidos` with `materiais`.
- **Rationale**: Required to show what the SKU "means" (the catalog material name).
- **Implementation**: 
  ```sql
  SELECT p.*, m.nome as material_nome, m.sku as material_sku 
  FROM pedidos p 
  LEFT JOIN materiais m ON p.material_id = m.id 
  WHERE p.status = 'Lavagem'
  ```

## Decision 4: Conditional Observations Display
- **Decision**: Use PHP `if (!empty($pedido['observacao']))` check in the Info Card.
- **Rationale**: Avoids cluttering the UI with empty labels as requested.
