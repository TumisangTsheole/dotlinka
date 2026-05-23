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
                echo "index.php default";
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
                echo "dashboard.php defualt";
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

        // Update state
        $productDetailPageProducts = $returnedProduct;
        $requestedId = $productId;
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
    case "/formHandlers/authentication.php":
        $userEmail = htmlspecialchars($_POST["email"]);
        $userPassword = htmlspecialchars($_POST["password"]);
        
        $userController = new UserController($connection);
        $user = $userController->getUserByEmail($userEmail);
     
        // if (password_verify($userPassword, $user["hashedPassword"]))
        // {
        //     echo "Access Granted";
        //     exit;
        // }

        if ($user == false || !password_verify($userPassword, $user["hashedPassword"])){
            http_response_code(401);
            echo "401 Unauthorized | Incorrect Credentials. Please go back and try again";
            exit;
        }

        
        // TODO: DONT FORGET TO CHANGE YOUR AUTH IMPLEMENTATION 
        // set session token for authentication and authorization
        setCookie("sessionId", "opentokenforeveryuser", 0, "/");
        setCookie("userId", json_encode($user["id"]), 0, "/");

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
    case "/addProductToCart.php":
        $cartController = new CartController($connection);
        $cartController->addProductToCart("123456789", 2);
        echo "Product Added Successfully, Hit the back button on your browser and refresh";    
        break;  
    case "/cartPage.php":
        $cartController = new CartController($connection);
        $cartData = $cartController->getCart("123456789");
        break;        
}

