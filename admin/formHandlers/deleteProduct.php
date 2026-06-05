<?php
require "../guard.php";
require "../../db/dbconnection.php";

$productId = intval($_POST["productId"] ?? 0);

if (!$productId) {
    header("Location: /admin/products.php?error=invalid");
    exit;
}

try {
    $connection->beginTransaction();

    // remove from any active carts first
    $connection->prepare(
        "DELETE FROM cart WHERE products = :productId;"
    )->execute([":productId" => $productId]);

    // delete the product
    $connection->prepare(
        "DELETE FROM products WHERE id = :productId;"
    )->execute([":productId" => $productId]);

    $connection->commit();

    header("Location: /admin/products.php?success=deleted");
    exit;

} catch (Exception $e) {
    $connection->rollBack();
    header("Location: /admin/products.php?error=failed");
    exit;
}