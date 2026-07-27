<?php
// ========================================
// GLOBAL CONSTANTS — Aldernorth Capital Platform
// ========================================

define('APP_NAME',     'Aldernorth Capital');
define('APP_SHORT',    'ANC');
// APP_URL is defined in config/env.php (sourced from .env) so the .env value
// is authoritative regardless of include order. Guarded fallback in case a
// caller pulls in constants.php without env.php.
if (!defined('APP_URL')) define('APP_URL', 'https://aldernorthcapital.com');
define('APP_TAGLINE',  'Own More. Hold Stronger. Grow Faster.');
define('APP_AFFILIATE','Tesla');
define('CURRENCY',     'USD');
define('TIMEZONE',     'America/New_York');
define('OTP_EXPIRY_MINUTES', 10);
define('MAX_WITHDRAWAL_ATTEMPTS', 3);

// Business Timings / System
date_default_timezone_set(TIMEZONE);
?>
