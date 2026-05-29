<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

require "../db/dbconnection.php";
require "../controllers/OrderController.php";
// require "../controllers/WalletController.php";

$orderId = intval($_POST["orderId"] ?? 0);

if (!$orderId) {
    header("Location: /profilePage.php");
    exit;
}

$platformId = "0000000000000";
$orderController = new OrderController($connection);
$order = $orderController->getOrderById($orderId);

// verify this user is the buyer and order is shipped
if (!$order || $order["buyer"] !== $_SESSION["userId"] || $order["status"] !== "shipped") {
    header("Location: /profilePage.php");
    exit;
}

$total = $orderController->getOrderTotal($orderId);

try {
    $connection->beginTransaction();

    // release from escrow to seller
    $deductPlatform = $connection->prepare(
        "UPDATE users SET walletBalance = walletBalance - :total WHERE id = :platformId;"
    );
    $deductPlatform->execute([":total" => $total, ":platformId" => $platformId]);

    $creditSeller = $connection->prepare(
        "UPDATE users SET walletBalance = walletBalance + :total WHERE id = :sellerId;"
    );
    $creditSeller->execute([":total" => $total, ":sellerId" => $order["seller"]]);

    $orderController->confirmReceipt($orderId, $_SESSION["userId"]);

    $connection->commit();

    header("Location: /profilePage.php?success=completed");
    exit;

} catch (Exception $e) {
    $connection->rollBack();
    header("Location: /profilePage.php?error=transaction_failed");
    exit;
}