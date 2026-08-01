<?php
// ========================================
// FORGOT PASSWORD HANDLER - Aldernorth Capital
// ========================================

ini_set('display_errors', 0);
error_reporting(0);
ob_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../backend/email.php';
require_once __DIR__ . '/../utilities/security.php';   // rate limiting

ob_clean();
header('Content-Type: application/json; charset=utf-8');

// These four never opened a session - they authenticate with an emailed OTP,
// not a cookie. CSRF verification is session-bound though (the token lives in
// $_SESSION), and the visitor already holds a session from the page that
// rendered the form, so the session is resumed here purely to read it back.
ancSessionStart();
ancCsrfEnforce();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');

if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Email is required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}

try {
    // ✅ Establish database connection
    $pdo = getPDO();

    // Throttle before doing any work. Scope 'reset' is independent of
    // the login buckets, so abuse here cannot lock anyone out of signing in.
    ancEnforceRateLimit($pdo, 'reset', $email);
    ancRecordAttempt($pdo, 'reset', ancClientIp());

    // --- Verify User ---
    $stmt = $pdo->prepare("SELECT id, full_name FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Deliberately NOT reporting whether the account exists.
    //
    // This used to return "No account found with that email", which turns the
    // endpoint into a user-enumeration oracle: anyone could check whether an
    // address has an account here. The response below is now identical either
    // way, and the flow simply stops without sending anything.
    if (!$user) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'If that email has an account, a reset code is on its way.',
            'data'    => new stdClass(),
        ]);
        exit;
    }

    // --- Simple rate limit: 2-minute cooldown ---
    $stmt = $pdo->prepare("SELECT created_at FROM password_resets WHERE user_id = :uid ORDER BY id DESC LIMIT 1");
    $stmt->execute(['uid' => $user['id']]);
    $lastReset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastReset && (time() - strtotime($lastReset['created_at'])) < 120) {
        // Same shape as the unknown-address branch, so timing and wording give
        // nothing away either.
        echo json_encode([
            'status'  => 'success',
            'message' => 'If that email has an account, a reset code is on its way.',
            'data'    => new stdClass(),
        ]);
        exit;
    }

    // --- Generate and store OTP ---
    $otp = random_int(100000, 999999);
    $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // The runtime CREATE TABLE IF NOT EXISTS that used to sit here duplicated
    // the schema in PHP and had already drifted from it - it did not know about
    // otp_attempts. The table is defined in dbschema/aldernorth_create.sql and
    // in dbschema/migrations/2026_07_31_auth_hardening.sql.

    // --- Clean up old OTPs ---
    $pdo->prepare("DELETE FROM password_resets WHERE user_id = :uid")->execute(['uid' => $user['id']]);

    // --- Insert new OTP ---
    $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, otp, expires_at) VALUES (:uid, :otp, :expiry)");
    $stmt->execute(['uid' => $user['id'], 'otp' => $otp, 'expiry' => $expiry]);

    // --- Send OTP Email ---
    sendEmail([
        'to' => $email,
        'template' => 'password_reset',
        'variables' => [
            'user_name' => $user['full_name'] ?? 'User',
            'otp' => $otp,
        ],
    ]);

    // user_id is no longer returned. Combined with a 6-digit OTP it was half
    // of a credential pair being handed to an unauthenticated caller. The
    // reset step looks the account up by email instead.
    echo json_encode([
        'status'  => 'success',
        'message' => 'If that email has an account, a reset code is on its way.',
        'data'    => new stdClass(),
    ]);

} catch (Exception $e) {
    error_log("Forgot Password Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong, please try again later.']);
}
?>
