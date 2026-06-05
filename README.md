# DotLinka

A Customer-to-Customer (C2C) e-commerce web platform that allows individual users to buy and sell goods directly with one another. The platform includes a public-facing marketplace and a dedicated admin interface with Role-Based Access Control (RBAC).

---

## Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Database Setup](#database-setup)
- [Admin Access](#admin-access)
- [Hosting](#hosting)
- [Academic Context](#academic-context)

---

## About

DotLinka is a C2C e-commerce platform built as part of an academic project at Eduvos. The platform facilitates direct transactions between individual consumers, allowing any registered user to list products for sale as well as purchase products listed by others.

---

## Features

### Main Platform
- User registration and login with session management
- Browse and search product listings by category
- Add products to cart and proceed to checkout
- Wallet-based payment system
- Order tracking with status updates (pending, shipped, completed, cancelled)
- Sellers can create, edit, and delete their own listings
- Product listings are hidden automatically when quantity reaches zero

### Admin Panel
- Role-Based Access Control (RBAC) with user and admin roles
- View and manage all registered users
- View and manage all product listings
- View all orders and order items
- Ability to change user roles

---

## Tech Stack

- Frontend: HTML, CSS, JavaScript, Bootstrap
- Backend: PHP
- Database: MySQL
- Hosting: Live server (localhost submissions not permitted)

---

## Project Structure

```
dotlinka/
├── db/
│   ├── dbconnection.php
│   └── sqlMigrationScript.php
├── admin/
│   ├── index.php
│   ├── users.php
│   ├── listings.php
│   └── orders.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── session.php
├── index.php
├── register.php
├── login.php
├── logout.php
├── product.php
├── cart.php
└── checkout.php
```

---

## Getting Started

### Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- A web server such as Apache or Nginx (XAMPP or similar for local development)

### Installation

1. Clone or download the repository:

   ```
   git clone https://github.com/yourusername/dotlinka.git
   ```

2. Place the project folder in your web server's root directory (e.g. htdocs for XAMPP).

3. Create the database manually in MySQL:

   ```sql
   CREATE DATABASE dotlinkaDB;
   ```

4. Update the database credentials in `db/dbconnection.php` to match your environment.

5. Run the migration script by navigating to it in your browser or executing it via the command line to create all required tables:

   ```
   php db/sqlMigrationScript.php
   ```

6. Navigate to the project in your browser:

   ```
   http://localhost/dotlinka
   ```

---

## Database Setup

The database consists of five tables:

| Table       | Description                                                  |
|-------------|--------------------------------------------------------------|
| users       | Stores all registered user accounts and roles                |
| products    | Stores all product listings created by sellers               |
| cart        | Junction table linking buyers to products added to cart      |
| orders      | Records all transactions between buyers and sellers          |
| order_items | Links individual products to a specific order                |

The migration script at `db/sqlMigrationScript.php` will create all tables automatically if they do not already exist.

---

## Admin Access

Admin accounts are assigned via the `role` field in the `users` table. To grant a user admin access, update their role directly in the database:

```sql
UPDATE users SET role = 'admin' WHERE email = 'youremail@example.com';
```

Admin users are redirected to the admin panel upon login where they can manage users, listings, and orders.

---

## Hosting

The application must be hosted on a live server for submission. Localhost submissions are not accepted. Ensure the database credentials in `dbconnection.php` are updated to reflect the live server environment before deployment.

---

## Academic Context

| Field       | Detail                          |
|-------------|---------------------------------|
| Institution | Eduvos                          |
| Module      | ITECA3-12 Initial Project       |
| Deliverable | 2                               |
| Model       | Customer-to-Customer (C2C)      |
| Due         | Block 2, Week 5                 |
