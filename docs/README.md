# MiniMarket POS System

This project is a modern retail point-of-sale system designed for Malaysian mini markets and convenience stores.

## Features

- Administrator and cashier roles with role-based access control.
- Dashboard with sales stats, low stock alerts, and recent transactions.
- POS counter with barcode/QR search, customer selection, payment processing, and receipt printing integration.
- Product management with images, categories, brands, and supplier links.
- Inventory management and stock movement tracking.
- Customer and supplier management.
- Reporting for sales, products, inventory, and export-ready output.
- Responsive interface with tablet/touchscreen-friendly UI.
- Designed for RM currency and Malaysian retail workflows.

## Recommended Stack

- PHP 8+ with MySQL/MariaDB
- Apache or Nginx
- HTML/CSS/JavaScript frontend

## Installation

1. Place the `pos` folder under your web root.
2. Create the database and tables using `docs/database-schema.sql`.
3. Update connection details in your DB helper file.
4. Access `login.php` in your browser.

## Important Notes

- This scaffold includes core UI and authentication flows.
- Backend logic for full transaction processing, printer integration, and reports should be implemented in future phases.
- The printer integration flow should use ESC/POS with a local print agent or browser preview fallback.
