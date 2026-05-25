<?php

// NOTE: Carts should be deleted when orders are placed
class Cart {
    // only products from the same seller are allowed in a single cart, hence the id
    private int $id;
    private string $buyer;
    // cart can only consist of unfullfilled orders
    private int $product;

    public function __construct(
        string $buyer,
        int $product
    ){
        $this->buyer = $buyer;
        $this->product = $product;
        // implement validation to make sure products are from the same seller
    }

}
