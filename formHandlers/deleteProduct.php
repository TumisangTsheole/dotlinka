<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../controllers/ProductController.php";

$productId = intval($_POST["productId"]);
$productController = new ProductController($connection);
$productController->deleteProduct($_SESSION["userId"], $productId);

header("Location: /profilePage.php");
exit;