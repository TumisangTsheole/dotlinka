<?php

/*
*   This is a router responsible for capturing requests and
*  for routing requests to the relevant controllers
*/

require "db/dbconnection.php";
require "OrderController.php";
require "ProductController.php";
require "UserController.php";

require "data/indexData.php";
require "data/dashboardData.php";
require "data/productDetailData.php";


$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'])["path"];



// TODO: For default cases we are either going to have 404 or method not allowed
// evaluate request path first then request method
switch ($path){
    case "/" || "/index.php": // only session and cart data is probably going to be used here.
        switch ($method){
            case "GET":
                $product = new ProductController($connection);
                $indexPageProducts = $product->getAllProducts(); 
                break;
            default:  
                break;          
        }
        break;

    case "/dashboard.php":
        switch ($method){
            case "GET":
                $product = new ProductController($connection);
                $dashboardPageProducts = $product->getAllProducts();

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
    case "/product-detail.php":
        $productId = intval($_GET["id"]);
        
        if ($productId == null || $productId == 0){
            http_response_code(404);
            exit;
        }

        $product = new ProductController($connection);
        
        $returnedProduct = $product->getProduct($productId);

        if (is_null($returnedProduct)){
            http_response_code(404);
            exit;
        }

        $productDetailPageProducts = $returnedProduct;
        break;
          
}

