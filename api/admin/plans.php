<?php
// FILE: /api/admin/funds.php
// ============================================================
// PURPOSE: Manage Investment Plans and Active Investments (Admin View)
// Handles: Metrics, Plan CRUD, Plan List, Active Investment List (Paginated)
// ============================================================

session_start();
header('Content-Type: application/json');

// Ensure only authenticated admins can access this script
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit;
}

require_once '../../config/database.php';

try {
    $pdo = getPDO();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

/**
 * Helper function to execute a prepared statement and return result set.
 */
function executeQuery($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Database Error in admin/funds.php: " . $e->getMessage());
        return false;
    }
}

// --- Metric Fetcher ---
function fetchInvestmentMetrics($pdo) {
    $metrics = [
        'total_active_invest' => 0.00,
        'total_roi_paid' => 0.00,
        'ongoing_plans_count' => 0,
        'next_maturity' => '—',
        'next_payout' => '—',
        'total_plans' => 0,
    ];

    try {
        // Investment Summary Metrics
        $stmt = executeQuery($pdo, "
            SELECT 
                COALESCE(SUM(CASE WHEN status = 'active' THEN amount ELSE 0 END), 0) AS total_active,
                COALESCE(SUM(CASE WHEN status = 'completed' THEN roi_earned ELSE 0 END), 0) AS total_roi_paid,
                COUNT(DISTINCT user_id) AS ongoing_users,
                MIN(CASE WHEN status = 'active' AND maturity_date >= CURDATE() THEN maturity_date ELSE NULL END) AS next_maturity 
            FROM investments
        ");
        $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

        if ($row) {
            $metrics['total_active_invest'] = (float)$row['total_active'];
            // Total ROI Paid includes all roi_earned on completed investments
            $metrics['total_roi_paid'] = (float)$row['total_roi_paid'];
            // Ongoing Plans is counted as unique users with active investments
            $metrics['ongoing_plans_count'] = (int)$row['ongoing_users']; 
            $metrics['next_maturity'] = $row['next_maturity'] ? date('M d, Y', strtotime($row['next_maturity'])) : '—';
        }

        // Total Plans Count
        $metrics['total_plans'] = $pdo->query("SELECT COUNT(id) FROM plans")->fetchColumn() ?? 0;

        // ROI actually credited by the cron, across every position.
        $metrics['total_roi_paid'] = (float) ($pdo->query("SELECT COALESCE(SUM(roi_earned), 0) FROM investments")->fetchColumn() ?? 0);

        // Next scheduled payout run.
        $np = $pdo->query("SELECT MIN(next_payout_date) FROM investments WHERE status = 'active'")->fetchColumn();
        $metrics['next_payout'] = $np ? date('M d, Y', strtotime($np)) : '—';

    } catch (PDOException $e) {
        error_log("Investment Metric Fetch Error: " . $e->getMessage());
    }

    return $metrics;
}

// --- Investment Plans Fetcher ---
function fetchPlans($pdo) {
    $sql = "SELECT id, title, cadence, roi_percent, duration_days, min_amount, max_amount,
                   risk, status, icon, description, summary, details, created_at
            FROM plans
            ORDER BY cadence DESC, min_amount ASC";

    $stmt = executeQuery($pdo, $sql);
    $plans = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    return array_map(function ($p) {
        $roi     = (float) $p['roi_percent'];
        $days    = (int) $p['duration_days'];
        $cadence = $p['cadence'];

        // Whole payout periods in the term — same rule as api/backend/invest.php.
        $periodDays = $cadence === 'monthly' ? 30 : 7;
        $payouts    = (int) floor($days / $periodDays);

        if ($days >= 365 && $days % 365 === 0) {
            $term_display = ($days / 365) . ' Year(s)';
        } elseif ($days >= 30 && $days % 30 === 0) {
            $term_display = ($days / 30) . ' Month(s)';
        } elseif ($days >= 7 && $days % 7 === 0) {
            $term_display = ($days / 7) . ' Week(s)';
        } else {
            $term_display = $days . ' Days';
        }

        return [
            'id'             => (int) $p['id'],
            'title'          => htmlspecialchars($p['title']),
            'cadence'        => $cadence,
            'cadence_label'  => ucfirst($cadence),
            'roi_percent'    => $roi,
            'roi_display'    => rtrim(rtrim(number_format($roi, 2, '.', ''), '0'), '.') . '% per ' . ($cadence === 'monthly' ? 'month' : 'week'),
            'payouts_total'  => $payouts,
            'total_percent'  => round($roi * $payouts, 2),
            'duration_days'  => $days,
            'term_display'   => $term_display,
            'min_amount'     => (float) $p['min_amount'],
            'max_amount'     => (float) $p['max_amount'],
            'risk'           => ucfirst(htmlspecialchars($p['risk'])),
            'status'         => $p['status'],
            'icon'           => $p['icon'],
            'description'    => htmlspecialchars($p['description']),
            'summary'        => htmlspecialchars($p['summary']),
            'details'        => htmlspecialchars($p['details']),
            'created_at'     => date('Y-m-d', strtotime($p['created_at'])),
        ];
    }, $plans);
}

// --- Active Investments Fetcher (Paginated) ---
function fetchActiveInvestments($pdo, $page = 1, $perPage = 10, $search = '') {
    
    $sql = "FROM investments i
            JOIN users u ON i.user_id = u.id
            WHERE i.status = 'active'";
    $params = [];
    
    // Apply search
    if (!empty($search)) {
        $searchWild = "%$search%";
        // Search by user name, user email, or plan name
        $sql .= " AND (u.full_name LIKE :s OR u.email LIKE :s OR i.plan_name LIKE :s)";
        $params[':s'] = $searchWild;
    }

    // 1. Count Total Records
    $countStmt = executeQuery($pdo, "SELECT COUNT(i.id) " . $sql, $params);
    $total = $countStmt ? (int)$countStmt->fetchColumn() : 0;

    $totalPages = max(1, ceil($total / $perPage));
    $offset = ($page - 1) * $perPage;
    $limitSql = " LIMIT " . $perPage . " OFFSET " . $offset;

    // 2. Fetch Active Investments (Paginated)
    $dataSql = "SELECT 
                    i.id,
                    i.plan_name,
                    i.amount,
                    i.roi_percent,
                    i.duration_days,
                    i.status,
                    i.maturity_date,
                    i.created_at,
                    COALESCE(u.full_name, u.name) AS user_name,
                    u.email AS user_email,
                    u.id AS user_id
                " . $sql . " 
                ORDER BY i.created_at DESC" . $limitSql;

    $stmt = executeQuery($pdo, $dataSql, $params);
    $rows = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    
    $formatted = array_map(fn($r) => [
        'id' => (int)$r['id'],
        'user_id' => (int)$r['user_id'],
        'user_name' => htmlspecialchars($r['user_name']),
        'user_email' => htmlspecialchars($r['user_email']),
        'plan_name' => htmlspecialchars($r['plan_name']),
        'amount' => (float)number_format((float)$r['amount'], 2, '.', ''),
        'roi_percent' => (float)$r['roi_percent'],
        'duration_days' => (int)$r['duration_days'],
        'status' => htmlspecialchars($r['status']),
        'date_started' => date('Y-m-d', strtotime($r['created_at'])),
        'maturity_date' => $r['maturity_date'] ? date('Y-m-d', strtotime($r['maturity_date'])) : 'N/A'
    ], $rows);
    
    return [
        'investments' => $formatted,
        'current_page' => $page,
        'total_pages' => $totalPages
    ];
}

// --- POST / Management Handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST ?: $_GET;
    $action = strtolower(trim($input['action'] ?? ''));

    if ($action === 'add_plan' || $action === 'edit_plan') {
        $title = trim($input['title'] ?? '');
        $min_amount  = (float) ($input['min_amount'] ?? 0);
        $max_amount  = (float) ($input['max_amount'] ?? 0);
        $roi_percent = (float) ($input['roi_percent'] ?? 0);   // PER PAYOUT PERIOD
        $duration    = (int)   ($input['duration'] ?? 0);
        $cadence     = strtolower(trim($input['cadence'] ?? 'monthly'));
        $risk        = trim($input['risk'] ?? 'Low');
        $status      = strtolower(trim($input['status'] ?? 'active'));
        $id          = (int)   ($input['id'] ?? 0);

        // --- Required fields validation ---
        if ($title === '' || $duration <= 0 || $min_amount <= 0 || $max_amount <= 0
            || $roi_percent <= 0 || $min_amount > $max_amount) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or missing required data (title, cadence, duration, ROI, min/max amounts).']);
            exit;
        }
        if (!in_array($cadence, ['weekly', 'monthly'], true)) {
            echo json_encode(['status' => 'error', 'message' => 'Cadence must be weekly or monthly.']);
            exit;
        }
        if (!in_array($status, ['active', 'hidden'], true)) {
            $status = 'active';
        }

        // A term shorter than one payout period would never pay out.
        $periodDays = $cadence === 'monthly' ? 30 : 7;
        if ($duration < $periodDays) {
            echo json_encode(['status' => 'error', 'message' => "A {$cadence} plan needs a term of at least {$periodDays} days."]);
            exit;
        }

        // Defaults for NOT NULL copy fields not exposed in the modal
        $description = trim($input['description'] ?? '') ?: 'Investment plan.';
        $details     = trim($input['details'] ?? '')     ?: 'Detailed plan terms.';
        $summary     = trim($input['summary'] ?? '')     ?: 'Summary of the plan.';
        $icon        = trim($input['icon'] ?? '')        ?: 'ph-chart-line-up';
        $accent      = trim($input['accent'] ?? '')      ?: 'orange';

        try {
            if ($action === 'add_plan') {
                $sql = "INSERT INTO plans
                        (title, cadence, roi_percent, duration_days, min_amount, max_amount,
                         risk, description, details, summary, icon, accent, status)
                        VALUES (:title, :cadence, :roi_percent, :duration, :min_amount, :max_amount,
                                :risk, :description, :details, :summary, :icon, :accent, :status)";
                $params = [
                    ':title'       => $title,
                    ':cadence'     => $cadence,
                    ':roi_percent' => $roi_percent,
                    ':duration'    => $duration,
                    ':min_amount'  => $min_amount,
                    ':max_amount'  => $max_amount,
                    ':risk'        => $risk,
                    ':description' => $description,
                    ':details'     => $details,
                    ':summary'     => $summary,
                    ':icon'        => $icon,
                    ':accent'      => $accent,
                    ':status'      => $status,
                ];
                $stmt = executeQuery($pdo, $sql, $params);

                echo json_encode($stmt
                    ? ['status' => 'success', 'message' => 'New investment plan created successfully.']
                    : ['status' => 'error', 'message' => 'Failed to create plan.']);

            } elseif ($action === 'edit_plan') {
                if ($id <= 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid plan ID for edit.']);
                    exit;
                }

                // Editing a plan never touches live positions: investments snapshot
                // their own plan_name / cadence / roi_percent / duration at purchase.
                $sql = "UPDATE plans SET
                            title         = :title,
                            cadence       = :cadence,
                            roi_percent   = :roi_percent,
                            duration_days = :duration,
                            min_amount    = :min_amount,
                            max_amount    = :max_amount,
                            risk          = :risk,
                            description   = :description,
                            details       = :details,
                            summary       = :summary,
                            icon          = :icon,
                            accent        = :accent,
                            status        = :status
                        WHERE id = :id";
                $params = [
                    ':title'       => $title,
                    ':cadence'     => $cadence,
                    ':roi_percent' => $roi_percent,
                    ':duration'    => $duration,
                    ':min_amount'  => $min_amount,
                    ':max_amount'  => $max_amount,
                    ':risk'        => $risk,
                    ':description' => $description,
                    ':details'     => $details,
                    ':summary'     => $summary,
                    ':icon'        => $icon,
                    ':accent'      => $accent,
                    ':status'      => $status,
                    ':id'          => $id,
                ];
                $stmt = executeQuery($pdo, $sql, $params);

                echo json_encode($stmt
                    ? ['status' => 'success', 'message' => 'Investment plan updated successfully.']
                    : ['status' => 'error', 'message' => 'Failed to update plan.']);
            }
        } catch (Exception $e) {
            error_log("Plan Action Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Server error processing plan request.']);
        }
    } elseif ($action === 'edit_investment') {
        $inv_id = (int)($input['id'] ?? 0);
        $amount = (float)($input['amount'] ?? 0);
        $roi_percent = (float)($input['roi_percent'] ?? 0);
        $status = trim($input['status'] ?? '');
        
        if ($inv_id <= 0 || empty($status)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid investment ID or missing status.']);
            exit;
        }

        try {
            $pdo->beginTransaction();

            // 1. Fetch current investment details, especially user_id and old status
            $stmt = executeQuery($pdo, "SELECT user_id, amount, status, roi_earned FROM investments WHERE id = :id FOR UPDATE", [':id' => $inv_id]);
            $inv = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

            if (!$inv) {
                $pdo->rollBack();
                echo json_encode(['status' => 'error', 'message' => 'Investment not found.']);
                exit;
            }
            
            $user_id = (int)$inv['user_id'];
            $old_status = $inv['status'];
            $old_amount = (float)$inv['amount'];

            // 2. Update investment record
            $update_sql = "UPDATE investments SET amount = :amount, roi_percent = :roi_percent, status = :status WHERE id = :id";
            $update_params = [
                ':amount' => number_format($amount, 2, '.', ''), 
                ':roi_percent' => number_format($roi_percent, 2, '.', ''), 
                ':status' => $status, 
                ':id' => $inv_id
            ];
            executeQuery($pdo, $update_sql, $update_params);

            // 3. Handle status change and wallet update (if needed)

            // Case A: Investment manually marked as 'completed'
            if ($status === 'completed' && $old_status !== 'completed') {
                // Calculate final ROI (either the existing roi_earned or the max potential)
                $final_roi_earned = (float)$inv['roi_earned'] ?: round($amount * $roi_percent / 100, 2);
                $total_payout = round($amount + $final_roi_earned, 2);

                // Update investments with final calculated ROI
                executeQuery($pdo, "UPDATE investments SET roi_earned = :roi WHERE id = :id", [':roi' => $final_roi_earned, ':id' => $inv_id]);

                // Credit user wallet (principal + ROI) and update total earnings
                executeQuery($pdo, "UPDATE wallets SET balance = balance + :payout, total_earnings = total_earnings + :roi WHERE user_id = :user_id", 
                             [':payout' => $total_payout, ':roi' => $final_roi_earned, ':user_id' => $user_id]);

                // Create transaction record
                $reference = 'ADMIN-PAYOUT-' . uniqid();
                $details = json_encode(['investment_id' => $inv_id, 'admin_action' => 'manual_completion', 'payout' => $total_payout, 'roi' => $final_roi_earned]);
                executeQuery($pdo, "INSERT INTO transactions (user_id, type, amount, reference, status, details, method, created_at)
                                    VALUES (?, 'investment_payout', ?, ?, 'completed', ?, 'system', NOW())",
                                    [$user_id, $total_payout, $reference, $details]);
                
            } 
            // Case B: Investment manually marked as 'cancelled' (only applies if it was previously 'active')
            elseif ($status === 'cancelled' && $old_status === 'active') {
                // Refund principal amount to user wallet
                executeQuery($pdo, "UPDATE wallets SET balance = balance + :amount, total_investments = total_investments - :amount WHERE user_id = :user_id", 
                             [':amount' => $old_amount, ':user_id' => $user_id]);

                // Create transaction record for the refund
                $reference = 'ADMIN-REFUND-' . uniqid();
                $details = json_encode(['investment_id' => $inv_id, 'admin_action' => 'manual_cancellation', 'refund_amount' => $old_amount]);
                executeQuery($pdo, "INSERT INTO transactions (user_id, type, amount, reference, status, details, method, created_at)
                                    VALUES (?, 'investment_refund', ?, ?, 'completed', ?, 'system', NOW())",
                                    [$user_id, $old_amount, $reference, $details]);
            }
            
            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => "Investment ID {$inv_id} updated successfully. Wallet adjusted for status change from {$old_status} to {$status}."]);

        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log("Edit Investment Action Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Server error processing investment update.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid POST action specified.']);
    }
    exit;
}


// --- GET Requests (Initial Load, Search, Filter, Single Data Fetch) ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $input = array_merge($_GET, $_POST); 
    $search = trim($input['search'] ?? '');
    $active_page = max(1, (int)($input['active_page'] ?? 1));
    $per_page = 10; 

    // Case 1: Fetch a single plan's details for editing
    if (isset($input['fetch']) && $input['fetch'] === 'plan_details') {
        $plan_id = (int)($input['id'] ?? 0);
        // FIX: Removed 'status' from SELECT as it's missing from DDL
        $stmt = executeQuery($pdo, "SELECT id, title, cadence, roi_percent, duration_days, min_amount, max_amount, risk, status, icon, description, summary, details FROM plans WHERE id = :id", [':id' => $plan_id]);
        $plan = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

        if ($plan) {
            $base_roi = (float)$plan['roi_percent'];
            // Re-calculate the display min/max based on the base ROI stored in the DB (for consistency)
            $roi_min = number_format($base_roi * 0.9, 2);
            $roi_max = number_format($base_roi * 1.1, 2);
            
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'id' => (int)$plan['id'],
                    'title' => htmlspecialchars($plan['title']),
                    'min_amount' => (string)number_format((float)$plan['min_amount'], 2, '.', ''),
                    'max_amount' => (string)number_format((float)$plan['max_amount'], 2, '.', ''),
                    'roi_min' => $roi_min,
                    'roi_max' => $roi_max,
                    'duration_days' => (int)$plan['duration_days'],
                    'risk' => htmlspecialchars($plan['risk']),
                    // Hardcoded status for the modal form field value
                    'status' => 'active', 
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Plan not found.']);
        }
        exit;
    }
    
    // Case 2: Fetch a single active investment's details for editing
    if (isset($input['fetch']) && $input['fetch'] === 'investment_details') {
        $inv_id = (int)($input['id'] ?? 0);
        $stmt = executeQuery($pdo, "SELECT i.id, i.plan_name, i.amount, i.roi_percent, i.status, COALESCE(u.full_name, u.name) AS user_name, u.email AS user_email FROM investments i JOIN users u ON i.user_id = u.id WHERE i.id = :id", [':id' => $inv_id]);
        $inv = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

        if ($inv) {
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'id' => (int)$inv['id'],
                    'user_display' => htmlspecialchars($inv['user_name']) . ' (' . htmlspecialchars($inv['user_email']) . ')',
                    'plan_name' => htmlspecialchars($inv['plan_name']),
                    'amount' => (string)number_format((float)$inv['amount'], 2, '.', ''),
                    'roi_percent' => (string)number_format((float)$inv['roi_percent'], 2, '.', ''),
                    'status' => htmlspecialchars($inv['status']),
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Investment not found.']);
        }
        exit;
    }

    // Case 3: Main Dashboard Data Fetch (load_dashboard)
    $metrics = fetchInvestmentMetrics($pdo);
    $plans = fetchPlans($pdo);
    $active_investments = fetchActiveInvestments($pdo, $active_page, $per_page, $search);
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'metrics' => $metrics,
            'plans' => $plans,
            'active_investments' => $active_investments['investments'],
            'active_page' => $active_investments['current_page'],
            'active_total_pages' => $active_investments['total_pages']
        ]
    ]);
    exit;
}

// Default response if no action matched
http_response_code(405);
echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
exit;
?>