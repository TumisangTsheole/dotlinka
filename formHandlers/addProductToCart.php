<?php

require "../data/global/sessionData.php";
require "../db/dbconnection.php";
require "../controllers/ProductController.php";
require "../controllers/UserController.php";
require "../models/cart.php";
require "../controllers/CartController.php";
require "../controllers/Router.php";

// $result = $cartController->addProductToCart($_SESSION["userId"], $productId);

// switch ($result) {
//     case "success":
//         header("Location: /cartPage.php");
//         break;
//     case "own_listing":
//         header("Location: /product-detail.php?id=" . $productId . "&error=own_listing");
//         break;
//     case "out_of_stock":
//         header("Location: /product-detail.php?id=" . $productId . "&error=out_of_stock");
//         break;
//     default:
//         header("Location: /dashboard.php");
//         break;
// }
// exit;

// // header("Location: /product-detail.php?id=" . $_GET["id"]);
// // exit;