<?php
  require "guard.php";
  require "../db/dbconnection.php";

  $orders = $connection->query(
    "SELECT o.id, o.status, o.created_at,
            b.firstName AS buyerFirstName, b.lastName AS buyerLastName, b.id AS buyerId,
            s.firstName AS sellerFirstName, s.lastName AS sellerLastName, s.id AS sellerId,
            SUM(oi.amount) AS total,
            GROUP_CONCAT(p.name SEPARATOR ', ') AS productNames
     FROM orders o
     INNER JOIN users b ON o.buyer = b.id
     INNER JOIN users s ON o.seller = s.id
     INNER JOIN order_items oi ON oi.order_id = o.id
     INNER JOIN products p ON oi.product = p.id
     GROUP BY o.id
     ORDER BY o.created_at DESC;"
  )->fetchAll(PDO::FETCH_ASSOC);

  // counts for filter tabs
  $counts = [
    "all"       => count($orders),
    "pending"   => count(array_filter($orders, fn($o) => $o["status"] === "pending")),
    "shipped"   => count(array_filter($orders, fn($o) => $o["status"] === "shipped")),
    "completed" => count(array_filter($orders, fn($o) => $o["status"] === "completed")),
    "cancelled" => count(array_filter($orders, fn($o) => $o["status"] === "cancelled")),
  ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — Administrator | Orders</title>
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

    /* ── Filter tabs ── */
    .filter-tabs {
      display: flex;
      gap: .5rem;
      margin-bottom: 1.25rem;
      flex-wrap: wrap;
    }

    .filter-tab {
      padding: .4rem .9rem;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      border: 1px solid #e8e6e1;
      background: #fff;
      color: #555;
      transition: all .15s;
      display: flex;
      align-items: center;
      gap: .4rem;
    }
    .filter-tab:hover { border-color: #D85A30; color: #D85A30; }
    .filter-tab.active { background: #1a1a1a; border-color: #1a1a1a; color: #fff; }

    .tab-count {
      font-size: 10px;
      font-weight: 700;
      padding: 1px 5px;
      border-radius: 10px;
      background: rgba(0,0,0,.08);
    }
    .filter-tab.active .tab-count { background: rgba(255,255,255,.15); }

    /* ── Search ── */
    .toolbar {
      display: flex;
      gap: .75rem;
      align-items: center;
      margin-bottom: 1.25rem;
    }
    .toolbar input {
      flex: 1;
      max-width: 300px;
      padding: .55rem .85rem;
      border: 1px solid #e8e6e1;
      border-radius: 8px;
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      background: #fff;
      outline: none;
      transition: border-color .15s;
    }
    .toolbar input:focus { border-color: #D85A30; }
    .result-count { font-size: 12px; color: #aaa; }

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

    .order-id { font-weight: 700; color: #1a1a1a; }
    .party-name { font-weight: 600; color: #1a1a1a; }
    .party-id   { font-size: 11px; color: #bbb; margin-top: 1px; }
    .products-list {
      font-size: 12px;
      color: #888;
      max-width: 200px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .amount { font-weight: 700; color: #D85A30; }
    .muted  { color: #aaa; font-size: 12px; }

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

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: #aaa;
      font-size: 14px;
    }

    /* hidden rows */
    tr.hidden-row { display: none; }
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
      <a href="/admin/products.php" class="admin-nav-link">Products</a>
      <a href="/admin/orders.php"   class="admin-nav-link active">Orders</a>
    </div>
    <div class="admin-nav-right">
      <a href="/dashboard.php"           class="btn-back">← Main Site</a>
      <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
  </nav>

  <div class="page-wrapper">
    <main class="main">

      <div class="page-header">
        <div>
          <h1>Orders</h1>
          <p><?= count($orders) ?> total orders on the platform</p>
        </div>
      </div>

      <!-- Filter tabs -->
      <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterStatus('all', this)">
          All <span class="tab-count"><?= $counts["all"] ?></span>
        </button>
        <button class="filter-tab" onclick="filterStatus('pending', this)">
          Pending <span class="tab-count"><?= $counts["pending"] ?></span>
        </button>
        <button class="filter-tab" onclick="filterStatus('shipped', this)">
          Shipped <span class="tab-count"><?= $counts["shipped"] ?></span>
        </button>
        <button class="filter-tab" onclick="filterStatus('completed', this)">
          Completed <span class="tab-count"><?= $counts["completed"] ?></span>
        </button>
        <button class="filter-tab" onclick="filterStatus('cancelled', this)">
          Cancelled <span class="tab-count"><?= $counts["cancelled"] ?></span>
        </button>
      </div>

      <!-- Search -->
      <div class="toolbar">
        <input type="text" id="searchInput" placeholder="Search by buyer, seller or product..." oninput="applyFilters()">
        <span class="result-count" id="resultCount"><?= count($orders) ?> orders</span>
      </div>

      <?php if (empty($orders)): ?>
        <div class="empty-state">No orders yet.</div>
      <?php else: ?>
        <table class="admin-table" id="ordersTable">
          <thead>
            <tr>
              <th>Order</th>
              <th>Buyer</th>
              <th>Seller</th>
              <th>Products</th>
              <th>Total</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <tr data-status="<?= $order["status"] ?>">
                <td class="order-id">#<?= $order["id"] ?></td>
                <td>
                  <div class="party-name">
                    <?= htmlspecialchars($order["buyerFirstName"] . " " . $order["buyerLastName"]) ?>
                  </div>
                  <div class="party-id"><?= htmlspecialchars($order["buyerId"]) ?></div>
                </td>
                <td>
                  <div class="party-name">
                    <?= htmlspecialchars($order["sellerFirstName"] . " " . $order["sellerLastName"]) ?>
                  </div>
                  <div class="party-id"><?= htmlspecialchars($order["sellerId"]) ?></div>
                </td>
                <td>
                  <div class="products-list" title="<?= htmlspecialchars($order["productNames"]) ?>">
                    <?= htmlspecialchars($order["productNames"]) ?>
                  </div>
                </td>
                <td class="amount">R<?= number_format($order["total"], 2) ?></td>
                <td>
                  <span class="badge badge-<?= $order["status"] ?>">
                    <?= ucfirst($order["status"]) ?>
                  </span>
                </td>
                <td class="muted"><?= date("d M Y", strtotime($order["created_at"])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

    </main>
  </div>

  <script>
    let activeStatus = "all";

    function filterStatus(status, btn) {
      activeStatus = status;

      document.querySelectorAll(".filter-tab").forEach(t => t.classList.remove("active"));
      btn.classList.add("active");

      applyFilters();
    }

    function applyFilters() {
      const query = document.getElementById("searchInput").value.toLowerCase();
      const rows  = document.querySelectorAll("#ordersTable tbody tr");
      let visible = 0;

      rows.forEach(row => {
        const statusMatch = activeStatus === "all" || row.dataset.status === activeStatus;
        const textMatch   = row.innerText.toLowerCase().includes(query);
        const show = statusMatch && textMatch;

        row.style.display = show ? "" : "none";
        if (show) visible++;
      });

      document.getElementById("resultCount").textContent = visible + " orders";
    }
  </script>

</body>
</html>
