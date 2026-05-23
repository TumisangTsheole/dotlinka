<?php
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "data/indexData.php";
  require "controllers/ProductController.php";
  require "controllers/UserController.php";
  require "controllers/Router.php";

  if (!isset($sessionData)){
    header("Location: /loginPage.php");
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — Register Product</title>
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

    /* Navbar */
    nav {
      background: #fff;
      border-bottom: 1px solid #e8e6e1;
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    nav h2 { margin: 0; font-size: 22px; }
    .animated-gradient-text {
      background: linear-gradient(270deg,#00ff00,#7928ca,#abaaac,#48bb78,#ed8936,#ff0000);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: flowAndGlow 8s ease infinite;
      display: inline-block;
    }
    @keyframes flowAndGlow {
      0% {background-position:0% 50%;filter:drop-shadow(0 0 5px rgba(255,255,255,.2));}
      50% {background-position:100% 50%;filter:drop-shadow(0 0 15px rgba(255,255,255,.6));}
      100% {background-position:0% 50%;filter:drop-shadow(0 0 5px rgba(255,255,255,.2));}
    }

    /* Registration wrapper */
    .register-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh;
    }
    .register-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 14px;
      padding: 2rem;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 2px 6px rgba(0,0,0,.05);
    }
    .register-card h1 {
      font-size: 22px;
      margin-bottom: 1.5rem;
      text-align: center;
      color: #1a1a1a;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    label {
      font-size: 13px;
      font-weight: 600;
      color: #333;
      display: block;
      margin-bottom: .4rem;
    }
    input {
      width: 100%;
      padding: .6rem .75rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    input:focus {
      border-color: #D85A30;
      outline: none;
      box-shadow: 0 0 0 2px rgba(216,90,48,.2);
    }
    .btn-primary {
      background: #D85A30;
      color: #fff;
      border: none;
      padding: .7rem 1.5rem;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      width: 100%;
      margin-top: 1rem;
    }
    .btn-primary:hover { background:#993C1D; }
    .register-footer {
      text-align: center;
      margin-top: 1rem;
      font-size: 13px;
      color: #666;
    }
    .register-footer a {
      color: #D85A30;
      text-decoration: none;
    }
    .register-footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <h2><span>commerce</span><span class="animated-gradient-text">.za</span></h2>
    <div>
      <a href="#">Marketplace</a>
      <a href="#" style="margin-left:1rem;">Verified Sellers</a>
      <a href="#" style="margin-left:1rem;">About</a>
    </div>
  </nav>

  <!-- Registration Form -->
  <div class="register-wrapper">
    <div class="register-card">
      <h1>Register Product</h1>
      <form method="post" action="formHandlers/registerProduct.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="productName">Product Name *</label>
          <input type="text" id="productName" name="productName" placeholder="Nke Air Forces" required>
        </div>
        <div class="form-group">
          <label for="description">Description *</label>
          <input type="text" id="description" name="description" placeholder="Brand New Nike Air Force 1s, not worn">
        </div>
        <div class="form-group">
          <label for="price">Price *</label>
          <input type="number" id="price" name="price" step="0.01" min="0" placeholder="1099.99" required>
        </div>
        <div class="form-group">
          <label for="productQuantity">Quantity *</label>
          <input type="number" id="productQuantity" name="productQuantity" min="1" placeholder="10" required>
        </div>
        <div class="form-group">
          <label for="category">Category *</label>
          <input type="test" id="category" name="category" placeholder="Clothing" required>
        </div>
        
        <button type="submit" class="btn-primary">Add Product</button>
        <button class="btn-primary">Cancel</button>
      </form>
    </div>
  </div>

</body>
</html>
