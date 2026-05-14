<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">

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

    /* Dashboard wrapper */
    .dashboard {
      width: 90%;
      margin: 2rem auto;
    }

    .dashboard-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }
    .dashboard-header h1 {
      font-size: 26px;
      margin: 0;
      color: #1a1a1a;
    }
    .dashboard-header a {
      font-size: 14px;
      color: #D85A30;
      text-decoration: none;
      border-bottom: 1px solid #F0997B;
      padding-bottom: 2px;
    }
    .dashboard-header a:hover {color:#993C1D;border-color:#993C1D;}

    /* Product grid */
    .row {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
      gap: 1.5rem;
    }
    .mp-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 14px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform .2s,border-color .2s;
    }
    .mp-card:hover {transform:translateY(-3px);border-color:#c4c0b8;}
    .mp-img {
      position: relative;
      height: 160px;
      overflow: hidden;
      background:#f0eeea;
    }
    .mp-img img {
      width:100%;height:100%;object-fit:cover;transition:transform .35s ease;
    }
    .mp-card:hover .mp-img img {transform:scale(1.04);}
    .mp-body {padding:1rem;flex:1;display:flex;flex-direction:column;}
    .mp-cat {font-size:10px;font-weight:600;text-transform:uppercase;color:#999;margin-bottom:4px;}
    .mp-name {font-size:14px;font-weight:600;color:#1a1a1a;margin-bottom:6px;}
    .mp-desc {font-size:12px;color:#777;line-height:1.4;margin-bottom:10px;flex:1;}
    .mp-price-row {display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
    .mp-price {font-size:16px;font-weight:600;color:#1a1a1a;}
    .mp-cond {font-size:10px;font-weight:600;text-transform:uppercase;padding:3px 6px;border-radius:4px;background:#f0eeea;color:#666;}
    .mp-seller {display:flex;align-items:center;gap:8px;}
    .mp-avatar {width:28px;height:28px;border-radius:50%;background:#f0eeea;color:#666;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;}
    .mp-seller-name {font-size:12px;font-weight:500;color:#1a1a1a;}
    .mp-seller-meta {font-size:11px;color:#999;}
    .mp-star {color:#EF9F27;}
  </style>
</head>
<body class="fs-5">

  <!-- Navbar -->
  <?php include 'components/navbar.php'; ?>

  <!-- Dashboard -->
  <div class="dashboard">
    <div class="dashboard-header">
      <h1>Product Dashboard</h1>
      <a href="/listings">View All Listings →</a>
    </div>

    <div class="row">
      <?php
      // Example product array (replace with DB query)
      $products = [
        [
          'title'=>'Sony WH-1000XM5 headphones',
          'category'=>'Electronics',
          'description'=>'Barely used, original box included.',
          'price'=>3200,
          'condition'=>'Like new',
          'image'=>'https://placehold.co/400x300/E6F1FB/378ADD?text=🎧',
          'seller'=>['name'=>'Thabo M.','initials'=>'TM','rating'=>'4.9','total_sales'=>142]
        ],
        [
          'title'=>"Vintage Levi's 501 jeans — W32 L32",
          'category'=>'Fashion',
          'description'=>'Authentic 90s stonewash. Minor fade adds character.',
          'price'=>850,
          'condition'=>'Good',
          'image'=>'https://placehold.co/400x300/EEEDFE/534AB7?text=👖',
          'seller'=>['name'=>'Lerato V.','initials'=>'LV','rating'=>'4.7','total_sales'=>38]
        ]
      ];
      foreach ($products as $product): ?>
        <a href="./product-detail.php" class="mp-card">
          <div class="mp-img">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
          </div>
          <div class="mp-body">
            <p class="mp-cat"><?= htmlspecialchars($product['category']) ?></p>
            <p class="mp-name"><?= htmlspecialchars($product['title']) ?></p>
            <p class="mp-desc"><?= htmlspecialchars($product['description']) ?></p>
            <div class="mp-price-row">
              <span class="mp-price">R <?= number_format($product['price']) ?></span>
              <span class="mp-cond"><?= htmlspecialchars($product['condition']) ?></span>
            </div>
            <div class="mp-seller">
              <div class="mp-avatar"><?= htmlspecialchars($product['seller']['initials']) ?></div>
              <div>
                <div class="mp-seller-name"><?= htmlspecialchars($product['seller']['name']) ?></div>
                <div class="mp-seller-meta"><span class="mp-star">★</span> <?= htmlspecialchars($product['seller']['rating']) ?> · <?= $product['seller']['total_sales'] ?> sales</div>
              </div>
            </div>
          </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
</body>
</html>
