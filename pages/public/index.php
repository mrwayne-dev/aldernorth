<?php require_once __DIR__ . '/../../config/assets.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta -->
  <meta charset="UTF-8">
  <meta name="description" content="Aldernorth Capital is an FCA-authorised investment platform with high-yield savings, fractional shares, automated weekly investing, and infrastructure co-investments — all in one wallet, FSCS-protected up to £85,000.">
  <meta name="author" content="Aldernorth Capital">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://aldernorthcapital.com/">


  <!-- Title -->
  <title>Aldernorth Capital – Build Wealth on Autopilot</title>

  <!-- Preload CSS -->
  <link rel="preload" href="<?= anc_asset('../../assets/css/main.css') ?>" as="style">

  <!-- Preload Fonts -->
  <link rel="preload" href="../../assets/fonts/HostGrotesk-Regular.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="../../assets/fonts/HostGrotesk-Bold.woff2" as="font" type="font/woff2" crossorigin>

  <!-- Unicons CDN -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?= anc_asset('../../assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= anc_asset('../../assets/css/responsive.css') ?>">
  <link rel="stylesheet" href="<?= anc_asset('../../assets/css/anc-design.css') ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../../assets/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="shortcut icon" href="../../assets/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
  <meta name="apple-mobile-web-app-title" content="Aldernorth Capital">
  <link rel="manifest" href="../../assets/favicon/site.webmanifest">
  
    <!-- Smartsupp Live Chat script -->
  <script type="text/javascript">
  var _smartsupp = _smartsupp || {};
  _smartsupp.key = 'acee1c8fc66bb651454e92b288dd5ddf2d428cc2';
  window.smartsupp||(function(d) {
    var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
    s=d.getElementsByTagName('script')[0];c=d.createElement('script');
    c.type='text/javascript';c.charset='utf-8';c.async=true;
    c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
  })(document);
  </script>
  <noscript>Powered by <a href="https://www.smartsupp.com" target="_blank" rel="noopener noreferrer">Smartsupp</a></noscript>

</head>
<body class="anc-redesign">

<!-- =================== NAVBAR (Crestmark D.12 adapted) =================== -->
<nav class="navbar" data-navbar>
  <div class="container">
    <div class="navbar__inner">
      <a href="/" class="navbar__brand" aria-label="Aldernorth Capital home">
        <img class="navbar__logo navbar__logo--light" src="/assets/images/logo/aldernorth-white.svg" width="1714" height="308" alt="Aldernorth Capital" loading="lazy">
        <img class="navbar__logo navbar__logo--dark" src="/assets/images/logo/aldernorth-black.svg" width="1714" height="308" alt="Aldernorth Capital" loading="lazy">
      </a>

      <ul class="navbar__links">
        <li><a href="/plans" class="navbar__link">Plans</a></li>
        <li><a href="/platform" class="navbar__link">Platform</a></li>
        <li><a href="/solutions" class="navbar__link">Solutions</a></li>
        <li><a href="/about" class="navbar__link">About</a></li>
        <li><a href="/contact" class="navbar__link">Contact</a></li>
      </ul>

      <div class="navbar__actions">
        <button class="theme-toggle" data-theme-toggle type="button" aria-label="Switch to light theme" aria-pressed="false">
          <i class="ph ph-sun"></i>
        </button>
        <a href="/login" class="btn btn--nav navbar__cta">Sign in</a>
      </div>

      <button class="navbar__toggle" aria-label="Toggle menu" data-nav-toggler>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <line x1="3" y1="6"  x2="21" y2="6"/>
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
    </div>
  </div>
</nav>

<!-- =================== HERO (Crestmark C.2 adapted) =================== -->
<section class="hero" id="hero">
  <div class="hero__bg" aria-hidden="true">
    <picture>
      <source type="image/avif" srcset="/assets/images/anc-home.avif">
      <source type="image/webp" srcset="/assets/images/anc-home.webp">
      <img src="/assets/images/anc-home.webp" alt="" width="1800" height="1080" loading="eager" fetchpriority="high">
    </picture>
  </div>

  <div class="container hero__inner">
    <div class="hero__content">
      <p class="eyebrow">
        <span class="eyebrow__icon">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="6"/></svg>
        </span>
        FCA-Authorised · FSCS-Protected
      </p>

      <h1 class="hero__title">Build wealth on autopilot.</h1>

      <p class="hero__subtitle">
        High-yield savings, fractional shares, automated weekly investing, and infrastructure co-investments — in one regulated wallet, FSCS-protected up to £85,000, and engineered to compound while you sleep.
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
          Aldernorth Capital gives everyday savers access to the products institutions use — fixed-term yield, fractional equity, automated DCA, and infrastructure co-investments — in one wallet with one statement and one set of FSCS-protected protections. Set a strategy, fund the wallet, and compound.
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
        Aldernorth Capital is a single platform with weekly and monthly plans — fixed-term savings, automated weekly investing, fractional equity, infrastructure co-investments, and a loyalty rewards layer. Fund the wallet once; route capital wherever your strategy needs it next.
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
        <p class="card-feature__desc">Lock in a rate at enrolment. Capital is FSCS-protected up to £85,000 and pays out automatically on maturity.</p>
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
        <h3 class="card-feature__title">FCA-authorised. FSCS-protected.</h3>
        <p class="card-feature__desc">Client money sits in segregated accounts at a UK-regulated banking partner. Eligible deposits covered up to £85,000.</p>
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
        often you want to be paid — every week, or every month. Both return
        your principal in full at the end of the term.
      </p>
      <div class="section-header__cta">
        <a href="/plans" class="btn btn--primary">Compare every plan</a>
      </div>
    </div>

    <div class="grid-2">
      <!-- Weekly -->
      <a href="/plans#plans" class="card-image" aria-label="Weekly plans — a payout every week">
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
      <a href="/plans#plans" class="card-image" aria-label="Monthly plans — a payout every month">
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


<!-- =================== VISION 1 — Democratise Yield (Crestmark D.13 pull-quote) =================== -->
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
        <p class="testimonial__quote">We democratise yield. The products institutions use, available from £50.</p>
      </div>
      <div>
        <p style="font-size: var(--text-body); line-height: var(--lh-body); color: var(--color-ink-muted);">
          For decades, the best yields, the best terms, and the cleanest reporting have been reserved for clients with seven-figure balances. We built Aldernorth Capital to flatten that — the same fixed-term products, the same fractional equity, the same infrastructure deals, available from £50 upwards, under the same FCA framework that governs the high street.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- =================== VISION 2 — Beat Idle Cash =================== -->
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
          Idle cash is a slow tax. Inflation, bank-account drift, and the opportunity cost of "I'll figure it out later" cost UK households thousands every year. Aldernorth Capital turns payday surplus, an unspent bonus, or an emergency-fund overflow into a yield-generating position the moment it lands in your wallet — with the option to withdraw or rebalance on your schedule, not the bank's.
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
        Aldernorth Capital was built for real people deploying real capital. These figures reflect what our members have built on the platform — and the trust that's let us keep building.
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
        We don't reinvent investing — we remove the markup, the fragmentation, and the fine print, then return the difference to the people putting in the capital.
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
        <p class="card-feature__desc">Six regulated products, one balance, one statement. No bouncing between apps to manage savings, shares, and infrastructure.</p>
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
        <p class="card-feature__desc">Start from £50 on X-Weekly, scale up over time. The minimums that lock out retail investors elsewhere don't exist here.</p>
      </article>

      <article class="card-feature">
        <span class="card-feature__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/>
          </svg>
        </span>
        <h3 class="card-feature__title">FCA + FSCS</h3>
        <p class="card-feature__desc">Authorised by the Financial Conduct Authority. Eligible deposits FSCS-protected up to £85,000. Client money held in segregated accounts at a UK-regulated banking partner.</p>
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
        I'd been parking my salary surplus in a 0.5% saver for years. Setting up X-Weekly took me ten minutes — and now £200 a week routes straight into a strategy that's actually compounding, with a maturity date I can see on the dashboard.
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
            <p class="testimonial__role">X-Weekly member, Aldernorth Capital</p>
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
          Aldernorth Capital is an FCA-authorised investment platform that brings weekly and monthly plans — X-Lock fixed-term savings, X-Weekly automated investing, X-Shares fractional equity, X-Yield investment plans, X-Grid infrastructure co-investments, and X-Rewards loyalty redemption — into a single wallet with one statement and one set of FSCS-backed protections.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          Is my money safe with Aldernorth Capital?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Client money is held in segregated accounts at a UK-regulated banking partner — never co-mingled with company funds. Eligible deposits are covered by the Financial Services Compensation Scheme (FSCS) up to £85,000 per client. Capital is at risk on non-FSCS-protected products, and we disclose the worst-case scenario before every allocation.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          Is my personal data secure?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Yes. We use end-to-end AES-256 encryption, multi-factor authentication, and CREST-tested security controls reviewed quarterly. The platform is UK GDPR-compliant, with a named Data Protection Officer and a transparent Privacy Notice.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          What's the minimum to get started?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Minimums vary by product. X-Weekly starts at £50 per week. X-Lock and X-Shares positions begin from £100. X-Grid co-investments have higher minimums reflective of the underlying deal — typically from £500 — and are presented per-opportunity.
        </div>
      </details>

      <details class="accordion__item">
        <summary class="accordion__trigger">
          Can I withdraw my money any time?
          <span class="accordion__icon" aria-hidden="true"></span>
        </summary>
        <div class="accordion__body">
          Your wallet balance is available on demand. Funds inside fixed-term products (X-Lock, X-Yield, X-Grid) are released at maturity. X-Weekly programs can be paused or cancelled instantly; the funds already invested continue to earn until their own term ends.
        </div>
      </details>
    </div>
  </div>
</section>


<!-- =================== FOOTER (Crestmark C.12) =================== -->
<footer class="footer">
  <div class="container">
    <div class="footer__top">
      <a href="/" aria-label="Aldernorth Capital home">
        <img src="/assets/images/logo/aldernorth-black.svg" width="1714" height="308" alt="Aldernorth Capital" loading="lazy" style="height: 30px;">
      </a>
      <h2 style="margin: var(--space-2) 0;">Your wealth, simplified in one place.</h2>
      <p style="color: var(--color-ink-muted); max-width: 560px;">
        Open an account in minutes. Fund the wallet. Deploy across weekly and monthly plans — and let Aldernorth Capital handle the compounding, the reporting, and the protections.
      </p>
      <a href="/register" class="btn btn--primary">Start a conversation</a>
    </div>

    <nav class="footer__nav" aria-label="Footer">
      <a href="/plans">Plans</a><span class="footer__sep">·</span>
      <a href="/platform">Platform</a><span class="footer__sep">·</span>
      <a href="/solutions">Solutions</a><span class="footer__sep">·</span>
      <a href="/about">About</a><span class="footer__sep">·</span>
      <a href="/contact">Contact</a><span class="footer__sep">·</span>
      <a href="/login">Sign in</a>
    </nav>

    <div class="footer__credits">
      <span>© <?= date('Y') ?> Aldernorth Capital Ltd. All rights reserved.</span>
      <span class="footer__socials" aria-label="Social links">
        <a href="https://www.linkedin.com/company/aldernorthholdings" aria-label="LinkedIn" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 0H5C2.2 0 0 2.2 0 5v14c0 2.8 2.2 5 5 5h14c2.8 0 5-2.2 5-5V5c0-2.8-2.2-5-5-5zM8 19H5V8h3v11zM6.5 6.7a1.8 1.8 0 1 1 0-3.6 1.8 1.8 0 0 1 0 3.6zM20 19h-3v-5.6c0-3.4-4-3.1-4 0V19h-3V8h3v1.8c1.4-2.6 7-2.8 7 2.5V19z"/></svg>
        </a>
        <a href="https://twitter.com/aldernorthholdings" aria-label="X (Twitter)" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2H21l-6.46 7.387L22 22h-6.828l-4.77-6.246L4.804 22H2l6.91-7.892L1.5 2h6.957l4.31 5.713L18.244 2zM17.222 20.146h1.84L7.027 3.748H5.05L17.222 20.146z"/></svg>
        </a>
        <a href="https://www.facebook.com/aldernorthholdings" aria-label="Facebook" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.66 9.13 8.44 9.88V14.9H7.9V12h2.54V9.8c0-2.51 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.9h-2.33v6.98C18.34 21.13 22 16.99 22 12z"/></svg>
        </a>
      </span>
    </div>
  </div>
</footer>


  <!-- Scripts -->
  <script src="<?= anc_asset('../../assets/js/main.js') ?>" defer></script>
  <script>
    // ANC Redesign: toggle .is-scrolled on navbar once past hero
    (function () {
      const nav = document.querySelector('.anc-redesign .navbar');
      if (!nav) return;
      const threshold = 80;
      const update = () => nav.classList.toggle('is-scrolled', window.scrollY > threshold);
      update();
      window.addEventListener('scroll', update, { passive: true });
    })();
  </script>
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Aldernorth Capital",
  "url": "https://aldernorthcapital.com",
  "logo": "https://aldernorthcapital.com/assets/images/logo/aldernorth-black.svg",
  "sameAs": [
    "https://www.linkedin.com/company/aldernorthholdings",
    "https://twitter.com/aldernorthholdings",
    "https://instagram.com/aldernorthholdings"
  ]
}
</script>

<noscript>
  Powered by <a href="https://www.smartsupp.com" target="_blank" rel="noopener noreferrer">Smartsupp</a>
</noscript>


</body>
</html>
