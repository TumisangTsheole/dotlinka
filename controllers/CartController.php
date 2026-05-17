<?php

class CartController {
    private $dbConnection;
    private $userId;

    public function __construct($dbConnection, $userId){
        $this->$dbConnection = $dbConnection;
        $this->$userId = $userId;
    }

    public function getCarts(){
        // Only retreive the cart/s the user owns
    }

    public function deleteCart(){
        // only delete cart on order placement or if user manually deletes it
    }

    public function addProductToCart($productId){
        //
    }
    
    public function removeProductFromCart($productId){
        //
    }


}