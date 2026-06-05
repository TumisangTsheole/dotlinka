<?php
    require "data/global/sessionData.php";
    require "db/dbconnection.php";
    // require "controllers/OrderController.php";
    require "controllers/CartController.php";
    require "controllers/Router.php";
?>

<?php
//   require "data/global/sessionData.php";
//   require "db/dbconnection.php";
//   require "controllers/CartController.php";
//   require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — Cart</title>
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
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      margin-bottom: 1.75rem;
    }
    .main-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0;
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

    /* ── Seller group ── */
    .seller-group {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 14px;
      overflow: hidden;
      margin-bottom: 1.5rem;
    }

    .seller-group-header {
      padding: .85rem 1.25rem;
      background: #faf9f7;
      border-bottom: 1px solid #e8e6e1;
      display: flex;
      align-items: center;
      gap: .5rem;
      font-size: 13px;
      font-weight: 600;
      color: #555;
    }
    .seller-group-header svg { opacity: .5; }

    .cart-item {
      padding: 1rem 1.25rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #f0eeea;
    }
    .cart-item:last-of-type { border-bottom: none; }

    .item-name {
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
    }
    .item-cat {
      font-size: 11px;
      color: #aaa;
      margin-top: 2px;
    }
    .item-out {
      font-size: 12px;
      color: #e05252;
      font-weight: 600;
      margin-top: 3px;
    }

    .item-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .item-price {
      font-size: 15px;
      font-weight: 700;
      color: #D85A30;
    }

    .btn-remove {
      background: none;
      border: 1px solid #e8e6e1;
      border-radius: 6px;
      padding: .3rem .65rem;
      font-size: 12px;
      color: #888;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: border-color .15s, color .15s;
    }
    .btn-remove:hover { border-color: #D85A30; color: #D85A30; }

    .seller-group-footer {
      padding: .85rem 1.25rem;
      border-top: 1px solid #e8e6e1;
      background: #faf9f7;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .group-total {
      font-size: 15px;
      font-weight: 700;
      color: #1a1a1a;
    }
    .group-total span {
      font-size: 12px;
      font-weight: 500;
      color: #aaa;
      margin-right: .5rem;
    }

    .btn-checkout {
      background: #D85A30;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: .55rem 1.25rem;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background .15s;
    }
    .btn-checkout:hover { background: #993C1D; }
    .btn-checkout:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .empty-state {
      text-align: center;
      padding: 4rem 1rem;
      color: #aaa;
      font-size: 14px;
    }
    .empty-state a { color: #D85A30; text-decoration: none; }
    .empty-state a:hover { text-decoration: underline; }

    .modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 1000;
    align-items: center;
    justify-content: center;
  }
  .modal-overlay.open { display: flex; }

  .modal-box {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    width: 90%;
    max-width: 420px;
    display: flex;
    flex-direction: column;
    gap: .85rem;
    text-align: center;
  }

  .modal-icon {
    font-size: 32px;
    line-height: 1;
  }

  .modal-box h2 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: #1a1a1a;
  }

  .modal-desc {
    font-size: 14px;
    color: #555;
    margin: 0;
    line-height: 1.6;
  }

  .modal-note {
    background: #f5f3ef;
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: 12px;
    color: #888;
    line-height: 1.6;
    text-align: left;
  }

  .modal-actions {
    display: flex;
    gap: .75rem;
    margin-top: .25rem;
  }

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
    transition: background .15s;
  }
  .btn-cancel-modal:hover { background: #e8e6e1; }

  .btn-confirm-modal {
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
    transition: background .15s;
  }
  .btn-confirm-modal:hover { background: #993C1D; }

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
    <?php
      require_once "controllers/UserController.php";
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

    <a href="/cartPage.php" class="sidebar-link active">
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
      <h1>My Cart</h1>
    </div>

    <?php if (isset($_GET["success"])): ?>
      <div class="alert alert-success">✓ Order placed successfully — the seller has been notified.</div>
    <?php endif; ?>

    <?php if (isset($_GET["error"])): ?>
      <div class="alert alert-error">
        <?php if ($_GET["error"] === "insufficient_balance"): ?>
          Insufficient wallet balance to complete this purchase.
        <?php elseif ($_GET["error"] === "transaction_failed"): ?>
          Something went wrong, please try again.
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (empty($cartData)): ?>
      <div class="empty-state">
        <p>Your cart is empty.</p>
        <a href="/dashboard.php">Browse listings →</a>
      </div>

    <?php else: ?>

      <?php
        // group cart items by seller
        $grouped = [];
        foreach ($cartData as $item) {
          $sid = $item["seller"];
          if (!isset($grouped[$sid])) {
            $grouped[$sid] = [
              "sellerName" => $item["sellerFirstName"] . " " . $item["sellerLastName"],
              "sellerId"   => $sid,
              "items"      => [],
              "total"      => 0,
              "hasOutOfStock" => false
            ];
          }
          $outOfStock = intval($item["quantity"]) <= 0;
          if ($outOfStock) $grouped[$sid]["hasOutOfStock"] = true;
          else $grouped[$sid]["total"] += $item["price"];
          $grouped[$sid]["items"][] = array_merge($item, ["outOfStock" => $outOfStock]);
        }
      ?>

      <?php foreach ($grouped as $group): ?>
        <div class="seller-group">

          <div class="seller-group-header">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Sold by <?= htmlspecialchars($group["sellerName"]) ?>
          </div>

          <?php foreach ($group["items"] as $item): ?>
            <div class="cart-item" style="<?= $item["outOfStock"] ? 'opacity:.5;' : '' ?>">
              <div>
                <div class="item-name"><?= htmlspecialchars($item["name"]) ?></div>
                <div class="item-cat"><?= htmlspecialchars($item["category"]) ?></div>
                <?php if ($item["outOfStock"]): ?>
                  <div class="item-out">Out of stock — please remove</div>
                <?php endif; ?>
              </div>
              <div class="item-right">
                <?php if (!$item["outOfStock"]): ?>
                  <div class="item-price">R<?= number_format($item["price"], 2) ?></div>
                <?php endif; ?>
                <form method="POST" action="/formHandlers/removeFromCart.php">
                  <input type="hidden" name="productId" value="<?= $item["id"] ?>">
                  <button type="submit" class="btn-remove">Remove</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="seller-group-footer">
            <div class="group-total">
              <span>Subtotal</span>
              R<?= number_format($group["total"], 2) ?>
            </div>
            <form method="POST" action="/formHandlers/processCheckout.php" 
              class="checkout-form"
              data-seller="<?= htmlspecialchars($group["sellerName"]) ?>"
              data-total="R<?= number_format($group["total"], 2) ?>">
              <input type="hidden" name="sellerId" value="<?= htmlspecialchars($group["sellerId"]) ?>">
              <button
                type="button"
                class="btn-checkout"
                <?= $group["hasOutOfStock"] ? 'disabled title="Remove out of stock items first"' : '' ?>
                onclick="openConfirm(this)"
              >
                Checkout with <?= htmlspecialchars($group["sellerName"]) ?>
              </button>
            </form>
          </div>

        </div>
      <?php endforeach; ?>

    <?php endif; ?>
  </main>
</div>

<!-- Confirm checkout modal -->
<div class="modal-overlay" id="confirmModal">
  <div class="modal-box">
    <div class="modal-icon">🛒</div>
    <h2 id="modalTitle">Confirm Purchase</h2>
    <p id="modalBody" class="modal-desc"></p>
    <div class="modal-note">
      Funds will be held in escrow until you confirm receipt of your order. You can cancel anytime before the seller marks it as shipped.
    </div>
    <div class="modal-actions">
      <button class="btn-cancel-modal" onclick="closeConfirm()">Go Back</button>
      <button class="btn-confirm-modal" id="modalConfirmBtn">Confirm & Pay</button>
    </div>
  </div>
</div>
<script>
  let pendingForm = null;

  function openConfirm(btn) {
    const form   = btn.closest("form");
    const seller = form.dataset.seller;
    const total  = form.dataset.total;

    pendingForm = form;

    document.getElementById("modalTitle").textContent = "Confirm Purchase";
    document.getElementById("modalBody").textContent  =
      "You are about to checkout with " + seller + " for a total of " + total + ". Once confirmed, funds will be held in escrow until you receive your order.";

    document.getElementById("modalConfirmBtn").onclick = function() {
      closeConfirm();
      form.submit();
    };

    document.getElementById("confirmModal").classList.add("open");
  }

  function closeConfirm() {
    document.getElementById("confirmModal").classList.remove("open");
    pendingForm = null;
  }

  // close on overlay click
  document.getElementById("confirmModal").addEventListener("click", function(e) {
    if (e.target === this) closeConfirm();
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
<script src="utils/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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