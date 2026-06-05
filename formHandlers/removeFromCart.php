<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../controllers/CartController.php";

$productId = intval($_POST["productId"]);

$cartController = new CartController($connection);
$cartController->removeProductFromCart($_SESSION["userId"], $productId);

header("Location: /cartPage.php");
exit;