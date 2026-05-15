<?php

// NOTE: Carts should be deleted when orders are placed
class Cart {
    // only products from the same seller are allowed in a single cart, hence the id
    private $id;
    // cart can only consist of unfullfilled orders
    private $products = []; // add validation | 

    public function __construct(
        $id,
        $products
    ){
        $this->$id = $id;
        $this->$products = $products;
        // implement validation to make sure products are from the same seller
    }

}