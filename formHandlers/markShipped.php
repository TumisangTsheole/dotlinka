<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../controllers/OrderController.php";

$orderId = intval($_POST["orderId"] ?? 0);

if (!$orderId) {
    header("Location: /profilePage.php");
    exit;
}

$orderController = new OrderController($connection);
$orderController->markShipped($orderId, $_SESSION["userId"]);

header("Location: /profilePage.php?success=shipped");
exit;