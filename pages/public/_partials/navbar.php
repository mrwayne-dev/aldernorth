<?php
// ============================================================
// NAVBAR partial - Crestmark D.12 adapted
// Pass $nav_variant = 'solid' to force solid background
// (used on pages without a dark hero: about, contact, auth)
//
// Below 768px the link list becomes a full-screen overlay. The
// brand and the controls in .navbar__actions stay on top of it,
// so the theme toggle is reachable with the menu open.
// Toggle behaviour lives in assets/js/main.js.
// ============================================================
$nav_variant = $nav_variant ?? 'default';
$nav_class = 'navbar' . ($nav_variant === 'solid' ? ' navbar--solid' : '');
?>
<nav class="<?= $nav_class ?>" data-navbar>
  <div class="container">
    <div class="navbar__inner">
      <?php // Lockup: leaf mark on the left, company name as live text on the
            // right. The mark is the only image - the name is text so it takes
            // the brand colour that already tracks the nav state and theme.
            // alt="" on both marks: the <a>'s aria-label plus the wordmark text
            // already name the link, so alt would announce it a third time. ?>
      <a href="/" class="navbar__brand" aria-label="Aldernorth Capital home">
        <img class="navbar__logo navbar__logo--light" src="/assets/images/logo/anc-mark-orange.png" width="128" height="128" alt="">
        <img class="navbar__logo navbar__logo--dark" src="/assets/images/logo/anc-mark-ink.png" width="128" height="128" alt="">
        <span class="navbar__wordmark">Aldernorth Capital</span>
      </a>

      <ul class="navbar__links" id="navbar-links">
        <li><a href="/plans" class="navbar__link">Plans</a></li>
        <li><a href="/platform" class="navbar__link">Platform</a></li>
        <li><a href="/solutions" class="navbar__link">Solutions</a></li>
        <li><a href="/about" class="navbar__link">About</a></li>
        <li><a href="/contact" class="navbar__link">Contact</a></li>
        <li class="navbar__links-cta"><a href="/login" class="btn btn--primary">Sign in</a></li>
      </ul>

      <div class="navbar__actions">
        <button class="theme-toggle" data-theme-toggle type="button" aria-label="Switch to light theme" aria-pressed="false">
          <i class="ph ph-sun"></i>
        </button>
        <a href="/login" class="btn btn--nav navbar__cta">Sign in</a>

        <button class="navbar__toggle" type="button" data-nav-toggler
                aria-label="Open menu" aria-expanded="false" aria-controls="navbar-links">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
            <line x1="3" y1="6"  x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</nav>
