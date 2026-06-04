<?php
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "data/dashboardData.php";
  require "controllers/ProductController.php";
  require "controllers/UserController.php";
  require "controllers/CartController.php";
  require "controllers/Router.php";

  // fetch logged in user's name for sidebar
  $userController = new UserController($connection);
  $currentUser = $userController->getUser($sessionUserId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; }

    body {
      font-family: Inter, sans-serif;
      background: #f5f3ef;
      margin: 0;
      padding: 0;
      color: #1a1a1a;
    }

    /* ── Layout ── */
    .page-wrapper {
      display: flex;
      min-height: 100vh;
      /* padding-top: 64px; navbar height */
    }

    /* ── Sidebar ── */
    .sidebar {
      width: 240px;
      min-width: 240px;
      background: #fff;
      border-right: 1px solid #e8e6e1;
      padding: 2rem 1.25rem;
      display: flex;
      flex-direction: column;
      gap: .25rem;
      position: sticky;
      top: 64px;
      height: calc(100vh - 64px);
    }

    .sidebar-greeting {
      font-family: 'DM Serif Display', serif;
      font-size: 18px;
      color: #1a1a1a;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #e8e6e1;
      line-height: 1.3;
    }
    .sidebar-greeting span {
      display: block;
      font-family: 'DM Sans', sans-serif;
      font-size: 12px;
      font-weight: 500;
      color: #999;
      text-transform: uppercase;
      letter-spacing: .05em;
      margin-bottom: 4px;
    }

    .sidebar-label {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #bbb;
      padding: .75rem .75rem .25rem;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      gap: .65rem;
      padding: .6rem .75rem;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      color: #444;
      text-decoration: none;
      transition: background .15s, color .15s;
    }
    .sidebar-link:hover {
      background: #f5f3ef;
      color: #1a1a1a;
    }
    .sidebar-link.active {
      background: #fff0ed;
      color: #D85A30;
    }
    .sidebar-link svg {
      flex-shrink: 0;
      opacity: .7;
    }
    .sidebar-link:hover svg, .sidebar-link.active svg { opacity: 1; }

    .sidebar-spacer { flex: 1; }

    .sidebar-wallet {
      background: #1a1a1a;
      border-radius: 10px;
      padding: .85rem 1rem;
      color: #fff;
      font-size: 13px;
    }
    .sidebar-wallet span {
      display: block;
      font-size: 11px;
      color: #999;
      margin-bottom: 4px;
      text-transform: uppercase;
      letter-spacing: .05em;
    }
    .sidebar-wallet strong {
      font-size: 20px;
      font-weight: 600;
      color: #fff;
    }

    /* ── Main content ── */
    .main {
      flex: 1;
      padding: 2rem 2.5rem;
      overflow-y: auto;
    }

    .main-header {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      margin-bottom: 1.75rem;
    }
    .main-header h1 {
      font-family: 'DM Serif Display', serif;
      font-size: 28px;
      margin: 0;
      color: #1a1a1a;
    }
    .main-header p {
      font-size: 13px;
      color: #999;
      margin: 0;
    }

    /* ── Product grid ── */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
      gap: 1.25rem;
    }

    .mp-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      text-decoration: none;
      color: inherit;
      transition: transform .2s, box-shadow .2s;
    }
    .mp-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(0,0,0,.07);
      color: inherit;
    }

    .mp-img {
      height: 150px;
      background: #f0eeea;
      overflow: hidden;
    }
    .mp-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform .35s ease;
    }
    .mp-card:hover .mp-img img { transform: scale(1.04); }

    .mp-body {
      padding: .9rem 1rem;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: .3rem;
    }

    .mp-cat {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #aaa;
    }

    .mp-name {
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
      line-height: 1.3;
    }

    .mp-desc {
      font-size: 12px;
      color: #888;
      line-height: 1.45;
      flex: 1;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .mp-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: .5rem;
      padding-top: .5rem;
      border-top: 1px solid #f0eeea;
    }

    .mp-price {
      font-size: 15px;
      font-weight: 700;
      color: #D85A30;
    }

    .mp-seller-name {
      font-size: 11px;
      color: #aaa;
      font-weight: 500;
    }

    /* success banner */
    .success-banner {
      background: #edfaf3;
      border: 1px solid #6fcf97;
      color: #1d6b42;
      border-radius: 10px;
      padding: .75rem 1.1rem;
      font-size: 14px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
  </style>
</head>
<body>

  <?php include 'components/navbar.php'; ?>

  <div class="page-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-greeting">
        <span>Logged in as</span>
        <?= htmlspecialchars($currentUser["firstName"] . " " . $currentUser["lastName"]) ?>
      </div>

      <div class="sidebar-label">Menu</div>

      <a href="/dashboard.php" class="sidebar-link active">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Browse Listings
      </a>

      <a href="/cartPage.php" class="sidebar-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        My Cart
      </a>

      <div class="sidebar-label">Selling</div>

      <a href="/profilePage.php" class="sidebar-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        My Profile & Listings
      </a>

      <a href="/registerProductPage.php" class="sidebar-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        List a Product
      </a>

      <div class="sidebar-label">Resources</div>

      <a href="/sellerResourcesPage.php" class="sidebar-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        Seller Resources
      </a>

      <div class="sidebar-spacer"></div>

      <!-- Wallet balance -->
      <?php
        $balanceStmt = $connection->prepare("SELECT walletBalance FROM users WHERE id = :userId;");
        $balanceStmt->execute([":userId" => $sessionUserId]);
        $walletRow = $balanceStmt->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="sidebar-wallet">
        <span>Wallet Balance</span>
        <strong>R<?= number_format($walletRow["walletBalance"], 2) ?></strong>
      </div>
    </aside>

    <!-- Main -->
    <main class="main">

      <?php if (isset($_GET["success"])): ?>
        <div class="success-banner">
          ✓ Purchase successful! Your wallet has been debited and your items are on their way.
        </div>
      <?php endif; ?>

      <div class="main-header">
        <h1>Browse Listings</h1>
        <p><?= count($dashboardPageProducts) ?> items available</p>
      </div>

      <div class="product-grid">
        <?php foreach ($dashboardPageProducts as $product): ?>
          <a href="./product-detail.php?id=<?= $product["id"] ?>" class="mp-card">
            <div class="mp-img">
              <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            </div>
            <div class="mp-body">
              <p class="mp-cat"><?= htmlspecialchars($product['category']) ?></p>
              <p class="mp-name"><?= htmlspecialchars($product['product_name']) ?></p>
              <p class="mp-desc"><?= htmlspecialchars($product['description']) ?></p>
              <div class="mp-footer">
                <span class="mp-price">R<?= number_format($product['price'], 2) ?></span>
                <span class="mp-seller-name"><?= htmlspecialchars($product['firstName']) ?></span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

    </main>
  </div>
  <!-- smooth scrollbar CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
    <script src="utils/script.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>