<?php

class Product {
    // the same item will have the same id regardless of quantity
    // unique item identification will the seller's responsibility
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $seller;
    private int $quantity;
    private string $category; // TODO: make this an enum

    public function __construct(
        string $name,
        string $description,
        float $price,
        string $seller,
        int $quantity,
        string $category
    ){
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->seller = $seller;
        $this->quantity = $quantity;
        $this->category = $category;

        //implement validation logic
    }

    public function getAllProperties() : array {
        $props = [
            $this->name,
            $this->description,
            $this->price,
            $this->seller,
            $this->quantity,
            $this->category
        ];
        
        return $props;
    }

}
