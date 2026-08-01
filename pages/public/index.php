<?php
$page_title = 'Build Wealth on Autopilot | Aldernorth Capital';
$page_description = 'Invest a lump sum with Aldernorth Capital, choose weekly or monthly payouts, and get your principal back in full at maturity.';
$page_path = '/';
include __DIR__ . '/_partials/head.php';
?>
<body class="anc-redesign">

<?php include __DIR__ . '/_partials/navbar.php'; ?>

<!-- =================== HERO (Crestmark C.2 adapted) =================== -->
<section class="hero" id="hero">
  <div class="hero__bg" aria-hidden="true">
    <picture>
      <source type="image/avif" srcset="/assets/images/home-hero.avif">
      <source type="image/webp" srcset="/assets/images/home-hero.webp">
      <img src="/assets/images/home-hero.webp" alt="" width="1800" height="1080" loading="eager" fetchpriority="high">
    </picture>
  </div>

  <div class="container hero__inner">
    <div class="hero__content">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        Segregated client funds
      </p>

      <h1 class="hero__title">Build wealth on autopilot.</h1>

      <p class="hero__subtitle">
        Invest a lump sum, pick weekly or monthly payouts, and watch them land in your wallet on schedule. Your principal comes back in full at the end of the term.
      </p>

      <div class="hero__cta-row">
        <a href="/platform" class="btn btn--primary">See how it works</a>
        <a href="/register" class="btn btn--ghost">Open an account</a>
      </div>
    </div>
  </div>

</section>


<!-- =================== SMARTER INVESTING (Crestmark D.2 + 2-col) =================== -->
<section class="section section--white" id="smarter-investing">
  <div class="container">
    <div class="grid-2" style="gap: var(--space-10); align-items: center;">
      <div class="section-header section-header--wide">
        <p class="eyebrow">
          <span class="eyebrow__icon">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
          </span>
          The Platform
        </p>
        <h2 class="section-header__title">Smarter investing.</h2>
        <p class="section-header__body">
          Aldernorth Capital gives everyday savers a fixed, predictable income schedule on capital they commit for a set term. One wallet, one statement. Fund the wallet, pick a plan, and collect.
        </p>
        <div class="section-header__cta">
          <a href="/platform" class="btn btn--primary">See how it works</a>
        </div>
      </div>

      <div>
        <img src="../../assets/images/smarter.webp" width="1200" height="900" alt="Modern investment platform illustration" loading="lazy" style="border-radius: var(--radius-card); width: 100%;">
      </div>
    </div>
  </div>
</section>


<!-- =================== ONE WALLET (Crestmark D.2 centered + D.5 icon grid) =================== -->
<section class="section section--warm">
  <div class="container">
    <div class="section-header section-header--center" style="margin-bottom: var(--space-10);">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        Architecture
      </p>
      <h2 class="section-header__title">One wallet. Every way to grow it.</h2>
      <p class="section-header__body">
        Aldernorth Capital is a single platform with weekly and monthly plans: fixed-term savings, automated weekly investing, fractional equity, infrastructure co-investments, and a loyalty rewards layer. Fund the wallet once; route capital wherever your strategy needs it next.
      </p>
    </div>

    <div class="grid-2">
      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Fixed-term savings, above the high street</h3>
        <p class="card-feature__desc">Lock in a rate at enrolment. Payouts are credited automatically each period, and your principal is released on the maturity date.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Fractional equity with scheduled payouts</h3>
        <p class="card-feature__desc">Own positions you couldn't reach whole. Weekly, monthly, or quarterly distributions, settled to your wallet.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M3 12a9 9 0 1 1 9 9"/><path d="M3 12l4-4M3 12l4 4"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Automated weekly contributions</h3>
        <p class="card-feature__desc">Set a strategy, fund it weekly, pause or cancel whenever. No early-exit penalty on active programs.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Segregated and reconciled.</h3>
        <p class="card-feature__desc">Client funds sit in segregated accounts, never co-mingled with company operating funds, and are reconciled on a regular schedule.</p>
      </article>
    </div>
  </div>
</section>



<!-- =================== HOW IT WORKS (weekly vs monthly) =================== -->
<section class="section section--white">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        How it works
      </p>
      <h2 class="section-header__title">Two rhythms. One wallet.</h2>
      <p class="section-header__body">
        You invest a lump sum once. From there it is simply a question of how
        often you want to be paid: every week, or every month. Both return
        your principal in full at the end of the term.
      </p>
      <div class="section-header__cta">
        <a href="/plans" class="btn btn--primary">Compare every plan</a>
      </div>
    </div>

    <div class="grid-2">
      <!-- Weekly -->
      <a href="/plans#plans" class="card-image" aria-label="Weekly plans, a payout every week">
        <div class="card-image__media">
          <picture>
            <source type="image/avif" srcset="/assets/images/weekly.avif">
            <source type="image/webp" srcset="/assets/images/weekly.webp">
            <img src="/assets/images/weekly.webp" alt="" width="1800" height="1080" loading="lazy">
          </picture>
        </div>
        <div class="card-image__body">
          <span class="card-image__icon">
            <i class="ph ph-calendar-dots" aria-hidden="true"></i>
          </span>
          <h3 class="card-image__title">Weekly plans</h3>
          <p class="card-image__desc">
            A payout lands in your wallet every week, from 90 days up to a full
            year. The shortest way to turn capital into regular income, and the
            easiest to start with.
          </p>
        </div>
      </a>

      <!-- Monthly -->
      <a href="/plans#plans" class="card-image" aria-label="Monthly plans, a payout every month">
        <div class="card-image__media">
          <picture>
            <source type="image/avif" srcset="/assets/images/monthly.avif">
            <source type="image/webp" srcset="/assets/images/monthly.webp">
            <img src="/assets/images/monthly.webp" alt="" width="1800" height="1080" loading="lazy">
          </picture>
        </div>
        <div class="card-image__body">
          <span class="card-image__icon">
            <i class="ph ph-calendar-check" aria-hidden="true"></i>
          </span>
          <h3 class="card-image__title">Monthly plans</h3>
          <p class="card-image__desc">
            A larger payout on the same date each month, over six months to two
            years. Higher rates for the longer commitment, and simple to plan
            your year around.
          </p>
        </div>
      </a>
    </div>
  </div>
</section>


<!-- =================== VISION 1 - Democratise Yield (Crestmark D.13 pull-quote) =================== -->
<section class="section section--warm" id="vision">
  <div class="container">
    <div class="testimonial">
      <div>
        <p class="eyebrow" style="margin-bottom: var(--space-5);">
          <span class="eyebrow__icon">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
          </span>
          Vision
        </p>
        <p class="testimonial__quote">We democratise yield. A published rate and a real schedule, available from $250.</p>
      </div>
      <div>
        <p style="font-size: var(--text-body); line-height: var(--lh-body); color: var(--color-ink-muted);">
          For decades, the best yields, the best terms, and the cleanest reporting have been reserved for clients with seven-figure balances. We built Aldernorth Capital to flatten that: a fixed, published rate and a clear payout schedule, available from $250 upwards, with the same reporting we would expect ourselves.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- =================== VISION 2 - Beat Idle Cash =================== -->
<section class="section section--white">
  <div class="container">
    <div class="testimonial">
      <div>
        <p class="eyebrow" style="margin-bottom: var(--space-5);">
          <span class="eyebrow__icon">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
          </span>
          Vision
        </p>
        <p class="testimonial__quote">We beat idle cash. Whatever's sitting still goes to work the moment it lands.</p>
      </div>
      <div>
        <p style="font-size: var(--text-body); line-height: var(--lh-body); color: var(--color-ink-muted);">
          Idle cash is a slow tax. Inflation, bank-account drift, and the opportunity cost of "I'll figure it out later" cost US households thousands every year. Aldernorth Capital turns payday surplus, an unspent bonus, or an emergency-fund overflow into a yield-generating position the moment it lands in your wallet, with the option to withdraw or rebalance on your schedule, not the bank's.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- =================== STATS (Crestmark C.5 / D.7 counter cards) =================== -->
<section class="section section--warm">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        Our Numbers
      </p>
      <h2 class="section-header__title">Built for real capital. Measured in trust.</h2>
      <p class="section-header__body">
        Aldernorth Capital was built for real people deploying real capital. These figures reflect what our members have built on the platform, and the trust that's let us keep building.
      </p>
    </div>

    <div class="grid-3">
      <article class="card-stat">
        <span class="card-stat__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <circle cx="9" cy="8" r="4"/><path d="M2 22a7 7 0 0 1 14 0M17 11a3 3 0 1 0 0-6M22 22a5 5 0 0 0-7-5"/>
          </svg>
        </span>
        <p class="card-stat__desc">Investors actively allocating</p>
        <p class="card-stat__value"><span data-count="12000">0</span>+</p>
      </article>

      <article class="card-stat">
        <span class="card-stat__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/>
          </svg>
        </span>
        <p class="card-stat__desc">ROI payouts settled on time</p>
        <p class="card-stat__value"><span data-count="6800">0</span>+</p>
      </article>

      <article class="card-stat">
        <span class="card-stat__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"/>
          </svg>
        </span>
        <p class="card-stat__desc">Days of clean audit trail</p>
        <p class="card-stat__value"><span data-count="320">0</span></p>
      </article>
    </div>
  </div>
</section>

<!-- =================== WHY ANC (Crestmark C.8 6-feature grid) =================== -->
<section class="section section--white">
  <div class="container">
    <div class="section-header" style="margin-bottom: var(--space-10);">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        Why Aldernorth Capital
      </p>
      <h2 class="section-header__title">No reinvention. Just less friction.</h2>
      <p class="section-header__body">
        We don't reinvent investing. We remove the markup, the fragmentation, and the fine print, then return the difference to the people putting in the capital.
      </p>
      <div class="section-header__cta">
        <a href="/contact" class="btn btn--primary">Start a conversation</a>
      </div>
    </div>

    <div class="grid-2">
      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <rect x="3" y="6" width="18" height="14" rx="2"/><path d="M7 6V4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
          </svg>
        </span>
        <h3 class="card-feature__title">One wallet</h3>
        <p class="card-feature__desc">One product, one balance, one statement. No bouncing between apps to see what your capital is doing.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M12 1v22M5 5h10a4 4 0 0 1 0 8H7a4 4 0 0 0 0 8h12"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Honest pricing</h3>
        <p class="card-feature__desc">The rate quoted is the rate paid. No spread games, no hidden margin, no "headline rate" footnotes you discover at maturity.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h4"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Audit-grade ledger</h3>
        <p class="card-feature__desc">Every transaction has a reference. Every reference reconciles to your bank. Export six months of activity in one click for your accountant.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Accessible minimums</h3>
        <p class="card-feature__desc">Start from $250 on a weekly plan and scale up over time. The minimums that lock out retail investors elsewhere don't exist here.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Safeguarding</h3>
        <p class="card-feature__desc">Client funds held in segregated accounts, never co-mingled with company operating funds, and reconciled on a regular schedule.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M3 12h4l3-9 4 18 3-9h4"/>
          </svg>
        </span>
        <h3 class="card-feature__title">Compounding by default</h3>
        <p class="card-feature__desc">ROI is reinvested into your chosen strategy unless you tell us otherwise. The earlier you start, the more your future self thanks you.</p>
      </article>
    </div>
  </div>
</section>

<!-- =================== TESTIMONIAL (Crestmark C.4 single pull-quote) =================== -->
<section class="section section--warm">
  <div class="container">
    <div class="testimonial">
      <h2 class="testimonial__quote">
        I'd been parking my salary surplus in a 0.5% saver for years. Opening a weekly plan took me ten minutes, and now a payout lands in my wallet every Friday, with a maturity date I can see on the dashboard.
      </h2>
      <div>
        <p class="eyebrow" style="margin-bottom: var(--space-4);">
          <span class="eyebrow__icon">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
          </span>
          Member story
        </p>
        <div class="testimonial__attribution">
          <img src="../../assets/images/avatar/default.png" width="2000" height="2000" alt="" class="testimonial__portrait" loading="lazy">
          <div>
            <p class="testimonial__name">Sarah Johnson</p>
            <p class="testimonial__role">Weekly plan member, Aldernorth Capital</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =================== FAQ (Crestmark C.11 accordion) =================== -->
<section class="section section--warm">
  <div class="container">
    <div class="section-header section-header--center" style="margin-bottom: var(--space-10);">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        FAQs
      </p>
      <h2 class="section-header__title">Frequently asked questions.</h2>
      <p class="section-header__body">Quick answers to the questions members ask most often.</p>
      <div class="section-header__cta">
        <a href="/contact" class="btn btn--primary">Connect with our team</a>
      </div>
    </div>

    <div class="accordion">
      <details class="accordion__item">
        <summary class="accordion__trigger">
          What is Aldernorth Capital?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Aldernorth Capital is an investment platform built around a single product: you invest a lump sum into a plan that pays a fixed percentage of your capital back to your wallet either weekly or monthly, and returns your principal in full at the end of the term. One wallet, one statement, one schedule.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          Is my money safe with Aldernorth Capital?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Client funds are held in segregated accounts, never co-mingled with company operating funds, and reconciled on a regular schedule. Your capital is at risk: rates are not guaranteed, and we disclose the worst-case scenario before every allocation.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          Is my personal data secure?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Yes. We use end-to-end AES-256 encryption, multi-factor authentication, and CREST-tested security controls reviewed quarterly. The platform follows recognised US data-protection practice, with a named Data Protection Officer and a transparent Privacy Notice.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          What's the minimum to get started?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Minimums vary by plan. Weekly plans start at $250, monthly plans at $500. Our longest monthly plan carries a $25,000 minimum, reflecting its term and rate. Every minimum is shown on the plan before you commit.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          Can I withdraw my money any time?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Your wallet balance is available on demand, and every payout is withdrawable the moment it lands. Capital committed to a plan is locked for the term and released in full on the maturity date.
        </div>
      </details>
    </div>
  </div>
</section>


<?php // Was a byte-for-byte inline duplicate of _partials/footer.php, which is
      // what every other public page includes - so footer edits silently missed
      // the home page. One definition now. ?>
<?php include __DIR__ . '/_partials/footer.php'; ?>


  <!-- Scripts -->
  <script src="<?= anc_asset('/assets/js/main.js') ?>" defer></script>
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Aldernorth Capital",
  "url": "https://aldernorthcapital.com",
  "logo": "https://aldernorthcapital.com/assets/favicon/android-chrome-512x512.png",
  "sameAs": [
    "https://www.linkedin.com/company/aldernorthholdings",
    "https://twitter.com/aldernorthholdings",
    "https://instagram.com/aldernorthholdings"
  ]
}
</script>



</body>
</html>
