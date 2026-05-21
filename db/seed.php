<?php

/**
 * Seed script to populate the database with test data
 */

include "./dbconnection.php";	

$jsonParam = '["/staticFileStorage/123456789_idcardimage.png"]';
// --- USERS ---
$users = [
    ['123456789', 'John', null, 'Doe', 'johndoe@gmail.com', '+27601234569', password_hash('password123', PASSWORD_BCRYPT), '1990-05-14', '12 Oak Street, Cape Town', $jsonParam,'["/staticFileStorage/123456789_userimage.png"]', 0.00],
    ['123456788','Jane', 'Melissa', 'Smith', 'j.smith@gmail.com', '+27031569874', password_hash('securepass', PASSWORD_BCRYPT), '1985-11-22', '7 Maple Ave, Johannesburg','["/staticFileStorage/123456788_idcardimage.png"]','["/staticFileStorage/123456788_userimage.png"]', 0.00],
    ['123456787', 'Carlos', 'Joao', 'Mendes', 'cjmendes2@gmail.com', '+27459873541', password_hash('mypassword', PASSWORD_BCRYPT), '1992-03-08', '3 Pine Road, Durban', '["/staticFileStorage/123456787_idcardimage.png"]','["/staticFileStorage/123456787_userimage.png"]', 0.00],
    ['123456786', 'Aisha', 'Laylah','Patel', 'aishapatel@gmali.com', '+27567452537', password_hash('hunter2', PASSWORD_BCRYPT), '1998-07-30', '45 Elm Blvd, Pretoria', '["/staticFileStorage/123456786_idcardimage.png"]','["/staticFileStorage/123456786_userimage.png"]', 0.00],
];

$userStmt = $connection->prepare(
    "INSERT INTO users (id, firstName, middleNames,  lastName, email, cellNumber, hashedPassword, dateOfBirth, physicalAddress, idCardImages, userImages, walletBalance)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

foreach ($users as $user) {
    $userStmt->execute($user);
}

echo "Γ£à Users seeded\n";

// --- PRODUCTS ---
// Sellers are user IDs 1ΓÇô4
$products = [
    ['Wireless Mouse', 'Ergonomic wireless mouse with USB receiver', 299.99, '123456789', 50, 'Electronics'],
    ['Desk Lamp', 'LED desk lamp with adjustable brightness', 149.50, '123456789', 30, 'Home'],
    ['Running Shoes', 'Lightweight running shoes, size 8ΓÇô12', 899.00, '123456788', 20, 'Clothing'],
    ['Python Book', 'Learn Python in 30 days ΓÇö beginner friendly', 450.00, '123456787', 15, 'Books'],
    ['USB-C Hub', '7-in-1 USB-C hub with HDMI and SD card slot', 549.00, '123456786', 40, 'Electronics'],
    ['Coffee Mug', 'Ceramic mug with "Keep Coding" print, 350ml', 89.99, '123456787', 100, 'Kitchen'],
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
    ['123456789', 1], // Jane has the Wireless Mouse in her cart
    ['123456788', 4], // Jane also has the Python Book
    ['123456788', 3], // Carlos has Running Shoes
    ['123456787', 5], // Aisha has the USB-C Hub
    ['123456787', 6], // Aisha also has the Coffee Mug
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
    ['123456789'], // John placed an order
    ['123456788'], // Jane placed an order
    ['123456787'], // Carlos placed an order
];

$orderStmt = $connection->prepare(
    "INSERT INTO orders (buyer) VALUES (?)"
);

foreach ($orders as $order) {
    $orderStmt->execute($order);
}

echo "Γ£à Orders seeded\n";

echo "\n≡ƒÄë Database seeded successfully!\n";
