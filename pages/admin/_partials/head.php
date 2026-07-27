<?php
require_once __DIR__ . '/../../../config/assets.php'; // asset cache-busting


// ============================================================
// ADMIN HEAD partial — $page_title, $page_description
// ============================================================
$page_title = $page_title ?? 'Aldernorth Capital Admin';
$page_description = $page_description ?? 'Aldernorth Capital administration.';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <meta name="author" content="Aldernorth Capital">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#161316">
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

    <!-- Preload + Apply (critical CSS) -->
    <link rel="preload" href="<?= anc_asset('/assets/css/bootstrap.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="<?= anc_asset('/assets/css/dashboard.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">

    <!-- Fonts (self-hosted: Switzer brand face) -->
    <link rel="preload" href="/assets/fonts/Switzer-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/fonts/Switzer-500.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Phosphor icons (self-hosted) -->
    <link rel="stylesheet" href="<?= anc_asset('/assets/fonts/phosphor.css') ?>">

    <!-- Non-critical CSS -->
    <link rel="stylesheet" href="<?= anc_asset('/assets/css/animation.min.css') ?>">
    <link rel="stylesheet" href="<?= anc_asset('/assets/css/animation.css') ?>">
    <link rel="stylesheet" href="<?= anc_asset('/assets/css/bootstrap-select.min.css') ?>">
    <link rel="stylesheet" href="<?= anc_asset('/assets/fonts/font.css') ?>">

    <!-- ANC design re-skin (loads last to win the cascade) -->
    <link rel="stylesheet" href="<?= anc_asset('/assets/css/anc-dashboard.css') ?>">
    <script src="<?= anc_asset('/assets/js/theme.js') ?>" defer></script>

    <noscript>
        <link rel="stylesheet" href="<?= anc_asset('/assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" href="<?= anc_asset('/assets/css/dashboard.css') ?>">
        <link rel="stylesheet" href="<?= anc_asset('/assets/css/anc-dashboard.css') ?>">
    </noscript>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="Aldernorth Capital">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
</head>
