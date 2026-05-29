<?php

/*
TODO:
Schema changes, product quantity should not be less 0,
When quantity reaches zero, product should not be displayed nor
should be allowed to add to cart, see if this can be enforced in 
schema,




*/

/**
 * Script that creates the database and scheam 
 * if doesnt exist,
 * 
*/

include "./dbconnection.php";

//IMPORTANT MAKE SURE THAT THE DATABASE HAS BEEN MANUALLY CREATED
// CREATE DATABASE dotlinkaDB;

//user
$connection->exec(
    "CREATE TABLE IF NOT EXISTS users (
        id VARCHAR(13) PRIMARY KEY,
        firstName VARCHAR(30) NOT NULL,
        middleNames VARCHAR(100),
        lastName VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE,
        cellNumber VARCHAR(12) NOT NULL UNIQUE,
        hashedPassword VARCHAR(500) NOT NULL,
        dateOfBirth DATETIME NOT NULL,
        physicalAddress VARCHAR(50) NOT NULL,
        idCardImages JSON NOT NULL,
        userImages JSON NOT NULL,
        walletBalance DECIMAL(10, 2) NOT NULL,
        dateRegistered DATETIME DEFAULT CURRENT_TIMESTAMP
    );"
);

//product
$connection->exec(
    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL NOT NULL,
        seller VARCHAR(13) NOT NULL,
        quantity INT NOT NULL,
        category VARCHAR(20) NOT NULL,
        FOREIGN KEY (seller) REFERENCES users(id)
    );"
);

// cart, junction table referncing buyer and products
//TODO: ADD FOREIGN KEYS
$connection->exec(
    "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        buyer VARCHAR(13),
        products INT,
        FOREIGN KEY (buyer) REFERENCES users(id),
        FOREIGN KEY (products) REFERENCES products(id)
    );"
);

//order
$connection->exec(
    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        buyer VARCHAR(13) NOT NULL,
        seller VARCHAR(13) NOT NULL,
        status ENUM('pending', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (buyer) REFERENCES users(id),
        FOREIGN KEY (seller) REFERENCES users(id)
    );"
);

// many to one with orders where multiple items can be part of a single order
$connection->exec(
    "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product INT NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (product) REFERENCES products(id)
    );"
);
