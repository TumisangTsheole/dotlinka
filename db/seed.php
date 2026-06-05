<?php

/**
 * Seed script to populate the database with test data
 */

include "./dbconnection.php";	

//$jsonParam = '["/staticFileStorage/123456789_idcardimage.png"]';
// --- USERS ---
$users = [
 	['0000000000000', 'Platform', null,'Escrow', 'escrow@dotlinka', '0000000000', 'N/A', '2000-01-01', 'N/A', 0.00, 'user'],
    ['123456789', 'John', null, 'Doe', 'johndoe@gmail.com', '+27601234569', password_hash('password123', PASSWORD_BCRYPT), '1990-05-14', '12 Oak Street, Cape Town', 0.00, 'user'],
    ['123456788','Jane', 'Melissa', 'Smith', 'j.smith@gmail.com', '+27031569874', password_hash('securepass', PASSWORD_BCRYPT), '1985-11-22', '7 Maple Ave, Johannesburg', 5000.00, 'user'],
    ['123456787', 'Carlos', 'Joao', 'Mendes', 'cjmendes2@gmail.com', '+27459873541', password_hash('mypassword', PASSWORD_BCRYPT), '1992-03-08', '3 Pine Road, Durban', 5000.00, 'user'],
    ['123456786', 'Aisha', 'Laylah','Patel', 'aishapatel@gmali.com', '+27567452537', password_hash('hunter2', PASSWORD_BCRYPT), '1998-07-30', '45 Elm Blvd, Pretoria' , 5000.00, 'user'],
];

$userStmt = $connection->prepare(
    "INSERT INTO users (id, firstName, middleNames,  lastName, email, cellNumber, hashedPassword, dateOfBirth, physicalAddress, walletBalance, role)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

foreach ($users as $user) {
    $userStmt->execute($user);
}

echo "Users seeded\n";

// --- PRODUCTS ---
// Sellers are user IDs; image column stores absolute web path (/uploads/products/userid_productname.ext)
$products = [
    ['Wireless Mouse', 'Ergonomic wireless mouse with USB receiver', 299.99, '123456789', 50, 'Electronics', '/uploads/products/123456789_Wireless_Mouse.jpg'],
    ['Desk Lamp',      'LED desk lamp with adjustable brightness',   149.50, '123456789', 30, 'Home',        '/uploads/products/123456789_Desk_Lamp.jpg'],
    ['Running Shoes',  'Lightweight running shoes, size 8–12',       899.00, '123456788', 20, 'Clothing',    '/uploads/products/123456788_Running_Shoes.jpg'],
    ['Python Book',    'Learn Python in 30 days — beginner friendly',450.00, '123456787', 15, 'Books',       '/uploads/products/123456787_Python_Book.jpg'],
    ['USB-C Hub',      '7-in-1 USB-C hub with HDMI and SD card slot',549.00, '123456786', 40, 'Electronics', '/uploads/products/123456786_USB-C_Hub.jpg'],
    ['Coffee Mug',     'Ceramic mug with "Keep Coding" print, 350ml', 89.99, '123456787',100, 'Kitchen',     '/uploads/products/123456787_Coffee_Mug.jpg'],
];

$productStmt = $connection->prepare(
    "INSERT INTO products (name, description, price, seller, quantity, category, image)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

// Admin user
$adminPassword = password_hash("admin123", PASSWORD_BCRYPT);
$connection->exec(
    "INSERT INTO users (id, firstName, lastName, email, cellNumber, hashedPassword, dateOfBirth, physicalAddress, walletBalance, role)
     VALUES (
        '1111111111111',
        'Admin',
        'User',
        'admin@dotlinka.za',
        '1111111111',
        '$adminPassword',
        '2000-01-01',
        'N/A',
        0.00,
        'admin'
     );"
);

foreach ($products as $product) {
    $productStmt->execute($product);
}

echo "Products seeded\n";

// --- CART ---
$cartItems = [
    ['123456789', 1],
    ['123456788', 4],
    ['123456788', 3],
    ['123456787', 5],
    ['123456787', 6],
];

$cartStmt = $connection->prepare(
    "INSERT INTO cart (buyer, products) VALUES (?, ?)"
);

foreach ($cartItems as $item) {
    $cartStmt->execute($item);
}

echo "Cart seeded\n";

echo "\nDatabase seeded successfully!\n";
