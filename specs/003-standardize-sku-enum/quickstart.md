# Quickstart: SKU & Enum Standardization

## Setup for Feature 001 Alignment

To apply these standards to the existing work on Feature 001, follow these steps:

1. **Database Migration**:
   ```sql
   -- Update Materials table
   ALTER TABLE materiais MODIFY COLUMN tipo_lavagem ENUM('A', 'S');
   -- Update Orders table to ensure foreign key
   ALTER TABLE pedidos ADD COLUMN material_id INT, ADD FOREIGN KEY (material_id) REFERENCES materiais(id);
   ```

2. **Code Updates**:
   - Update `includes/sku_helper.php` to include the `[WASH]` suffix in SKU generation.
   - Update `pages/materiais.php` to use the 'A' and 'S' options in the form.

3. **Documentation Sync**:
   - Run `/speckit.tasks` to generate the standardized task list for branch `003-standardize-sku-enum`.
