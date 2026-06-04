<?php
  session_start();
  
  require "db/dbconnection.php";
  require "data/indexData.php";
  require "controllers/ProductController.php";
  require "controllers/UserController.php";
  require "controllers/CartController.php";
  require "controllers/Router.php";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <title>commerce.za — South Africa's C2C Marketplace</title>

  <style>
    /* ── SYSTEM TOKENS & RESET ── */
    :root {
      --brand-primary: #D85A30;
      --brand-hover: #B8431B;
      --brand-light: #FDF4F0;
      --surface-dark: #121212;
      --surface-card: #1A1A1A;
      --text-dark: #1C1917;
      --text-muted: #6B6661;
      --border-color: #E6E4E0;
      
      --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
      --ease-physics: cubic-bezier(0.25, 1, 0.5, 1);
      --transition-fast: 180ms var(--ease-physics);
      --transition-smooth: 320ms var(--ease-physics);
      
      /* Stacking Card Variables */
      --nav-height: 70px; /* Adjust this to match your exact components/navbar.php height */
      --card-gap: 40px;   /* The visible overlap threshold */
    }

    body {
      font-family: var(--font-sans);
      color: var(--text-dark);
      background-color: #0c0b0a; /* Dark base tone so edges look deep when scrolling out */
      -webkit-font-smoothing: antialiased;
    }

    /* ── STACKED CARD SCROLL MECHANICS ── */
    .stack-wrapper {
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .stack-card {
      position: sticky;
      top: var(--nav-height);
      min-height: calc(100vh - var(--nav-height));
      display: flex;
      align-items: center;
      width: 100%;
      padding: 6rem 0;
      border-top-left-radius: 32px;
      border-top-right-radius: 32px;
      box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.06);
      background: #FAFAF9;
      margin-top: calc(var(--card-gap) * -1);
    }

    /* Assigning strict Z-Index layers and subtle dark overlays to lower elements */
    #hero { 
      z-index: 1; 
      border-top-left-radius: 0px; 
      border-top-right-radius: 0px;
      margin-top: 0;
      background: #FFFFFF;
    }
    #featured     { z-index: 2; background: #F5F4F0; box-shadow: 0 -30px 60px rgba(0,0,0,0.08); }
    #escrow       { z-index: 3; background: var(--surface-dark); box-shadow: 0 -30px 60px rgba(0,0,0,0.15); }
    #safety       { z-index: 4; background: #FFFFFF; box-shadow: 0 -30px 60px rgba(0,0,0,0.1); }
    #how-it-works { z-index: 5; background: #FAFAF9; box-shadow: 0 -30px 60px rgba(0,0,0,0.08); }
    .footer       { z-index: 6; position: relative; margin-top: 0; border-top-left-radius: 32px; border-top-right-radius: 32px; box-shadow: 0 -30px 60px rgba(0,0,0,0.2); }

    /* ── HERO TEXT DESIGN ── */
    .hero-eyebrow {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--brand-primary);
      margin-bottom: 1rem;
      display: inline-block;
    }
    .hero-cta h1 {
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 800;
      color: var(--text-dark);
      line-height: 1.15;
      letter-spacing: -0.02em;
      margin-bottom: 1.25rem;
    }
    .hero-cta p {
      color: var(--text-muted);
      font-size: 1.05rem;
      line-height: 1.65;
      margin-bottom: 2.25rem;
      max-width: 520px;
    }
    
    .btn-action-primary {
      background: var(--brand-primary);
      color: #FFFFFF;
      font-weight: 600;
      padding: 0.75rem 1.75rem;
      border-radius: 8px;
      font-size: 0.95rem;
      text-decoration: none;
      display: inline-block;
      transition: transform var(--transition-fast), background var(--transition-fast), box-shadow var(--transition-fast);
      box-shadow: 0 4px 14px rgba(216, 90, 48, 0.2);
    }
    .btn-action-primary:hover {
      background: var(--brand-hover);
      color: #FFFFFF;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(216, 90, 48, 0.35);
    }
    .btn-action-secondary {
      background: transparent;
      color: var(--text-dark);
      border: 2px solid var(--text-dark);
      font-weight: 600;
      padding: 0.7rem 1.75rem;
      border-radius: 8px;
      font-size: 0.95rem;
      text-decoration: none;
      display: inline-block;
      margin-left: 1rem;
      transition: all var(--transition-fast);
    }
    .btn-action-secondary:hover {
      background: var(--text-dark);
      color: #FFFFFF;
      transform: translateY(-2px);
    }

    .hero-trust {
      display: flex;
      gap: 1.5rem;
      margin-top: 3rem;
      flex-wrap: wrap;
    }
    .hero-trust-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.8rem;
      color: var(--text-muted);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .hero-trust-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--brand-primary);
      box-shadow: 0 0 8px var(--brand-primary);
    }

    /* ── SECURE TRANSACTION LEDGER WIDGET ── */
    .secure-widget-card {
      width: 100%;
      max-width: 480px;
      background: #FFFFFF;
      border: 1px solid var(--border-color);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 30px 60px rgba(27, 25, 23, 0.08);
      position: relative;
      transform: perspective(1000px) rotateY(-6deg) rotateX(3deg);
      transition: transform var(--transition-smooth), box-shadow var(--transition-smooth);
    }
    .secure-widget-card:hover {
      transform: perspective(1000px) rotateY(0deg) rotateX(0deg) translateY(-2px);
      box-shadow: 0 40px 80px rgba(27, 25, 23, 0.12);
    }
    .widget-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border-color);
    }
    .widget-badge {
      background: #DCFCE7;
      color: #15803D;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 4px 10px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .widget-pulse {
      width: 6px;
      height: 6px;
      background: #16A34A;
      border-radius: 50%;
      animation: pulse-green 2s infinite;
    }
    .pipeline-track {
      position: relative;
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }
    .pipeline-track::before {
      content: '';
      position: absolute;
      left: 15px;
      top: 15px;
      bottom: 15px;
      width: 2px;
      background: var(--border-color);
      z-index: 1;
    }
    .pipeline-node {
      position: relative;
      display: flex;
      gap: 1.25rem;
      z-index: 2;
    }
    .node-dot {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #FFFFFF;
      border: 2px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--text-muted);
    }
    .pipeline-node.complete .node-dot {
      background: var(--text-dark);
      border-color: var(--text-dark);
      color: #FFFFFF;
    }
    .pipeline-node.active .node-dot {
      background: #FFF7ED;
      border-color: var(--brand-primary);
      color: var(--brand-primary);
      box-shadow: 0 0 0 4px var(--brand-light);
    }
    .node-content {
      flex: 1;
      background: #FAFAF9;
      padding: 0.85rem 1.25rem;
      border-radius: 12px;
    }
    .pipeline-node.active .node-content {
      background: #FFFFFF;
      border: 1px solid var(--brand-light);
      box-shadow: 0 4px 12px rgba(216, 90, 48, 0.05);
    }
    .node-title {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 2px;
    }
    .node-meta {
      font-size: 0.75rem;
      color: var(--text-muted);
    }

    /* ── MARKETPLACE CHIPS & CARDS ── */
    .mp-section-title {
      font-size: 2.2rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: var(--text-dark);
    }
    .mp-view-all {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--brand-primary);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .mp-chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 2.5rem;
    }
    .mp-chip {
      font-size: 0.85rem;
      font-weight: 600;
      padding: 6px 18px;
      border-radius: 20px;
      border: 1px solid var(--border-color);
      background: #FFFFFF;
      color: var(--text-muted);
      text-decoration: none;
      transition: all var(--transition-fast);
    }
    .mp-chip:hover { border-color: var(--text-dark); color: var(--text-dark); }
    .mp-chip.active { background: var(--text-dark); border-color: var(--text-dark); color: #FFFFFF; }

    .mp-card {
      background: #FFFFFF;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      transition: transform var(--transition-fast), border-color var(--transition-fast), box-shadow var(--transition-fast);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .mp-card:hover {
      transform: translateY(-4px);
      border-color: #C4C2BC;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.04);
    }
    .mp-img-wrapper {
      position: relative;
      width: 100%;
      aspect-ratio: 4 / 3;
      overflow: hidden;
      background: #EAE8E4;
    }
    .mp-img-wrapper img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform var(--transition-smooth);
    }
    .mp-card:hover .mp-img-wrapper img { transform: scale(1.05); }
    .mp-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
    .mp-cat { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--brand-primary); margin-bottom: 0.5rem; }
    .mp-name { font-size: 0.95rem; font-weight: 700; color: var(--text-dark); margin: 0 0 0.5rem; line-height: 1.4; }
    .mp-desc { font-size: 0.8rem; color: var(--text-muted); line-height: 1.5; margin: 0 0 1.25rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex: 1; }
    .mp-price-row { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
    .mp-price { font-size: 1.1rem; font-weight: 800; color: var(--text-dark); }
    .mp-divider { height: 1px; background: var(--border-color); margin: 1rem 0; }
    .mp-seller { display: flex; align-items: center; gap: 8px; }
    .mp-seller-avatar { width: 20px; height: 20px; border-radius: 50%; background: var(--brand-light); color: var(--brand-primary); font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
    .mp-seller-name { font-size: 0.8rem; font-weight: 600; color: var(--text-dark); }

    /* ── ESCROW SYSTEM BLOCK ── */
    .escrow-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--brand-primary); margin-bottom: 0.75rem; display: block; }
    .escrow-copy h2 { font-size: 2.2rem; font-weight: 800; color: #FFFFFF; margin-bottom: 1.5rem; line-height: 1.25; letter-spacing: -0.02em; }
    .escrow-copy p { font-size: 1.05rem; color: #99948F; line-height: 1.7; }
    .escrow-steps { display: flex; flex-direction: column; gap: 1rem; }
    .escrow-step { display: flex; align-items: flex-start; gap: 1.25rem; background: var(--surface-card); border: 1px solid #2E2A27; border-radius: 12px; padding: 1.25rem; transition: transform var(--transition-fast), border-color var(--transition-fast); }
    .escrow-step:hover { transform: translateX(4px); border-color: var(--brand-primary); }
    .escrow-step-num { width: 32px; height: 32px; border-radius: 50%; background: var(--brand-primary); color: #FFFFFF; font-size: 0.85rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .escrow-step-title { font-size: 0.95rem; font-weight: 700; color: #FFFFFF; margin-bottom: 0.25rem; }
    .escrow-step-desc { font-size: 0.85rem; color: #99948F; line-height: 1.5; }

    /* ── VALUE PROPS & FLOW GRID ── */
    .trust-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
    .trust-item { background: #FAFAF9; border: 1px solid var(--border-color); border-radius: 12px; padding: 2rem; transition: transform var(--transition-fast); }
    .trust-item:hover { transform: translateY(-4px); }
    .trust-icon { font-size: 2rem; margin-bottom: 1.25rem; display: inline-block; }
    .trust-item h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-dark); }
    .trust-item p { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; margin: 0; }

    .how-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; }
    .how-step { background: #FFFFFF; border: 1px solid var(--border-color); border-radius: 12px; padding: 2.5rem 1.5rem; text-align: center; transition: transform var(--transition-fast); }
    .how-step:hover { transform: translateY(-4px); }
    .how-num { width: 40px; height: 40px; border-radius: 50%; background: var(--brand-light); color: var(--brand-primary); font-size: 1rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .how-step h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-dark); }
    .how-step p { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; margin: 0; }

    /* ── FOOTER FOOTPRINT ── */
    .footer { background: var(--surface-dark); color: #99948F; padding: 5rem 0 2rem; }
    .footer-logo h2 { color: #FFFFFF; font-weight: 800; font-size: 1.5rem; letter-spacing: -0.03em; margin-bottom: 1rem; }
    .footer-logo p { font-size: 0.85rem; line-height: 1.6; max-width: 260px; }
    .footer-links h3 { color: #FFFFFF; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1.25rem; }
    .footer-links a { display: block; color: #99948F; text-decoration: none; margin-bottom: 0.75rem; font-size: 0.85rem; transition: all var(--transition-fast); }
    .footer-links a:hover { color: var(--brand-primary); transform: translateX(2px); }
    .footer-bottom { text-align: center; margin-top: 4rem; font-size: 0.8rem; color: #55514E; padding-top: 2rem; border-top: 1px solid #2E2A27; }

    @keyframes pulse-green {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }
    @media (max-width: 991.98px) {
      .secure-widget-card { transform: none !important; margin-top: 3rem; }
      .stack-card { min-height: auto; padding: 4rem 0; }
    }
  </style>
</head>

<body>

  <?php include "components/navbar.php"; ?>

  <div class="stack-wrapper">

    <section id="hero" class="stack-card">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 hero-cta">
            <span class="hero-eyebrow">South Africa's C2C marketplace</span>
            <h1>Buy and sell locally — safely, simply, securely.</h1>
            <p>
              commerce.za is a consumer-to-consumer marketplace built exclusively for South Africans. 
              List your goods, browse local sellers, and trade with confidence knowing your payment 
              is protected by our built-in escrow system.
            </p>
            <div class="mb-2">
              <a href="registrationPage.php" class="btn-action-primary">Get Started Free</a>
              <a href="dashboard.php" class="btn-action-secondary">Browse Listings &rarr;</a>
            </div>
            <div class="hero-trust">
              <span class="hero-trust-item"><span class="hero-trust-dot"></span>Escrow-protected</span>
              <span class="hero-trust-item"><span class="hero-trust-dot"></span>SA sellers only</span>
              <span class="hero-trust-item"><span class="hero-trust-dot"></span>ID-verified</span>
            </div>
          </div>
          <div class="col-lg-6 d-flex justify-content-lg-end justify-content-center">
            <div class="secure-widget-card">
              <div class="widget-header">
                <div>
                  <h4 class="mb-0 fw-bold" style="font-size: 0.95rem;">Escrow Ledger Protection</h4>
                  <p class="text-muted mb-0" style="font-size: 0.75rem;">System Core: Active</p>
                </div>
                <div class="widget-badge">
                  <span class="widget-pulse"></span>Live Protection
                </div>
              </div>
              <div class="pipeline-track">
                <div class="pipeline-node complete">
                  <div class="node-dot">✓</div>
                  <div class="node-content">
                    <div class="node-title">Buyer Commits Wallet Funds</div>
                    <div class="node-meta">R3,450.00 locked securely inside system escrow architectural vault</div>
                  </div>
                </div>
                <div class="pipeline-node active">
                  <div class="node-dot">2</div>
                  <div class="node-content">
                    <div class="node-title">Sellers Verification & Transit</div>
                    <div class="node-meta">Tracking code uploaded; pending visual package arrivals check</div>
                  </div>
                </div>
                <div class="pipeline-node">
                  <div class="node-dot">3</div>
                  <div class="node-content">
                    <div class="node-title">Release Pay-Out Payload</div>
                    <div class="node-meta">Funds deploy instantly to user balance upon structural confirmation</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="featured" class="stack-card">
      <div class="container">
        <div class="d-flex align-items-end justify-content-between mb-4">
          <div>
            <p class="mp-cat mb-1" style="font-size: 0.75rem;">Fresh listings</p>
            <h2 class="mp-section-title">Latest on the market</h2>
          </div>
          <a href="/dashboard.php" class="mp-view-all">View all &rarr;</a>
        </div>

        <div class="mp-chips">
          <a href="?" class="mp-chip active">All Listings</a>
          <a href="?cat=Electronics" class="mp-chip">Electronics</a>
          <a href="?cat=Clothing" class="mp-chip">Clothing</a>
          <a href="?cat=Furniture" class="mp-chip">Furniture</a>
          <a href="?cat=Books" class="mp-chip">Books</a>
          <a href="?cat=Sports" class="mp-chip">Sports</a>
          <a href="?cat=Vehicles" class="mp-chip">Vehicles</a>
        </div>

        <div class="row g-4">
          <?php foreach ($indexPageProducts as $product): ?>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
              <a href="/product-detail.php?id=<?= $product["id"] ?>" class="mp-card text-decoration-none">
                <div class="mp-img-wrapper">
                  <?php
                    $imgSrc = !empty($product["image"])
                      ? htmlspecialchars($product["image"])
                      : "https://placehold.co/600x400/1a1a1a/f5f3ef/png";
                  ?>
                  <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" loading="lazy">
                </div>
                <div class="mp-body">
                  <p class="mp-cat"><?= htmlspecialchars($product['category']) ?></p>
                  <h3 class="mp-name"><?= htmlspecialchars($product['product_name']) ?></h3>
                  <p class="mp-desc"><?= htmlspecialchars($product['description']) ?></p>
                  <div class="mp-price-row">
                    <span class="mp-price">R<?= number_format($product['price'], 2) ?></span>
                  </div>
                  <div class="mp-divider"></div>
                  <div class="mp-seller">
                    <div class="mp-seller-avatar">
                      <?= strtoupper(substr(htmlspecialchars($product['firstName']), 0, 1)) ?>
                    </div>
                    <div class="mp-seller-name"><?= htmlspecialchars($product['firstName']) ?></div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="escrow" class="stack-card">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-5 escrow-copy">
            <span class="escrow-eyebrow">How payments work</span>
            <h2>Your money is protected — every single time.</h2>
            <p>
              We hold your payment in escrow until you confirm you've received your order. 
              The seller only gets paid once you're happy. No more fake proof of payments, 
              no more losing money to scammers.
            </p>
          </div>
          <div class="col-lg-7">
            <div class="escrow-steps">
              <div class="escrow-step">
                <div class="escrow-step-num">1</div>
                <div>
                  <h3 class="escrow-step-title">You pay into escrow</h3>
                  <div class="escrow-step-desc">Funds are deducted securely from your digital wallet and locked up inside system state payloads.</div>
                </div>
              </div>
              <div class="escrow-step">
                <div class="escrow-step-num">2</div>
                <div>
                  <h3 class="escrow-step-title">Seller ships your order</h3>
                  <div class="escrow-step-desc">The seller receives confirmation details and dispatches tracking information directly to you.</div>
                </div>
              </div>
              <div class="escrow-step">
                <div class="escrow-step-num">3</div>
                <div>
                  <h3 class="escrow-step-title">You confirm receipt</h3>
                  <div class="escrow-step-desc">Once package arrival checks finish out cleanly, transactional escrow funds release automatically.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="safety" class="stack-card">
      <div class="container">
        <div class="text-center mb-5">
          <span class="hero-eyebrow">Why Choose Us</span>
          <h2 class="mp-section-title">Built for Safe Local Trading</h2>
        </div>
        <div class="trust-grid">
          <div class="trust-item">
            <div class="trust-icon">🔒</div>
            <h3>Escrow Payments</h3>
            <p>Your money is held safely until you confirm you've received your order — the seller never touches it first.</p>
          </div>
          <div class="trust-item">
            <div class="trust-icon">🪪</div>
            <h3>ID-Verified Accounts</h3>
            <p>Every account is registered with a South African ID number, making it harder for scammers to operate anonymously.</p>
          </div>
          <div class="trust-item">
            <div class="trust-icon">👛</div>
            <h3>Built-in Wallet</h3>
            <p>Top up your wallet and use it to buy across the platform. Sellers receive earnings directly into their wallet.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="how-it-works" class="stack-card">
      <div class="container">
        <div class="text-center mb-5">
          <span class="hero-eyebrow">Getting Started</span>
          <h2 class="mp-section-title">How It Works</h2>
        </div>
        <div class="how-grid">
          <div class="how-step">
            <div class="how-num">1</div>
            <h3>Create Account</h3>
            <p>Register via secure national ID verification pathways.</p>
          </div>
          <div class="how-step">
            <div class="how-num">2</div>
            <h3>List or Browse</h3>
            <p>Upload backend listings or scan through verified community sellers.</p>
          </div>
          <div class="how-step">
            <div class="how-num">3</div>
            <h3>Checkout Securely</h3>
            <p>Funds exit your wallet balance to rest safely inside protected escrow mechanics.</p>
          </div>
          <div class="how-step">
            <div class="how-num">4</div>
            <h3>Confirm Receipt</h3>
            <p>Authorize safe release vectors upon visual delivery validation checks.</p>
          </div>
        </div>
      </div>
    </section>

  </div> <footer class="footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4 footer-logo">
          <h2>commerce<span style="color: var(--brand-primary);">.za</span></h2>
          <p>South Africa's consumer-to-consumer marketplace. Built for safe, local, scam-free trade.</p>
        </div>
        <div class="col-6 col-md-2 footer-links">
          <h3>Platform</h3>
          <a href="/dashboard.php">Browse Listings</a>
          <a href="/registrationPage.php">Register</a>
          <a href="/loginPage.php">Login</a>
        </div>
        <div class="col-6 col-md-3 footer-links">
          <h3>Resources</h3>
          <a href="/sellerResources.php">Seller Resources</a>
          <a href="https://www.safps.org.za/" target="_blank" rel="noopener">SAFPS — Fraud Protection</a>
        </div>
        <div class="col-md-3 footer-links">
          <h3>Legal Verification</h3>
          <a href="https://www.justice.gov.za/inforeg/" target="_blank" rel="noopener">POPIA Protection Regulator</a>
        </div>
      </div>
      <div class="footer-bottom">
        &copy; <?= date("Y") ?> commerce.za — All rights reserved. Built as part of ITECA3-12.
      </div>
    </div>
  </footer>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script> -->
  <!-- <script src="utils/script.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>