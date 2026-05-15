<?php

class Product {
    // the same item will have the same id regardless of quantity
    // unique item identification will the seller's responsibility
    private $id;
    private $name;
    private $description;
    private $price;
    private $seller;
    private $quantity;
    private $category; // TODO: make this an enum

    public function __construct(
        $id,
        $name,
        $description,
        $price,
        $seller,
        $quantity,
        $category
    ){
        $this->$id = $id;
        $this->$name = $name;
        $this->$description = $description;
        $this->$price = $price;
        $this->$seller = $seller;
        $this->$quantity = $quantity;
        $this->$category = $category;

        //implement validation logic
    }

}