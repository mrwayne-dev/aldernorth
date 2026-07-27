<?php
$page_title = 'Investment plans | Weekly and monthly payouts | Aldernorth Capital';
$page_description = 'Aldernorth Capital investment plans — invest a lump sum, choose weekly or monthly payouts, and get your principal back in full at maturity.';
$page_path = '/plans';
include __DIR__ . '/_partials/head.php';
?>
<body class="anc-redesign">

<?php include __DIR__ . '/_partials/navbar.php'; ?>

<section class="hero">
  <div class="hero__bg" aria-hidden="true">
    <picture>
      <source type="image/avif" srcset="/assets/images/monthly.avif">
      <source type="image/webp" srcset="/assets/images/monthly.webp">
      <img src="/assets/images/monthly.webp" alt="" width="1800" height="1080" loading="eager" fetchpriority="high">
    </picture>
  </div>
  <div class="container hero__inner">
    <div class="hero__content">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Investment plans</p>
      <h1 class="hero__title">Invest once. Get paid on schedule.</h1>
      <p class="hero__subtitle">Put a lump sum to work, pick whether you want paying every week or every month, and receive your principal back in full at the end of the term.</p>
      <div class="hero__cta-row">
        <a href="/register" class="btn btn--primary">Open an account</a>
        <a href="#plans" class="btn btn--ghost">See the plans</a>
      </div>
    </div>
  </div>
</section>

<section class="section section--white" id="how">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>How it works</p>
      <h2 class="section-header__title">Four steps, then it runs itself.</h2>
      <p class="section-header__body">Every plan quotes a fixed percentage per payout period. That percentage is what lands in your wallet — there is no headline rate hiding a smaller real one.</p>
    </div>
    <div class="grid-2">
      <article class="card-feature">
        <span class="card-feature__icon"><i class="ph ph-wallet" aria-hidden="true"></i></span>
        <h3 class="card-feature__title">Fund your wallet</h3>
        <p class="card-feature__desc">Deposit into your Aldernorth wallet. Your balance sits there until you choose to deploy it.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><i class="ph ph-calendar-dots" aria-hidden="true"></i></span>
        <h3 class="card-feature__title">Choose your rhythm</h3>
        <p class="card-feature__desc">Weekly plans pay out every seven days. Monthly plans pay out on the same date each month at a higher rate.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><i class="ph ph-trend-up" aria-hidden="true"></i></span>
        <h3 class="card-feature__title">Collect every period</h3>
        <p class="card-feature__desc">Each payout is credited to your wallet automatically and is withdrawable straight away — you never wait for maturity to see a return.</p>
      </article>
      <article class="card-feature">
        <span class="card-feature__icon"><i class="ph ph-shield-check" aria-hidden="true"></i></span>
        <h3 class="card-feature__title">Principal returned</h3>
        <p class="card-feature__desc">When the term ends, your original capital is released back to your wallet in full, on top of every payout already made.</p>
      </article>
    </div>
  </div>
</section>

<?php include __DIR__ . '/_partials/plans-section.php'; ?>

<section class="section section--white">
  <div class="container">
    <div class="section-header section-header--center">
      <h2 class="section-header__title">A worked example.</h2>
      <p class="section-header__body">
        $5,000 into Ironwood Monthly at 5.75% per month over 12 months returns
        $287.50 to your wallet every month. That is $3,450 in payouts across the
        year, and your $5,000 comes back at the end — 69% total return.
        Capital is at risk; rates are not guaranteed.
      </p>
      <div class="section-header__cta">
        <a href="/register" class="btn btn--primary">Open an account</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/_partials/footer.php'; ?>

<script src="<?= anc_asset('/assets/js/main.js') ?>" defer></script>
</body>
</html>
