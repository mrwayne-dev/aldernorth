<?php
// ============================================================
// ADMIN SIDEBAR partial
// $active = dashboard | users | transactions | wallets |
//           announcements | plans
// ============================================================
$active = $active ?? 'dashboard';
$is = static fn(string $s) => $active === $s ? ' active' : '';
?>
<div class="section-menu-left">
    <div class="box-logo">
        <a href="/admin.dashboard" id="site-logo-inner">
            <img id="logo_header" alt="Aldernorth Capital Admin" src="/assets/images/logo/aldernorth-white.svg" width="150px">
        </a>
        <div class="button-show-hide">
            <i class="ph ph-caret-left"></i>
        </div>
    </div>

    <div class="section-menu-left-wrap">
        <div class="center">
            <div class="center-item">
                <div class="center-heading f14-regular text-Gray menu-heading mb-12">Navigation</div>
            </div>

            <div class="center-item">
                <ul>
                    <!-- DASHBOARD -->
                    <li class="menu-item has-children<?= $is('dashboard') ?>">
                        <a href="javascript:void(0);" class="menu-item-button<?= $is('dashboard') ?>">
                            <div class="icon"><i class="ph ph-squares-four"></i></div>
                            <div class="text">Dashboard</div>
                        </a>
                        <ul class="sub-menu">
                            <li class="sub-menu-item<?= $is('dashboard') ?>"><a href="/admin.dashboard"><div class="text">Overview</div></a></li>
                        </ul>
                    </li>

                    <!-- USERS -->
                    <li class="menu-item<?= $is('users') ?>">
                        <a href="/admin.users" class="menu-item-button<?= $is('users') ?>">
                            <div class="icon"><i class="ph ph-users-three"></i></div>
                            <div class="text">Users</div>
                        </a>
                    </li>

                    <!-- TRANSACTIONS -->
                    <li class="menu-item<?= $is('transactions') ?>">
                        <a href="/admin.transactions" class="menu-item-button<?= $is('transactions') ?>">
                            <div class="icon"><i class="ph ph-receipt"></i></div>
                            <div class="text">Transactions</div>
                        </a>
                    </li>

                    <!-- WALLET MANAGEMENT -->
                    <li class="menu-item<?= $is('wallets') ?>">
                        <a href="/admin.wallets" class="menu-item-button<?= $is('wallets') ?>">
                            <div class="icon"><i class="ph ph-wallet"></i></div>
                            <div class="text">Wallet Management</div>
                        </a>
                    </li>

                    <!-- ANNOUNCEMENTS -->
                    <li class="menu-item<?= $is('announcements') ?>">
                        <a href="/admin.announcements" class="menu-item-button<?= $is('announcements') ?>">
                            <div class="icon"><i class="ph ph-megaphone"></i></div>
                            <div class="text">Announcements</div>
                        </a>
                    </li>

                    <!-- PLANS -->
                    <li class="menu-item<?= $is('plans') ?>">
                        <a href="/admin.plans" class="menu-item-button<?= $is('plans') ?>">
                            <div class="icon"><i class="ph ph-chart-line-up"></i></div>
                            <div class="text">Investment Plans</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
