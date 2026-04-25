# Quickstart: Market Readiness & SKU Standardization

## Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Composer (for testing)

## Setup
1. **Initialize Composer**:
   ```bash
   composer init
   composer require --dev phpunit/phpunit
   ```
2. **Database Migration**:
   Run the following in your MySQL console:
   ```sql
   -- Create materials table
   CREATE TABLE materials (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       sku VARCHAR(50) UNIQUE NOT NULL,
       description TEXT,
       category_prefix VARCHAR(10),
       material_prefix VARCHAR(10),
       size_prefix VARCHAR(10),
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
   );

   -- Create users table
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE NOT NULL,
       password_hash VARCHAR(255) NOT NULL,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
   );

   -- Update pedidos table
   ALTER TABLE pedidos ADD COLUMN material_id INT, ADD FOREIGN KEY (material_id) REFERENCES materials(id);
   ```
3. **Seed Initial Admin**:
   ```bash
   php scripts/create_admin.php admin password123
   ```

## Running Tests
```bash
./vendor/bin/phpunit tests
```

## Accessing the Catalog
Navigate to `pages/material_catalog.php` to manage your SKUs. All operational pages (Recebimento, Lavagem, Expedição) now require login.
