<?php

    class OrderController {
        private $_dbConnection;

        public function __construct($dbConnection){
            //
        }

        //GET
        public function getOrder($id){
            //
        }

        
    }



<?php

// include '../db/dbconnection.php';

// // Check if id param exists
// if (!isset($_GET)){
//     die("ERROR: No order id provided");
// }

// $id = $_GET['id'];

// echo "Order with ID -> {$id} has been created!";

// echo "These are the users that exist";

// // $statement = $connection->prepare("SELECT * FROM users;");
// $statement = $connection->query("SELECT * FROM users;");

// $result = $statement->fetch(PDO::FETCH_ASSOC);

// echo $result['username'];

?>