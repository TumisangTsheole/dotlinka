<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<style>
  /* ── NAV STRUCTURAL TOKENS ── */
  :root {
    --nav-bg-initial: transparent;
    --nav-bg-scrolled: rgba(255, 255, 255, 0.85);
    --nav-border-scrolled: rgba(28, 25, 23, 0.08);
    --nav-text: #1C1917;
    --nav-accent: #D85A30;
    --nav-accent-hover: #B8431B;
    --nav-radius-initial: 0px;
    --nav-radius-scrolled: 100px;
  }

  /* ── FIXED OUTER CONTAINER ── */
  .custom-navbar-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999; /* Higher than the card stack layers */
    padding: 1.25rem 0;
    transition: padding 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  }

  /* ── THE FLOATING INNER PILL CONTAINER ── */
  .custom-navbar-inner {
    background-color: var(--nav-bg-initial);
    border: 1px solid transparent;
    border-radius: var(--nav-radius-initial);
    padding: 0.5rem 1.5rem;
    width: 100%;
    transition: 
      background-color 0.4s cubic-bezier(0.25, 1, 0.5, 1),
      border-color 0.4s cubic-bezier(0.25, 1, 0.5, 1),
      border-radius 0.4s cubic-bezier(0.25, 1, 0.5, 1),
      box-shadow 0.4s cubic-bezier(0.25, 1, 0.5, 1),
      max-width 0.5s cubic-bezier(0.25, 1, 0.5, 1);
  }

  /* ── STATE CHANGES TRIPPED VIA JAVASCRIPT SCROLL ── */
  .custom-navbar-wrapper.scrolled {
    padding: 0.75rem 0;
  }
  .custom-navbar-wrapper.scrolled .custom-navbar-inner {
    background-color: var(--nav-bg-scrolled);
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border-color: var(--nav-border-scrolled);
    border-radius: var(--nav-radius-scrolled);
    box-shadow: 0 10px 30px rgba(28, 25, 23, 0.06);
    max-width: 92%; /* Smoothly pulls inward away from browser walls */
  }

  /* ── ANCHOR UNDERLINE INTERACTION ── */
  .anchor-underline {
    position: relative;
    color: var(--nav-text) !important;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 6px 12px;
    transition: color 0.25s ease;
  }
  .anchor-underline::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 12px;
    right: 12px;
    height: 2px;
    background-color: var(--nav-accent);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
  }
  .anchor-underline:hover {
    color: var(--nav-accent) !important;
  }
  .anchor-underline:hover::after {
    transform: scaleX(1);
    transform-origin: left;
  }

  /* ── FUNCTIONAL BUTTON STYLING ── */
  .nav-icon-btn {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--nav-text);
    border: 1px solid rgba(28, 25, 23, 0.1);
    background: transparent;
    transition: all 0.2s ease;
  }
  .nav-icon-btn:hover {
    background-color: #FFFFFF;
    color: var(--nav-accent);
    border-color: var(--nav-accent);
    transform: scale(1.04);
  }

  .btn-pill-action {
    font-size: 0.85rem;
    font-weight: 700;
    padding: 0.5rem 1.25rem;
    transition: all 0.25s ease;
  }
  .btn-pill-action.btn-primary {
    background-color: var(--nav-text);
    border-color: var(--nav-text);
    color: #FFFFFF;
  }
  .btn-pill-action.btn-primary:hover {
    background-color: var(--nav-accent);
    border-color: var(--nav-accent);
    transform: translateY(-1px);
  }
  .btn-pill-action.btn-secondary {
    background-color: transparent;
    border-color: rgba(28, 25, 23, 0.15);
    color: var(--nav-text);
  }
  .btn-pill-action.btn-secondary:hover {
    background-color: rgba(28, 25, 23, 0.05);
    color: var(--nav-text);
    border-color: var(--nav-text);
  }
  .btn-arrow-indicator {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--nav-text);
  }
</style>

<body>
<div class="custom-navbar-wrapper" id="js-navbar-container">
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between custom-navbar-inner mx-auto">
      
      <h2 class="text-black mb-0" style="font-size:22px; z-index: 10;">
        <a href="#" class="text-decoration-none text-dark">
          <span class="border border-4 px-1" style="border-color: var(--nav-text) !important;"><strong>.</strong></span>
          <span class="animated-gradient-text border-3 ms-1"><strong>LINKA</strong></span>
        </a>
      </h2>

      <?php if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php' || strpos($_SERVER['REQUEST_URI'], 'index.php') !== false): ?>
        <div class="d-none d-md-flex align-items-center gap-2">
          <a href="#featured" class="nav-link text-decoration-none anchor-underline">Latest</a>
          <a href="#safety" class="nav-link text-decoration-none anchor-underline">Safety</a>
          <a href="#how-it-works" class="nav-link text-decoration-none anchor-underline">How It Works</a>
        </div>
      <?php endif; ?>

      <div class="d-flex align-items-center gap-2">
        
        <button type="button" class="btn nav-icon-btn rounded-circle">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </g>
          </svg>
        </button>
        
        <a class="btn nav-icon-btn rounded-circle" href="cartPage.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <circle cx="8" cy="21" r="1"/>
              <circle cx="19" cy="21" r="1"/>
              <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
            </g>
          </svg>
        </a>

        <?php if (!isset($_SESSION["userId"])): ?>
          <a href="/loginPage.php" class="d-flex align-items-center btn btn-primary rounded-pill btn-pill-action px-3">
            <span>Sign In</span>
            <div class="btn-arrow-indicator ms-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h14m-7-7l7 7-7 7"/>
              </svg>
            </div>
          </a>
        <?php else: ?>
          <a href="/logout.php" class="d-flex align-items-center btn btn-secondary rounded-pill btn-pill-action px-3">
            <span>Log Out</span>
            <div class="btn-arrow-indicator ms-2" style="background: var(--nav-text); color: #FFF;">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 12H5m7-7l-7 7 7 7"/>
              </svg>
            </div>
          </a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navbarContainer = document.getElementById('js-navbar-container');
    
    function checkScrollPosition() {
      // If user scrolls past 40 pixels, transform navbar layout into a condensed pill
      if (window.scrollY > 40) {
        navbarContainer.classList.add('scrolled');
      } else {
        navbarContainer.classList.remove('scrolled');
      }
    }

    window.addEventListener('scroll', checkScrollPosition, { passive: true });
    checkScrollPosition(); // Guard calculation run check on immediate page refreshes
  });
</script>
</body>
</html>


