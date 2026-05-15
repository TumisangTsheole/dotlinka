<?php

class Order {
    private $id; 
    private $buyer;
    // private $seller; this information is already present in the product model
    private $products = [];
    private $totalCost;
    private $status;
    private $orderFulfillmentDate; //init with SAST time on object creation
    // add dates
    
    public function __construct(
        $buyer,
        $seller,
        $products,
        $totalCost,
        $status  
    )
    {
        //implement validation logic

    }
}