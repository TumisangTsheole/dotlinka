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

$platformId = "0000000000000";
$orderController = new OrderController($connection);
$order = $orderController->getOrderById($orderId);

// verify this user is the buyer and order is still pending
if (!$order || $order["buyer"] !== $_SESSION["userId"] || $order["status"] !== "pending") {
    header("Location: /profilePage.php");
    exit;
}

$total = $orderController->getOrderTotal($orderId);

try {
    $connection->beginTransaction();

    // refund from escrow back to buyer
    $deductPlatform = $connection->prepare(
        "UPDATE users SET walletBalance = walletBalance - :total WHERE id = :platformId;"
    );
    $deductPlatform->execute([":total" => $total, ":platformId" => $platformId]);

    $refundBuyer = $connection->prepare(
        "UPDATE users SET walletBalance = walletBalance + :total WHERE id = :buyerId;"
    );
    $refundBuyer->execute([":total" => $total, ":buyerId" => $_SESSION["userId"]]);

    $orderController->cancelOrder($orderId, $_SESSION["userId"]);

    $connection->commit();

    header("Location: /profilePage.php?success=cancelled");
    exit;

} catch (Exception $e) {
    $connection->rollBack();
    header("Location: /profilePage.php?error=transaction_failed");
    exit;
}