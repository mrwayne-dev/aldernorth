<?php
$page_title = 'Platform | One wallet, every way to grow it | Aldernorth Capital';
$page_description = 'One investment product, one wallet, audit-grade reporting. The Aldernorth Capital platform is built on trust and secured by design.';
$page_path = '/platform';
include __DIR__ . '/_partials/head.php';
?>
<body class="anc-redesign">

<?php include __DIR__ . '/_partials/navbar.php'; ?>

<section class="hero">
  <div class="hero__bg" aria-hidden="true">
    <img src="/assets/images/platform.webp" width="929" height="697" alt="" loading="eager" fetchpriority="high">
  </div>
  <div class="container hero__inner">
    <div class="hero__content">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>The platform</p>
      <h1 class="hero__title">One platform. Every way to grow your money.</h1>
      <p class="hero__subtitle">One product, one wallet, one statement. Fund once, choose your payout rhythm, and let the schedule run.</p>
      <div class="hero__cta-row">
        <a href="#products" class="btn btn--primary">Explore the products</a>
        <a href="/register" class="btn btn--ghost">Open an account</a>
      </div>
    </div>
  </div>
</section>

<section class="section section--white" id="products">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>How it works</p>
      <h2 class="section-header__title">One product, done properly.</h2>
      <p class="section-header__body">We deliberately do not run a sprawling product shelf. There is one thing to decide: how often you want to be paid. Everything else is handled for you.</p>
    </div>

    <div class="grid-2">
      <a href="/plans#plans" class="card-image">
        <div class="card-image__media"><picture>
          <source type="image/avif" srcset="/assets/images/weekly.avif">
          <source type="image/webp" srcset="/assets/images/weekly.webp">
          <img src="/assets/images/weekly.webp" alt="" width="1800" height="1080" loading="lazy">
        </picture></div>
        <div class="card-image__body">
          <span class="card-image__icon"><i class="ph ph-calendar-dots" aria-hidden="true"></i></span>
          <h3 class="card-image__title">Weekly plans</h3>
          <p class="card-image__desc">A payout every week across a 90-day to 12-month term. Lower minimums, faster feedback.</p>
        </div>
      </a>
      <a href="/plans#plans" class="card-image">
        <div class="card-image__media"><picture>
          <source type="image/avif" srcset="/assets/images/monthly.avif">
          <source type="image/webp" srcset="/assets/images/monthly.webp">
          <img src="/assets/images/monthly.webp" alt="" width="1800" height="1080" loading="lazy">
        </picture></div>
        <div class="card-image__body">
          <span class="card-image__icon"><i class="ph ph-calendar-check" aria-hidden="true"></i></span>
          <h3 class="card-image__title">Monthly plans</h3>
          <p class="card-image__desc">A larger payout on the same date each month, over six months to two years. Higher rates for the longer term.</p>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- Live plan catalogue, straight from the database -->
<?php
$plans_eyebrow = 'The catalogue';
$plans_heading = 'Every plan we currently offer.';
include __DIR__ . '/_partials/plans-section.php';
?>

<section class="section section--warm">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Trust architecture</p>
      <h2 class="section-header__title">Built on trust. Secured by design.</h2>
      <p class="section-header__body">Four layers of operational discipline sit beneath every product. Each one is audited, logged, and presented to you in plain English.</p>
    </div>

    <div class="grid-2">
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg></span>
        <h3 class="card-feature__title">Safeguarding &amp; segregation</h3>
        <p class="card-feature__desc">Client funds sit in segregated accounts, never co-mingled with company operating funds, and are reconciled on a regular schedule.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="16" r="1"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/><rect x="3" y="11" width="18" height="11" rx="2"/></svg></span>
        <h3 class="card-feature__title">Suitability before allocation</h3>
        <p class="card-feature__desc">Every product surfaces yield, risk, lock-up, and the worst-case scenario before you commit a dollar. No hidden tiers, no jargon-walled fine print.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h4"/></svg></span>
        <h3 class="card-feature__title">Audit-grade ledger</h3>
        <p class="card-feature__desc">Every transaction has a unique reference. Every reference reconciles to your bank. Six-month exports in one click.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M9 12l2 2 4-4"/></svg></span>
        <h3 class="card-feature__title">Compliance beyond regulation</h3>
        <p class="card-feature__desc">Data-protection controls, anti-money-laundering checks, and internal safeguarding rules. Quarterly security reviews. Annual independent audit of client-fund reconciliations.</p>
      </article>
    </div>
  </div>
</section>

<section class="section section--white">
  <div class="container">
    <div class="testimonial">
      <h2 class="testimonial__quote">Put your capital to work at institutional terms, retail minimums.</h2>
      <div>
        <p class="eyebrow" style="margin-bottom: var(--space-4);"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Open an account</p>
        <p style="color: var(--color-ink-muted); margin-bottom: var(--space-5);">Three-minute sign-up. Segregated from your first deposit. Close your account anytime.</p>
        <a href="/register" class="btn btn--primary">Open an account</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/_partials/footer.php'; ?>

<script src="<?= anc_asset('/assets/js/main.js') ?>" defer></script>
</body>
</html>
