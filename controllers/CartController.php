<?php

class CartController {
    private $_dbConnection;
    // private $userId;

    public function __construct($dbConnection){
        $this->_dbConnection = $dbConnection;
    }

    public function getCart(string $userId) : array {
        // Only retreive the cart/s the user owns
        $statement = $this->_dbConnection->prepare(
            "SELECT * FROM cart
            WHERE cart.buyer = :userid;"
        );
        $statement->execute([":userid" => $userId]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function deleteCart(){
        // only delete cart on order placement or if user manually deletes it
    }

    public function addProductToCart(string $userId, int $productId) : string {
    // check product exists, has stock, and seller is not the buyer
    $check = $this->_dbConnection->prepare(
        "SELECT seller, quantity FROM products WHERE id = :productId;"
    );
    $check->execute([":productId" => $productId]);
    $product = $check->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        return "product_not_found";
    }
    if ($product["seller"] === $userId) {
        return "own_listing";
    }
    if ($product["quantity"] <= 0) {
        return "out_of_stock";
    }

    $statement = $this->_dbConnection->prepare(
        "INSERT INTO cart (buyer, products) VALUES (:userId, :productId);"
    );
    $statement->execute([":userId" => $userId, ":productId" => $productId]);
    return "success";
    }

    public function getCartWithDetails(string $userId) : array {
    $statement = $this->_dbConnection->prepare(
        "SELECT p.id, p.name, p.price, p.quantity, p.seller,
                u.firstName AS sellerFirstName,
                u.lastName AS sellerLastName
        FROM cart c
        INNER JOIN products p ON c.products = p.id
        INNER JOIN users u ON p.seller = u.id
        WHERE c.buyer = :userId;"
    );
    $statement->execute([":userId" => $userId]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function processCheckout(string $buyerId) : void {
        // get cart with full details
        $items = $this->getCartWithDetails($buyerId);

        if (empty($items)) {
            echo "Your cart is empty.";
            exit;
        }

        // calculate total
        $total = array_sum(array_column($items, "price"));

        // check buyer has enough balance
        $balanceCheck = $this->_dbConnection->prepare(
            "SELECT walletBalance FROM users WHERE id = :buyerId;"
        );
        $balanceCheck->execute([":buyerId" => $buyerId]);
        $buyer = $balanceCheck->fetch(PDO::FETCH_ASSOC);

        if ($buyer["walletBalance"] < $total) {
            header("Location: /cartPage.php?error=insufficient_balance");
            exit;
        }

        // check all items still in stock
        foreach ($items as $item) {
            if ($item["quantity"] <= 0) {
                header("Location: /cartPage.php");
                exit;
            }
        }

        try {
            $this->_dbConnection->beginTransaction();

            // deduct from buyer
            $deduct = $this->_dbConnection->prepare(
                "UPDATE users SET walletBalance = walletBalance - :total WHERE id = :buyerId;"
            );
            $deduct->execute([":total" => $total, ":buyerId" => $buyerId]);

            // credit each seller and decrement stock
            $credit = $this->_dbConnection->prepare(
                "UPDATE users SET walletBalance = walletBalance + :price WHERE id = :sellerId;"
            );
            $decrement = $this->_dbConnection->prepare(
                "UPDATE products SET quantity = quantity - 1 WHERE id = :productId;"
            );

            $orderController = new OrderController($this->_dbConnection);
            foreach ($items as $item) {
                $credit->execute([":price" => $item["price"], ":sellerId" => $item["seller"]]);
                $decrement->execute([":productId" => $item["id"]]);
                $orderController->createOrder($buyerId, $item["id"], $item["price"]);
            }

            // clear cart
            $clearCart = $this->_dbConnection->prepare(
                "DELETE FROM cart WHERE buyer = :buyerId;"
            );
            $clearCart->execute([":buyerId" => $buyerId]);

            $this->_dbConnection->commit();

            header("Location: /dashboard.php?success=1");
            exit;

        } catch (Exception $e) {
            $this->_dbConnection->rollBack();
            header("Location: /cartPage.php?error=transaction_failed");
            exit;
        }
    }
    
    public function removeProductFromCart(string $userId, int $productId) : void {
    $statement = $this->_dbConnection->prepare(
        "DELETE FROM cart WHERE buyer = :userId AND products = :productId LIMIT 1;"
    );
    $statement->execute([":userId" => $userId, ":productId" => $productId]);
    }
}