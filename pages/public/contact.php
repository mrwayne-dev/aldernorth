<?php
$page_title = 'Contact | Aldernorth Capital';
$page_description = 'Get in touch with Aldernorth Capital. Open an account, ask how the plans work, or discuss a partnership.';
$page_path = '/contact';
$nav_variant = 'solid';
include __DIR__ . '/_partials/head.php';
?>
<body class="anc-redesign">

<?php include __DIR__ . '/_partials/navbar.php'; ?>

<!-- =================== INTRO =================== -->
<section class="section section--warm" style="padding-top: var(--space-20);">
  <div class="container">
    <div class="section-header section-header--center" style="margin: 0 auto;">
      <p class="eyebrow"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Contact</p>
      <h1 style="font-size: var(--text-h1); line-height: var(--lh-h1); letter-spacing: var(--tracking-h1); font-weight: var(--fw-regular);">Let's talk.</h1>
      <p class="section-header__body" style="max-width: 600px;">
        Our team is based in the United States and works alongside compliance, banking, and audit partners. Whether you're looking to open an account, discuss a partnership, or ask about how the plans work, we're happy to help.
      </p>
    </div>
  </div>
</section>

<!-- =================== FORM + INFO =================== -->
<section class="section section--white">
  <div class="container">
    <div class="grid-2" style="gap: var(--space-10); align-items: flex-start;">
      <!-- Form -->
      <div class="form-card form-card--wide" style="margin: 0;">
        <?php // Was action="/contact/submit" as a native POST. That path matched no
              // rewrite rule, so every submission fell through to the 404 page and the
              // message was lost. Submitted with fetch + FormData now, like the rest
              // of the site. ?>
        <form class="form-stack" id="contact-form" enctype="multipart/form-data" novalidate>
          <?php // Honeypot. Off-screen rather than display:none, which some bots
                // check for. Real people never see or fill it; api/public/contact.php
                // answers a filled one with the ordinary success shape. ?>
          <div aria-hidden="true" style="position:absolute; left:-9999px; width:1px; height:1px; overflow:hidden;">
            <label for="company_website">Company website</label>
            <input id="company_website" name="company_website" type="text" tabindex="-1" autocomplete="off">
          </div>

          <div class="form-row">
            <div class="form-field">
              <label class="form-field__label" for="name">Full name</label>
              <input id="name" name="name" type="text" class="form-field__input" placeholder="Jane Doe" required>
            </div>
            <div class="form-field">
              <label class="form-field__label" for="email">Email</label>
              <input id="email" name="email" type="email" class="form-field__input" placeholder="you@example.com" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-field">
              <label class="form-field__label" for="type">Message type</label>
              <select id="type" name="type" class="form-field__input" required>
                <option value="" disabled selected>Select...</option>
                <option value="general">General enquiry</option>
                <option value="services">Services</option>
                <option value="support">Support</option>
                <option value="feedback">Feedback</option>
                <option value="partnership">Partnership</option>
              </select>
            </div>
            <div class="form-field">
              <label class="form-field__label" for="service">Role / interest <span style="color: var(--color-ink-muted); font-weight: 400;">(optional)</span></label>
              <select id="service" name="service" class="form-field__input">
                <option value="">Select...</option>
                <option value="prospect">Prospective member</option>
                <option value="member">Existing member</option>
                <option value="press">Press / media</option>
                <option value="partner">Partner / integration</option>
                <option value="compliance">Compliance / legal</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>

          <div class="form-field">
            <label class="form-field__label" for="subject">Subject</label>
            <input id="subject" name="subject" type="text" class="form-field__input" placeholder="What's this about?" required>
          </div>

          <div class="form-field">
            <label class="form-field__label" for="message">Message</label>
            <textarea id="message" name="message" rows="6" class="form-field__input" placeholder="Tell us more..." required></textarea>
          </div>

          <div class="form-field">
            <label class="form-field__label" for="attachment">Attachment <span style="color: var(--color-ink-muted); font-weight: 400;">(optional)</span></label>
            <input id="attachment" name="attachment" type="file" class="form-field__input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            <p class="form-field__hint">PDF, JPG, PNG or DOC. Max 5&nbsp;MB.</p>
          </div>

          <button type="submit" class="btn btn--primary" id="contact-submit" style="width: 100%;">Send message</button>
          <p class="form-field__hint" id="contact-status" role="status" aria-live="polite"></p>
        </form>
      </div>

      <!-- Info sidebar -->
      <aside style="position: sticky; top: 96px;">
        <p class="eyebrow" style="margin-bottom: var(--space-4);"><span class="eyebrow__icon"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="6"/></svg></span>Direct lines</p>
        <h2 style="margin-bottom: var(--space-5);">Talk to a human.</h2>
        <p style="color: var(--color-ink-muted); margin-bottom: var(--space-6);">
          Existing members can also reach support directly from inside the app. Typical response is under 2 working hours.
        </p>

        <ul style="display: flex; flex-direction: column; gap: var(--space-4);">
          <li style="display: flex; gap: var(--space-3); align-items: flex-start;">
            <span style="width: 32px; height: 32px; border-radius: var(--radius-circle); background: var(--color-surface-warm); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 6h16v12H4z"/><path d="M4 6l8 7 8-7"/></svg>
            </span>
            <div>
              <p style="font-weight: var(--fw-medium); color: var(--color-ink-primary);">support@aldernorthcapital.com</p>
              <p style="font-size: var(--text-sm); color: var(--color-ink-muted);">General enquiries &amp; member support</p>
            </div>
          </li>
          <li style="display: flex; gap: var(--space-3); align-items: flex-start;">
            <span style="width: 32px; height: 32px; border-radius: var(--radius-circle); background: var(--color-surface-warm); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </span>
            <div>
              <p style="font-weight: var(--fw-medium); color: var(--color-ink-primary);">New York, New York</p>
              <p style="font-size: var(--text-sm); color: var(--color-ink-muted);">United States</p>
            </div>
          </li>
        </ul>
      </aside>
    </div>
  </div>
</section>

<?php // #loader and #successModal lived here referencing legacy main.css
      // selectors that no JS ever touched. The form reports inline and via the
      // shared toast instead. ?>
<?php include __DIR__ . '/_partials/footer.php'; ?>

<script src="<?= anc_asset('/assets/js/main.js') ?>" defer></script>
<script src="<?= anc_asset('/assets/js/contact.js') ?>" defer></script>
</body>
</html>
