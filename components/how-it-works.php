<style>
  /* ── How It Works Section ── */
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
</style>

<section class="how-section">
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
