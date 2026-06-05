<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<style>
  .animated-gradient-text {
    background: linear-gradient(270deg,#00ff00,#7928ca,#abaaac,#48bb78,#ed8936,#ff0000);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: flowAndGlow 8s ease infinite;
    display: inline-block;
  }
  @keyframes flowAndGlow {
    0%   { background-position: 0%   50%; filter: drop-shadow(0 0 5px rgba(255,255,255,.2)); }
    50%  { background-position: 100% 50%; filter: drop-shadow(0 0 15px rgba(255,255,255,.6)); }
    100% { background-position: 0%   50%; filter: drop-shadow(0 0 5px rgba(255,255,255,.2)); }
  }
  .anchor-underline {
    background-image: linear-gradient(#5fca66 0 0);
    background-position: bottom left;
    background-size: 20% 2px;
    background-repeat: no-repeat;
    font-weight: unset;
    transition: background-size 0.5s ease-in-out;
  }
  .anchor-underline:hover { background-size: 50% 2px; font-weight: bold; }
  .anchor-underline:active { background-size: 100% 5px; }
  .nav-button {
    background-color: transparent;
    color: rgb(33, 37, 41);
    display: inline-block;
    transition: all 0.2s ease-in-out;
  }
  .nav-button:hover  { color: rgb(0, 0, 0); }
  .nav-button:active { font-weight: bolder; }
  /* ── NAVBAR RESPONSIVE ── */
  .nav-sign-label { display: inline; }
  @media (max-width: 500px) {
    .nav-sign-label { display: none; }
    nav .d-flex.align-items-center.rounded-pill { display: none !important; }
    nav { padding-top: .5rem !important; margin-top: 0 !important; }
    nav .d-flex.align-items-center.justify-content-between { padding: 0 .75rem !important; }
  }
</style>

<nav class="bg-transparent py-3 mt-3">
  <div class="d-flex align-items-center justify-content-between px-4">

    <!-- Logo -->
    <h2 class="text-black mb-0 me-5" style="font-size:22px;">
      <a href="/dashboard.php"><span class="border border-4"><strong>.</strong></span><span class="animated-gradient-text border-3"><strong>LINKA</strong></span></a>
    </h2>

    <!-- Page navigation (index only) -->
    <?php $uri = strtok($_SERVER['REQUEST_URI'], '?'); ?>
    <?php if ($uri === '/' || basename($uri) === 'index.php'): ?>
    <div class="d-flex align-items-center rounded-pill">
      <a href="#featured"    class="nav-button ms-5 me-4 text-decoration-none anchor-underline">Latest</a>
      <a href="#safety"      class="nav-button me-4 text-decoration-none anchor-underline">Safety</a>
      <a href="#how-it-works" class="nav-button text-decoration-none anchor-underline">How It Works</a>
    </div>
    <?php endif; ?>

    <!-- Auth section -->
    <div class="d-flex align-items-center">
      <div class="d-flex ms-2 gap-2 align-items-center">

        <a href="/profilePage.php" class="btn btn-outline-secondary border rounded-pill p-1 px-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" style="color:rgb(28,32,51);">
            <g fill="currentColor">
              <path fill-rule="evenodd" d="M16 7a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0" clip-rule="evenodd"/>
              <path d="M16 15a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6H6v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6h-2z"/>
            </g>
          </svg>
        </a>

        <a class="btn btn-outline-secondary rounded-pill p-1 px-2" href="/cartPage.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2">
              <path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608z"/>
              <path stroke-linecap="round" d="m5 7l-.81-3.243A1 1 0 0 0 3.22 3H2m6 18h2m6 0h2"/>
            </g>
          </svg>
        </a>

        <?php if (!isset($_SESSION['userId'])): ?>
          <a href="/loginPage.php" class="d-flex align-items-center btn btn-primary border rounded-pill px-2">
            <span class="ms-1 nav-sign-label">Sign In</span>
            <div class="border rounded-circle bg-light ms-1 p-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="color:rgb(28,32,51);">
                <path fill="currentColor" d="M17.452 6H6.547a.548.548 0 0 0 0 1.096h9.585l-9.97 9.97a.545.545 0 1 0 .772.772l9.97-9.971v9.586a.548.548 0 0 0 1.096 0V6.546A.55.55 0 0 0 17.452 6"/>
              </svg>
            </div>
          </a>
        <?php else: ?>
          <a href="/logout.php" class="d-flex align-items-center btn btn-primary border rounded-pill px-2">
            <span class="ms-1 nav-sign-label">Log Out</span>
            <div class="border rounded-circle bg-light ms-1 p-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="color:rgb(28,32,51);">
                <path fill="currentColor" d="M17.452 6H6.547a.548.548 0 0 0 0 1.096h9.585l-9.97 9.97a.545.545 0 1 0 .772.772l9.97-9.971v9.586a.548.548 0 0 0 1.096 0V6.546A.55.55 0 0 0 17.452 6"/>
              </svg>
            </div>
          </a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</nav>
