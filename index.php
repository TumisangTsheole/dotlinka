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
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <title>dotlinka — South Africa's C2C Marketplace</title>

  <style>
    /* ── HERO ── */
    .hero-section {
      background: #fff;
      min-height: 50vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 4rem 0;
    }
    .hero-inner {
      width: 85%;
      display: flex;
      align-items: center;
      gap: 3rem;
    }
    .hero-cta { flex: 1; }
    .hero-eyebrow {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: #D85A30;
      margin-bottom: 12px;
      display: block;
    }
    .hero-cta h1 {
      font-size: clamp(1.6rem, 3vw, 2.4rem);
      font-weight: 700;
      color: #1a1a1a;
      line-height: 1.2;
      margin-bottom: 1rem;
    }
    .hero-cta p {
      color: #555;
      font-size: 1rem;
      line-height: 1.65;
      margin-bottom: 1.75rem;
      max-width: 480px;
    }
    .hero-btn-primary {
      background: #D85A30;
      color: #fff;
      border: 2px solid #D85A30;
      font-weight: 700;
      padding: .55rem 1.5rem;
      border-radius: 6px;
      font-size: .95rem;
      cursor: pointer;
      transition: background .15s, border-color .15s;
      text-decoration: none;
      display: inline-block;
    }
    .hero-btn-primary:hover { background: #993C1D; border-color: #993C1D; color: #fff; text-decoration: none; }
    .hero-btn-secondary {
      background: transparent;
      color: #1a1a1a;
      border: 2px solid #1a1a1a;
      font-weight: 500;
      padding: .55rem 1.5rem;
      border-radius: 6px;
      font-size: .95rem;
      cursor: pointer;
      margin-left: .75rem;
      transition: background .15s, color .15s;
      text-decoration: none;
      display: inline-block;
    }
    .hero-btn-secondary:hover { background: #1a1a1a; color: #fff; text-decoration: none; }
    .hero-video { flex: 1; display: flex; justify-content: flex-end; align-items: center; }
    .hero-video iframe {
      border-radius: 14px;
      border: 3px solid #fff;
      box-shadow: 0 0 0 1px #e8e6e1;
      max-width: 100%;
    }
    .hero-trust { display: flex; gap: 1.5rem; margin-top: 2rem; flex-wrap: wrap; }
    .hero-trust-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: #777;
      font-weight: 500;
    }
    .hero-trust-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: #D85A30;
      flex-shrink: 0;
    }
    @media (max-width: 768px) {
      .hero-inner { flex-direction: column; width: 92%; gap: 2rem; }
      .hero-video  { justify-content: center; width: 100%; }
      .hero-video iframe { width: 100%; height: 200px; }
    }

    /* ── FEATURED ── */
    :root {
      --mp-accent:      #D85A30;
      --mp-accent-lt:   #F0997B;
      --mp-radius-card: 14px;
    }
    .mp-section { padding: 4rem 0 3rem; background: #f8f7f4; }
    .mp-eyebrow {
      font-size: 11px; font-weight: 600;
      letter-spacing: .12em; text-transform: uppercase;
      color: var(--mp-accent); margin-bottom: 6px;
    }
    .mp-section-title { font-size: 30px; font-weight: 600; color: #1a1a1a; margin: 0; }
    .mp-view-all {
      font-size: 13px; font-weight: 500;
      color: var(--mp-accent);
      border-bottom: 1.5px solid var(--mp-accent-lt);
      text-decoration: none; padding-bottom: 2px; white-space: nowrap;
    }
    .mp-view-all:hover { color: #993C1D; border-color: #993C1D; text-decoration: none; }

    .mp-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 1.75rem; }
    .mp-chip {
      font-size: 12px; font-weight: 500;
      padding: 5px 16px; border-radius: 20px;
      border: 1px solid #d8d6d0; background: #fff; color: #666;
      cursor: pointer; transition: all .15s;
      text-decoration: none; display: inline-block;
    }
    .mp-chip:hover, .mp-chip.active {
      background: var(--mp-accent); border-color: var(--mp-accent);
      color: #fff; text-decoration: none;
    }

    .mp-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: var(--mp-radius-card);
      overflow: hidden;
      transition: border-color .2s, transform .2s;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .mp-card:hover { border-color: #c4c0b8; transform: translateY(-2px); text-decoration: none; }
    .mp-card:hover .mp-img img { transform: scale(1.04); }

    .mp-img {
      position: relative; height: 190px;
      overflow: hidden; background: #f0eeea;
    }
    .mp-img img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform .35s ease; display: block;
    }

    .mp-body { padding: 13px 15px 15px; flex: 1; display: flex; flex-direction: column; }
    .mp-cat { font-size: 10px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: #999; margin-bottom: 4px; }
    .mp-name { font-size: 14px; font-weight: 500; color: #1a1a1a; margin: 0 0 5px; line-height: 1.35; }
    .mp-desc {
      font-size: 12px; color: #777; line-height: 1.5;
      margin: 0 0 12px;
      display: -webkit-box; -webkit-line-clamp: 2;
      -webkit-box-orient: vertical; overflow: hidden; flex: 1;
    }
    .mp-price-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .mp-price { font-size: 17px; font-weight: 600; color: #1a1a1a; }
    .mp-divider { height: 1px; background: #f0eeea; margin: 0 0 10px; }
    .mp-seller { display: flex; align-items: center; gap: 9px; }
    .mp-seller-name { font-size: 12px; font-weight: 500; color: #1a1a1a; }

    /* ── ESCROW EXPLAINER ── */
    .escrow-section {
      background: #1a1a1a;
      padding: 4rem 0;
    }
    .escrow-inner {
      width: 85%;
      margin: 0 auto;
      display: flex;
      align-items: center;
      gap: 4rem;
      flex-wrap: wrap;
    }
    .escrow-copy { flex: 1; min-width: 260px; }
    .escrow-eyebrow {
      font-size: 11px; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      color: #D85A30; margin-bottom: 10px; display: block;
    }
    .escrow-copy h2 {
      font-size: 26px; font-weight: 700;
      color: #fff; margin-bottom: 1rem; line-height: 1.3;
    }
    .escrow-copy p {
      font-size: 14px; color: #888; line-height: 1.7; margin: 0;
    }
    .escrow-steps { flex: 1; min-width: 260px; display: flex; flex-direction: column; gap: 1rem; }
    .escrow-step {
      display: flex; align-items: flex-start; gap: 1rem;
      background: #242424; border-radius: 10px; padding: 1rem 1.25rem;
    }
    .escrow-step-num {
      width: 28px; height: 28px; border-radius: 50%;
      background: #D85A30; color: #fff;
      font-size: 12px; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .escrow-step-title { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 3px; }
    .escrow-step-desc  { font-size: 12px; color: #777; line-height: 1.5; }

    /* ── TRUST ── */
    .trust-section { background: #fff; padding: 4rem 0; border-top: 1px solid #e8e6e1; }
    .trust-inner { width: 85%; margin: 0 auto; text-align: center; }
    .trust-eyebrow {
      font-size: 11px; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      color: #D85A30; margin-bottom: 10px; display: block;
    }
    .trust-title { font-size: 28px; font-weight: 600; color: #1a1a1a; margin-bottom: 2rem; }
    .trust-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; }
    .trust-item {
      background: #f8f7f4; border: 1px solid #e8e6e1;
      border-radius: 12px; padding: 1.5rem; text-align: center;
      transition: transform .2s;
    }
    .trust-item:hover { transform: translateY(-4px); }
    .trust-icon { font-size: 28px; color: #D85A30; margin-bottom: 1rem; }
    .trust-item h3 { font-size: 16px; font-weight: 600; margin-bottom: .5rem; color: #1a1a1a; }
    .trust-item p { font-size: 13px; color: #666; line-height: 1.5; margin: 0; }

    /* ── HOW IT WORKS ── */
    .how-section { background: #f8f7f4; padding: 4rem 0; }
    .how-inner { width: 85%; margin: 0 auto; text-align: center; }
    .how-eyebrow {
      font-size: 11px; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      color: #D85A30; margin-bottom: 10px; display: block;
    }
    .how-title { font-size: 28px; font-weight: 600; color: #1a1a1a; margin-bottom: 2.5rem; }
    .how-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; }
    .how-step {
      background: #fff; border: 1px solid #e8e6e1;
      border-radius: 12px; padding: 2rem 1.5rem;
      text-align: center; transition: transform .2s;
    }
    .how-step:hover { transform: translateY(-4px); }
    .how-num {
      width: 36px; height: 36px; border-radius: 50%;
      background: #D85A30; color: #fff;
      font-size: 14px; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1rem;
    }
    .how-step h3 { font-size: 15px; font-weight: 600; margin-bottom: .65rem; color: #1a1a1a; }
    .how-step p  { font-size: 13px; color: #666; line-height: 1.5; margin: 0; }

    /* ── FOOTER ── */
    .footer { background: #1a1a1a; color: #ddd; padding: 3rem 0; }
    .footer-inner {
      width: 85%; margin: 0 auto;
      display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem;
    }
    .footer-logo h2 { color: #fff; margin-bottom: 1rem; font-size: 22px; }
    .footer-logo p  { font-size: 13px; color: #666; line-height: 1.6; }
    .footer-links h3 { color: #fff; font-size: 14px; font-weight: 600; margin-bottom: .75rem; }
    .footer-links a {
      display: block; color: #888; text-decoration: none;
      margin-bottom: .5rem; font-size: 13px; transition: color .2s;
    }
    .footer-links a:hover { color: #D85A30; }
    .footer-contact h3 { color: #fff; font-size: 14px; font-weight: 600; margin-bottom: .75rem; }
    .footer-contact p  { font-size: 13px; color: #888; margin: .25rem 0; }
    .footer-bottom { text-align: center; margin-top: 2rem; font-size: 13px; color: #555; padding-top: 2rem; border-top: 1px solid #2a2a2a; width: 85%; margin-left: auto; margin-right: auto; }
  
    /* ── RESPONSIVE: index.php sections ── */
    @media (max-width: 768px) {
      .escrow-inner,
      .trust-inner,
      .how-inner,
      .footer-inner,
      .footer-bottom { width: 100% !important; padding-left: 1rem; padding-right: 1rem; box-sizing: border-box; }
      .escrow-inner { flex-direction: column; gap: 2rem; }
      .mp-section > div { padding-left: 1rem; padding-right: 1rem; }
      /* Product grid: 2 columns on mobile */
      #product-grid .col-6 { flex: 0 0 50%; max-width: 50%; }
    }
    @media (max-width: 480px) {
      /* 1 column product grid on very small screens */
      #product-grid .col-6 { flex: 0 0 100%; max-width: 100%; }
    }
</style>
</head>

<body id="my-scrollbar" class="fs-5">
  <?php include 'components/loading.php'; ?>

  <?php include "components/navbar.php"; ?>

  <section class="hero-section">
    <div class="hero-inner">
      <div class="hero-cta">
        <span class="hero-eyebrow">South Africa's C2C marketplace</span>
        <h1 class="fw-bold">Buy and sell locally — safely, simply, securely.</h1>
        <p>
          dotlinka is a consumer-to-consumer marketplace built exclusively for South Africans. 
          List your goods, browse local sellers, and trade with confidence knowing your payment 
          is protected by our built-in escrow system.
        </p>
        <div>
          <a href="registrationPage.php" class="hero-btn-primary">Get Started Free</a>
          <a href="dashboard.php" class="hero-btn-secondary">Browse Listings &rarr;</a>
        </div>
        <div class="hero-trust">
          <span class="hero-trust-item"><span class="hero-trust-dot"></span>Escrow-protected payments</span>
          <span class="hero-trust-item"><span class="hero-trust-dot"></span>SA sellers only</span>
          <span class="hero-trust-item"><span class="hero-trust-dot"></span>ID-verified accounts</span>
          <span class="hero-trust-item"><span class="hero-trust-dot"></span>Built-in wallet</span>
        </div>
      </div>
		<style>
		  /* ── LIVE ESCROW SIMULATOR CARD ── */
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
		    box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
		    animation: pulse-green 2s infinite;
		  }
		  
		  /* Pipeline Node Architecture */
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
		    transition: all var(--transition-fast);
		  }
		  
		  /* Active states simulating functional mechanics */
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
		    border: 1px solid transparent;
		    transition: all var(--transition-fast);
		  }
		  .pipeline-node.active .node-content {
		    background: #FFFFFF;
		    border-color: var(--brand-light);
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
		
		  @keyframes pulse-green {
		    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
		    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
		    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
		  }
		</style>
		
		<div class="col-lg-6 d-flex justify-content-lg-end justify-content-center">
		  <div class="secure-widget-card">
		    
		    <div class="widget-header">
		      <div>
		        <h4 class="mb-0 fw-bold" style="font-size: 0.95rem; letter-spacing: -0.01em;">Escrow Ledger Protection</h4>
		        <p class="text-muted mb-0" style="font-size: 0.75rem;">System Core: Active Integration</p>
		      </div>
		      <div class="widget-badge">
		        <span class="widget-pulse"></span>
		        Live Protection
		      </div>
		    </div>
		
		    <div class="pipeline-track">
		      <!-- Node 1: Completed -->
		      <div class="pipeline-node complete">
		        <div class="node-dot">✓</div>
		        <div class="node-content">
		          <div class="node-title">Buyer Commits Wallet Funds</div>
		          <div class="node-meta">R3,450.00 locked tightly inside system escrow architecture</div>
		        </div>
		      </div>
		
		      <!-- Node 2: Active Processing State -->
		      <div class="pipeline-node active">
		        <div class="node-dot">2</div>
		        <div class="node-content">
		          <div class="node-title">Sellers Verification & Transit</div>
		          <div class="node-meta">Tracking code uploaded; pending visual package verification</div>
		        </div>
		      </div>
		
		      <!-- Node 3: Future State -->
		      <div class="pipeline-node">
		        <div class="node-dot">3</div>
		        <div class="node-content">
		          <div class="node-title">Release Pay-Out Payload</div>
		          <div class="node-meta">Funds deploy instantly to the seller's wallet balance upon authorization</div>
		        </div>
		      </div>
		    </div>
		
		  </div>
		</div>
    </div>
  </section>

  <section id="featured" class="mp-section">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between mb-3">
        <div>
          <p class="mp-eyebrow mb-0">Fresh listings</p>
          <h2 class="mp-section-title">Latest on the market</h2>
        </div>
        <a href="/dashboard.php" class="mp-view-all">View all &rarr;</a>
      </div>

      <div class="mp-chips">
        <a href="?"                  class="mp-chip active">All</a>
        <a href="?cat=Electronics"    class="mp-chip">Electronics</a>
        <a href="?cat=Clothing"       class="mp-chip">Clothing</a>
        <a href="?cat=Furniture"      class="mp-chip">Furniture</a>
        <a href="?cat=Books"          class="mp-chip">Books</a>
        <a href="?cat=Sports"         class="mp-chip">Sports</a>
        <a href="?cat=Vehicles"       class="mp-chip">Vehicles</a>
      </div>

      <div class="row g-3">
 		<?php foreach (array_slice($indexPageProducts, 0, 4) as $product): ?>
          <div class="col-6 col-md-4 col-lg-2">
            <a href="/product-detail.php?id=<?= $product["id"] ?>"
               class="mp-card d-block text-decoration-none">

              <div class="mp-img">
                <?php
                  $imgSrc = !empty($product["image"])
                    ? htmlspecialchars($product["image"])
                    : "https://placehold.co/600x400/1a1a1a/f5f3ef/png";
                ?>
                <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" loading="lazy">
              </div>

              <div class="mp-body">
                <p class="mp-cat"><?= htmlspecialchars($product['category']) ?></p>
                <p class="mp-name"><?= htmlspecialchars($product['product_name']) ?></p>
                <p class="mp-desc"><?= htmlspecialchars($product['description']) ?></p>
                <div class="mp-price-row">
                  <span class="mp-price">R<?= number_format($product['price'], 2) ?></span>
                </div>
                <div class="mp-divider"></div>
                <div class="mp-seller">
                  <div class="mp-seller-name"><?= htmlspecialchars($product['firstName']) ?></div>
                </div>
              </div>

            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="escrow" class="escrow-section">
    <div class="escrow-inner">
      <div class="escrow-copy">
        <span class="escrow-eyebrow">How payments work</span>
        <h2>Your money is protected — every single time.</h2>
        <p>
          We hold your payment in escrow until you confirm you've received your order. 
          The seller only gets paid once you're happy. No more fake proof of payments, 
          no more losing money to scammers.
        </p>
      </div>
      <div class="escrow-steps">
        <div class="escrow-step">
          <div class="escrow-step-num">1</div>
          <div>
            <div class="escrow-step-title">You pay into escrow</div>
            <div class="escrow-step-desc">Funds are deducted from your wallet and held securely by dotlinka — not the seller.</div>
          </div>
        </div>
        <div class="escrow-step">
          <div class="escrow-step-num">2</div>
          <div>
            <div class="escrow-step-title">Seller ships your order</div>
            <div class="escrow-step-desc">The seller is notified and marks the order as shipped once it's on its way to you.</div>
          </div>
        </div>
        <div class="escrow-step">
          <div class="escrow-step-num">3</div>
          <div>
            <div class="escrow-step-title">You confirm receipt</div>
            <div class="escrow-step-desc">Once you confirm delivery, funds are released to the seller. Not before.</div>
          </div>
        </div>
        <div class="escrow-step">
          <div class="escrow-step-num">4</div>
          <div>
            <div class="escrow-step-title">Cancel anytime before shipping</div>
            <div class="escrow-step-desc">Changed your mind? Cancel while the order is pending and your full amount is refunded instantly.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="safety" class="trust-section">
    <div class="trust-inner">
      <span class="trust-eyebrow">Why Choose Us</span>
      <h2 class="trust-title">Built for safe trading</h2>
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
          <div class="trust-icon">👥</div>
          <h3>Built-in Wallet</h3>
          <p>Top up your wallet and use it to buy across the platform. Sellers receive earnings directly into their wallet.</p>
        </div>
       
        <div class="trust-item">
          <div class="trust-icon">📋</div>
          <h3>Seller Resources</h3>
          <p>Access plain-language guides on tax obligations, POPIA compliance, and fraud prevention — all in one place.</p>
        </div>
        <div class="trust-item">
          <div class="trust-icon">🛡️</div>
          <h3>Admin Oversight</h3>
          <p>Our platform is actively managed — listings and accounts are monitored to keep the marketplace clean and fair.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="how-it-works" class="how-section">
    <div class="how-inner">
      <span class="how-eyebrow">Getting Started</span>
      <h2 class="how-title">How It Works</h2>
      <div class="how-grid">
        <div class="how-step">
          <div class="how-num">1</div>
          <h3>Create Your Account</h3>
          <p>Register with your South African ID number, verify your details, and you're ready to buy or sell.</p>
        </div>
        <div class="how-step">
          <div class="how-num">2</div>
          <h3>List or Browse</h3>
          <p>Sellers list products with photos, descriptions and prices. Buyers browse by category and add to cart.</p>
        </div>
        <div class="how-step">
          <div class="how-num">3</div>
          <h3>Checkout Securely</h3>
          <p>Pay from your wallet — funds go into escrow, not directly to the seller, protecting you immediately.</p>
        </div>
        <div class="how-step">
          <div class="how-num">4</div>
          <h3>Confirm & Complete</h3>
          <p>Once you receive your order, confirm it on your profile. Payment is released to the seller instantly.</p>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-logo">
        <h2>.<span style="color:#D85A30;">linka</span></h2>
        <p>South Africa's consumer-to-consumer marketplace. Built for safe, local, scam-free trade.</p>
      </div>
      <div class="footer-links">
        <h3>Platform</h3>
        <a href="/dashboard.php">Browse Listings</a>
        <a href="/registrationPage.php">Register</a>
        <a href="/loginPage.php">Login</a>
        <a href="/registerProductPage.php">Sell Something</a>
      </div>
      <div class="footer-links">
        <h3>Resources</h3>
        <a href="/sellerResources.php">Seller Resources</a>
        <a href="https://www.safps.org.za/" target="_blank" rel="noopener">SAFPS — Fraud Protection</a>
        <a href="https://www.sars.gov.za/businesses-and-employers/small-businesses-taxpayers/" target="_blank" rel="noopener">SARS Small Business</a>
        <a href="https://www.thencc.gov.za/welcome" target="_blank" rel="noopener">Consumer Rights (NCC)</a>
      </div>
      <div class="footer-links">
        <h3>Legal</h3>
        <a href="https://www.justice.gov.za/inforeg/" target="_blank" rel="noopener">POPIA Information Regulator</a>
        <a href="https://www.thedtic.gov.za/wp-content/uploads/Consumer_Protection_Act.pdf" target="_blank" rel="noopener">Consumer Protection Act</a>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; <?= date("Y") ?> dotlinka — All rights reserved. Built as part of ITECA3-12 at Eduvos.
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
  <script src="utils/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
