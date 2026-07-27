<?php
// pages/user/dashboard.php
session_start([
    'cookie_lifetime' => 86400, // Example: 24 hours
    'cookie_httponly' => true,
    'cookie_secure' => true, 
    'cookie_samesite' => 'Strict',
]);
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
  $page_title = "Dashboard | Aldernorth Capital";
  include __DIR__ . "/_partials/head.php";
?>
<body class="counter-scroll anc-dash">
    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        <div id="page" class="">
            <!-- layout-wrap -->
            <div class="layout-wrap loader-off">
                <!-- preload -->=
                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>
                <!-- /preload -->
                <!-- section-menu-left -->
                 <!-- testing my commit -->
                <?php $active = "dashboard"; include __DIR__ . "/_partials/sidebar.php"; ?>
                <!-- section-content-right -->
                <div class="section-content-right">
                    <!-- header-dashboard -->
                    <?php $page_heading = "Dashboard"; include __DIR__ . "/_partials/topbar.php"; ?>
                    <!-- main-content -->
                    <div class="main-content">
                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="tf-container">
                                    
                                    <div class="row">
                                        <!-- ============================= -->
                                        <!-- BIG WALLET CARDS OVERVIEW SECTION (Full Width, Bigger Cards) -->
                                        <!-- ============================= -->
                                   <div class="col-12 mb-40">
  <div class="wallet-overview">
    <div class="section-header flex justify-between items-center mb-16">
      <h6 class="label-01">Wallet Overview</h6>
      <a href="#" class="f14-regular flex items-center gap8 text-Primary" onclick="refreshDashboard()">
        <i class="ph ph-arrows-clockwise"></i> Refresh Balances
      </a>
    </div>

    <div class="wallet-cards grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap20">

      <!-- Main Wallet -->
      <div class="wallet-card wallet-main">
        <div class="wallet-card-header">Main Wallet</div>
        <div class="wallet-card-balance">$<span id="total-balance">0.00</span></div>
        <div class="wallet-card-footer">
          ANC-MAIN-<?= str_pad($user_id, 4, '0', STR_PAD_LEFT) ?>
        </div>
      </div>

      <!-- Total Earnings -->
      <div class="wallet-card wallet-green">
        <div class="wallet-card-header">Total Earnings</div>
        <div class="wallet-card-balance">$<span id="total-earnings">0.00</span></div>
        <div class="wallet-card-footer">
          ANC-ERN-<?= str_pad($user_id, 4, '0', STR_PAD_LEFT) ?>
        </div>
      </div>

      <!-- Capital invested -->
      <div class="wallet-card wallet-investments">
        <div class="wallet-card-header">Invested</div>
        <div class="wallet-card-balance">$<span id="total-investments">0.00</span></div>
        <div class="wallet-card-footer">
          <span id="active-positions">0</span> active position(s)
        </div>
      </div>

      <!-- Next scheduled payout -->
      <div class="wallet-card wallet-accent">
        <div class="wallet-card-header">Next Payout</div>
        <div class="wallet-card-balance">$<span id="next-payout-amount">0.00</span></div>
        <div class="wallet-card-footer">
          due <span id="next-payout-date">—</span>
        </div>
      </div>

    </div>
  </div>
</div>



<!-- ============================= -->
<!-- CARD DETAILS SECTION (CLEAN VERSION) -->
<!-- ============================= -->
<div class="col-12 mb-32">
  <div class="wg-box card-details mb-32">
    <div class="title flex justify-between items-center">
      <h6 class="label-01">Card Details</h6>
    </div>

    <hr class="divider mb-24">

    <div class="card-details-grid">
      <!-- Left: Card Info -->
      <div class="card-info-panel">
        <ul class="card-info-list">
          <li>
            <span>Card Name</span>
            <strong id="card-name">Main Wallet</strong>
          </li>
          <li>
            <span>Valid Date</span>
            <strong id="card-valid">08/26</strong>
          </li>
          <li>
            <span>ANC ID</span>
            <strong id="card-id">ANC-<?= str_pad($user_id, 4, '0', STR_PAD_LEFT) ?>-9011-3298</strong>
            </li>
          <li>
            <span>Card Holder</span>
            <strong id="card-holder"><?= $user_name ?></strong>
          </li>
          <li>
            <span>Bank Name</span>
            <strong id="card-bank">Aldernorth Capital Bank</strong>
          </li>
        </ul>
      </div>

      <!-- Right: Chart Only -->
      <div class="card-chart-panel text-center">
        <canvas id="cardUsageChart" width="200" height="200"></canvas>
        <ul class="chart-legend flex justify-center gap16 mt-12 flex-wrap">
          <li class="flex items-center gap6">
            <div class="dot bg-Primary"></div> <span>Weekly</span> <strong>0%</strong>
          </li>
          <li class="flex items-center gap6">
            <div class="dot bg-Accent"></div> <span>Monthly</span> <strong>0%</strong>
          </li>
          <li class="flex items-center gap6">
            <div class="dot bg-Gainsboro"></div> <span>Wallet</span> <strong>0%</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>



                                        <!-- ============================= -->
                                        <!-- LATEST UPDATES AND RECENT ACTIVITY (Side by Side) -->
                                        <!-- ============================= -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-32">
                                                <!-- Latest Updates Section -->
                                                <div class="wg-box style-1 bg-Primary shadow-none mb-32">
                                                    <div>
                                                        <div class="title mb-10">
                                                            <div class="label-01 text-White">Latest Updates</div>
                                                        </div>
                                                        <div class="updates-list text-White">
                                                            <div class="update-item flex gap16 items-start mb-20">
                                                                <div class="update-content">
                                                                    <div class="f14-bold">Weekly plans now open</div>
                                                                    <div class="f12-regular text-Gainsboro">Alder, Rowan and Blackthorn Weekly are accepting allocations, with a payout credited every seven days.</div>
                                                                    <div class="f12-regular text-LightGray mt-4">Recently</div>
                                                                </div>
                                                            </div>
                                                            <div class="update-item flex gap16 items-start mb-0">
                                                                <div class="update-content">
                                                                    <div class="f14-bold">Monthly plans now open</div>
                                                                    <div class="f12-regular text-Gainsboro">Northwood, Ironwood and Aldercrest Monthly pay a larger amount on the same date each month.</div>
                                                                    <div class="f12-regular text-LightGray mt-4">Recently</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Latest Updates Section -->
                                            </div>
                                            <div class="col-lg-6 mb-32">
                                                <div class="wg-box gap16">
                                                    <div>
                                                        <div class="title mb-12">
                                                            <div class="label-01">Recent Activity</div>
                                                        </div>
                                                    </div>
                                                    <table class="tab-sell-order">
                                                        <thead>
                                                            <tr>
                                                                <th class="f14-regular text-Gray">Date</th>
                                                                <th class="f14-regular text-Gray">Type</th>
                                                                <th class="f14-regular text-Gray">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="recent-activity">
                                                        </tbody>
                                                    </table>
                                                    <a href="/dashboard.transactions" class="tf-button f12-bold w-100">
                                                        View All
                                                        <i class="icon icon-send"></i>
                                                    </a>
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
    <div id="loader" class="hidden">
        <div class="line-loader">
            <div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>
    <!-- Toast Notifications -->
    <div id="toast-container"></div>
    
<script src="<?= anc_asset('../../assets/js/api.js') ?>" defer></script>
<script src="<?= anc_asset('../../assets/js/jquery.min.js') ?>"></script>
<script src="<?= anc_asset('../../assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= anc_asset('../../assets/js/countto.js') ?>" defer></script>
<script src="<?= anc_asset('../../assets/js/bootstrap-select.min.js') ?>" defer></script>
<script src="<?= anc_asset('../../assets/js/dashboard.js') ?>" defer></script>

<!-- Chart.js CDN -->
<script src="/assets/js/chart.min.js"></script>

<!-- Iconify CDN -->

<script>
async function renderCardUsageChart() {
  const ctx = document.getElementById("cardUsageChart");
  if (!ctx) return;

  try {
    const res = await fetch("/api/backend/card_usage.php");
    const result = await res.json();

    if (!result.success) throw new Error(result.message);

    // 🟢 Use the correct structure from your PHP output
    const data = result.percentages; // not result.data

    // Matches the keys returned by api/backend/card_usage.php
    const labels = ["Weekly", "Monthly", "Wallet"];
    const datasetValues = [
      data.weekly || 0,
      data.monthly || 0,
      data.wallet || 0
    ];
    // Brand orange, a muted brown tint, and a neutral for idle cash.
    const sliceColors = ["#FF6D29", "#A8623C", "#453027"];

    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels,
        datasets: [{
          data: datasetValues,
          backgroundColor: sliceColors,
          borderWidth: 0,
          cutout: "70%"
        }]
      },
      options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
      }
    });

    // ✅ Update the legend dynamically
    const legend = document.querySelector(".chart-legend");
    if (legend) {
      legend.innerHTML = labels.map((label, i) => `
        <li class="flex items-center gap6">
          <div class="dot" style="background-color:${sliceColors[i]}"></div>
          <span>${label}</span> <strong>${datasetValues[i]}%</strong>
        </li>
      `).join("");
    }

  } catch (err) {
    console.error("Chart Load Error:", err);
  }
}

document.addEventListener("DOMContentLoaded", renderCardUsageChart);

</script>

</body>
</html>