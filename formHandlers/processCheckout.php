<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../models/cart.php";
require "../controllers/OrderController.php";
require "../controllers/CartController.php";

$sellerId = trim($_POST["sellerId"] ?? "");

if (empty($sellerId)) {
    header("Location: /cartPage.php");
    exit;
}

$cartController = new CartController($connection);
$cartController->processCheckout($_SESSION["userId"], $sellerId);