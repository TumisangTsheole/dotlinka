<?php

class Order {
    private int $id; 
    private string $buyer;
    // private $seller; this information is already present in the product model
    private array $products = [];
    private float $totalCost;
    private string $status;
    private DateTime $orderFulfillmentDate; //init with SAST time on object creation
    // add dates
    
    public function __construct(
        string $buyer,
        string $seller,
        array $products,
        float $totalCost,
        string $status  
    )
    {
        //implement validation logic

    }
}
