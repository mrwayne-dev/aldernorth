<?php
/**
 * ============================================================
 * Aldernorth Capital - PROCESS WITHDRAWAL ACTION (ADMIN)
 * ============================================================
 * POST: id, action (complete|cancel), [reason]
 * Actions:
 *  - complete = approve and send money (deduction already made)
 *  - cancel = return money to user wallet + notify user
 * Emails: withdrawal_approved, withdrawal_declined
 * ============================================================
 */

require_once("../../config/database.php");
require_once("../../api/utilities/email_temps.php"); 
require_once("../backend/email.php"); // Contains the sendEmail function
require_once("../../api/utilities/helpers.php");
require_once __DIR__ . '/../../api/utilities/security.php';
// Hardened + proxy-aware session cookie (HttpOnly, Secure, SameSite=Strict,
// use_strict_mode). A bare session_start() inherited this box's ini defaults,
// which set NONE of those - see api/utilities/security.php.

ancSessionStart();

// CSRF. Safe methods return immediately; anything else must present the
// session token as X-CSRF-Token (assets/js/api.js sends it on every POST).
ancCsrfEnforce();
header('Content-Type: application/json');

// Admin Auth Check - this endpoint approves/cancels withdrawals and credits wallets.
if (!isset($_SESSION["admin_id"])) {
    logSecurityEvent('unauthorized_admin_access', ['endpoint' => 'process_withdrawal', 'ip' => $_SERVER['REMOTE_ADDR'] ?? '', 'ua' => $_SERVER['HTTP_USER_AGENT'] ?? '']);
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Allow both JSON and form POST
$input = json_decode(file_get_contents("php://input"), true);

$id     = intval($input['id'] ?? ($_POST['id'] ?? 0));
$action = $input['action'] ?? ($_POST['action'] ?? '');
$reason = trim($input['reason'] ?? ($_POST['reason'] ?? ''));

if (!$id || !in_array($action, ['complete', 'cancel'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

try {
    $pdo = getPDO();

    // Role gate: this endpoint approves withdrawals and moves member funds out.
    // Only isset($_SESSION['admin_id']) was checked before, so a `support`
    // admin had exactly the same power here as the owner. Read from the DB,
    // fails closed. See ancRequireAdminRole() in api/utilities/security.php.
    ancRequireAdminRole($pdo, ANC_ROLE_OPERATOR);
    $pdo->beginTransaction();

    // Fetch withdrawal
    $stmt = $pdo->prepare("
        SELECT t.*, u.full_name, u.email 
        FROM transactions t
        JOIN users u ON u.id = t.user_id
        WHERE t.id = ? AND t.type = 'withdraw' AND t.status = 'pending'
        LIMIT 1
    ");
    $stmt->execute([$id]);
    $txn = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$txn) {
        throw new Exception("Withdrawal not found or already processed.");
    }

    $userId  = $txn['user_id'];
    $amount  = floatval($txn['amount']);
    $userEmail = $txn['email'];
    $userName  = $txn['full_name'];
    $reference = $txn['reference'];

    // --------------------------
    // COMPLETE WITHDRAWAL
    // --------------------------
    if ($action === 'complete') {

        // Compare-and-set, as in process_deposit.php. Without `AND status='pending'`
        // a double-submit re-ran the whole branch and sent a second approval mail.
        $update = $pdo->prepare("UPDATE transactions SET status='completed' WHERE id=? AND status='pending'");
        $update->execute([$id]);
        if ($update->rowCount() !== 1) {
            $pdo->rollBack();
            http_response_code(409);
            echo json_encode(['status' => 'error', 'message' => 'That withdrawal is no longer pending.']);
            exit;
        }

        // The funds left the balance at request time and were parked in
        // wallets.pending_withdrawals. Completing has to clear that parking slot;
        // it never did, so the column only ever grew and was useless as a
        // per-user figure.
        $pdo->prepare("UPDATE wallets SET pending_withdrawals = GREATEST(pending_withdrawals - ?, 0) WHERE user_id = ?")
            ->execute([$amount, $userId]);

        // Email Notification
        sendEmail([
            'to' => $userEmail,
            'template' => 'withdrawal_approved',
            'variables' => [
                'user_name' => $userName,
                'amount'    => number_format($amount, 2),
                'method'    => formatPaymentMethod($txn['method']),   // was the raw slug: members read "wallet_address"
                'reference' => $reference
            ]
        ]);

        $pdo->commit();
        echo json_encode(['status' => 'success', 'message' => 'Withdrawal completed']);
        exit;
    }

// --------------------------
// CANCEL WITHDRAWAL
// --------------------------
if ($action === 'cancel') {

    // 1. Flip the status first, under a compare-and-set, so a double-submit
    //    cannot refund the same withdrawal twice.
    $update = $pdo->prepare("UPDATE transactions SET status='failed' WHERE id=? AND status='pending'");
    $update->execute([$id]);
    if ($update->rowCount() !== 1) {
        $pdo->rollBack();
        http_response_code(409);
        echo json_encode(['status' => 'error', 'message' => 'That withdrawal is no longer pending.']);
        exit;
    }

    // 2. Return funds to wallet + release the parked amount.
    $wallet = $pdo->prepare("
        UPDATE wallets 
        SET balance = balance + ?, 
            pending_withdrawals = GREATEST(pending_withdrawals - ?, 0)
        WHERE user_id=?
    ");
    $wallet->execute([$amount, $amount, $userId]);

sendEmail([
    'to' => $userEmail,
    'template' => 'withdrawal_declined',
    'variables' => [
        'user_name' => $userName,
        'amount'    => number_format($amount, 2),
        'reference' => $reference,
        'reason'    => $reason  
    ]
]);


    $pdo->commit();
    echo json_encode(['status' => 'success', 'message' => 'Withdrawal cancelled and funds returned']);
    exit;
}


} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    error_log('process_withdrawal.php: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Could not process the withdrawal. Please try again.']);
}
