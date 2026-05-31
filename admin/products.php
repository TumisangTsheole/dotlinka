<?php
  require "guard.php";
  require "../db/dbconnection.php";

  $products = $connection->query(
    "SELECT p.id, p.name, p.description, p.price, p.quantity, p.category,
            u.firstName AS sellerFirstName, u.lastName AS sellerLastName, u.id AS sellerId
     FROM products p
     INNER JOIN users u ON p.seller = u.id
     ORDER BY p.id DESC;"
  )->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>.linka — Administrator | Products</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .admin-nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 56px;
      background: #1a1a1a;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      z-index: 100;
    }
    .admin-nav-brand {
      display: flex;
      align-items: center;
      gap: .65rem;
      font-size: 14px;
      font-weight: 700;
      color: #fff;
      text-decoration: none;
    }
    .admin-badge {
      background: #D85A30;
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 4px;
      text-transform: uppercase;
      letter-spacing: .05em;
    }
    .admin-nav-links {
      display: flex;
      align-items: center;
      gap: .25rem;
    }
    .admin-nav-link {
      padding: .4rem .85rem;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      color: #aaa;
      text-decoration: none;
      transition: background .15s, color .15s;
    }
    .admin-nav-link:hover  { background: #2a2a2a; color: #fff; }
    .admin-nav-link.active { background: #2a2a2a; color: #fff; }
    .admin-nav-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .btn-back {
      font-size: 12px;
      font-weight: 600;
      color: #888;
      text-decoration: none;
      padding: .35rem .75rem;
      border: 1px solid #333;
      border-radius: 6px;
      transition: color .15s, border-color .15s;
    }
    .btn-back:hover { color: #fff; border-color: #555; }
    .btn-logout {
      font-size: 12px;
      font-weight: 600;
      color: #D85A30;
      text-decoration: none;
      padding: .35rem .75rem;
      border: 1px solid #5a2010;
      border-radius: 6px;
      transition: background .15s;
    }
    .btn-logout:hover { background: #D85A30; color: #fff; }

    .page-wrapper { padding-top: 56px; }
    .main {
      max-width: 1100px;
      margin: 0 auto;
      padding: 2.5rem 2rem;
    }

    .page-header {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      margin-bottom: 1.75rem;
    }
    .page-header h1 {
      font-size: 22px;
      font-weight: 700;
      margin: 0 0 .25rem;
    }
    .page-header p {
      font-size: 13px;
      color: #999;
      margin: 0;
    }

    .alert {
      border-radius: 10px;
      padding: .75rem 1.1rem;
      font-size: 13px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .alert-success { background: #edfaf3; border: 1px solid #6fcf97; color: #1d6b42; }
    .alert-error   { background: #fff0ed; border: 1px solid #f5c4b5; color: #D85A30; }

    /* ── Search bar ── */
    .search-bar {
      display: flex;
      gap: .75rem;
      margin-bottom: 1.25rem;
      align-items: center;
    }
    .search-bar input {
      flex: 1;
      max-width: 320px;
      padding: .55rem .85rem;
      border: 1px solid #e8e6e1;
      border-radius: 8px;
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      background: #fff;
      outline: none;
      transition: border-color .15s;
    }
    .search-bar input:focus { border-color: #D85A30; }
    .search-count {
      font-size: 12px;
      color: #aaa;
    }

    /* ── Table ── */
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      overflow: hidden;
      font-size: 13px;
    }
    .admin-table th {
      background: #faf9f7;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: #aaa;
      padding: .75rem 1rem;
      text-align: left;
      white-space: nowrap;
    }
    .admin-table td {
      padding: .85rem 1rem;
      border-top: 1px solid #f0eeea;
      color: #1a1a1a;
      vertical-align: middle;
    }
    .admin-table tr:hover td { background: #faf9f7; }

    .product-name { font-weight: 600; color: #1a1a1a; }
    .product-desc {
      font-size: 11px;
      color: #aaa;
      margin-top: 2px;
      max-width: 220px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .price  { font-weight: 700; color: #D85A30; }
    .muted  { color: #aaa; font-size: 12px; }
    .seller { color: #555; font-size: 12px; }

    .badge {
      font-size: 11px;
      font-weight: 700;
      padding: .25rem .6rem;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: .04em;
    }
    .badge-ok  { background: #edfaf3; color: #1d6b42; }
    .badge-low { background: #fff7e6; color: #b7791f; }
    .badge-out { background: #fff0ed; color: #D85A30; }

    .btn-delete {
      background: #fff0ed;
      border: 1px solid #f5c4b5;
      color: #D85A30;
      border-radius: 6px;
      padding: .3rem .75rem;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background .15s;
      white-space: nowrap;
    }
    .btn-delete:hover { background: #ffe0d6; }

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: #aaa;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <nav class="admin-nav">
    <a href="/admin/index.php" class="admin-nav-brand">
      .linka <span class="admin-badge">Administrator</span>
    </a>
    <div class="admin-nav-links">
      <a href="/admin/index.php"    class="admin-nav-link">Overview</a>
      <a href="/admin/users.php"    class="admin-nav-link">Users</a>
      <a href="/admin/products.php" class="admin-nav-link active">Products</a>
      <a href="/admin/orders.php"   class="admin-nav-link">Orders</a>
    </div>
    <div class="admin-nav-right">
      <a href="/dashboard.php"           class="btn-back">← Main Site</a>
      <a href="/formHandlers/logout.php" class="btn-logout">Logout</a>
    </div>
  </nav>

  <div class="page-wrapper">
    <main class="main">

      <div class="page-header">
        <div>
          <h1>Products</h1>
          <p><?= count($products) ?> listings on the platform</p>
        </div>
      </div>

      <?php if (isset($_GET["success"]) && $_GET["success"] === "deleted"): ?>
        <div class="alert alert-success">✓ Product removed successfully.</div>
      <?php endif; ?>
      <?php if (isset($_GET["error"])): ?>
        <div class="alert alert-error">Something went wrong, please try again.</div>
      <?php endif; ?>

      <!-- Search -->
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by name, category or seller..." oninput="filterTable()">
        <span class="search-count" id="searchCount"><?= count($products) ?> products</span>
      </div>

      <?php if (empty($products)): ?>
        <div class="empty-state">No products listed yet.</div>
      <?php else: ?>
        <table class="admin-table" id="productsTable">
          <thead>
            <tr>
              <th>Product</th>
              <th>Category</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Seller</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <?php
                $qty = intval($product["quantity"]);
                $qtyClass = $qty === 0 ? "badge-out" : ($qty <= 3 ? "badge-low" : "badge-ok");
                $qtyLabel = $qty === 0 ? "Out of stock" : ($qty === 1 ? "1 left" : $qty . " in stock");
              ?>
              <tr>
                <td>
                  <div class="product-name"><?= htmlspecialchars($product["name"]) ?></div>
                  <div class="product-desc"><?= htmlspecialchars($product["description"]) ?></div>
                </td>
                <td class="muted"><?= htmlspecialchars($product["category"]) ?></td>
                <td class="price">R<?= number_format($product["price"], 2) ?></td>
                <td>
                  <span class="badge <?= $qtyClass ?>"><?= $qtyLabel ?></span>
                </td>
                <td class="seller">
                  <?= htmlspecialchars($product["sellerFirstName"] . " " . $product["sellerLastName"]) ?>
                  <div class="muted"><?= htmlspecialchars($product["sellerId"]) ?></div>
                </td>
                <td>
                  <form method="POST" action="/admin/formHandlers/deleteProduct.php"
                    onsubmit="return confirm('Remove this listing permanently?')">
                    <input type="hidden" name="productId" value="<?= $product["id"] ?>">
                    <button type="submit" class="btn-delete">Remove</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

    </main>
  </div>

  <script>
    function filterTable() {
      const query = document.getElementById("searchInput").value.toLowerCase();
      const rows  = document.querySelectorAll("#productsTable tbody tr");
      let visible = 0;

      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const show = text.includes(query);
        row.style.display = show ? "" : "none";
        if (show) visible++;
      });

      document.getElementById("searchCount").textContent = visible + " products";
    }
  </script>

</body>
</html>