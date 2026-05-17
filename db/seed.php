<?php

/**
 * Seed script to populate the database with test data
 */

include "./dbconnection.php";	


// --- USERS ---
$users = [
    ['John', 'Doe', password_hash('password123', PASSWORD_BCRYPT), '1990-05-14', '12 Oak Street, Cape Town'],
    ['Jane', 'Smith', password_hash('securepass', PASSWORD_BCRYPT), '1985-11-22', '7 Maple Ave, Johannesburg'],
    ['Carlos', 'Mendes', password_hash('mypassword', PASSWORD_BCRYPT), '1992-03-08', '3 Pine Road, Durban'],
    ['Aisha', 'Patel', password_hash('hunter2', PASSWORD_BCRYPT), '1998-07-30', '45 Elm Blvd, Pretoria'],
];

$userStmt = $connection->prepare(
    "INSERT INTO users (firstName, lastName, hashedPassword, dateOfBirth, address)
     VALUES (?, ?, ?, ?, ?)"
);

foreach ($users as $user) {
    $userStmt->execute($user);
}

echo "Γ£à Users seeded\n";

// --- PRODUCTS ---
// Sellers are user IDs 1ΓÇô4
$products = [
    ['Wireless Mouse', 'Ergonomic wireless mouse with USB receiver', 299.99, 1, 50, 'Electronics'],
    ['Desk Lamp', 'LED desk lamp with adjustable brightness', 149.50, 2, 30, 'Home'],
    ['Running Shoes', 'Lightweight running shoes, size 8ΓÇô12', 899.00, 3, 20, 'Clothing'],
    ['Python Book', 'Learn Python in 30 days ΓÇö beginner friendly', 450.00, 4, 15, 'Books'],
    ['USB-C Hub', '7-in-1 USB-C hub with HDMI and SD card slot', 549.00, 1, 40, 'Electronics'],
    ['Coffee Mug', 'Ceramic mug with "Keep Coding" print, 350ml', 89.99, 2, 100, 'Kitchen'],
];

$productStmt = $connection->prepare(
    "INSERT INTO products (name, description, price, seller, quantity, category)
     VALUES (?, ?, ?, ?, ?, ?)"
);

foreach ($products as $product) {
    $productStmt->execute($product);
}

echo "Γ£à Products seeded\n";

// --- CART ---
// Buyers are users, products are product IDs 1ΓÇô6
$cartItems = [
    [2, 1], // Jane has the Wireless Mouse in her cart
    [2, 4], // Jane also has the Python Book
    [3, 3], // Carlos has Running Shoes
    [4, 5], // Aisha has the USB-C Hub
    [4, 6], // Aisha also has the Coffee Mug
];

$cartStmt = $connection->prepare(
    "INSERT INTO cart (buyer, products) VALUES (?, ?)"
);

foreach ($cartItems as $item) {
    $cartStmt->execute($item);
}

echo "Γ£à Cart seeded\n";

// --- ORDERS ---
$orders = [
    [1], // John placed an order
    [2], // Jane placed an order
    [3], // Carlos placed an order
];

$orderStmt = $connection->prepare(
    "INSERT INTO orders (buyer) VALUES (?)"
);

foreach ($orders as $order) {
    $orderStmt->execute($order);
}

echo "Γ£à Orders seeded\n";

echo "\n≡ƒÄë Database seeded successfully!\n";
