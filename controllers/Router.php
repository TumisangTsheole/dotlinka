<?php

/*
*   This is a router responsible for capturing requests and
*  for routing requests to the relevant controllers
*/
// require "../pathBootstrap.php";

// require "db/dbconnection.php";
// require "controllers/OrderController.php";
// require "controllers/ProductController.php";
// require "controllers/UserController.php";

// require "data/indexData.php";
// require "data/dashboardData.php";
// require "data/productDetailData.php";


$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'])["path"];


// TODO: For default cases we are either going to have 404 or method not allowed
// evaluate request path first then request method
switch ($path){
    case "/index.php": // only session and cart data is probably going to be used here.
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
                $productController = new ProductController($connection);
                $dashboardPageProducts = $productController->getAllProducts();

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

        $productController = new ProductController($connection);
        
        $returnedProduct = $productController->getProduct($productId);

        if (is_null($returnedProduct)){
            http_response_code(404);
            exit;
        }

        $productDetailPageProducts = $returnedProduct;
        break;
    case "/formHandlers/registerUser.php":
        $user = new User(
            intval(htmlspecialchars($_POST["idNumber"])),
            htmlspecialchars($_POST["firstName"]),
            htmlspecialchars($_POST["middleNames"]),
            htmlspecialchars($_POST["lastName"]),
            htmlspecialchars($_POST["email"]),
            htmlspecialchars($_POST["cellNumber"]),
            htmlspecialchars($_POST["password"]),
            htmlspecialchars($_POST["dateOfBirth"]),
            htmlspecialchars($_POST["physicalAddress"]),
            htmlspecialchars($_POST["idNumber"]) . "idCardImages.pdf",
            htmlspecialchars($_POST["idNumber"]) . "userImages.pdf",
            0.00
        );

        $userController = new UserController($connection);
        $userController->addUser($user);
        break;
    case "/formHandlers/registerProduct.php":
        // get user session and pass id into getUser() to
        // to check if user exists
        echo "Product Created Succesfully!";
        $userid = "123456789"; //placeholder

        $userController = new UserController($connection);
        // $user = $userController->getUser($userid);

        $product = new Product(
            htmlspecialchars($_POST["productName"]),
            htmlspecialchars($_POST["description"]),
            floatval(htmlspecialchars($_POST["price"])),
            $userid,
            intval(htmlspecialchars($_POST["productQuantity"])),
            htmlspecialchars($_POST["category"])
        );

        $productController = new ProductController($connection);
        $productController->addProduct($product);
        break;
          
}

