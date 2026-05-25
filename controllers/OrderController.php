<?php

class OrderController {
    private $_dbConnection;

    public function __construct($dbConnection) {
        $this->_dbConnection = $dbConnection;
    }

    public function getOrdersByBuyer(string $buyerId) : array {
        $statement = $this->_dbConnection->prepare(
            "SELECT o.id, o.amount, o.created_at,
                    p.name AS product_name, p.category,
                    u.firstName AS sellerFirstName, u.lastName AS sellerLastName
            FROM orders o
            INNER JOIN products p ON o.product = p.id
            INNER JOIN users u ON p.seller = u.id
            WHERE o.buyer = :buyerId
            ORDER BY o.created_at DESC;"
        );
        $statement->execute([":buyerId" => $buyerId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrder(string $buyerId, int $productId, float $amount) : void {
        $statement = $this->_dbConnection->prepare(
            "INSERT INTO orders (buyer, product, amount)
             VALUES (:buyerId, :productId, :amount);"
        );
        $statement->execute([
            ":buyerId"   => $buyerId,
            ":productId" => $productId,
            ":amount"    => $amount
        ]);
    }
}