<?php

/*
*   This is a router responsible for capturing requests and
*  for routing requests to the relevant controllers
*/

include "../db/dbconnection.php";
include "OrderController.php";
include "ProductController.php";
include "UserController.php";

include "../data/indexData.php";


$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];


// TODO: For default cases we are either going to have 404 or method not allowed
// evaluate request path first then request method
switch ($path){
    case "/": // only session and cart data is probably going to be used here.
        switch ($method){
            case "GET":
                $product = new ProductController($connection);
                $product->getAllProducts(); 

                //populate indexData.php products
                $x = "Populated";

                break;
            default:  
                break;          
        }
        break;

    case "/dashboard.php":
        switch ($method){
            case "GET":
                break;
            case "POST":
                break;
            case "DELETE":
                break;
            case "PATCH":
                break;
            default:  
                break;          
        }
        break;
}

?>