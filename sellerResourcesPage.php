<?php
  require "data/global/sessionData.php";
  require "db/dbconnection.php";
  require "controllers/CartController.php";
  require "controllers/UserController.php";
  require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — Seller Resources</title>
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
      max-width: 860px;
    }

    .main-header {
      margin-bottom: 2rem;
    }
    .main-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 .4rem;
    }
    .main-header p {
      font-size: 14px;
      color: #888;
      margin: 0;
      line-height: 1.6;
    }

    /* ── Section ── */
    .resource-section {
      margin-bottom: 2.5rem;
    }

    .section-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #D85A30;
      margin-bottom: .75rem;
    }

    .section-title {
      font-size: 18px;
      font-weight: 700;
      color: #1a1a1a;
      margin: 0 0 .4rem;
    }

    .section-desc {
      font-size: 13px;
      color: #888;
      margin: 0 0 1.1rem;
      line-height: 1.6;
    }

    /* ── Resource cards ── */
    .resource-cards {
      display: flex;
      flex-direction: column;
      gap: .75rem;
    }

    .resource-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 12px;
      padding: 1.1rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      text-decoration: none;
      color: inherit;
      transition: border-color .15s, box-shadow .15s;
    }
    .resource-card:hover {
      border-color: #D85A30;
      box-shadow: 0 4px 16px rgba(216,90,48,.08);
      color: inherit;
    }

    .resource-card-left {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .resource-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .icon-tax     { background: #fff7e6; }
    .icon-legal   { background: #f0f4ff; }
    .icon-fraud   { background: #fff0ed; }

    .resource-card-title {
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 2px;
    }
    .resource-card-desc {
      font-size: 12px;
      color: #aaa;
    }

    .resource-card-arrow {
      color: #ccc;
      flex-shrink: 0;
      transition: color .15s, transform .15s;
    }
    .resource-card:hover .resource-card-arrow {
      color: #D85A30;
      transform: translateX(3px);
    }

    /* ── Hotline callout ── */
    .hotline-card {
      background: #1a1a1a;
      border-radius: 12px;
      padding: 1.25rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .hotline-card-left h3 {
      font-size: 15px;
      font-weight: 700;
      color: #fff;
      margin: 0 0 4px;
    }
    .hotline-card-left p {
      font-size: 13px;
      color: #888;
      margin: 0;
    }
    .hotline-number {
      font-size: 18px;
      font-weight: 700;
      color: #D85A30;
      text-decoration: none;
      white-space: nowrap;
    }
    .hotline-number:hover { color: #F0997B; }

    /* ── Divider ── */
    .divider {
      border: none;
      border-top: 1px solid #e8e6e1;
      margin: 2rem 0;
    }
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

    <a href="/registerProductPage.php" class="sidebar-link">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      List a Product
    </a>

    <div class="sidebar-label">Resources</div>

    <a href="/sellerResources.php" class="sidebar-link active">
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
      <h1>Seller Resources</h1>
      <p>Everything you need to trade safely, stay compliant, and protect yourself on commerce.za. All resources link to official South African government and fraud prevention organisations.</p>
    </div>

    <!-- Tax & Compliance -->
    <div class="resource-section">
      <p class="section-label">Tax & Compliance</p>
      <h2 class="section-title">Know your tax obligations</h2>
      <p class="section-desc">If you earn income from selling on this platform, SARS requires you to declare it. These guides explain what applies to you as an informal or small business trader — in plain language.</p>

      <div class="resource-cards">

        <a href="https://www.sars.gov.za/businesses-and-employers/small-businesses-taxpayers/" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-tax">
              <svg width="20" height="20" fill="none" stroke="#b7791f" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
              <div class="resource-card-title">SARS Small Business Tax Hub</div>
              <div class="resource-card-desc">Official SARS page for SMMEs — registration, turnover tax, VAT threshold, eFiling</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

        <a href="https://www.sars.gov.za/wp-content/uploads/Docs/SmallBusiness/Small-business-leaflet-ENG.pdf" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-tax">
              <svg width="20" height="20" fill="none" stroke="#b7791f" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
            </div>
            <div>
              <div class="resource-card-title">Small Business Essential Tax Guide (PDF)</div>
              <div class="resource-card-desc">Quick-start guide — how to register, what taxes apply, when you need to pay VAT</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

        <a href="https://www.sars.gov.za/wp-content/uploads/Ops/Guides/Legal-Pub-Guide-Gen09-Tax-Guide-for-Small-Businesses.pdf" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-tax">
              <svg width="20" height="20" fill="none" stroke="#b7791f" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div>
              <div class="resource-card-title">Tax Guide for Small Businesses 2024/2025 (PDF)</div>
              <div class="resource-card-desc">Detailed guide covering income tax, turnover tax, VAT, record-keeping obligations</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

      </div>
    </div>

    <hr class="divider">

    <!-- Legal & Consumer Rights -->
    <div class="resource-section">
      <p class="section-label">Legal & Consumer Rights</p>
      <h2 class="section-title">Know the law that protects your buyers — and you</h2>
      <p class="section-desc">As a seller you are a supplier under the Consumer Protection Act. Understanding POPIA and the CPA protects you from liability and builds trust with your buyers.</p>

      <div class="resource-cards">

        <a href="https://www.thencc.gov.za/welcome" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-legal">
              <svg width="20" height="20" fill="none" stroke="#2b6cb0" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
              <div class="resource-card-title">National Consumer Commission (NCC)</div>
              <div class="resource-card-desc">Official body enforcing the Consumer Protection Act — file or check complaints here</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

        <a href="https://www.thedtic.gov.za/wp-content/uploads/Consumer_Protection_Act.pdf" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-legal">
              <svg width="20" height="20" fill="none" stroke="#2b6cb0" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
              <div class="resource-card-title">Consumer Protection Act 68 of 2008 (PDF)</div>
              <div class="resource-card-desc">Full legislation — your rights and obligations as a seller, returns policy, product liability</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

        <a href="https://www.standardbank.co.za/southafrica/personal/learn/everything-you-need-to-know-about-popia" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-legal">
              <svg width="20" height="20" fill="none" stroke="#2b6cb0" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            </div>
            <div>
              <div class="resource-card-title">POPIA Plain Language Guide</div>
              <div class="resource-card-desc">What the Protection of Personal Information Act means for you and your buyers' data</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

      </div>
    </div>

    <hr class="divider">

    <!-- Fraud & Scam Protection -->
    <div class="resource-section">
      <p class="section-label">Fraud & Scam Protection</p>
      <h2 class="section-title">Protect yourself from marketplace scams</h2>
      <p class="section-desc">Marketplace scams in South Africa rose 32% in the last year. As a seller you can be the victim too — fake proof of payments and courier impersonation scams are common. Stay informed.</p>

      <div class="resource-cards">

        <a href="https://www.safps.org.za/" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-fraud">
              <svg width="20" height="20" fill="none" stroke="#D85A30" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
              <div class="resource-card-title">SAFPS — Register for Free Fraud Protection</div>
              <div class="resource-card-desc">Register your ID to be alerted if your identity is compromised — free service, takes minutes</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

        <a href="https://www.yima.org.za/" target="_blank" rel="noopener" class="resource-card">
          <div class="resource-card-left">
            <div class="resource-icon icon-fraud">
              <svg width="20" height="20" fill="none" stroke="#D85A30" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
              <div class="resource-card-title">Yima — Scam Awareness Platform</div>
              <div class="resource-card-desc">Check if a site is safe to trade on, report scams, and read common fraud patterns in SA</div>
            </div>
          </div>
          <svg class="resource-card-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>

      </div>
    </div>

    <!-- Hotline callout -->
    <div class="hotline-card">
      <div class="hotline-card-left">
        <h3>Report a Scam — Yima Hotline</h3>
        <p>If you've been targeted by a marketplace scam, call the Yima fraud hotline immediately. Free to call, available during business hours.</p>
      </div>
      <a href="tel:0831237226" class="hotline-number">083 123 7226</a>
    </div>

  </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
<script src="utils/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
