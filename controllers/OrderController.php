<?php

class OrderController {
    private $_dbConnection;

    public function __construct($dbConnection){
        $this->$_dbConnection = $dbConnection;
    }

    //GET
    public function getOrder($id){
        //
    }

    
}