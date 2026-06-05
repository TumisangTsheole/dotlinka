<?php
  require "guard.php";
  require "../db/dbconnection.php";

  $users = $connection->query(
    "SELECT id, firstName, lastName, email, cellNumber, physicalAddress, walletBalance, role
     FROM users
     WHERE id != '0000000000000' AND id != '0000000000001'
     ORDER BY role ASC, firstName ASC;"
  )->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — Administrator | Users</title>
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

    /* ── Layout ── */
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

    /* ── Alerts ── */
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

    .user-name { font-weight: 600; color: #1a1a1a; }
    .user-id   { font-size: 11px; color: #bbb; margin-top: 2px; }
    .user-email { color: #555; }
    .wallet { font-weight: 700; color: #D85A30; }
    .muted  { color: #aaa; font-size: 12px; }

    /* role badges */
    .badge {
      font-size: 11px;
      font-weight: 700;
      padding: .25rem .6rem;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: .04em;
    }
    .badge-admin { background: #fff0ed; color: #D85A30; }
    .badge-user  { background: #f5f3ef; color: #888;    }

    /* ── Action buttons ── */
    .action-group { display: flex; gap: .5rem; align-items: center; }

    .btn-promote {
      background: #edfaf3;
      border: 1px solid #9ae6b4;
      color: #1d6b42;
      border-radius: 6px;
      padding: .3rem .75rem;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      white-space: nowrap;
      transition: background .15s;
    }
    .btn-promote:hover { background: #c6f6d5; }

    .btn-demote {
      background: #fff7e6;
      border: 1px solid #fbd38d;
      color: #b7791f;
      border-radius: 6px;
      padding: .3rem .75rem;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      white-space: nowrap;
      transition: background .15s;
    }
    .btn-demote:hover { background: #feebc8; }

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

  <!-- Admin Navbar -->
  <nav class="admin-nav">
    <a href="/admin/index.php" class="admin-nav-brand">
      .Linka <span class="admin-badge">Administrator</span>
    </a>
    <div class="admin-nav-links">
      <a href="/admin/index.php"    class="admin-nav-link">Overview</a>
      <a href="/admin/users.php"    class="admin-nav-link active">Users</a>
      <a href="/admin/products.php" class="admin-nav-link">Products</a>
      <a href="/admin/orders.php"   class="admin-nav-link">Orders</a>
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
          <h1>Users</h1>
          <p><?= count($users) ?> registered accounts</p>
        </div>
      </div>

      <?php if (isset($_GET["success"])): ?>
        <div class="alert alert-success">
          <?php if ($_GET["success"] === "deleted"):  ?>  ✓ User deleted successfully.
          <?php elseif ($_GET["success"] === "promoted"): ?> ✓ User promoted to admin.
          <?php elseif ($_GET["success"] === "demoted"):  ?> ✓ User demoted to regular user.
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET["error"])): ?>
        <div class="alert alert-error">
          <?php if ($_GET["error"] === "self"): ?>
            You cannot modify your own account from here.
          <?php else: ?>
            Something went wrong, please try again.
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (empty($users)): ?>
        <div class="empty-state">No users registered yet.</div>
      <?php else: ?>
        <table class="admin-table">
          <thead>
            <tr>
              <th>User</th>
              <th>Email</th>
              <th>Cell</th>
              <th>Physical Address</th>
              <th>Wallet</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td>
                  <div class="user-name"><?= htmlspecialchars($user["firstName"] . " " . $user["lastName"]) ?></div>
                  <div class="user-id"><?= htmlspecialchars($user["id"]) ?></div>
                </td>
                <td class="user-email"><?= htmlspecialchars($user["email"]) ?></td>
                <td class="muted"><?= htmlspecialchars($user["cellNumber"]) ?></td>
                <td class="muted"><?= htmlspecialchars($user["physicalAddress"]) ?></td>
                <td class="wallet">R<?= number_format($user["walletBalance"], 2) ?></td>
                <td>
                  <span class="badge badge-<?= $user["role"] ?>">
                    <?= ucfirst($user["role"]) ?>
                  </span>
                </td>
                <td>
                  <div class="action-group">

                    <?php if ($user["role"] === "user"): ?>
                      <form method="POST" action="/admin/formHandlers/updateUserRole.php">
                        <input type="hidden" name="userId" value="<?= $user["id"] ?>">
                        <input type="hidden" name="role"   value="admin">
                        <button type="submit" class="btn-promote"
                          onclick="return confirm('Promote <?= htmlspecialchars($user["firstName"]) ?> to admin?')">
                          Promote
                        </button>
                      </form>
                    <?php else: ?>
                      <form method="POST" action="/admin/formHandlers/updateUserRole.php">
                        <input type="hidden" name="userId" value="<?= $user["id"] ?>">
                        <input type="hidden" name="role"   value="user">
                        <button type="submit" class="btn-demote"
                          onclick="return confirm('Demote <?= htmlspecialchars($user["firstName"]) ?> to regular user?')">
                          Demote
                        </button>
                      </form>
                    <?php endif; ?>

                    <form method="POST" action="/admin/formHandlers/deleteUser.php"
                      onsubmit="return confirm('Permanently delete <?= htmlspecialchars($user["firstName"]) ?>? This cannot be undone.')">
                      <input type="hidden" name="userId" value="<?= $user["id"] ?>">
                      <button type="submit" class="btn-delete">Delete</button>
                    </form>

                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

    </main>
  </div>

</body>
</html>
