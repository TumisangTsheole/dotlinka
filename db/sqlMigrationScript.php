<?php

/**
 * Script that creates the database and scheam 
 * if doesnt exist,
 * 
*/

include "./dbconnection.php";

//create db manually!!
// $connection->exec("CREATE DATABASE IF NOT EXISTS dotlinkaDB;");

//user
$connection->exec(
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(30) NOT NULL,
        lastName VARCHAR(30) NOT NULL,
        hashedPassword VARCHAR(50) NOT NULL,
        dateOfBirth DATETIME,
        address VARCHAR(50) NOT NULL,
        dateRegistered DATETIME DEFAULT CURRENT_TIMESTAMP
    );"
);

//product
$connection->exec(
    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        desciption TEXT NOT NULL,
        price DECIMAL NOT NULL,
        seller INT,
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
        buyer INT,
        products INT,
        FOREIGN KEY (buyer) REFERENCES users(id),
        FOREIGN KEY (products) REFERENCES products(id)
    );"
);

//order
//TODO: ADD FOREIGN KEYS
$connection->exec(
    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        buyer INT,
        FOREIGN KEY (buyer) REFERENCES users(id) 
    );"
);

