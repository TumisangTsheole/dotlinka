<?php

require "dbconnection.php";

// Admin user
$adminPassword = password_hash("admin123", PASSWORD_BCRYPT);
$connection->exec(
    "INSERT INTO users (id, firstName, middleNames, lastName, email, cellNumber, hashedPassword, dateOfBirth, physicalAddress, idCardImages, userImages, walletBalance, role)
     VALUES (
        '0000000000002',
        'Admin',
        'N/A',
        'User',
        'admin@dotlinka.za',
        'N/A',
        '$adminPassword',
        '2000-01-01',
        'N/A',
        '[\"N/A\"]',
        '[\"N/A\"]',
        0.00,
        'admin'
     );"
);
