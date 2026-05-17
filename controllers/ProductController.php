<?php

class ProductController {
    private $_dbConnection;

    public function __construct($dbConnection){
        $this->_dbConnection = $dbConnection;
    }

    //GET
    public function getProduct(int $id){
        $statement = $this->_dbConnection->prepare(
            "SELECT p.id,
                    p.name AS product_name,
                    p.description,
                    p.price,
                    p.quantity,
                    p.category,
                    u.firstName,
                    u.lastName
            FROM products AS p
            INNER JOIN users AS u
            ON p.seller=u.id
            WHERE p.id=:id;"
        );
        $statement->bindParam(":id", $id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // if array empty return null
        if (count($result) == 0){
            return null;
        }
        print_r($result);
        return $result;
    }

    public function getAllProducts(){
        $statement = $this->_dbConnection->query(
            "SELECT p.id,
                    p.name AS product_name,
                    p.description,
                    p.price,
                    p.quantity,
                    p.category,
                    u.firstName,
                    u.lastName
            FROM products AS p
            INNER JOIN users AS u
            ON p.seller=u.id;"
        ); // BE CAREFUL NOT TO RETURN PASSWORDS
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    
}