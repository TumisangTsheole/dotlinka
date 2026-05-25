<?php
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "controllers/ProductController.php";
  require "controllers/OrderController.php";
  require "controllers/UserController.php";
  require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — My Profile</title>
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
      padding-top: 64px;
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
      overflow-y: auto;
    }

    .section-title {
      font-size: 20px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 1.25rem;
    }

    /* ── User info card ── */
    .info-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      padding: 1.5rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.25rem;
      margin-bottom: 2.5rem;
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

    /* ── Listings ── */
    .listings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.25rem;
      margin-bottom: 2.5rem;
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
    .listing-img img {
      width: 100%; height: 100%; object-fit: cover;
    }

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
    .listing-price {
      font-size: 15px;
      font-weight: 700;
      color: #D85A30;
    }
    .listing-qty {
      font-size: 11px;
      color: #aaa;
      font-weight: 500;
    }
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
      text-align: center;
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
      text-align: center;
      transition: background .15s;
    }
    .btn-delete:hover { background: #ffe0d6; }

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
    .modal-box h2 {
      font-size: 18px;
      font-weight: 700;
      margin: 0;
    }
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
    }
    .btn-save:hover { background: #993C1D; }

    .btn-cancel {
      flex: 1;
      background: #f5f3ef;
      border: 1px solid #e8e6e1;
      border-radius: 8px;
      padding: .65rem;
      font-size: 14px;
      font-weight: 600;
      color: #444;
      cursor: pointer;
    }
    .btn-cancel:hover { background: #e8e6e1; }

    /* ── Orders ── */
    .order-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      overflow: hidden;
      font-size: 14px;
    }
    .order-table th {
      background: #f5f3ef;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: #aaa;
      padding: .75rem 1rem;
      text-align: left;
    }
    .order-table td {
      padding: .85rem 1rem;
      border-top: 1px solid #f0eeea;
      color: #1a1a1a;
    }
    .order-table tr:hover td { background: #faf9f7; }
    .order-amount { font-weight: 700; color: #D85A30; }
    .order-date { color: #aaa; font-size: 12px; }

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: #aaa;
      font-size: 14px;
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

    <!-- User info -->
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
        <p><?= htmlspecialchars($profileUser["address"]) ?></p>
      </div>
    </div>

    <!-- My listings -->
    <p class="section-title">My Listings</p>

    <?php if (empty($myListings)): ?>
      <div class="empty-state">You haven't listed anything yet. <a href="/registerProductPage.php" style="color:#D85A30;">List your first product →</a></div>
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
              <img src="https://placehold.co/600x400/1a1a1a/f5f3ef/png" alt="<?= htmlspecialchars($listing["name"]) ?>">
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

    <!-- Transaction history -->
    <p class="section-title">Purchase History</p>

    <?php if (empty($myOrders)): ?>
      <div class="empty-state">No purchases yet.</div>
    <?php else: ?>
      <table class="order-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Seller</th>
            <th>Amount</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($myOrders as $order): ?>
            <tr>
              <td><?= htmlspecialchars($order["product_name"]) ?></td>
              <td><?= htmlspecialchars($order["category"]) ?></td>
              <td><?= htmlspecialchars($order["sellerFirstName"] . " " . $order["sellerLastName"]) ?></td>
              <td class="order-amount">R<?= number_format($order["amount"], 2) ?></td>
              <td class="order-date"><?= date("d M Y", strtotime($order["created_at"])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

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
        <button type="button" class="btn-cancel" onclick="closeEdit()">Cancel</button>
        <button type="submit" class="btn-save">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
<script src="utils/script.js"></script>
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

  // close modal if overlay clicked
  document.getElementById("editModal").addEventListener("click", function(e) {
    if (e.target === this) closeEdit();
  });
</script>

</body>
</html>