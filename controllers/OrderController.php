<?php

class OrderController {
    private $_dbConnection;

    public function __construct($dbConnection) {
        $this->_dbConnection = $dbConnection;
    }

    // create one order for one seller group, returns the new order id
    public function createOrder(string $buyerId, string $sellerId) : int {
        $statement = $this->_dbConnection->prepare(
            "INSERT INTO orders (buyer, seller)
             VALUES (:buyerId, :sellerId);"
        );
        $statement->execute([
            ":buyerId"  => $buyerId,
            ":sellerId" => $sellerId
        ]);
        return intval($this->_dbConnection->lastInsertId());
    }

    // add a single item to an order
    public function addOrderItem(int $orderId, int $productId, float $amount) : void {
        $statement = $this->_dbConnection->prepare(
            "INSERT INTO order_items (order_id, product, amount)
             VALUES (:orderId, :productId, :amount);"
        );
        $statement->execute([
            ":orderId"   => $orderId,
            ":productId" => $productId,
            ":amount"    => $amount
        ]);
    }

    // get all orders where user is buyer, with items and seller info
    public function getOrdersByBuyer(string $buyerId) : array {
        $statement = $this->_dbConnection->prepare(
            "SELECT o.id, o.status, o.created_at,
                    u.firstName AS sellerFirstName, u.lastName AS sellerLastName,
                    oi.amount, oi.product,
                    p.name AS product_name, p.category
             FROM orders o
             INNER JOIN users u ON o.seller = u.id
             INNER JOIN order_items oi ON oi.order_id = o.id
             INNER JOIN products p ON oi.product = p.id
             WHERE o.buyer = :buyerId
             ORDER BY o.created_at DESC;"
        );
        $statement->execute([":buyerId" => $buyerId]);
        return $this->groupOrderItems($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    // get all orders where user is seller, with items and buyer info
    public function getOrdersBySeller(string $sellerId) : array {
        $statement = $this->_dbConnection->prepare(
            "SELECT o.id, o.status, o.created_at,
                    u.firstName AS buyerFirstName, u.lastName AS buyerLastName,
                    oi.amount, oi.product,
                    p.name AS product_name, p.category
             FROM orders o
             INNER JOIN users u ON o.buyer = u.id
             INNER JOIN order_items oi ON oi.order_id = o.id
             INNER JOIN products p ON oi.product = p.id
             WHERE o.seller = :sellerId
             ORDER BY o.created_at DESC;"
        );
        $statement->execute([":sellerId" => $sellerId]);
        return $this->groupOrderItems($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    // groups flat join rows into nested order → items structure
    private function groupOrderItems(array $rows) : array {
        $orders = [];
        foreach ($rows as $row) {
            $orderId = $row["id"];
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    "id"         => $row["id"],
                    "status"     => $row["status"],
                    "created_at" => $row["created_at"],
                    // seller info (present on buyer queries)
                    "sellerFirstName" => $row["sellerFirstName"] ?? null,
                    "sellerLastName"  => $row["sellerLastName"] ?? null,
                    // buyer info (present on seller queries)
                    "buyerFirstName" => $row["buyerFirstName"] ?? null,
                    "buyerLastName"  => $row["buyerLastName"] ?? null,
                    "items" => [],
                    "total" => 0
                ];
            }
            $orders[$orderId]["items"][] = [
                "product_name" => $row["product_name"],
                "category"     => $row["category"],
                "amount"       => $row["amount"]
            ];
            $orders[$orderId]["total"] += $row["amount"];
        }
        return array_values($orders);
    }

    public function getOrderById(int $orderId) : array|false {
        $statement = $this->_dbConnection->prepare(
            "SELECT * FROM orders WHERE id = :orderId;"
        );
        $statement->execute([":orderId" => $orderId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function markShipped(int $orderId, string $sellerId) : void {
        $statement = $this->_dbConnection->prepare(
            "UPDATE orders SET status = 'shipped'
             WHERE id = :orderId AND seller = :sellerId AND status = 'pending';"
        );
        $statement->execute([":orderId" => $orderId, ":sellerId" => $sellerId]);
    }

    public function confirmReceipt(int $orderId, string $buyerId) : void {
        $statement = $this->_dbConnection->prepare(
            "UPDATE orders SET status = 'completed'
             WHERE id = :orderId AND buyer = :buyerId AND status = 'shipped';"
        );
        $statement->execute([":orderId" => $orderId, ":buyerId" => $buyerId]);
    }

    public function cancelOrder(int $orderId, string $buyerId) : void {
        $statement = $this->_dbConnection->prepare(
            "UPDATE orders SET status = 'cancelled'
             WHERE id = :orderId AND buyer = :buyerId AND status = 'pending';"
        );
        $statement->execute([":orderId" => $orderId, ":buyerId" => $buyerId]);
    }

    // get total escrowed amount for an order (sum of all items)
    public function getOrderTotal(int $orderId) : float {
        $statement = $this->_dbConnection->prepare(
            "SELECT SUM(amount) AS total FROM order_items WHERE order_id = :orderId;"
        );
        $statement->execute([":orderId" => $orderId]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return floatval($row["total"]);
    }
}

// class OrderController {
//     private $_dbConnection;

//     public function __construct($dbConnection) {
//         $this->_dbConnection = $dbConnection;
//     }

//     public function getOrdersByBuyer(string $buyerId) : array {
//         $statement = $this->_dbConnection->prepare(
//             "SELECT o.id, o.amount, o.created_at,
//                     p.name AS product_name, p.category,
//                     u.firstName AS sellerFirstName, u.lastName AS sellerLastName
//             FROM orders o
//             INNER JOIN products p ON o.product = p.id
//             INNER JOIN users u ON p.seller = u.id
//             WHERE o.buyer = :buyerId
//             ORDER BY o.created_at DESC;"
//         );
//         $statement->execute([":buyerId" => $buyerId]);
//         return $statement->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function createOrder(string $buyerId, int $productId, float $amount) : void {
//         $statement = $this->_dbConnection->prepare(
//             "INSERT INTO orders (buyer, product, amount)
//              VALUES (:buyerId, :productId, :amount);"
//         );
//         $statement->execute([
//             ":buyerId"   => $buyerId,
//             ":productId" => $productId,
//             ":amount"    => $amount
//         ]);
//     }
// }