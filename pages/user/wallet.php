<?php
// pages/user/wallet.php

require_once __DIR__ . '/../../api/utilities/security.php';
// Hardened + proxy-aware (use_strict_mode, and cookie_secure that survives
// a TLS-terminating proxy - the inline options this replaced tested
// $_SERVER['HTTPS'] === 'on', which is unset there).
ancSessionStart();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: /login');
    exit;
}
// Retrieve user data from session
$user_name = htmlspecialchars($_SESSION['full_name'] ?? 'User'); // Fallback to 'User' if not set
$user_id = $_SESSION['user_id'] ?? null;
$user_email = $_SESSION['email'] ?? null;
$user_role = $_SESSION['role'] ?? 'user';

?>
<?php
  $page_title = "Wallet | Aldernorth Capital";
  include __DIR__ . "/_partials/head.php";
?>

<body class="counter-scroll anc-dash">

    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        <div id="page" class="">
            <!-- layout-wrap -->
            <div class="layout-wrap loader-off">
                <!-- preload -->
                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>
                <!-- /preload -->
                <!-- section-menu-left -->
                <?php $active = "wallet"; include __DIR__ . "/_partials/sidebar.php"; ?>
                <?php include __DIR__ . "/_partials/dock.php"; ?>
                <!-- section-content-right -->
                <div class="section-content-right">
                    <!-- header-dashboard -->
                    <?php $page_heading = "Wallet"; include __DIR__ . "/_partials/topbar.php"; ?>
                    <!-- main-content -->
                    <div class="main-content">
                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="tf-container">
                                    <!-- ============================================================
                                         ROW 1 · PORTFOLIO SUMMARY (hero) + LIFETIME ACTIVITY
                                         ============================================================ -->
                                    <div class="row mb-32">
                                        <!-- Hero balance -->
                                        <div class="col-lg-8 col-md-12 mb-24">
                                            <div class="wallet-card wallet-main wallet-hero" data-balance-card>
                                                <div class="wallet-hero-top">
                                                    <div class="title-box flex items-center gap-2">
                                                        <i class="ph ph-wallet"></i>
                                                        <span class="f12-medium text-White">Total Balance (USD)</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="box-status bg-Green f12-medium flex items-center gap-2">
                                                            <i class="ph ph-shield-check"></i> Active
                                                        </span>
                                                        <button type="button" class="wallet-hero-eye" data-balance-toggle
                                                                aria-pressed="false" aria-label="Hide balance" title="Hide balance">
                                                            <i class="ph ph-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="wallet-hero-balance">
                                                    <h2 class="counter text-White">$<span id="total-balance">0.00</span></h2>
                                                    <div class="wallet-hero-change f14-regular">
                                                        <i class="ph ph-trend-up"></i>
                                                        +$<span id="total-earnings">0.00</span> earned to date
                                                    </div>
                                                </div>

                                                <button type="button" class="wallet-hero-ref" data-copy-text="ANC-MAIN-<?= str_pad((string)(int)$_SESSION['user_id'], 4, '0', STR_PAD_LEFT) ?>" title="Copy wallet reference">
                                                    <i class="ph ph-copy" aria-hidden="true"></i>
                                                    <span>ANC-MAIN-<?= str_pad((string)(int)$_SESSION['user_id'], 4, '0', STR_PAD_LEFT) ?></span>
                                                </button>

                                                <div class="wallet-hero-substats">
                                                    <div class="wallet-substat">
                                                        <div class="f12-regular">Invested across products</div>
                                                        <div class="f14-bold text-White">$<span id="wallet-total-invested">0.00</span></div>
                                                    </div>
                                                    <div class="wallet-substat">
                                                        <div class="f12-regular">Pending withdrawals</div>
                                                        <div class="f14-bold text-White">$<span id="pending-withdrawals">0.00</span></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quick actions. Replaces the two inline deposit/withdraw
                                                 form panels; both now open as modals. -->
                                            <div class="wg-box wallet-actions mt-24">
                                                <button type="button" class="wallet-action" data-open-modal="#deposit-modal">
                                                    <span class="wallet-action__icon"><i class="ph ph-arrow-down"></i></span>
                                                    <span class="wallet-action__label">Deposit</span>
                                                </button>
                                                <button type="button" class="wallet-action" data-open-modal="#withdraw-start-modal">
                                                    <span class="wallet-action__icon"><i class="ph ph-arrow-up"></i></span>
                                                    <span class="wallet-action__label">Withdraw</span>
                                                </button>
                                                <a href="/dashboard.invest" class="wallet-action">
                                                    <span class="wallet-action__icon"><i class="ph ph-chart-line-up"></i></span>
                                                    <span class="wallet-action__label">Invest</span>
                                                </a>
                                                <a href="/dashboard.transactions" class="wallet-action">
                                                    <span class="wallet-action__icon"><i class="ph ph-clock-counter-clockwise"></i></span>
                                                    <span class="wallet-action__label">History</span>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Lifetime activity -->
                                        <div class="col-lg-4 col-md-12 mb-24">
                                            <div class="wg-box wallet-lifetime h-full">
                                                <div class="title mb-16">
                                                    <div class="label-01 text-Primary">Lifetime activity</div>
                                                </div>
                                                <ul class="wallet-stat-list">
                                                    <li>
                                                        <span class="wallet-stat-label f14-regular text-Gray">
                                                            <i class="ph ph-arrow-down"></i> Total deposited
                                                        </span>
                                                        <span class="f14-bold text-Primary">$<span id="total-deposited">0.00</span></span>
                                                    </li>
                                                    <li>
                                                        <span class="wallet-stat-label f14-regular text-Gray">
                                                            <i class="ph ph-arrow-up"></i> Total withdrawn
                                                        </span>
                                                        <span class="f14-bold text-Primary">$<span id="total-withdrawn">0.00</span></span>
                                                    </li>
                                                    <li>
                                                        <span class="wallet-stat-label f14-regular text-Gray">
                                                            <i class="ph ph-trend-up"></i> Total earnings
                                                        </span>
                                                        <span class="f14-bold text-Green">$<span id="wallet-total-earnings">0.00</span></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ============================================================
                                         ROW 2 · PORTFOLIO ALLOCATION (where your money is)
                                         ============================================================ -->
                                    <div class="row mb-32">
                                        <div class="col-12">
                                            <div class="wg-box">
                                                <div class="title mb-16 flex justify-between items-center">
                                                    <div class="label-01 text-Primary">Your portfolio</div>
                                                    <a href="/dashboard.invest" class="view-all f12-regular text-Primary">
                                                        Manage <i class="ph ph-caret-right ml-2"></i>
                                                    </a>
                                                </div>
                                                <ul class="wallet-alloc-list">
                                                    <li class="wallet-alloc-item">
                                                        <a href="/dashboard.invest">
                                                            <span class="wallet-alloc-icon"><i class="ph ph-calendar-dots"></i></span>
                                                            <span class="wallet-alloc-meta">
                                                                <span class="f14-bold text-Primary">Weekly plans</span>
                                                                <span class="f12-regular text-Gray">A payout every week</span>
                                                            </span>
                                                            <span class="wallet-alloc-value f14-bold text-Primary">$<span id="weekly-invested">0.00</span></span>
                                                            <i class="ph ph-caret-right wallet-alloc-arrow"></i>
                                                        </a>
                                                    </li>
                                                    <li class="wallet-alloc-item">
                                                        <a href="/dashboard.invest">
                                                            <span class="wallet-alloc-icon"><i class="ph ph-calendar-check"></i></span>
                                                            <span class="wallet-alloc-meta">
                                                                <span class="f14-bold text-Primary">Monthly plans</span>
                                                                <span class="f12-regular text-Gray">A payout every month</span>
                                                            </span>
                                                            <span class="wallet-alloc-value f14-bold text-Primary">$<span id="monthly-invested">0.00</span></span>
                                                            <i class="ph ph-caret-right wallet-alloc-arrow"></i>
                                                        </a>
                                                    </li>
                                                    <li class="wallet-alloc-item">
                                                        <a href="/dashboard.invest">
                                                            <span class="wallet-alloc-icon"><i class="ph ph-trend-up"></i></span>
                                                            <span class="wallet-alloc-meta">
                                                                <span class="f14-bold text-Primary">Next payout</span>
                                                                <span class="f12-regular text-Gray">due <span id="next-payout-date">—</span></span>
                                                            </span>
                                                            <span class="wallet-alloc-value f14-bold text-Primary">$<span id="next-payout-amount">0.00</span></span>
                                                            <i class="ph ph-caret-right wallet-alloc-arrow"></i>
                                                        </a>
                                                    </li>
                                                    <li class="wallet-alloc-item">
                                                        <a href="/dashboard.invest">
                                                            <span class="wallet-alloc-icon"><i class="ph ph-chart-line-up"></i></span>
                                                            <span class="wallet-alloc-meta">
                                                                <span class="f14-bold text-Primary">Total invested</span>
                                                                <span class="f12-regular text-Gray">Capital currently deployed</span>
                                                            </span>
                                                            <span class="wallet-alloc-value f14-bold text-Primary">$<span id="total-investments">0.00</span></span>
                                                            <i class="ph ph-caret-right wallet-alloc-arrow"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ============================================================
                                         ROW 3 · AWAITING YOUR TRANSFER
                                         The read-only address list that used to sit here is gone:
                                         the addresses are now shown inside the deposit flow, where
                                         they are actionable, rather than as reference copy.
                                         This card is the way back to a deposit already started -
                                         revealed only when one exists, the same pattern the address
                                         list used.
                                         ============================================================ -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="wg-box mb-32" id="pending-deposits-box" hidden>
                                                <div class="title mb-16 flex justify-between items-center">
                                                    <div class="label-01 text-Primary">Awaiting your transfer</div>
                                                    <span class="f12-regular text-Gray">Credited once we confirm receipt</span>
                                                </div>
                                                <div class="content">
                                                    <ul class="anc-address-list" id="pending-deposits-list"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ============================================================
                                         ROW 4 · WALLET ACTIVITY
                                         Same .anc-table markup and the same renderer as
                                         /dashboard.transactions - previously this was a bespoke
                                         <ul> with its own field names and colour rules, so the
                                         two views of one dataset disagreed with each other.
                                         ============================================================ -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="wg-box">
                                                <div class="title mb-16 flex justify-between items-center">
                                                    <div class="label-01 text-Primary">Wallet Activity</div>
                                                    <div class="view-all">
                                                        <a href="/dashboard.transactions" class="f12-regular text-Primary">
                                                            View All
                                                            <i class="ph ph-caret-right ml-2"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="anc-scroll-table">
                                                        <table class="anc-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Transaction ID</th>
                                                                    <th>Date</th>
                                                                    <th>Type</th>
                                                                    <th>Amount (USD)</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="wallet-activity">
                                                                <tr><td class="anc-empty" colspan="5">Loading activity...</td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->
                        
                    </div>
                    <!-- /main-content -->
                </div>
                <!-- /section-content-right -->
            </div>
            <!-- /layout-wrap -->
        </div>
        <!-- /#page -->
    </div>
    <!-- /#wrapper -->

    <!-- Loader -->
    <div id="loader" class="hidden">
        <div class="line-loader">
            <div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>
    <!-- Toast Container -->
    <div id="toast-container"></div>

<!-- ============================================================
     DEPOSIT MODAL
     Holds the fields that used to sit in the inline deposit panel.
     The IDs are unchanged, so bindDepositForm() in dashboard.js works
     against it without modification.
     ============================================================ -->
<div id="deposit-modal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" data-modal>
  <div class="modal-overlay" data-modal-close></div>
  <div class="modal-content" tabindex="-1" aria-labelledby="deposit-modal-title">
    <header class="modal-header">
      <h2 id="deposit-modal-title">Deposit Funds</h2>
      <button class="modal-close" type="button" aria-label="Close modal" data-modal-close>&times;</button>
    </header>
    <div class="modal-body">
      <form id="deposit-form">
        <div class="anc-field">
          <div class="anc-field__top">
            <label class="anc-field__label" for="deposit-amount">Amount to deposit</label>
            <span class="anc-field__hint" id="deposit-min-hint">Minimum <strong>$1</strong></span>
          </div>
          <div class="anc-field__row">
            <input class="anc-field__input" type="number" placeholder="0.00" min="1" step="0.01" id="deposit-amount" inputmode="decimal">
            <span class="anc-field__chip"><i class="ph ph-currency-dollar"></i> USD</span>
          </div>
        </div>

        <?php // Two live routes. secure_exchange hands off to the crypto
              // checkout, which issues its own address. deposit_address shows
              // one of the addresses an admin publishes and leaves the
              // transaction pending until they confirm the transfer.
              // The hidden input keeps #deposit-method readable to
              // bindDepositForm exactly as before. ?>
        <div class="anc-field">
          <div class="anc-field__top">
            <span class="anc-field__label">Payment method</span>
          </div>
          <div class="anc-segment" id="deposit-method-segment" role="radiogroup" aria-label="Payment method">
            <button type="button" class="anc-segment__btn is-active" data-method="secure_exchange"
                    role="radio" aria-checked="true">
              <i class="ph ph-lightning"></i> Crypto checkout
            </button>
            <button type="button" class="anc-segment__btn" data-method="deposit_address"
                    role="radio" aria-checked="false" id="deposit-method-manual" hidden>
              <i class="ph ph-qr-code"></i> Deposit address
            </button>
          </div>
          <input type="hidden" id="deposit-method" value="secure_exchange">
        </div>

        <?php // Revealed only for deposit_address; options come from
              // get_deposit_networks, the same fetch the flow already makes. ?>
        <div class="anc-field hidden" id="deposit-network-field" aria-hidden="true">
          <div class="anc-field__top">
            <label class="anc-field__label" for="deposit-network">Coin and network</label>
            <span class="anc-field__hint" id="deposit-network-hint"></span>
          </div>
          <div class="anc-field__row">
            <select class="anc-field__input" id="deposit-network"></select>
          </div>
        </div>

        <ul class="anc-summary">
          <li class="anc-summary__row">
            <span class="k"><i class="ph ph-clock"></i> Processing</span>
            <span class="v" id="deposit-summary-time">Instant for crypto</span>
          </li>
          <li class="anc-summary__row">
            <span class="k"><i class="ph ph-receipt"></i> Fee</span>
            <span class="v">No deposit fee</span>
          </li>
        </ul>

        <div class="modal-actions">
          <button type="button" class="button-close-modal tf-button" data-modal-close>Cancel</button>
          <button type="submit" class="modal-confirm-btn">Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================
     WITHDRAW - STEP 1 (amount + method)
     Step 2 is #withdraw-modal below, which collects the payout
     details. bindWithdrawForm() validates here and hands over.
     ============================================================ -->
<div id="withdraw-start-modal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" data-modal>
  <div class="modal-overlay" data-modal-close></div>
  <div class="modal-content" tabindex="-1" aria-labelledby="withdraw-start-title">
    <header class="modal-header">
      <h2 id="withdraw-start-title">Withdraw Funds</h2>
      <button class="modal-close" type="button" aria-label="Close modal" data-modal-close>&times;</button>
    </header>
    <div class="modal-body">
      <form id="withdraw-form">
        <div class="anc-field">
          <div class="anc-field__top">
            <span class="anc-field__label">Amount to withdraw</span>
            <span class="anc-field__hint">Available <strong>$<span id="withdraw-available">0.00</span></strong></span>
          </div>
          <div class="anc-field__row">
            <input class="anc-field__input" type="number" placeholder="0.00" min="1" step="0.01" id="withdraw-amount" inputmode="decimal">
            <span class="anc-field__chip"><i class="ph ph-currency-dollar"></i> USD</span>
          </div>
        </div>

        <div class="anc-field">
          <div class="anc-field__top">
            <span class="anc-field__label">Withdrawal method</span>
          </div>
          <div class="anc-field__row">
            <select class="anc-field__input" id="withdraw-method">
              <option selected disabled value="">Select method</option>
              <option value="local_bank">Local Bank</option>
              <option value="wallet_address">Wallet Address</option>
            </select>
          </div>
        </div>

        <ul class="anc-summary">
          <li class="anc-summary__row">
            <span class="k"><i class="ph ph-clock"></i> Processing time</span>
            <span class="v">1 to 3 business days</span>
          </li>
          <li class="anc-summary__row">
            <span class="k"><i class="ph ph-shield-check"></i> Review</span>
            <span class="v">Manually approved</span>
          </li>
        </ul>

        <div class="modal-actions">
          <button type="button" class="button-close-modal tf-button" data-modal-close>Cancel</button>
          <button type="submit" class="modal-confirm-btn">Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Withdrawal Modal (step 2: payout details) -->
<div id="withdraw-modal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" data-modal>
  <div class="modal-overlay" data-modal-close></div>
  <div class="modal-content" tabindex="-1" aria-labelledby="withdraw-modal-title">
    <header class="modal-header">
      <h2 id="withdraw-modal-title">Withdraw Funds</h2>
      <button class="modal-close" type="button" aria-label="Close modal" data-modal-close>&times;</button>
    </header>

    <div class="modal-body">
      <div class="withdrawal-method">
        <label>Selected Method: <span id="modal-method-name"></span></label>
      </div>

      <div class="form-group">
        <label>Amount to Withdraw</label>
        <input type="text" id="modal-withdraw-amount" readonly>
      </div>

      <!-- Local Bank Fields -->
      <div id="local-bank-fields" class="bank-form hidden" aria-hidden="true">
        <div class="form-group">
          <label for="modal-bank-country">Country</label>
          <select id="modal-bank-country">
            <option value="">Select Country</option>
            <option value="United States of America">United States of America</option>
            <option value="Germany">Germany</option>
            <option value="France">France</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Italy">Italy</option>
            <option value="Spain">Spain</option>
            <option value="Netherlands">Netherlands</option>
            <option value="Sweden">Sweden</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Poland">Poland</option>
            <option value="Austria">Austria</option>
            <option value="Greece">Greece</option>
            <option value="Portugal">Portugal</option>
            <option value="Norway">Norway</option>
            <option value="Denmark">Denmark</option>
            <option value="Belgium">Belgium</option>
            <option value="Finland">Finland</option>
            <option value="Ireland">Ireland</option>
            <option value="Czech Republic">Czech Republic</option>
            <option value="Hungary">Hungary</option>
            <option value="Ukraine">Ukraine</option>
          </select>
        </div>

        <div class="form-group">
          <label for="modal-bank-search">Bank</label>
          <div class="bank-search-container">
            <input type="text" id="modal-bank-search" placeholder="Search for a bank..." autocomplete="off">
            <div id="modal-bank-dropdown"></div>
            <input type="hidden" id="modal-bank-name">
          </div>
          <small class="form-error" id="modal-bank-name-error"></small>
        </div>

        <div class="form-group">
          <label for="modal-account-holder">Account Holder Name</label>
          <input type="text" id="modal-account-holder" placeholder="Full Name">
        </div>

        <div class="form-group">
          <label for="modal-iban">IBAN</label>
          <input type="text" id="modal-iban" placeholder="e.g., DE89370400440532013000">
        </div>

        <div class="form-group">
          <label for="modal-bic">BIC/SWIFT Code</label>
          <input type="text" id="modal-bic" placeholder="e.g., DEUTDEFFXXX">
        </div>

        <div class="form-group uk-only">
          <label for="modal-sort-code">Sort Code (UK only)</label>
          <input type="text" id="modal-sort-code" placeholder="e.g., 12-34-56">
        </div>

        <div class="form-group">
          <label for="modal-bank-currency">Currency</label>
          <select id="modal-bank-currency">
            <option value="EUR">EUR</option>
            <option value="USD">USD</option>
            <option value="GBP">GBP</option>
            <option value="CHF">CHF</option>
            <option value="SEK">SEK</option>
            <option value="PLN">PLN</option>
            <option value="CZK">CZK</option>
            <option value="HUF">HUF</option>
            <option value="NOK">NOK</option>
            <option value="DKK">DKK</option>
            <option value="UAH">UAH</option>
          </select>
        </div>

        <div class="form-group">
          <label for="modal-transaction-ref">Transaction Reference</label>
          <input type="text" id="modal-transaction-ref" placeholder="e.g., Withdrawal October 2025">
        </div>

        <small class="form-error" id="withdraw-general-error"></small>
        <p class="note">Local bank conversions are based on currency selected.</p>
      </div>

      <!-- Wallet Address Fields -->
      <div id="wallet-address-fields" class="hidden" aria-hidden="true">
        <div class="form-group">
          <label for="modal-coin">Select Coin</label>
          <select id="modal-coin">
            <option value="btc">Bitcoin (BTC)</option>
            <option value="eth">Ethereum (ETH)</option>
            <option value="usdt">USDT</option>
            <option value="usdc">USDC</option>
          </select>
        </div>

        <div class="form-group">
          <label for="modal-wallet-address">Wallet Address</label>
          <input type="text" id="modal-wallet-address" placeholder="Enter wallet address">
        </div>
      </div>

      <?php // The cash-mailing branch was removed with the method itself. Its
            // JS counterparts in bindWithdrawForm / bindConfirmWithdraw went
            // with it, so nothing looks for #modal-cash-details any more. ?>

      <button type="button" class="modal-confirm-btn" id="confirm-withdraw">
        Confirm Withdrawal
      </button>
    </div>
  </div>
</div>

<!-- ============================================================
     DEPOSIT INSTRUCTIONS  (manual transfer to a published address)

     Replaces #pending-actions-modal, which had a single hardcoded
     method option, used the legacy .form-group dialect and carried a
     second, parallel clipboard mechanism (.copy-btn[data-target]).

     Named "instructions", not "address": #deposit-address-modal is
     already the admin CRUD dialog.

     The address block reuses .anc-address*, which is already styled and
     already wired to the delegated [data-copy-text] handler - no new
     CSS and no new copy logic.
     ============================================================ -->
<div id="deposit-instructions-modal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" data-modal>
  <div class="modal-overlay" data-modal-close></div>
  <div class="modal-content" tabindex="-1" aria-labelledby="deposit-instructions-title">
    <header class="modal-header">
      <div>
        <h2 id="deposit-instructions-title">Send your deposit</h2>
        <p class="modal-header__sub">Funds are credited once we confirm the transfer.</p>
      </div>
      <button class="modal-close" type="button" aria-label="Close modal" data-modal-close>&times;</button>
    </header>
    <div class="modal-body">

      <div class="anc-field">
        <div class="anc-field__top">
          <span class="anc-field__label">Send exactly</span>
          <span class="anc-field__hint" id="di-network-label"></span>
        </div>
        <div class="anc-field__row">
          <span class="anc-field__input" id="di-amount">0.00</span>
          <span class="anc-field__chip"><i class="ph ph-currency-dollar"></i> USD</span>
        </div>
      </div>

      <ul class="anc-address-list">
        <li class="anc-address">
          <div class="anc-address__head">
            <span class="anc-address__label" id="di-label"></span>
            <span class="anc-address__meta" id="di-meta"></span>
          </div>
          <div class="anc-address__row">
            <code class="anc-address__value" id="di-address"></code>
            <button type="button" class="anc-address__copy" id="di-address-copy"
                    data-copy-label="Deposit address" aria-label="Copy deposit address">
              <i class="ph ph-copy"></i>
            </button>
          </div>
          <div class="anc-address__row hidden" id="di-memo-row">
            <span class="anc-address__memo-label" id="di-memo-label">Memo</span>
            <code class="anc-address__value" id="di-memo"></code>
            <button type="button" class="anc-address__copy" id="di-memo-copy"
                    data-copy-label="Memo" aria-label="Copy memo">
              <i class="ph ph-copy"></i>
            </button>
          </div>
          <p class="anc-address__note hidden" id="di-instructions"></p>
        </li>
      </ul>

      <ul class="anc-summary">
        <li class="anc-summary__row">
          <span class="k"><i class="ph ph-hash"></i> Reference</span>
          <span class="v" id="di-reference"></span>
        </li>
        <li class="anc-summary__row hidden" id="di-conf-row">
          <span class="k"><i class="ph ph-check-circle"></i> Network confirmations</span>
          <span class="v" id="di-conf"></span>
        </li>
        <li class="anc-summary__row">
          <span class="k"><i class="ph ph-shield-check"></i> Status</span>
          <span class="v" id="di-status">Awaiting your transfer</span>
        </li>
      </ul>

      <?php // Revealed by "I have paid". Optional, but prompted: without a
            // hash the admin is approving on the amount alone. ?>
      <div class="anc-field anc-field--textarea hidden" id="di-hash-field">
        <div class="anc-field__top">
          <label class="anc-field__label" for="di-tx-hash">Transaction hash</label>
          <span class="anc-field__hint">Optional, speeds up confirmation</span>
        </div>
        <div class="anc-field__row">
          <textarea class="anc-field__input anc-field__input--mono" id="di-tx-hash" rows="2"
                    maxlength="120" spellcheck="false" placeholder="Paste the hash from your wallet"></textarea>
        </div>
      </div>

      <p class="note">Send only the named asset on the named network. Anything else is unrecoverable.</p>

      <div class="modal-actions">
        <button type="button" class="button-close-modal tf-button" data-modal-close>Close</button>
        <button type="button" class="modal-confirm-btn" id="di-confirm-paid">I have paid</button>
      </div>
    </div>
  </div>
</div>




<!-- core libs: jquery then bootstrap -->
<script src="<?= anc_asset('../../assets/js/jquery.min.js') ?>"></script>
<script src="<?= anc_asset('../../assets/js/bootstrap.min.js') ?>"></script>

<!-- app/network layer (deferred) -->
<script src="<?= anc_asset('../../assets/js/api.js') ?>" defer></script>

<!-- plugins (deferred if they support it) -->
<script src="<?= anc_asset('../../assets/js/countto.js') ?>" defer></script>
<script src="<?= anc_asset('../../assets/js/bootstrap-select.min.js') ?>" defer></script>

<!-- main dashboard behaviour (deferred so it runs after DOM is parsed and after api.js) -->
<script src="<?= anc_asset('../../assets/js/dashboard.js') ?>" defer></script>

    <!-- Iconify CDN -->
</body>
</html>