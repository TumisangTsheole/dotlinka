<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../models/product.php";
require "../controllers/ProductController.php";

$name = trim($_POST["name"] ?? "");
$description = trim($_POST["description"] ?? "");
$price = $_POST["price"] ?? "";
$quantity = $_POST["quantity"] ?? "";
$category = trim($_POST["category"] ?? "");
$image = $_FILES["image"]["tmp_name"];

// Filesystem path (relative to formHandlers/) used only for moving the file
$fsPath  = "../uploads/products/" . $_SESSION["userId"] . "_" . $name . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
// Web-accessible absolute path stored in the DB and used in <img src>
$newFilePath = "/uploads/products/" . $_SESSION["userId"] . "_" . $name . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

    if (move_uploaded_file($image, $fsPath)) {
        // file moved successfully, continue
    } 
    else {
        echo "Error: Could not move the file. Check folder permissions.";
        exit;
    }

// validation
if (empty($name) || empty($description) || empty($price) || empty($quantity) || empty($category)) {
    header("Location: /registerProductPage.php?error=missing_fields");
    exit;
}

if (!is_numeric($price) || floatval($price) <= 0) {
    header("Location: /registerProductPage.php?error=invalid_price");
    exit;
}

if (!is_numeric($quantity) || intval($quantity) < 1) {
    header("Location: /registerProductPage.php?error=invalid_quantity");
    exit;
}

$productController = new ProductController($connection);
$productModel = new Product(
    $name,
    $description,
    floatval($price),
    $_SESSION["userId"],
    intval($quantity),
    $category,
    $newFilePath
);
$productController->addProduct($productModel);

header("Location: /profilePage.php?success=listed");
exit;

// make a for loop to iterate over all uploaded images
// move_uploaded_file($_FILES["idCardImages"]["tmp_name"], "document1.pdf");


