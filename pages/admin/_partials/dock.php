<?php
// ============================================================
// ADMIN MOBILE DOCK
// Bottom tab bar shown below the sidebar breakpoint (1200px).
// Six nav items do not fit a dock, so the four highest-traffic
// sections get slots and the rest live behind "More".
// $active = dashboard | users | transactions | wallets |
//           announcements | plans | deposit_addresses
// ============================================================
$active = $active ?? 'dashboard';
$on  = static fn(string $s) => $active === $s ? ' is-active' : '';
$cur = static fn(string $s) => $active === $s ? ' aria-current="page"' : '';
$inMore = in_array($active, ['announcements', 'plans', 'deposit_addresses'], true);
?>
<nav class="anc-dock" aria-label="Primary">
    <a href="/admin.dashboard" class="anc-dock__item<?= $on('dashboard') ?>"<?= $cur('dashboard') ?>>
        <i class="ph ph-squares-four" aria-hidden="true"></i>
        <span>Home</span>
    </a>
    <a href="/admin.users" class="anc-dock__item<?= $on('users') ?>"<?= $cur('users') ?>>
        <i class="ph ph-users-three" aria-hidden="true"></i>
        <span>Users</span>
    </a>
    <a href="/admin.transactions" class="anc-dock__item<?= $on('transactions') ?>"<?= $cur('transactions') ?>>
        <i class="ph ph-receipt" aria-hidden="true"></i>
        <span>Activity</span>
    </a>
    <a href="/admin.wallets" class="anc-dock__item<?= $on('wallets') ?>"<?= $cur('wallets') ?>>
        <i class="ph ph-wallet" aria-hidden="true"></i>
        <span>Wallets</span>
    </a>
    <button type="button"
            class="anc-dock__item<?= $inMore ? ' is-active' : '' ?>"
            data-dock-more
            aria-expanded="false"
            aria-controls="anc-dock-sheet">
        <i class="ph ph-dots-three" aria-hidden="true"></i>
        <span>More</span>
    </button>
</nav>

<div class="anc-sheet" id="anc-dock-sheet" role="dialog" aria-modal="true" aria-hidden="true" aria-label="More sections">
    <div class="anc-sheet__overlay" data-dock-close></div>
    <div class="anc-sheet__panel" tabindex="-1">
        <div class="anc-sheet__handle" aria-hidden="true"></div>
        <a href="/admin.announcements" class="anc-sheet__item<?= $on('announcements') ?>">
            <i class="ph ph-megaphone" aria-hidden="true"></i>
            <span>Announcements</span>
        </a>
        <a href="/admin.plans" class="anc-sheet__item<?= $on('plans') ?>">
            <i class="ph ph-chart-line-up" aria-hidden="true"></i>
            <span>Investment Plans</span>
        </a>
        <a href="/admin.deposit-addresses" class="anc-sheet__item<?= $on('deposit_addresses') ?>">
            <i class="ph ph-wallet" aria-hidden="true"></i>
            <span>Deposit Addresses</span>
        </a>
    </div>
</div>
