<?php

class ProductController {
    private PDO $_dbConnection;

    public function __construct(PDO $dbConnection){
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
        return $result;
    }

    public function getProductsBySeller(string $sellerId) : array {
        $statement = $this->_dbConnection->prepare(
            "SELECT * FROM products WHERE seller = :sellerId ORDER BY id DESC;"
        );
        $statement->execute([":sellerId" => $sellerId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
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

    public function addProduct(Product $product){
         $statement = $this->_dbConnection->prepare(
            "INSERT INTO products 
            (
            	name,
                description,
                price,
                seller,
                quantity,
                category
            )
            VALUES (?, ?, ?, ?, ?, ?);"
        );
        $statement->execute($product->getAllProperties());
    }

    public function deleteProduct(string $sellerId, int $productId) : void {
    $statement = $this->_dbConnection->prepare(
        "DELETE FROM products WHERE id = :productId AND seller = :sellerId;"
    );
    $statement->execute([":productId" => $productId, ":sellerId" => $sellerId]);
}

    public function updateProduct(string $sellerId, int $productId, string $name, string $description, float $price, int $quantity) : void {
        $statement = $this->_dbConnection->prepare(
            "UPDATE products
            SET name = :name, description = :description, price = :price, quantity = :quantity
            WHERE id = :productId AND seller = :sellerId;"
        );
        $statement->execute([
            ":name"        => $name,
            ":description" => $description,
            ":price"       => $price,
            ":quantity"    => $quantity,
            ":productId"   => $productId,
            ":sellerId"    => $sellerId
        ]);
    }

    
}