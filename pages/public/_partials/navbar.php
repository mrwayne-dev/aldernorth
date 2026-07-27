<?php
// ============================================================
// NAVBAR partial — Crestmark D.12 adapted
// Pass $nav_variant = 'solid' to force solid background
// (used on pages without a dark hero — about, contact, auth)
// ============================================================
$nav_variant = $nav_variant ?? 'default';
$nav_class = 'navbar' . ($nav_variant === 'solid' ? ' navbar--solid' : '');
?>
<nav class="<?= $nav_class ?>" data-navbar>
  <div class="container">
    <div class="navbar__inner">
      <a href="/" class="navbar__brand" aria-label="Aldernorth Capital home">
        <img class="navbar__logo navbar__logo--light" src="/assets/images/logo/aldernorth-white.svg" alt="Aldernorth Capital" loading="lazy">
        <img class="navbar__logo navbar__logo--dark" src="/assets/images/logo/aldernorth-black.svg" alt="Aldernorth Capital" loading="lazy">
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
