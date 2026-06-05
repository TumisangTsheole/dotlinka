<?php
require "../guard.php";
require "../../db/dbconnection.php";

$userId = trim($_POST["userId"] ?? "");

// can't delete yourself
if ($userId === $sessionUserId) {
    header("Location: /admin/users.php?error=self");
    exit;
}

// can't delete system accounts
if (in_array($userId, ["0000000000000", "0000000000001"])) {
    header("Location: /admin/users.php?error=invalid");
    exit;
}

if (empty($userId)) {
    header("Location: /admin/users.php?error=invalid");
    exit;
}

try {
    $connection->beginTransaction();

    // clear their cart
    $connection->prepare("DELETE FROM cart WHERE buyer = :userId;")
        ->execute([":userId" => $userId]);

    // cancel any pending orders they're buyer on, refund escrow
    $pendingOrders = $connection->prepare(
        "SELECT id FROM orders WHERE buyer = :userId AND status = 'pending';"
    );
    $pendingOrders->execute([":userId" => $userId]);
    $pending = $pendingOrders->fetchAll(PDO::FETCH_ASSOC);

    foreach ($pending as $order) {
        $total = $connection->prepare(
            "SELECT SUM(amount) FROM order_items WHERE order_id = :orderId;"
        );
        $total->execute([":orderId" => $order["id"]]);
        $amount = floatval($total->fetchColumn());

        // refund from escrow back to buyer before deleting
        $connection->prepare(
            "UPDATE users SET walletBalance = walletBalance - :amount WHERE id = '0000000000000';"
        )->execute([":amount" => $amount]);

        $connection->prepare(
            "UPDATE orders SET status = 'cancelled' WHERE id = :orderId;"
        )->execute([":orderId" => $order["id"]]);
    }

    // delete their products
    $connection->prepare("DELETE FROM products WHERE seller = :userId;")
        ->execute([":userId" => $userId]);

    // delete the user
    $connection->prepare("DELETE FROM users WHERE id = :userId;")
        ->execute([":userId" => $userId]);

    $connection->commit();

    header("Location: /admin/users.php?success=deleted");
    exit;

} catch (Exception $e) {
    $connection->rollBack();
    header("Location: /admin/users.php?error=failed");
    exit;
}