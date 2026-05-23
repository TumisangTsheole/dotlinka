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

    public function addProductToCart(string $userId, int $productId){
        $userStatement = $this->_dbConnection->prepare(
            "SELECT id FROM users 
            WHERE users.id= :userid;"
        );  
        $userStatement->execute([':userid' => $userId]);
        $resultUser = $userStatement->fetch(PDO::FETCH_ASSOC);
        
        $productStatement = $this->_dbConnection->prepare(
            "SELECT id FROM products 
            WHERE products.id= :productId;"
        );   
        $productStatement->execute([':productId' => $productId]);
        $resultProduct = $productStatement->fetch(PDO::FETCH_ASSOC);


        if ($resultUser == false || $resultProduct == null){
            echo "The specified User or Product does not exist!";
            exit;
        }
          
        $cart = new Cart($userId, $productId);
        $statement = $this->_dbConnection->prepare(
            "INSERT INTO cart 
            (buyer, products)
            VALUES (?, ?);"
        );
        $statement->execute([$productId, $userId]);
        echo "Cart Added Succesfully!";
        
    }
    
    public function removeProductFromCart($productId){
        //
    }
}

// test
// include "../db/dbconnection.php";
// include "../models/cart.php";

// $cartController = new CartController($connection);
// print_r($cartController->getCart("123456789"));