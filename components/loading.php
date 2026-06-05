<?php
/**
 * Loading screen component.
 * Usage: include 'components/loading.php';
 * The overlay hides automatically once the page finishes loading (window load event).
 * You can also manually hide it: window.dotlinkaHideLoader()
 */
?>
<style>
  /* ── DOTLINKA LOADER ── */
  #dl-loader {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: opacity 0.4s ease, visibility 0.4s ease;
  }
  #dl-loader.dl-loader-hidden {
    opacity: 0;
    visibility: hidden;
  }
  .dl-logo {
    font-size: 2rem;
    font-weight: 800;
    letter-spacing: -1px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
  }
  .dl-logo-dot {
    border: 4px solid #111;
    padding: 0 4px;
    margin-right: 1px;
  }
  .dl-logo-text {
    background: linear-gradient(270deg,#00ff00,#7928ca,#abaaac,#48bb78,#ed8936,#ff0000);
    background-size: 300% 300%;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: dlFlow 4s ease infinite;
  }
  @keyframes dlFlow {
    0%   { background-position: 0%   50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0%   50%; }
  }
  /* Spinner dots */
  .dl-dots {
    display: flex;
    gap: 8px;
  }
  .dl-dots span {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #D85A30;
    animation: dlBounce 1.2s ease-in-out infinite;
  }
  .dl-dots span:nth-child(1) { animation-delay: 0s; }
  .dl-dots span:nth-child(2) { animation-delay: 0.2s; }
  .dl-dots span:nth-child(3) { animation-delay: 0.4s; }
  @keyframes dlBounce {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40%            { transform: scale(1.1); opacity: 1; }
  }
</style>

<div id="dl-loader" role="status" aria-label="Loading dotlinka…">
  <div class="dl-logo">
    <span class="dl-logo-dot"><strong>.</strong></span>
    <span class="dl-logo-text"><strong>LINKA</strong></span>
  </div>
  <div class="dl-dots">
    <span></span><span></span><span></span>
  </div>
</div>

<script>
  (function () {
    function hideLoader() {
      var el = document.getElementById('dl-loader');
      if (el) el.classList.add('dl-loader-hidden');
    }
    // Expose globally so pages can call it manually if needed
    window.dotlinkaHideLoader = hideLoader;
    // Auto-hide once everything is loaded
    window.addEventListener('load', function () {
      setTimeout(hideLoader, 200); // tiny delay so it doesn't flash
    });
    // Safety fallback: hide after 4s regardless
    setTimeout(hideLoader, 4000);
  })();
</script>
