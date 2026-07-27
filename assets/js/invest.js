/* =======================================================
   invest.js — Aldernorth Capital invest page

   One product: a lump sum into a plan that pays out weekly or
   monthly. The cadence toggle filters the plan list; the preview
   panel is computed server-side (action: 'preview') so the figures
   shown always match what investment_cron.php will credit.
   ======================================================= */

document.addEventListener('DOMContentLoaded', function () {
  // === DOM ELEMENTS ===
  const walletBalanceEl = document.getElementById('wallet-balance');
  const planSelect = document.getElementById('plan-select');
  const termDuration = document.getElementById('term-duration');
  const expectedRoi = document.getElementById('expected-roi');
  const investBtn = document.getElementById('invest-btn');
  const investForm = document.getElementById('investment-form');

  const cardActive = document.getElementById('card-active-investments');
  const cardROI = document.getElementById('card-total-roi');
  const cardOngoing = document.getElementById('card-ongoing-plans');
  const cardNextPayoutAmt = document.getElementById('card-next-payout-amount');
  const cardNextPayoutDate = document.getElementById('card-next-payout-date');
  const cardPortfolio = document.getElementById('card-portfolio-value');

  // Preview panel
  const previewBox = document.getElementById('invest-preview');
  const prevPerPayout = document.getElementById('prev-per-payout');
  const prevPayouts = document.getElementById('prev-payouts');
  const prevFirst = document.getElementById('prev-first');
  const prevTotalRoi = document.getElementById('prev-total-roi');
  const prevTotalReturn = document.getElementById('prev-total-return');

  // Which cadence the plan list is filtered to. Weekly is the default
  // because it has the lowest minimum.
  let activeCadence = 'weekly';

  const activeTableBody = document.getElementById('active-investments-table-body');
  const maturedTableBody = document.querySelector('.unlock-plans tbody');
  const plansGrid = document.getElementById('plans-grid'); // NEW

  // === INITIAL LOAD ===
  loadSummary();
  loadPlans();
  loadActivePositions();
  loadMaturedPositions();
  wireCadenceToggle();
  wirePreview();

  // === CADENCE TOGGLE ===
  function wireCadenceToggle() {
    const buttons = document.querySelectorAll('.cadence-toggle__btn');
    buttons.forEach(btn => {
      btn.addEventListener('click', function () {
        const cadence = this.getAttribute('data-cadence');
        if (cadence === activeCadence) return;
        activeCadence = cadence;
        buttons.forEach(b => b.classList.toggle('active', b === this));
        // Reset the form: a plan from the other cadence must not stay selected.
        if (planSelect) planSelect.value = '';
        updatePlanDetails();
        loadPlans();
      });
    });
  }

  // === LIVE PREVIEW ===
  // Debounced so typing an amount does not fire a request per keystroke.
  let previewTimer = null;
  function wirePreview() {
    const amountEl = document.getElementById('investment-amount');
    if (!amountEl) return;
    amountEl.addEventListener('input', function () {
      clearTimeout(previewTimer);
      previewTimer = setTimeout(refreshPreview, 300);
    });
  }

  async function refreshPreview() {
    const amountEl = document.getElementById('investment-amount');
    const planId = parseInt(planSelect?.value || 0, 10);
    const amount = parseFloat(amountEl?.value || 0);

    if (!planId || !amount || amount <= 0) {
      if (previewBox) previewBox.hidden = true;
      return;
    }

    const res = await fetchApi('/api/backend/invest.php', {
      action: 'preview', plan_id: planId, amount: amount
    });

    if (res.status !== 'success' || !previewBox) {
      if (previewBox) previewBox.hidden = true;
      return;
    }

    const pv = res.data.preview;
    const period = pv.cadence === 'monthly' ? 'month' : 'week';
    if (prevPerPayout) prevPerPayout.textContent = money(pv.per_payout) + ' / ' + period;
    if (prevPayouts) prevPayouts.textContent = pv.payouts_total;
    if (prevFirst) prevFirst.textContent = formatDate(pv.first_payout_date);
    if (prevTotalRoi) prevTotalRoi.textContent = money(pv.total_roi) + ' (' + pv.effective_percent + '%)';
    if (prevTotalReturn) prevTotalReturn.textContent = money(pv.total_return);

    previewBox.hidden = false;
    // The server is the authority on whether the amount is allowed.
    if (investBtn) investBtn.disabled = !pv.in_range;
  }

  function money(n) {
    return '$' + Number(n || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function formatDate(iso) {
    if (!iso) return '—';
    const d = new Date(iso + 'T00:00:00');
    return isNaN(d) ? iso : d.toLocaleDateString(undefined, { month: 'short', day: '2-digit', year: 'numeric' });
  }

  // === PLAN DETAILS UPDATE ===
  window.updatePlanDetails = function () {
    const selectedOption = planSelect?.options[planSelect.selectedIndex];
    const id = selectedOption ? parseInt(selectedOption.value) : null;

    const amountEl = document.getElementById('investment-amount');
    if (!id) {
      termDuration.value = '';
      expectedRoi.value = '';
      amountEl.placeholder = 'Enter amount';
      amountEl.removeAttribute('min');
      amountEl.removeAttribute('max');
      investBtn.disabled = true;
      if (previewBox) previewBox.hidden = true;
      window.ancRenderPlanPanel && window.ancRenderPlanPanel(null);
      return;
    }

    const cached = window.__anc_plans?.find(p => p.id === id);
    if (cached) {
      const period = cached.cadence === 'monthly' ? 'month' : 'week';
      termDuration.value = termLabel(cached.duration_days);
      expectedRoi.value = cached.roi_percent + '% per ' + period;

      if (cached.min && cached.max) {
        amountEl.min = cached.min;
        amountEl.max = cached.max;
        amountEl.placeholder = `$${cached.min.toLocaleString()} - $${cached.max.toLocaleString()}`;
      }
      investBtn.disabled = false;

      window.ancRenderPlanPanel && window.ancRenderPlanPanel({
        name: cached.title,
        roi: cached.roi_percent + '% per ' + period,
        roiLabel: 'Rate per payout period',
        risk: cached.risk,
        meta: [
          ['Term', termDuration.value],
          ['Payouts', `${cached.payouts_total} x ${cached.roi_percent}%`],
          ['Total return', cached.total_percent + '%'],
          ['Min - Max', (cached.min && cached.max) ? `$${(+cached.min).toLocaleString()} - $${(+cached.max).toLocaleString()}` : ''],
        ],
        summary: cached.summary || cached.description,
      });

      refreshPreview();
      return;
    }

    const dataTerm = selectedOption?.getAttribute('data-term') || '';
    const dataRoi = selectedOption?.getAttribute('data-roi') || '';
    termDuration.value = dataTerm;
    expectedRoi.value = dataRoi;
    investBtn.disabled = !!(!dataTerm || !dataRoi);
  };

  // === SUBMIT INVESTMENT FORM ===
  if (investForm) {
    investForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      investBtn.disabled = true;
      toggleLoader(true);

      const planId = parseInt(planSelect.value);
      const amountEl = document.getElementById('investment-amount');
      const amount = parseFloat(amountEl?.value || 0);

      if (!planId) {
        showToast('Please select an investment plan.', 'error');
        investBtn.disabled = false;
        toggleLoader(false);
        return;
      }

      if (!amount || amount <= 0) {
        showToast('Enter a valid investment amount.', 'error');
        investBtn.disabled = false;
        toggleLoader(false);
        return;
      }

      const selectedPlan = window.__anc_plans?.find(p => p.id === planId);
      if (selectedPlan && selectedPlan.min && selectedPlan.max) {
        const min = parseFloat(selectedPlan.min);
        const max = parseFloat(selectedPlan.max);
        if (amount < min || amount > max) {
          showToast(`Amount must be between $${min.toLocaleString()} and $${max.toLocaleString()}.`, 'error');
          investBtn.disabled = false;
          toggleLoader(false);
          return;
        }
      }

      const res = await fetchApi('/api/backend/invest.php', {
        action: 'start_investment',
        plan_id: planId,
        amount: amount
      });

      toggleLoader(false);
      if (res.status === 'success') {
        showToast('X-Yield started successfully.', 'success');
        loadSummary();
        loadActivePositions();
        loadMaturedPositions();
        amountEl.value = '';
        planSelect.selectedIndex = 0;
        updatePlanDetails();
      } else {
        showToast(res.message || 'Failed to start investment.', 'error');
      }
      investBtn.disabled = false;
    });
  }

  // === SUMMARY CARDS ===
  async function loadSummary() {
    toggleLoader(true);
    const res = await fetchApi('/api/backend/invest.php', { action: 'get_summary' });
    toggleLoader(false);

    if (res.status === 'success') {
      const summary = res.data?.summary || {};
      const wallet = res.data?.wallet || {};

      if (cardActive) cardActive.textContent = '$' + (summary.active_investments_value ?? 0).toFixed(2);
      if (cardROI) cardROI.textContent = '$' + (summary.total_roi ?? 0).toFixed(2);
      if (cardOngoing) cardOngoing.textContent = summary.ongoing_plans_count ?? 0;
      if (cardNextPayoutAmt) cardNextPayoutAmt.textContent = money(summary.next_payout_amount ?? 0);
      if (cardNextPayoutDate) cardNextPayoutDate.textContent = summary.next_payout_date ?? '—';
      if (cardPortfolio) cardPortfolio.textContent = money(summary.portfolio_value ?? 0);
      if (walletBalanceEl) walletBalanceEl.textContent = '$' + (wallet.balance ?? 0).toFixed(2);
    }
  }

  // === LOAD PLANS ===
  async function loadPlans() {
    const res = await fetchApi('/api/backend/invest.php', { action: 'get_plans', cadence: activeCadence });
    if (res.status === 'success') {
      const plans = res.data?.plans || [];
      window.__anc_plans = plans;

      // Populate SELECT
      if (planSelect) {
        const firstOption = planSelect.querySelector('option:first-child');
        planSelect.innerHTML = '';
        if (firstOption) planSelect.appendChild(firstOption);

        plans.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p.id;
          opt.textContent = `${p.title} — ${p.roi_percent}% per ${p.cadence === 'monthly' ? 'month' : 'week'}`;
          opt.setAttribute('data-term', termLabel(p.duration_days));
          opt.setAttribute('data-roi', p.roi_percent + '% per ' + (p.cadence === 'monthly' ? 'month' : 'week'));
          planSelect.appendChild(opt);
        });

        planSelect.addEventListener('change', updatePlanDetails);
      }

// Render Dynamic Cards
if (plansGrid) {
  plansGrid.innerHTML = '';
  plans.forEach(p => {
    const min = parseFloat(p.min).toLocaleString();
    const max = parseFloat(p.max).toLocaleString();
    const period = p.cadence === 'monthly' ? 'month' : 'week';

    const card = document.createElement('div');
    card.className = 'col-lg-4 col-md-6';
    card.innerHTML = `
      <div class="plan-card" onclick="selectPlanFromCard(${p.id})">
        <div class="plan-header flex justify-between items-center mb-12">
          <div class="flex items-center gap-2">
            <i class="ph ${escapeHtml(p.icon || 'ph-chart-line-up')}"></i>
            <h6 class="plan-title">${escapeHtml(p.title)}</h6>
          </div>
          <span class="box-status bg-Primary f12-medium">${escapeHtml(p.cadence)}</span>
        </div>

        <p class="f12-regular text-Gray mb-12">${escapeHtml(p.description)}</p>

        <table class="plan-features">
          <tr><td>Rate</td><td class="text-Green fw-bold">${p.roi_percent}% / ${period}</td></tr>
          <tr><td>Payouts</td><td>${p.payouts_total} x ${p.roi_percent}%</td></tr>
          <tr><td>Total return</td><td class="fw-bold">${p.total_percent}%</td></tr>
          <tr><td>Term</td><td>${escapeHtml(termLabel(p.duration_days))}</td></tr>
          <tr><td>Amount</td><td>$${min} – $${max}</td></tr>
          <tr><td>Risk</td><td>${escapeHtml(p.risk)}</td></tr>
        </table>
      </div>
    `;
    plansGrid.appendChild(card);
  });
}

    } else {
      console.warn('Failed to load plans', res);
    }
  }

  // === LOAD ACTIVE INVESTMENTS ===
  async function loadActivePositions() {
    toggleLoader(true);
    const res = await fetchApi('/api/backend/invest.php', { action: 'get_active' });
    toggleLoader(false);

    if (res.status === 'success') {
      const investments = res.data?.investments || [];
      if (!activeTableBody) return;
      activeTableBody.innerHTML = '';

      investments.forEach(inv => {
        const tr = document.createElement('tr');
        tr.className = 'tf-table-item';
        tr.innerHTML = `
          <td data-label="Plan Name"><div class="f12-medium key-sort">${escapeHtml(inv.plan)}</div></td>
          <td data-label="Amount Invested"><div class="f12-bold key-sort">$${(inv.amount || 0).toFixed(2)}</div></td>
          <td data-label="ROI (%)"><div class="f12-bold text-Green key-sort">${(inv.roi_percent || 0)}%</div></td>
          <td data-label="Term Duration"><div class="f12-medium key-sort">${inv.duration_days} days</div></td>
          <td data-label="Status"><div class="box-status ${inv.status === 'active' ? 'bg-Green' : 'bg-Gray'}"><span class="font-poppins key-sort">${inv.status}</span></div></td>
          <td data-label="Date Started"><div class="f12-medium key-sort">${inv.date_started}</div></td>
        `;
        activeTableBody.appendChild(tr);
      });
    }
  }

  // === LOAD MATURED INVESTMENTS ===
  async function loadMaturedPositions() {
    if (!maturedTableBody) return;
    const res = await fetchApi('/api/backend/invest.php', { action: 'get_matured' });
    if (res.status === 'success') {
      const matured = res.data?.matured || [];
      maturedTableBody.innerHTML = '';

      if (!matured.length) {
        maturedTableBody.innerHTML = `<tr><td colspan="6" class="text-center text-Gray py-3">No mature plans available for unlock at this time.</td></tr>`;
        return;
      }

      matured.forEach(m => {
        const payout = (parseFloat(m.amount) + parseFloat(m.roi_earned || 0)).toFixed(2);
        const tr = document.createElement('tr');
        tr.className = 'tf-table-item';
        tr.innerHTML = `
          <td>${escapeHtml(m.plan_name)}</td>
          <td>$${(m.amount || 0).toFixed(2)}</td>
          <td class="text-Green">$${(m.roi_earned || 0).toFixed(2)}</td>
          <td>${m.maturity_date}</td>
          <td>$${payout}</td>
          <td><button class="tf-button bg-Green text-White f12-regular hover:bg-Primary" onclick="initiateUnlock(${m.id})">Unlock</button></td>
        `;
        maturedTableBody.appendChild(tr);
      });
    }
  }

  // === UNLOCK INVESTMENT ===
  window.initiateUnlock = async function (investmentId) {
    if (!confirm('Unlock this investment?')) return;
    toggleLoader(true);
    const res = await fetchApi('/api/backend/invest.php', { action: 'unlock_investment', investment_id: investmentId });
    toggleLoader(false);

    if (res.status === 'success') {
      showToast('X-Yield unlocked successfully. Wallet credited.', 'success');
      loadSummary();
      loadActivePositions();
      loadMaturedPositions();
    } else {
      showToast(res.message || 'Failed to unlock investment.', 'error');
    }
  };

  // === SELECT FROM CARD ===
  window.selectPlanFromCard = function (planId) {
    if (!planSelect) return;
    planSelect.value = planId;
    updatePlanDetails();
    planSelect.scrollIntoView({ behavior: 'smooth', block: 'center' });
    showToast('Plan selected. Enter your amount to continue.', 'info');
  };

  // === UTILITIES ===
  // Term formatting, shared by the select, the cards and the detail panel.
  function termLabel(days) {
    days = parseInt(days || 0, 10);
    if (days <= 0) return '—';
    if (days % 365 === 0) return (days / 365) + ' year' + (days / 365 > 1 ? 's' : '');
    if (days % 30 === 0) return (days / 30) + ' month' + (days / 30 > 1 ? 's' : '');
    if (days % 7 === 0) return (days / 7) + ' week' + (days / 7 > 1 ? 's' : '');
    return days + ' days';
  }

  function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"'`=\/]/g, function (s) {
      return ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;',
        "'": '&#39;', '/': '&#x2F;', '`': '&#x60;', '=': '&#x3D;'
      })[s];
    });
  }

  function toggleLoader(show = true) {
    const loader = document.getElementById('preload');
    if (!loader) return;
    loader.style.display = show ? 'flex' : 'none';
  }

  // Expose refresh functions globally
  window.hrc_loadSummary = loadSummary;
  window.hrc_loadActivePositions = loadActivePositions;
  window.hrc_loadMaturedPositions = loadMaturedPositions;
  window.hrc_loadPlans = loadPlans;
});
