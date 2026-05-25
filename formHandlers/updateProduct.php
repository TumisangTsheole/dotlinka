<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../controllers/ProductController.php";

$productId   = intval($_POST["productId"]);
$name        = trim($_POST["name"]);
$description = trim($_POST["description"]);
$price       = floatval($_POST["price"]);
$quantity    = intval($_POST["quantity"]);

$productController = new ProductController($connection);
$productController->updateProduct($_SESSION["userId"], $productId, $name, $description, $price, $quantity);

header("Location: /profilePage.php");
exit;