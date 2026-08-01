<?php
// ========================================
// ADMIN FORGOT PASSWORD - Aldernorth Capital
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

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Email is required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

try {
    $pdo = getPDO();

    // Throttle before doing any work. Scope 'reset' is independent of
    // the login buckets, so abuse here cannot lock anyone out of signing in.
    ancEnforceRateLimit($pdo, 'reset', $email);
    ancRecordAttempt($pdo, 'reset', ancClientIp());

    // --- Verify Admin ---
    $stmt = $pdo->prepare("SELECT id, full_name FROM admins WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Identical response whether the account exists or not - see the note in
    // forgotpassword.php. "No admin found with that email" was an enumeration
    // oracle, and a worse one here: it confirmed ADMIN accounts specifically.
    if (!$admin) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'If that email has an account, a reset code is on its way.',
            'data'    => new stdClass(),
        ]);
        exit;
    }

    // --- Rate limit ---
    $stmt = $pdo->prepare("SELECT created_at FROM admin_password_resets WHERE admin_id = :aid ORDER BY id DESC LIMIT 1");
    $stmt->execute(['aid' => $admin['id']]);
    $lastReset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastReset && (time() - strtotime($lastReset['created_at'])) < 120) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'If that email has an account, a reset code is on its way.',
            'data'    => new stdClass(),
        ]);
        exit;
    }

    // --- Generate OTP ---
    $otp = random_int(100000, 999999);
    $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // The runtime CREATE TABLE that used to sit here was the ONLY definition of
    // admin_password_resets anywhere - it was absent from
    // dbschema/aldernorth_create.sql, so on a fresh deploy this table appeared
    // only when the first admin reset was attempted, and without otp_attempts.
    // It is now in the schema and in
    // dbschema/migrations/2026_07_31_auth_hardening.sql.

    // --- Clean up old OTPs ---
    $pdo->prepare("DELETE FROM admin_password_resets WHERE admin_id = :aid")->execute(['aid' => $admin['id']]);

    // --- Insert new OTP ---
    $stmt = $pdo->prepare("INSERT INTO admin_password_resets (admin_id, otp, expires_at) VALUES (:aid, :otp, :expiry)");
    $stmt->execute(['aid' => $admin['id'], 'otp' => $otp, 'expiry' => $expiry]);

    // --- Send OTP Email ---
    sendEmail([
        'to' => $email,
        'template' => 'password_reset',
        'variables' => [
            'user_name' => $admin['full_name'] ?? 'Administrator',
            'otp' => $otp,
        ],
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'If that email has an account, a reset code is on its way.',
        // user_id is no longer returned - the reset step looks the account up
        // by email. See the note in forgotpassword.php.
        'data' => new stdClass()
    ]);

} catch (Exception $e) {
    error_log("Admin Forgot Password Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Server error. Try again later.']);
}
?>
