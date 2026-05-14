<style>
  /* ── Footer Section ── */
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

<footer class="footer">
  <div class="footer-inner">

    <!-- Logo / Brand -->
    <div class="footer-logo">
      <h2 class="text-white">
        <span class="border border-4"><strong>.</strong></span><span class="animated-gradient-text border-3"><strong>LINKA</strong></span>
        
      </h2>
      <p>South Africa’s trusted C2C marketplace.</p>
    </div>

    <!-- Quick Links -->
    <div class="footer-links">
      <h2>Quick Links</h2>
      <a href="#">Marketplace</a>
      <a href="#">Verified Sellers</a>
      <a href="#">About Us</a>
      <a href="#">Help Center</a>
    </div>

    <!-- Contact / Social -->
    <div class="footer-contact">
      <h2>Contact</h2>
      <p>Email: support@commerce.za</p>
      <p>Phone: +27 11 123 4567</p>
      <p>Follow us:</p>
      <p>🌐 Facebook · 📸 Instagram · 🐦 Twitter</p>
    </div>

  </div>

  <!-- Bottom -->
  <div class="footer-bottom">
    <p>&copy; 2026 commerce.za — All rights reserved.</p>
  </div>
</footer>
