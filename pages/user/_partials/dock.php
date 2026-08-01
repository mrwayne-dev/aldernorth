<?php
// ============================================================
// MEMBER MOBILE DOCK
// Bottom tab bar shown below the sidebar breakpoint (1200px).
// $active = dashboard | wallet | transactions | invest | profile
// Same variable the sidebar partial already receives.
// ============================================================
$active = $active ?? 'dashboard';
$on = static fn(string $s) => $active === $s ? ' is-active' : '';
$cur = static fn(string $s) => $active === $s ? ' aria-current="page"' : '';
?>
<nav class="anc-dock" aria-label="Primary">
    <a href="/dashboard" class="anc-dock__item<?= $on('dashboard') ?>"<?= $cur('dashboard') ?>>
        <i class="ph ph-squares-four" aria-hidden="true"></i>
        <span>Home</span>
    </a>
    <a href="/dashboard.wallet" class="anc-dock__item<?= $on('wallet') ?>"<?= $cur('wallet') ?>>
        <i class="ph ph-wallet" aria-hidden="true"></i>
        <span>Wallet</span>
    </a>
    <a href="/dashboard.invest" class="anc-dock__item<?= $on('invest') ?>"<?= $cur('invest') ?>>
        <i class="ph ph-chart-line-up" aria-hidden="true"></i>
        <span>Invest</span>
    </a>
    <a href="/dashboard.transactions" class="anc-dock__item<?= $on('transactions') ?>"<?= $cur('transactions') ?>>
        <i class="ph ph-receipt" aria-hidden="true"></i>
        <span>Activity</span>
    </a>
    <a href="/dashboard.profile" class="anc-dock__item<?= $on('profile') ?>"<?= $cur('profile') ?>>
        <i class="ph ph-user-circle" aria-hidden="true"></i>
        <span>Profile</span>
    </a>
</nav>
