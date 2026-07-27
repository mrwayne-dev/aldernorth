<?php
$page_title = 'Solutions | Tailored for every investor profile | Aldernorth Capital';
$page_description = 'Aldernorth Capital solutions for every kind of investor — savers, income builders, portfolio diversifiers, and institutional allocators.';
$page_path = '/solutions';
include __DIR__ . '/_partials/head.php';
?>
<body class="anc-redesign">

<?php include __DIR__ . '/_partials/navbar.php'; ?>

<section class="hero">
  <div class="hero__bg" aria-hidden="true">
    <picture>
      <source type="image/avif" srcset="/assets/images/solutions.avif">
      <source type="image/webp" srcset="/assets/images/solutions.webp">
      <img src="/assets/images/solutions.webp" alt="" width="1800" height="1080" loading="eager" fetchpriority="high">
    </picture>
  </div>
  <div class="container hero__inner">
    <div class="hero__content">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Solutions</p>
      <h1 class="hero__title">Solutions for every kind of investor.</h1>
      <p class="hero__subtitle">Whether you're parking salary surplus, building income, or diversifying a portfolio — there's a ANC path designed for it.</p>
      <div class="hero__cta-row">
        <a href="#profiles" class="btn btn--primary">Find your profile</a>
        <a href="/register" class="btn btn--ghost">Open an account</a>
      </div>
    </div>
  </div>
</section>

<section class="section section--white" id="profiles">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Investor profiles</p>
      <h2 class="section-header__title">Tailored solutions for every investor profile.</h2>
      <p class="section-header__body">Four common starting points — each maps to a primary ANC product and a sensible add-on stack.</p>
    </div>

    <div class="grid-2">
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg></span>
        <h3 class="card-feature__title">For everyday savers</h3>
        <p class="card-feature__desc">Tired of 0.5% high-street savers. Start with a weekly plan for a payout every seven days, and roll the payouts into a longer monthly position as your balance grows.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 17l6-6 4 4 8-8"/></svg></span>
        <h3 class="card-feature__title">For income builders</h3>
        <p class="card-feature__desc">Want regular distributions hitting the wallet. Weekly plans pay every seven days; monthly plans pay a larger amount on the same date each month.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 12h4l3-9 4 18 3-9h4"/></svg></span>
        <h3 class="card-feature__title">For portfolio diversifiers</h3>
        <p class="card-feature__desc">Already have an ISA. Use a long monthly plan as the anchor and shorter weekly positions for the capital you want moving more often.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 21h18M5 21V9l7-5 7 5v12"/></svg></span>
        <h3 class="card-feature__title">For institutional-style allocators</h3>
        <p class="card-feature__desc">Higher minimums, longer horizons. Aldercrest Monthly runs for two years at our strongest published rate, with performance disclosed before allocation.</p>
      </article>
    </div>
  </div>
</section>

<section class="section section--warm">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>How it works</p>
      <h2 class="section-header__title">How Aldernorth Capital compounds your wealth.</h2>
      <p class="section-header__body">Three steps. No spreadsheets, no quarterly statements buried under three menus.</p>
    </div>

    <div class="grid-3">
      <article class="card-feature">
        <p style="font-family: var(--font-mono); font-size: 14px; color: var(--color-accent-red); margin-bottom: var(--space-3);">01 ·</p>
        <h3 class="card-feature__title">Open your wallet</h3>
        <p class="card-feature__desc">Three-minute sign-up, full KYC, funds segregated from your first deposit.</p>
      </article>
      <article class="card-feature">
        <p style="font-family: var(--font-mono); font-size: 14px; color: var(--color-accent-red); margin-bottom: var(--space-3);">02 ·</p>
        <h3 class="card-feature__title">Pick a strategy</h3>
        <p class="card-feference__desc">Single product or stacked. Every plan surfaces yield, risk, and lock-up before you commit a pound.</p>
      </article>
      <article class="card-feature">
        <p style="font-family: var(--font-mono); font-size: 14px; color: var(--color-accent-red); margin-bottom: var(--space-3);">03 ·</p>
        <h3 class="card-feature__title">Watch it compound</h3>
        <p class="card-feature__desc">ROI reinvests by default. Audit-grade ledger, exportable in one click.</p>
      </article>
    </div>
  </div>
</section>

<section class="section section--white">
  <div class="container">
    <div class="testimonial">
      <h2 class="testimonial__quote">Start compounding today.</h2>
      <div>
        <p class="eyebrow" style="margin-bottom: var(--space-4);"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Open an account</p>
        <p style="color: var(--color-ink-muted); margin-bottom: var(--space-5);">From $250 on Alder Weekly, $500 on Northwood Monthly, and up to $25,000 on Aldercrest Monthly. Every plan returns your principal in full at maturity.</p>
        <a href="/register" class="btn btn--primary">Open an account</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/_partials/footer.php'; ?>

<script src="<?= anc_asset('/assets/js/main.js') ?>" defer></script>
</body>
</html>
