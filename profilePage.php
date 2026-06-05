<?php
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "controllers/CartController.php";
  require "controllers/ProductController.php";
  require "controllers/OrderController.php";
  require "controllers/UserController.php";
  require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — My Profile</title>
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
      overflow-y: auto;
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
      overflow-y: auto;
    }

    /* ── Alerts ── */
    .alert {
      border-radius: 10px;
      padding: .75rem 1.1rem;
      font-size: 14px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .alert-success { background: #edfaf3; border: 1px solid #6fcf97; color: #1d6b42; }
    .alert-error   { background: #fff0ed; border: 1px solid #f5c4b5; color: #D85A30; }

    /* ── Section titles ── */
    .section-title {
      font-size: 18px;
      font-weight: 700;
      color: #1a1a1a;
      margin: 0 0 1.25rem;
    }

    .section-block {
      margin-bottom: 2.5rem;
    }

    /* ── User info ── */
    .info-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      padding: 1.5rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 1.25rem;
    }
    .info-field span {
      display: block;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: #aaa;
      margin-bottom: 4px;
    }
    .info-field p {
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
      margin: 0;
    }

    /* ── Listings grid ── */
    .listings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
      gap: 1.25rem;
    }

    .listing-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .listing-img {
      height: 130px;
      background: #f0eeea;
      overflow: hidden;
    }
    .listing-img img { width: 100%; height: 100%; object-fit: cover; }

    .listing-body {
      padding: .9rem 1rem;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: .25rem;
    }
    .listing-cat {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #aaa;
    }
    .listing-name {
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
    }
    .listing-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: .5rem;
      padding-top: .5rem;
      border-top: 1px solid #f0eeea;
    }
    .listing-price { font-size: 15px; font-weight: 700; color: #D85A30; }
    .listing-qty   { font-size: 11px; color: #aaa; font-weight: 500; }
    .listing-qty.low { color: #e07b3a; font-weight: 600; }
    .listing-qty.out { color: #e05252; font-weight: 600; }

    .listing-actions {
      padding: .75rem 1rem;
      border-top: 1px solid #f0eeea;
      display: flex;
      gap: .5rem;
    }

    .btn-edit {
      flex: 1;
      background: #f5f3ef;
      border: 1px solid #e8e6e1;
      border-radius: 6px;
      padding: .4rem .75rem;
      font-size: 12px;
      font-weight: 600;
      color: #444;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background .15s;
    }
    .btn-edit:hover { background: #e8e6e1; }

    .btn-delete {
      flex: 1;
      background: #fff0ed;
      border: 1px solid #f5c4b5;
      border-radius: 6px;
      padding: .4rem .75rem;
      font-size: 12px;
      font-weight: 600;
      color: #D85A30;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background .15s;
    }
    .btn-delete:hover { background: #ffe0d6; }

    /* ── Orders ── */
    .order-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 1rem;
    }

    .order-header {
      padding: .85rem 1.25rem;
      background: #faf9f7;
      border-bottom: 1px solid #e8e6e1;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: .5rem;
    }

    .order-meta {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .order-id {
      font-size: 12px;
      font-weight: 700;
      color: #1a1a1a;
    }

    .order-date {
      font-size: 12px;
      color: #aaa;
    }

    .order-party {
      font-size: 12px;
      color: #555;
      font-weight: 500;
    }

    /* status badges */
    .badge {
      font-size: 11px;
      font-weight: 700;
      padding: .25rem .6rem;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: .04em;
    }
    .badge-pending   { background: #fff7e6; color: #b7791f; }
    .badge-shipped   { background: #ebf8ff; color: #2b6cb0; }
    .badge-completed { background: #edfaf3; color: #1d6b42; }
    .badge-cancelled { background: #f5f3ef; color: #aaa;    }

    .order-items {
      padding: .75rem 1.25rem;
      border-bottom: 1px solid #f0eeea;
    }

    .order-item-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: .4rem 0;
      font-size: 13px;
    }
    .order-item-row:not(:last-child) { border-bottom: 1px solid #f5f3ef; }

    .order-item-name { font-weight: 600; color: #1a1a1a; }
    .order-item-cat  { font-size: 11px; color: #aaa; }
    .order-item-amount { font-weight: 700; color: #D85A30; font-size: 14px; }

    .order-footer {
      padding: .85rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .order-total {
      font-size: 14px;
      font-weight: 700;
      color: #1a1a1a;
    }
    .order-total span {
      font-size: 12px;
      font-weight: 500;
      color: #aaa;
      margin-right: .4rem;
    }

    .order-actions { display: flex; gap: .5rem; }

    .btn-action {
      border: none;
      border-radius: 7px;
      padding: .45rem 1rem;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background .15s;
    }
    .btn-ship    { background: #ebf8ff; color: #2b6cb0; }
    .btn-ship:hover    { background: #bee3f8; }
    .btn-confirm { background: #edfaf3; color: #1d6b42; }
    .btn-confirm:hover { background: #c6f6d5; }
    .btn-cancel  { background: #fff0ed; color: #D85A30; }
    .btn-cancel:hover  { background: #ffe0d6; }

    /* ── Edit modal ── */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.4);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }
    .modal-overlay.open { display: flex; }

    .modal-box {
      background: #fff;
      border-radius: 14px;
      padding: 2rem;
      width: 90%;
      max-width: 460px;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .modal-box h2 { font-size: 18px; font-weight: 700; margin: 0; }
    .modal-box label {
      font-size: 12px;
      font-weight: 600;
      color: #666;
      display: block;
      margin-bottom: 4px;
    }
    .modal-box input,
    .modal-box textarea {
      width: 100%;
      padding: .55rem .75rem;
      border: 1px solid #e8e6e1;
      border-radius: 8px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: border-color .15s;
    }
    .modal-box input:focus,
    .modal-box textarea:focus { border-color: #D85A30; }
    .modal-box textarea { resize: vertical; min-height: 80px; }
    .modal-actions { display: flex; gap: .75rem; margin-top: .5rem; }

    .btn-save {
      flex: 1;
      background: #D85A30;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: .65rem;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
    }
    .btn-save:hover { background: #993C1D; }

    .btn-cancel-modal {
      flex: 1;
      background: #f5f3ef;
      border: 1px solid #e8e6e1;
      border-radius: 8px;
      padding: .65rem;
      font-size: 14px;
      font-weight: 600;
      color: #444;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
    }
    .btn-cancel-modal:hover { background: #e8e6e1; }

    .empty-state {
      text-align: center;
      padding: 2.5rem 1rem;
      color: #aaa;
      font-size: 14px;
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
    }
    .empty-state a { color: #D85A30; text-decoration: none; }
  
    /* ── RESPONSIVE: Sidebar pages ── */
    @media (max-width: 768px) {
      .page-wrapper { flex-direction: column; }
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1060;
        transform: translateX(-100%);
        transition: transform .25s ease;
        overflow-y: auto;
        min-width: 240px !important;
      }
      .sidebar.open { transform: translateX(0); }
      .main {
        width: 100% !important;
        padding: 1rem !important;
        margin-left: 0 !important;
      }
      /* Give some top padding so content isn't under the hamburger */
      .main-header, .page-wrapper > .main > *:first-child { margin-top: .5rem; }
    }
</style>
</head>
<body>
  <?php include 'components/loading.php'; ?>

<?php include 'components/navbar.php'; ?>
<!-- Sidebar toggle button (mobile) -->
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu">
  <svg width="20" height="20" fill="none" stroke="#1a1a1a" stroke-width="2" viewBox="0 0 24 24">
    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
  </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="page-wrapper">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-greeting">
      <span>Logged in as</span>
      <?= htmlspecialchars($profileUser["firstName"] . " " . $profileUser["lastName"]) ?>
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

    <a href="/profilePage.php" class="sidebar-link active">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      My Profile & Listings
    </a>

    <a href="/registerProductPage.php" class="sidebar-link">
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

    <?php if (isset($_GET["success"])): ?>
      <div class="alert alert-success">
        <?php if ($_GET["success"] === "shipped"): ?>
          ✓ Order marked as shipped.
        <?php elseif ($_GET["success"] === "completed"): ?>
          ✓ Order confirmed — payment has been released to the seller.
        <?php elseif ($_GET["success"] === "cancelled"): ?>
          ✓ Order cancelled — your funds have been refunded.
        <?php elseif ($_GET["success"] === "listed"): ?>
          ✓ Your product is now live on the dashboard.
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET["error"])): ?>
      <div class="alert alert-error">
        Something went wrong, please try again.
      </div>
    <?php endif; ?>

    <!-- My Details -->
    <div class="section-block">
      <p class="section-title">My Details</p>
      <div class="info-card">
        <div class="info-field">
          <span>Full Name</span>
          <p><?= htmlspecialchars($profileUser["firstName"] . " " . $profileUser["lastName"]) ?></p>
        </div>
        <div class="info-field">
          <span>Email</span>
          <p><?= htmlspecialchars($profileUser["email"]) ?></p>
        </div>
        <div class="info-field">
          <span>Cell</span>
          <p><?= htmlspecialchars($profileUser["cellNumber"]) ?></p>
        </div>
        <div class="info-field">
          <span>Address</span>
          <p><?= htmlspecialchars($profileUser["physicalAddress"]) ?></p>
        </div>
      </div>
    </div>

    <!-- My Listings -->
    <div class="section-block">
      <p class="section-title">My Listings</p>
      <?php if (empty($myListings)): ?>
        <div class="empty-state">
          You haven't listed anything yet. <a href="/registerProductPage.php">List your first product →</a>
        </div>
      <?php else: ?>
        <div class="listings-grid">
          <?php foreach ($myListings as $listing): ?>
            <?php
              $qty = intval($listing["quantity"]);
              $qtyClass = $qty === 0 ? "out" : ($qty <= 3 ? "low" : "");
              $qtyLabel = $qty === 0 ? "Out of stock" : ($qty === 1 ? "1 left" : $qty . " in stock");
            ?>
            <div class="listing-card">
              <div class="listing-img">
				
                <!--<img src="https://placehold.co/600x400/1a1a1a/f5f3ef/png" alt="<?= htmlspecialchars($listing["name"]) ?>">-->
                <img src="<?= $listing["image"] ?>" alt="<?= htmlspecialchars($listing["name"]) ?>">
              </div>
              <div class="listing-body">
                <p class="listing-cat"><?= htmlspecialchars($listing["category"]) ?></p>
                <p class="listing-name"><?= htmlspecialchars($listing["name"]) ?></p>
                <div class="listing-meta">
                  <span class="listing-price">R<?= number_format($listing["price"], 2) ?></span>
                  <span class="listing-qty <?= $qtyClass ?>"><?= $qtyLabel ?></span>
                </div>
              </div>
              <div class="listing-actions">
                <button class="btn-edit" onclick="openEdit(
                  <?= $listing["id"] ?>,
                  '<?= addslashes($listing["name"]) ?>',
                  '<?= addslashes($listing["description"]) ?>',
                  <?= $listing["price"] ?>,
                  <?= $listing["quantity"] ?>
                )">Edit</button>
                <form method="POST" action="/formHandlers/deleteProduct.php" onsubmit="return confirm('Remove this listing?')">
                  <input type="hidden" name="productId" value="<?= $listing["id"] ?>">
                  <button type="submit" class="btn-delete">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- My Purchases (as buyer) -->
    <div class="section-block">
      <p class="section-title">My Purchases</p>
      <?php if (empty($myPurchases)): ?>
        <div class="empty-state">No purchases yet.</div>
      <?php else: ?>
        <?php foreach ($myPurchases as $order): ?>
          <div class="order-card">
            <div class="order-header">
              <div class="order-meta">
                <span class="order-id">Order #<?= $order["id"] ?></span>
                <span class="order-date"><?= date("d M Y", strtotime($order["created_at"])) ?></span>
                <span class="order-party">
                  Seller: <?= htmlspecialchars($order["sellerFirstName"] . " " . $order["sellerLastName"]) ?>
                </span>
              </div>
              <span class="badge badge-<?= $order["status"] ?>"><?= ucfirst($order["status"]) ?></span>
            </div>

            <div class="order-items">
              <?php foreach ($order["items"] as $item): ?>
                <div class="order-item-row">
                  <div>
                    <div class="order-item-name"><?= htmlspecialchars($item["product_name"]) ?></div>
                    <div class="order-item-cat"><?= htmlspecialchars($item["category"]) ?></div>
                  </div>
                  <div class="order-item-amount">R<?= number_format($item["amount"], 2) ?></div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="order-footer">
              <div class="order-total">
                <span>Total</span>R<?= number_format($order["total"], 2) ?>
              </div>
              <div class="order-actions">
                <?php if ($order["status"] === "shipped"): ?>
                  <form method="POST" action="/formHandlers/confirmReceipt.php">
                    <input type="hidden" name="orderId" value="<?= $order["id"] ?>">
                    <button type="submit" class="btn-action btn-confirm"
                      onclick="return confirm('Confirm you have received this order? This will release payment to the seller.')">
                      Confirm Receipt
                    </button>
                  </form>
                <?php endif; ?>
                <?php if ($order["status"] === "pending"): ?>
                  <form method="POST" action="/formHandlers/cancelOrder.php">
                    <input type="hidden" name="orderId" value="<?= $order["id"] ?>">
                    <button type="submit" class="btn-action btn-cancel"
                      onclick="return confirm('Cancel this order? Your funds will be refunded.')">
                      Cancel Order
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- My Sales (as seller) -->
    <div class="section-block">
      <p class="section-title">My Sales</p>
      <?php if (empty($mySales)): ?>
        <div class="empty-state">No sales yet.</div>
      <?php else: ?>
        <?php foreach ($mySales as $order): ?>
          <div class="order-card">
            <div class="order-header">
              <div class="order-meta">
                <span class="order-id">Order #<?= $order["id"] ?></span>
                <span class="order-date"><?= date("d M Y", strtotime($order["created_at"])) ?></span>
                <span class="order-party">
                  Buyer: <?= htmlspecialchars($order["buyerFirstName"] . " " . $order["buyerLastName"]) ?>
                </span>
              </div>
              <span class="badge badge-<?= $order["status"] ?>"><?= ucfirst($order["status"]) ?></span>
            </div>

            <div class="order-items">
              <?php foreach ($order["items"] as $item): ?>
                <div class="order-item-row">
                  <div>
                    <div class="order-item-name"><?= htmlspecialchars($item["product_name"]) ?></div>
                    <div class="order-item-cat"><?= htmlspecialchars($item["category"]) ?></div>
                  </div>
                  <div class="order-item-amount">R<?= number_format($item["amount"], 2) ?></div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="order-footer">
              <div class="order-total">
                <span>Total</span>R<?= number_format($order["total"], 2) ?>
              </div>
              <div class="order-actions">
                <?php if ($order["status"] === "pending"): ?>
                  <form method="POST" action="/formHandlers/markShipped.php">
                    <input type="hidden" name="orderId" value="<?= $order["id"] ?>">
                    <button type="submit" class="btn-action btn-ship"
                      onclick="return confirm('Mark this order as shipped?')">
                      Mark as Shipped
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </main>
</div>

<!-- Edit modal -->
<div class="modal-overlay" id="editModal">
  <div class="modal-box">
    <h2>Edit Listing</h2>
    <form method="POST" action="/formHandlers/updateProduct.php">
      <input type="hidden" name="productId" id="edit-id">
      <div>
        <label>Product Name</label>
        <input type="text" name="name" id="edit-name" required>
      </div>
      <div>
        <label>Description</label>
        <textarea name="description" id="edit-description" required></textarea>
      </div>
      <div>
        <label>Price (R)</label>
        <input type="number" name="price" id="edit-price" step="0.01" min="0" required>
      </div>
      <div>
        <label>Quantity</label>
        <input type="number" name="quantity" id="edit-quantity" min="0" required>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-cancel-modal" onclick="closeEdit()">Cancel</button>
        <button type="submit" class="btn-save">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function openEdit(id, name, description, price, quantity) {
    document.getElementById("edit-id").value          = id;
    document.getElementById("edit-name").value        = name;
    document.getElementById("edit-description").value = description;
    document.getElementById("edit-price").value       = price;
    document.getElementById("edit-quantity").value    = quantity;
    document.getElementById("editModal").classList.add("open");
  }
  function closeEdit() {
    document.getElementById("editModal").classList.remove("open");
  }
  document.getElementById("editModal").addEventListener("click", function(e) {
    if (e.target === this) closeEdit();
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var btn = document.getElementById("sidebarToggle");
    var overlay = document.getElementById("sidebarOverlay");
    var sidebar = document.querySelector(".sidebar");
    if (!btn || !sidebar) return;
    btn.addEventListener("click", function() {
      sidebar.classList.toggle("open");
      overlay.classList.toggle("open");
    });
    overlay.addEventListener("click", function() {
      sidebar.classList.remove("open");
      overlay.classList.remove("open");
    });
  });
</script>
</body>
</html>
