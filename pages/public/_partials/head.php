<?php
require_once __DIR__ . '/../../../config/assets.php'; // asset cache-busting


// ============================================================
// HEAD partial — shared by every public page
// Usage:
//   $page_title       (string)  e.g. "Aldernorth Capital — Build Wealth"
//   $page_description (string)
//   $page_path        (string)  e.g. "/about" (for canonical)
// ============================================================
$page_title       = $page_title       ?? 'Aldernorth Capital';
$page_description = $page_description ?? 'Invest a lump sum, choose a weekly or monthly payout cadence, and watch it land in your wallet on schedule.';
$page_path        = $page_path        ?? '/';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
  <meta name="author" content="Aldernorth Capital">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index, follow">
  <meta name="theme-color" content="#161316">
  <link rel="canonical" href="https://aldernorthcapital.com<?= htmlspecialchars($page_path) ?>">

  <title><?= htmlspecialchars($page_title) ?></title>

  <!-- Theme: applied before paint so there is no flash of the wrong palette.
       Must stay INLINE and stay ahead of the stylesheets. -->
  <script>
    (function () {
      try {
        var t = localStorage.getItem('anc-theme');
        document.documentElement.setAttribute('data-theme', t === 'light' ? 'light' : 'dark');
      } catch (e) { /* private mode — keep the dark default */ }
    })();
  </script>

  <!-- Fonts (self-hosted: Switzer brand face) -->
  <link rel="preload" href="/assets/fonts/Switzer-400.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="/assets/fonts/Switzer-500.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="<?= anc_asset('/assets/fonts/font.css') ?>">

  <!-- Phosphor icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css">

  <!-- Stylesheets — legacy first, design system overrides last -->
  <link rel="stylesheet" href="<?= anc_asset('/assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= anc_asset('/assets/css/responsive.css') ?>">
  <link rel="stylesheet" href="<?= anc_asset('/assets/css/anc-design.css') ?>">
  <script src="<?= anc_asset('/assets/js/theme.js') ?>" defer></script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assets/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="shortcut icon" href="/assets/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
  <meta name="apple-mobile-web-app-title" content="Aldernorth Capital">
  <link rel="manifest" href="/assets/favicon/site.webmanifest">
</head>
