<style>
  /* ── Hero — matches product section palette ── */
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

  /* Responsive */
  @media (max-width: 768px) {
    .hero-inner { flex-direction: column; width: 92%; gap: 2rem; }
    .hero-video  { justify-content: center; width: 100%; }
    .hero-video iframe { width: 100%; height: 200px; }
  }
</style>

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
        <button type="button" class="hero-btn-primary">Explore</button>
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