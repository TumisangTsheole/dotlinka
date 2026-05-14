<?php
// Replace this array with a DB query, e.g.:
// $products = $pdo->query("SELECT p.*, u.username, u.avatar, u.rating, u.total_sales FROM products p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC LIMIT 6")->fetchAll();

$products = [
    [
        'title'       => 'Sony WH-1000XM5 headphones',
        'category'    => 'Electronics',
        'description' => 'Barely used, original box included. Noise cancellation still pristine.',
        'price'       => 3200,
        'condition'   => 'Like new',
        'badge'       => 'Hot',
        'badge_class' => 'badge-hot',
        'image'       => 'https://placehold.co/400x300/E6F1FB/378ADD?text=🎧',
        'seller'      => [
            'name'        => 'Thabo M.',
            'initials'    => 'TM',
            'rating'      => '4.9',
            'total_sales' => 142,
            'avatar'      => null, // set to image path if available
        ],
    ],
    [
        'title'       => "Vintage Levi's 501 jeans — W32 L32",
        'category'    => 'Fashion',
        'description' => 'Authentic 90s stonewash. Minor fade adds character, no tears or stains.',
        'price'       => 850,
        'condition'   => 'Good',
        'badge'       => 'New',
        'badge_class' => 'badge-new',
        'image'       => 'https://placehold.co/400x300/EEEDFE/534AB7?text=👖',
        'seller'      => [
            'name'        => 'Lerato V.',
            'initials'    => 'LV',
            'rating'      => '4.7',
            'total_sales' => 38,
            'avatar'      => null,
        ],
    ],
    [
        'title'       => 'Weber Q1200 portable gas braai',
        'category'    => 'Home & Garden',
        'description' => 'Cleaned and ready to use. Spare gas canister included. Compact and powerful.',
        'price'       => 2100,
        'condition'   => 'Good',
        'badge'       => null,
        'badge_class' => null,
        'image'       => 'https://placehold.co/400x300/FAECE7/D85A30?text=🔥',
        'seller'      => [
            'name'        => 'Pieter K.',
            'initials'    => 'PK',
            'rating'      => '5.0',
            'total_sales' => 21,
            'avatar'      => null,
        ],
    ],
    [
        'title'       => 'iPad Air 5th gen — 256 GB Wi-Fi',
        'category'    => 'Electronics',
        'description' => 'Space grey, minor scratch on back corner. Screen is immaculate.',
        'price'       => 7500,
        'condition'   => 'Fair',
        'badge'       => 'Featured',
        'badge_class' => 'badge-featured',
        'image'       => 'https://placehold.co/400x300/EAF3DE/3B6D11?text=📱',
        'seller'      => [
            'name'        => 'Asha N.',
            'initials'    => 'AN',
            'rating'      => '4.8',
            'total_sales' => 67,
            'avatar'      => null,
        ],
    ],
    [
        'title'       => 'Cannondale Synapse road bike',
        'category'    => 'Sporting Goods',
        'description' => '54cm frame, Shimano 105 groupset, new tyres fitted last month.',
        'price'       => 12000,
        'condition'   => 'Like new',
        'badge'       => 'New',
        'badge_class' => 'badge-new',
        'image'       => 'https://placehold.co/400x300/FAEEDA/BA7517?text=🚴',
        'seller'      => [
            'name'        => 'Ben W.',
            'initials'    => 'BW',
            'rating'      => '4.6',
            'total_sales' => 9,
            'avatar'      => null,
        ],
    ],
    [
        'title'       => 'First edition Harry Potter boxed set',
        'category'    => 'Collectibles',
        'description' => 'All 7 books, UK Bloomsbury prints. Minor shelf wear on outer box.',
        'price'       => 4800,
        'condition'   => 'Good',
        'badge'       => 'Hot',
        'badge_class' => 'badge-hot',
        'image'       => 'https://placehold.co/400x300/FBEAF0/993556?text=📚',
        'seller'      => [
            'name'        => 'Sindi R.',
            'initials'    => 'SR',
            'rating'      => '5.0',
            'total_sales' => 15,
            'avatar'      => null,
        ],
    ],
];
?>

<!-- ===== GOOGLE FONTS — add inside <head> ===== -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"> -->

<style>
  /* ── Section variables ── */
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
</style>

<!-- ===== SECTION ===== -->
<section class="mp-section">
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