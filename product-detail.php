<?php
  $requestedId; // Used to store the request param "?id=???" so that we know which product was requested to view
  
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "data/productDetailData.php";
  require "controllers/ProductController.php";
  require "controllers/UserController.php";
  require "controllers/CartController.php";
  require "controllers/Router.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — Product Detail</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f8f7f4;
      margin: 0;
      padding: 0;
    }

    @keyframes flowAndGlow {
      0% {background-position:0% 50%;filter:drop-shadow(0 0 5px rgba(255,255,255,.2));}
      50% {background-position:100% 50%;filter:drop-shadow(0 0 15px rgba(255,255,255,.6));}
      100% {background-position:0% 50%;filter:drop-shadow(0 0 5px rgba(255,255,255,.2));}
    }

    /* Product detail layout */
    .product-detail {
      width: 90%;
      margin: 2rem auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 14px;
      padding: 2rem;
    }
    .product-img img {
      width: 100%;
      border-radius: 12px;
      border: 1px solid #ddd;
    }
    .product-info h1 {
      font-size: 24px;
      margin-bottom: .75rem;
      color: #1a1a1a;
    }
    .product-info .category {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      color: #999;
      margin-bottom: .5rem;
    }
    .product-info .price {
      font-size: 22px;
      font-weight: 700;
      color: #D85A30;
      margin: 1rem 0;
    }
    .product-info .condition {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      background: #f0eeea;
      padding: 4px 8px;
      border-radius: 4px;
      display: inline-block;
      margin-bottom: 1rem;
    }
    .product-info p {
      font-size: 14px;
      color: #555;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    /* Seller box */
    .seller-box {
      border-top: 1px solid #e8e6e1;
      padding-top: 1rem;
      margin-top: 1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .seller-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #f0eeea;
      color: #666;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 600;
    }
    .seller-info {
      font-size: 13px;
      color: #333;
    }
    .seller-info span {
      display: block;
      font-size: 12px;
      color: #999;
    }

    /* Buttons */
    .btn-primary {
      background: #D85A30;
      color: #fff;
      border: none;
      padding: .6rem 1.5rem;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      margin-right: .5rem;
    }
    .btn-primary:hover { background:#993C1D; }
    .btn-secondary {
      background: transparent;
      border: 1px solid #1a1a1a;
      padding: .6rem 1.5rem;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
    }
    .btn-secondary:hover { background:#1a1a1a;color:#fff; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <?php include 'components/navbar.php' ?>

  <!-- Product Detail -->
  <div class="product-detail">
    <div class="product-img">
      <img src="<?= htmlspecialchars($productDetailPageProducts['image']) ?>" alt="<?= htmlspecialchars($productDetailPageProducts['product_name']) ?>">
    </div>
    <div class="product-info">
      <div class="category"><?= htmlspecialchars($productDetailPageProducts['category']) ?></div>
      <h1><?= htmlspecialchars($productDetailPageProducts['product_name']) ?></h1>
      <div class="price">R <?= number_format($productDetailPageProducts['price']) ?></div>
      <!-- <div class="condition"><?= htmlspecialchars($productDetailPageProducts['condition']) ?></div> -->
      <p><?= htmlspecialchars($productDetailPageProducts['description']) ?></p>

      <div class="seller-box">
        <!-- <div class="seller-avatar"><?= htmlspecialchars($productDetailPageProducts['seller']['initials']) ?></div> -->
        <div class="seller-info">
          <h5>Seller</h5>
          <?= htmlspecialchars($productDetailPageProducts['firstName']) . " " . htmlspecialchars($productDetailPageProducts['lastName']) ?>
          <!-- <span>★ <?= htmlspecialchars($productDetailPageProducts['rating']) ?> · <?= $productDetailPageProducts['seller']['total_sales'] ?> sales</span> -->
        </div>
      </div>

      <div style="margin-top:1.5rem;">
        <?php if (isset($_GET["error"])): ?>
            <div style="
                background: #fff0ed;
                border: 1px solid #D85A30;
                color: #D85A30;
                border-radius: 8px;
                padding: .65rem 1rem;
                font-size: 14px;
                margin-bottom: 1rem;
            ">
                <?php if ($_GET["error"] === "own_listing"): ?>
                    You can't add your own listing to your cart.
                <?php elseif ($_GET["error"] === "out_of_stock"): ?>
                    Sorry, this item is out of stock.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <a href="formHandlers/addProductToCart.php?id=<?=$requestedId?>" class="btn-primary">Add to Cart</a>
        <!-- <a class="btn-secondary">Message Seller</a> -->
      </div>
    </div>
  </div>

  <!-- smooth scrollbar CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
  <script src="utils/script.js"></script>


</body>
</html>
