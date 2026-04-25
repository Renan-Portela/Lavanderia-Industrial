# Quickstart: SKU Standardization Implementation

## 1. Database Setup
Execute the migrations in `database.sql` (to be created) which include:
- Creating the `materiais` table.
- Creating the `usuarios` table.
- Updating `pedidos` to reference `material_id`.

## 2. Initial Catalog Seed
Populate the `materiais` table with standard PPE items:
```sql
INSERT INTO materiais (nome, sku, tipo_lavagem) VALUES 
('Luva de Raspa G', 'GLV-RSP-G-S', 'S'),
('Avental de Raspa', 'APR-RSP-UNI-S', 'S'),
('Capacete Industrial', 'HLM-PVC-UNI-A', 'A'),
('Pano Azul (Indústria)', 'CLO-BLU-UNI-A', 'A'),
('Pano Vermelho (Gráfica)', 'CLO-RED-UNI-A', 'A');
```

## 3. Configuration
- Ensure `config/config.php` has correct DB credentials.
- Ensure `qrcodes/` is writable (`chmod 777`).
- Install dependencies via `composer install` (if using local QR generator).

## 4. Operational Flow
1. **Login**: Access `login.php`.
2. **Catalog**: View/Edit materials in `pages/materiais.php`.
3. **Receiving**: Use `pages/recebimento.php` to create an order selecting from the catalog.
4. **Washing**: Update status in `pages/lavagem.php`.
5. **Expedition**: Complete flow in `pages/expedicao.php`.

## 5. Verification
Run the automated test suite:
```bash
./vendor/bin/phpunit tests/
```
(Or manual check of the flow integrity).
