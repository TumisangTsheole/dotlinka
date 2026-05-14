<?php include "data/products.php"; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <title>Project</title>
  </head>

<style>
  /* HERO SECTION */
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

  /* CTA column */
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

  /* Buttons */
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
  .hero-btn-primary:hover {
    background: #993C1D;
    border-color: #993C1D;
    color: #fff;
    text-decoration: none;
  }

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
  .hero-btn-secondary:hover {
    background: #1a1a1a;
    color: #fff;
    text-decoration: none;
  }

  /* Video column */
  .hero-video { flex: 1; display: flex; justify-content: flex-end; align-items: center; }

  .hero-video iframe {
    border-radius: 14px;
    border: 3px solid #fff;
    box-shadow: 0 0 0 1px #e8e6e1;
    max-width: 100%;
  }

  /* Trust bar */
  .hero-trust {
    display: flex;
    gap: 1.5rem;
    margin-top: 2rem;
    flex-wrap: wrap;
  }
  .hero-trust-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #777;
    font-weight: 500;
  }
  .hero-trust-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #D85A30;
    flex-shrink: 0;
  }


  @media (max-width: 768px) {
    .hero-inner { flex-direction: column; width: 92%; gap: 2rem; }
    .hero-video  { justify-content: center; width: 100%; }
    .hero-video iframe { width: 100%; height: 200px; }
  }

  /* FEATURED SECTION */
  :root {
    --mp-accent:      #D85A30;
    --mp-accent-lt:   #F0997B;
    --mp-radius-card: 14px;
    --mp-radius-sm:   6px;
  }

  /* ── Section wrapper ── */
  .mp-section {
    /* font-family: 'DM Sans', sans-serif; */
    padding: 4rem 0 3rem;
    background: #f8f7f4;
  }

  /* ── Header ── */
  .mp-eyebrow {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--mp-accent);
    margin-bottom: 6px;
  }
  .mp-section-title {
    /* font-family: 'Playfair Display', serif; */
    font-size: 30px;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0;
  }
  .mp-view-all {
    font-size: 13px;
    font-weight: 500;
    color: var(--mp-accent);
    border-bottom: 1.5px solid var(--mp-accent-lt);
    text-decoration: none;
    padding-bottom: 2px;
    white-space: nowrap;
  }
  .mp-view-all:hover { color: #993C1D; border-color: #993C1D; text-decoration: none; }

  /* ── Filter chips ── */
  .mp-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 1.75rem; }
  .mp-chip {
    font-size: 12px;
    font-weight: 500;
    padding: 5px 16px;
    border-radius: 20px;
    border: 1px solid #d8d6d0;
    background: #fff;
    color: #666;
    cursor: pointer;
    transition: all .15s;
    text-decoration: none;
    display: inline-block;
  }
  .mp-chip:hover, .mp-chip.active {
    background: var(--mp-accent);
    border-color: var(--mp-accent);
    color: #fff;
    text-decoration: none;
  }

  /* ── Card ── */
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
  .mp-card:hover {
    border-color: #c4c0b8;
    transform: translateY(-2px);
    text-decoration: none;
  }
  .mp-card:hover .mp-img img { transform: scale(1.04); }

  /* ── Image area ── */
  .mp-img {
    position: relative;
    height: 190px;
    overflow: hidden;
    background: #f0eeea;
  }
  .mp-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
    display: block;
  }

  /* ── Badges ── */
  .mp-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 4px;
  }
  .badge-new      { background: #E1F5EE; color: #0F6E56; }
  .badge-hot      { background: #FAECE7; color: #993C1D; }
  .badge-featured { background: #EEEDFE; color: #3C3489; }

  /* ── Wishlist button ── */
  .mp-wish {
    position: absolute;
    top: 9px;
    right: 9px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #999;
    font-size: 15px;
    transition: color .15s;
    text-decoration: none;
  }
  .mp-wish:hover { color: var(--mp-accent); }

  /* ── Card body ── */
  .mp-body { padding: 13px 15px 15px; flex: 1; display: flex; flex-direction: column; }
  .mp-cat  { font-size: 10px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: #999; margin-bottom: 4px; }
  .mp-name { font-size: 14px; font-weight: 500; color: #1a1a1a; margin: 0 0 5px; line-height: 1.35; }
  .mp-desc {
    font-size: 12px;
    color: #777;
    line-height: 1.5;
    margin: 0 0 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
  }
  .mp-price-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .mp-price { font-size: 17px; font-weight: 600; color: #1a1a1a; }
  .mp-cond  { font-size: 10px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; padding: 3px 8px; border-radius: 4px; background: #f0eeea; color: #666; }

  /* ── Seller row ── */
  .mp-divider { height: 1px; background: #f0eeea; margin: 0 0 10px; }
  .mp-seller  { display: flex; align-items: center; gap: 9px; }
  .mp-avatar  { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 600; }
  .mp-seller-name { font-size: 12px; font-weight: 500; color: #1a1a1a; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .mp-seller-meta { font-size: 11px; color: #999; }
  .mp-star { color: #EF9F27; }

  /* TRUST AND SAFETY */
  
  .trust-section {
    background: #fff;
    padding: 4rem 0;
    border-top: 1px solid #e8e6e1;
  }

  .trust-inner {
    width: 85%;
    margin: 0 auto;
    text-align: center;
  }

  .trust-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #D85A30;
    margin-bottom: 10px;
    display: block;
  }

  .trust-title {
    font-size: 28px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 2rem;
  }

  .trust-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
  }

  .trust-item {
    background: #f8f7f4;
    border: 1px solid #e8e6e1;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: transform .2s;
  }
  .trust-item:hover { transform: translateY(-4px); }

  .trust-icon {
    font-size: 28px;
    color: #D85A30;
    margin-bottom: 1rem;
  }

  .trust-item h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: .5rem;
    color: #1a1a1a;
  }

  .trust-item p {
    font-size: 13px;
    color: #666;
    line-height: 1.5;
    margin: 0;
  }

  /* HOW IT WORKS SECTION */
  .how-section {
    background: #f8f7f4;
    padding: 4rem 0;
  }

  .how-inner {
    width: 85%;
    margin: 0 auto;
    text-align: center;
  }

  .how-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #D85A30;
    margin-bottom: 10px;
    display: block;
  }

  .how-title {
    font-size: 28px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 2.5rem;
  }

  .how-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
  }

  .how-step {
    background: #fff;
    border: 1px solid #e8e6e1;
    border-radius: 12px;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: transform .2s;
  }
  .how-step:hover { transform: translateY(-4px); }

  .how-icon {
    font-size: 32px;
    color: #D85A30;
    margin-bottom: 1rem;
  }

  .how-step h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: .75rem;
    color: #1a1a1a;
  }

  .how-step p {
    font-size: 13px;
    color: #666;
    line-height: 1.5;
    margin: 0;
  }

  /* FOOTER  */
  .footer {
    background: #1a1a1a;
    color: #ddd;
    padding: 3rem 0;
  }

  .footer-inner {
    width: 85%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
  }

  .footer h2 {
    font-size: 22px;
    margin-bottom: 1rem;
  }

  .footer-logo h2 {
    color: #fff;
    margin-bottom: 1rem;
  }

  .footer-logo span {
    font-weight: 700;
  }

  .footer-links a {
    display: block;
    color: #ddd;
    text-decoration: none;
    margin-bottom: .5rem;
    font-size: 14px;
    transition: color .2s;
  }
  .footer-links a:hover { color: #D85A30; }

  .footer-contact p {
    font-size: 14px;
    margin: .25rem 0;
  }

  .footer-bottom {
    text-align: center;
    margin-top: 2rem;
    font-size: 13px;
    color: #999;
  }
</style>


  <body class="fs-5">
    <!-- include smooth scroll and animation at "Go To Marketplace button" -->

    <!-- NAVBAR -->
    <?php include "components/navbar.php"; ?>

    <!-- HERO SECTION -->
    <section class="hero-section">
      <div class="hero-inner">

        <!-- CTA -->
        <div class="hero-cta">
          <span class="hero-eyebrow">South Africa&rsquo;s C2C marketplace</span>
          <h1 class="fw-bold">Looking To Sell Something? We got the platform! ...and all the support you need.</h1>
          <p>
            Sell your goods on a consumer-to-consumer platform exclusive to South Africans looking for a platform to purchase goods scam-free and securely.
          </p>
          <div>
            <a href="dashboard.php" class="hero-btn-primary">Explore</a>
            <button type="button" class="hero-btn-secondary">For New Users &rarr;</button>
          </div>

          <!-- Trust bar -->
          <div class="hero-trust">
            <span class="hero-trust-item"><span class="hero-trust-dot"></span>Scam-free transactions</span>
            <span class="hero-trust-item"><span class="hero-trust-dot"></span>SA sellers only</span>
            <span class="hero-trust-item"><span class="hero-trust-dot"></span>Secure payments</span>
          </div>
        </div>

        <!-- Intro Video -->
        <div class="hero-video">
          <iframe
            width="450"
            height="250"
            src="https://www.youtube.com/embed/kW6zlWQAIWg?si=pd3h7chSssgb2ggL"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen
          ></iframe>
        </div>

      </div>
    </section>

    <!-- FEATURED SECTION -->
    <section id="featured" class="mp-section">
      <div class="container">

        <!-- Header -->
        <div class="d-flex align-items-end justify-content-between mb-3">
          <div>
            <p class="mp-eyebrow mb-0">Fresh listings</p>
            <h2 class="mp-section-title">Latest on the market</h2>
          </div>
          <a href="/listings" class="mp-view-all">View all &rarr;</a>
        </div>

        <!-- Filter chips -->
        <div class="mp-chips">
          <a href="?" class="mp-chip active">All</a>
          <a href="?cat=electronics"    class="mp-chip">Electronics</a>
          <a href="?cat=fashion"        class="mp-chip">Fashion</a>
          <a href="?cat=home-garden"    class="mp-chip">Home &amp; Garden</a>
          <a href="?cat=sporting-goods" class="mp-chip">Sporting goods</a>
          <a href="?cat=collectibles"   class="mp-chip">Collectibles</a>
        </div>

        <!-- Product grid -->
        <div class="row g-3">
          <?php foreach ($products as $product): ?>
            <div class="col-6 col-md-4 col-lg-2">
              <a href="/listing/<?= urlencode(strtolower(str_replace(' ', '-', $product['title']))) ?>"
                class="mp-card d-block text-decoration-none">

                <!-- Image -->
                <div class="mp-img">
                  <img
                    src="<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['title']) ?>"
                    loading="lazy"
                  >
                  <?php if ($product['badge']): ?>
                    <span class="mp-badge <?= $product['badge_class'] ?>">
                      <?= htmlspecialchars($product['badge']) ?>
                    </span>
                  <?php endif; ?>
                  <span class="mp-wish" title="Save to wishlist" aria-label="Save to wishlist">&#9825;</span>
                </div>

                <!-- Body -->
                <div class="mp-body">
                  <p class="mp-cat"><?= htmlspecialchars($product['category']) ?></p>
                  <p class="mp-name"><?= htmlspecialchars($product['title']) ?></p>
                  <p class="mp-desc"><?= htmlspecialchars($product['description']) ?></p>

                  <div class="mp-price-row">
                    <span class="mp-price">R <?= number_format($product['price']) ?></span>
                    <span class="mp-cond"><?= htmlspecialchars($product['condition']) ?></span>
                  </div>

                  <!-- Seller -->
                  <div class="mp-divider"></div>
                  <div class="mp-seller">
                    <?php $seller = $product['seller']; ?>

                    <?php if (!empty($seller['avatar'])): ?>
                      <img
                        src="<?= htmlspecialchars($seller['avatar']) ?>"
                        alt="<?= htmlspecialchars($seller['name']) ?>"
                        class="mp-avatar"
                      >
                    <?php else: ?>
                      <!-- Initials fallback -->
                      <div class="mp-avatar" style="background:#f0eeea; color:#666;">
                        <?= htmlspecialchars($seller['initials']) ?>
                      </div>
                    <?php endif; ?>

                    <div style="min-width:0;">
                      <div class="mp-seller-name"><?= htmlspecialchars($seller['name']) ?></div>
                      <div class="mp-seller-meta">
                        <span class="mp-star">&#9733;</span>
                        <?= htmlspecialchars($seller['rating']) ?> &middot; <?= $seller['total_sales'] ?> sales
                      </div>
                    </div>
                  </div>
                </div><!-- /.mp-body -->

              </a><!-- /.mp-card -->
            </div>
          <?php endforeach; ?>
        </div><!-- /.row -->

      </div><!-- /.container -->
    </section>
  
    <!-- TRUST AND SECTION -->
    <section id="safety" class="trust-section">
      <div class="trust-inner">
        <span class="trust-eyebrow">Why Choose Us</span>
        <h2 class="trust-title">Your Safety, Our Priority</h2>

        <div class="trust-grid">
          <div class="trust-item">
            <div class="trust-icon">🔒</div>
            <h3>Secure Payments</h3>
            <p>All transactions are protected with trusted payment gateways to keep your money safe.</p>
          </div>
          <div class="trust-item">
            <div class="trust-icon">🛡️</div>
            <h3>Scam-Free Marketplace</h3>
            <p>We verify sellers and monitor listings to ensure a safe buying and selling experience.</p>
          </div>
          <div class="trust-item">
            <div class="trust-icon">🌍</div>
            <h3>Local Sellers Only</h3>
            <p>Exclusive to South African buyers and sellers, keeping trade close to home.</p>
          </div>
          <div class="trust-item">
            <div class="trust-icon">🤝</div>
            <h3>Community Support</h3>
            <p>Our team is here to help with disputes, questions, and guidance every step of the way.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- HOW IT WORKS SECTION -->
    <section id="how-it-works" class="how-section">
      <div class="how-inner">
        <span class="how-eyebrow">Getting Started</span>
        <h2 class="how-title">How It Works</h2>

        <div class="how-grid">
          <div class="how-step">
            <div class="how-icon">📸</div>
            <h3>List Your Item</h3>
            <p>Upload photos, set a price, and add details. Your listing goes live instantly.</p>
          </div>
          <div class="how-step">
            <div class="how-icon">💬</div>
            <h3>Connect With Buyers</h3>
            <p>Chat securely within the platform and arrange delivery or pickup with ease.</p>
          </div>
          <div class="how-step">
            <div class="how-icon">💰</div>
            <h3>Get Paid Safely</h3>
            <p>Receive payments through our secure system — fast, reliable, and scam‑free.</p>
          </div>
        </div>
      </div>
    </section>

    <?php include "components/footer.php"; ?>


    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
  </body>
</html>
