<?php
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "controllers/CartController.php";
  require "controllers/UserController.php";
  require "models/product.php";
  require "controllers/ProductController.php";
  require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — List a Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background: #f5f3ef;
      margin: 0;
      padding: 0;
      color: #1a1a1a;
    }

    .page-wrapper {
      display: flex;
      min-height: 100vh;
      /* padding-top: 64px; */
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
      font-size: 16px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #e8e6e1;
      line-height: 1.3;
    }
    .sidebar-greeting span {
      display: block;
      font-size: 11px;
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
    .sidebar-link:hover { background: #f5f3ef; color: #1a1a1a; }
    .sidebar-link.active { background: #fff0ed; color: #D85A30; }
    .sidebar-link svg { flex-shrink: 0; opacity: .7; }
    .sidebar-link:hover svg, .sidebar-link.active svg { opacity: 1; }

    .sidebar-spacer { flex: 1; }

    .sidebar-wallet {
      background: #1a1a1a;
      border-radius: 10px;
      padding: .85rem 1rem;
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
      font-weight: 700;
      color: #fff;
    }

    /* ── Main ── */
    .main {
      flex: 1;
      padding: 2rem 2.5rem;
    }

    .main-header {
      margin-bottom: 2rem;
    }
    .main-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 .35rem;
    }
    .main-header p {
      font-size: 13px;
      color: #999;
      margin: 0;
    }

    /* ── Form card ── */
    .form-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 14px;
      padding: 2rem;
      /* width: 100%; */
      /* display: flex; */
      /* flex-direction: column; */
      gap: 1.25rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: .8rem;
    }

    .form-group label {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: #300808;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      padding: .65rem .85rem;
      border: 1px solid #cab885;
      border-radius: 8px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      color: #1a1a1a;
      background: #faf9f7;
      outline: none;
      margin-bottom: .3rem;
      transition: border-color .15s, background .15s;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: #D85A30;
      background: #fff;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    .hint {
      font-size: 11px;
      color: #bbb;
      margin-top: 2px;
    }

    .error-banner {
      background: #fff0ed;
      border: 1px solid #f5c4b5;
      color: #D85A30;
      border-radius: 8px;
      padding: .65rem 1rem;
      font-size: 13px;
    }

    .btn-submit {
      background: #D85A30;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: .75rem 1.5rem;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background .15s;
      align-self: flex-start;
      width: 100%;
    }
    .btn-submit:hover { background: #993C1D; }
  </style>
</head>
<body>

<?php include 'components/navbar.php'; ?>

<div class="page-wrapper">

  <!-- Sidebar -->
  <aside class="sidebar">
    <?php
      $userController = new UserController($connection);
      $currentUser = $userController->getUser($sessionUserId);
    ?>
    <div class="sidebar-greeting">
      <span>Logged in as</span>
      <?= htmlspecialchars($currentUser["firstName"] . " " . $currentUser["lastName"]) ?>
    </div>

    <div class="sidebar-label">Menu</div>

    <a href="/dashboard.php" class="sidebar-link">
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

    <a href="/registerProductPage.php" class="sidebar-link active">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      List a Product
    </a>

    <div class="sidebar-label">Resources</div>

    <a href="/sellerResources.php" class="sidebar-link">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Seller Resources
    </a>

    <div class="sidebar-spacer"></div>

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
    <div class="main-header">
      <h1>List a Product</h1>
      <p>Fill in the details below and your listing will go live on the dashboard immediately.</p>
    </div>

    <?php if (isset($_GET["error"])): ?>
      <div class="error-banner" style="margin-bottom:1.25rem;">
        <?php if ($_GET["error"] === "missing_fields"): ?>
          Please fill in all required fields.
        <?php elseif ($_GET["error"] === "invalid_price"): ?>
          Price must be a positive number.
        <?php elseif ($_GET["error"] === "invalid_quantity"): ?>
          Quantity must be a whole number greater than zero.
        <?php else: ?>
          Something went wrong, please try again.
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="form-card">
      <form method="POST" action="/formHandlers/registerProduct.php" enctype="multipart/form-data">

        <div class="form-group">
          <label>Product Name</label>
          <input type="text" name="name" maxlength="30" placeholder="e.g. iPhone 13 Pro" required>
          <span class="hint">Max 30 characters</span>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" placeholder="Describe your product — condition, features, reason for selling..." required></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Price (R)</label>
            <input type="number" name="price" min="1" step="0.01" placeholder="0.00" required>
          </div>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" min="1" step="1" placeholder="1" required>
          </div>
        </div>

        <div class="form-group">
          <label>Category</label>
          <select name="category" required>
            <option value="" disabled selected>Select a category</option>
            <option value="Electronics">Electronics</option>
            <option value="Clothing">Clothing</option>
            <option value="Furniture">Furniture</option>
            <option value="Books">Books</option>
            <option value="Sports">Sports</option>
            <option value="Toys">Toys</option>
            <option value="Vehicles">Vehicles</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Product Image</label>
          <input class="form-control" type="file" name="image" id="formFile">
        </div>

        <button type="submit" class="btn-submit">Publish Listing</button>

      </form>
    </div>
  </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
<script src="utils/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>