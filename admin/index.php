<?php
  require "guard.php";
  require "../db/dbconnection.php";
  require "../controllers/UserController.php";
  require "../controllers/ProductController.php";
  require "../controllers/OrderController.php";

  // overview stats
  $totalUsers = $connection->query(
    "SELECT COUNT(*) FROM users WHERE id != '0000000000000' AND id != '0000000000001';"
  )->fetchColumn();

  $totalProducts = $connection->query(
    "SELECT COUNT(*) FROM products;"
  )->fetchColumn();

  $totalOrders = $connection->query(
    "SELECT COUNT(*) FROM orders;"
  )->fetchColumn();

  $pendingOrders = $connection->query(
    "SELECT COUNT(*) FROM orders WHERE status = 'pending';"
  )->fetchColumn();

  $shippedOrders = $connection->query(
    "SELECT COUNT(*) FROM orders WHERE status = 'shipped';"
  )->fetchColumn();

  $completedOrders = $connection->query(
    "SELECT COUNT(*) FROM orders WHERE status = 'completed';"
  )->fetchColumn();

  $totalRevenue = $connection->query(
    "SELECT SUM(amount) FROM order_items oi
     INNER JOIN orders o ON oi.order_id = o.id
     WHERE o.status = 'completed';"
  )->fetchColumn() ?? 0;

  $escrowBalance = $connection->query(
    "SELECT walletBalance FROM users WHERE id = '0000000000000';"
  )->fetchColumn() ?? 0;

  $recentOrders = $connection->query(
    "SELECT o.id, o.status, o.created_at,
            b.firstName AS buyerFirstName, b.lastName AS buyerLastName,
            s.firstName AS sellerFirstName, s.lastName AS sellerLastName,
            SUM(oi.amount) AS total
     FROM orders o
     INNER JOIN users b ON o.buyer = b.id
     INNER JOIN users s ON o.seller = s.id
     INNER JOIN order_items oi ON oi.order_id = o.id
     GROUP BY o.id
     ORDER BY o.created_at DESC
     LIMIT 5;"
  )->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — Administrator | Dashboard</title>
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

    /* ── Admin navbar ── */
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
    .admin-nav-link:hover { background: #2a2a2a; color: #fff; }
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

    /* ── Layout ── */
    .page-wrapper {
      padding-top: 56px;
    }

    .main {
      max-width: 1100px;
      margin: 0 auto;
      padding: 2.5rem 2rem;
    }

    .page-header {
      margin-bottom: 2rem;
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

    /* ── Stat cards ── */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      padding: 1.25rem;
    }
    .stat-label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #aaa;
      margin-bottom: .5rem;
    }
    .stat-value {
      font-size: 28px;
      font-weight: 700;
      color: #1a1a1a;
      line-height: 1;
      margin-bottom: .25rem;
    }
    .stat-sub {
      font-size: 12px;
      color: #bbb;
    }
    .stat-card.highlight {
      background: #1a1a1a;
      border-color: #1a1a1a;
    }
    .stat-card.highlight .stat-label { color: #666; }
    .stat-card.highlight .stat-value { color: #fff; }
    .stat-card.highlight .stat-sub   { color: #555; }

    /* ── Order status row ── */
    .order-status-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .status-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .status-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      flex-shrink: 0;
    }
    .dot-pending   { background: #ECC94B; }
    .dot-shipped   { background: #4299E1; }
    .dot-completed { background: #48BB78; }

    .status-card-label {
      font-size: 12px;
      color: #aaa;
      margin-bottom: 2px;
    }
    .status-card-value {
      font-size: 20px;
      font-weight: 700;
      color: #1a1a1a;
    }

    /* ── Section ── */
    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
    }
    .section-header h2 {
      font-size: 16px;
      font-weight: 700;
      margin: 0;
    }
    .section-header a {
      font-size: 13px;
      color: #D85A30;
      text-decoration: none;
    }
    .section-header a:hover { text-decoration: underline; }

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
    }
    .admin-table td {
      padding: .85rem 1rem;
      border-top: 1px solid #f0eeea;
      color: #1a1a1a;
      vertical-align: middle;
    }
    .admin-table tr:hover td { background: #faf9f7; }

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

    .amount { font-weight: 700; color: #D85A30; }
    .muted  { color: #aaa; font-size: 12px; }
  </style>
</head>
<body>

  <!-- Admin Navbar -->
  <nav class="admin-nav">
    <a href="/admin/index.php" class="admin-nav-brand">
      .Linka <span class="admin-badge">Administrator</span>
    </a>

    <div class="admin-nav-links">
      <a href="/admin/index.php"    class="admin-nav-link active">Overview</a>
      <a href="/admin/users.php"    class="admin-nav-link">Users</a>
      <a href="/admin/products.php" class="admin-nav-link">Products</a>
      <a href="/admin/orders.php"   class="admin-nav-link">Orders</a>
    </div>

    <div class="admin-nav-right">
      <a href="/dashboard.php"            class="btn-back">← Main Site</a>
      <a href="../logout.php"  class="btn-logout">Logout</a>
    </div>
  </nav>

  <div class="page-wrapper">
    <main class="main">

      <div class="page-header">
        <h1>Overview</h1>
        <p>Platform summary — users, listings, and order activity.</p>
      </div>

      <!-- Top stats -->
      <div class="stats-grid">
        <div class="stat-card highlight">
          <div class="stat-label">Total Users</div>
          <div class="stat-value"><?= $totalUsers ?></div>
          <div class="stat-sub">registered accounts</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Active Listings</div>
          <div class="stat-value"><?= $totalProducts ?></div>
          <div class="stat-sub">products on platform</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Total Orders</div>
          <div class="stat-value"><?= $totalOrders ?></div>
          <div class="stat-sub">all time</div>
        </div>
        <div class="stat-card highlight">
          <div class="stat-label">Completed Revenue</div>
          <div class="stat-value">R<?= number_format($totalRevenue, 0) ?></div>
          <div class="stat-sub">from completed orders</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Escrow Balance</div>
          <div class="stat-value">R<?= number_format($escrowBalance, 0) ?></div>
          <div class="stat-sub">funds held in escrow</div>
        </div>
      </div>

      <!-- Order status breakdown -->
      <div class="order-status-row">
        <div class="status-card">
          <div class="status-dot dot-pending"></div>
          <div>
            <div class="status-card-label">Pending</div>
            <div class="status-card-value"><?= $pendingOrders ?></div>
          </div>
        </div>
        <div class="status-card">
          <div class="status-dot dot-shipped"></div>
          <div>
            <div class="status-card-label">Shipped</div>
            <div class="status-card-value"><?= $shippedOrders ?></div>
          </div>
        </div>
        <div class="status-card">
          <div class="status-dot dot-completed"></div>
          <div>
            <div class="status-card-label">Completed</div>
            <div class="status-card-value"><?= $completedOrders ?></div>
          </div>
        </div>
      </div>

      <!-- Recent orders -->
      <div class="section-header">
        <h2>Recent Orders</h2>
        <a href="/admin/orders.php">View all →</a>
      </div>

      <table class="admin-table">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Buyer</th>
            <th>Seller</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentOrders)): ?>
            <tr>
              <td colspan="6" style="text-align:center; color:#aaa; padding:2rem;">
                No orders yet.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentOrders as $order): ?>
              <tr>
                <td>#<?= $order["id"] ?></td>
                <td><?= htmlspecialchars($order["buyerFirstName"] . " " . $order["buyerLastName"]) ?></td>
                <td><?= htmlspecialchars($order["sellerFirstName"] . " " . $order["sellerLastName"]) ?></td>
                <td class="amount">R<?= number_format($order["total"], 2) ?></td>
                <td><span class="badge badge-<?= $order["status"] ?>"><?= ucfirst($order["status"]) ?></span></td>
                <td class="muted"><?= date("d M Y", strtotime($order["created_at"])) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

    </main>
  </div>

</body>
</html>
