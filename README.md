# Dairy Management System

A web-based Dairy Management System built with PHP and MySQL to manage milk production, sales, and customer management for dairy businesses.

## Features

- Admin dashboard to manage customers, farmers, milk collection, milk products, payments, and sales.
- Customer dashboard for registration, login, placing orders, and viewing order history.
- Farmer management for tracking milk supply.
- Shopping cart and checkout system.
- Notifications for order updates.
- Secure login and logout functionality.

## Technologies Used

- PHP
- MySQL
- HTML/CSS
- JavaScript
- Bootstrap (optional)

## Installation

1. Import the database:
   - Open phpMyAdmin or MySQL.
   - Import `dairymanagementsystem.sql`.

2. Configure the database:
   - Update database credentials in `db.php`.

3. Run the project:
   - Place the files in your local server (e.g., XAMPP `htdocs` folder).
   - Open `http://localhost/Dairy-Management-System/` in your browser.

## Usage

- Admin login: Manage all operations like milk collection, products, payments, and sales.
- Customer login: Place orders, view cart, and track order history.

## Project Structure

- `admin_*` files – Admin dashboard and management features.
- `customer_*` files – Customer dashboard, login, registration, and order placement.
- `manage_*` files – CRUD operations for different entities.
- `db.php` – Database connection.
- `dairymanagementsystem.sql` – Database schema.
- `*.php` – Other functional pages like `index.php`, `checkout.php`, etc.
- `my1.jpg` – Example image used in the project.

## Contributing

Contributions are welcome! Feel free to open an issue or submit a pull request.

## Project Developer

**G Manohar**

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
