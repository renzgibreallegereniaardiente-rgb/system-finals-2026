<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calculate base URL dynamically so paths work in any folder name
$script_path = $_SERVER['SCRIPT_NAME'];
$project_folder = explode('/', trim($script_path, '/'))[0];
$base_url = '/' . $project_folder . '/';

// Initialize empty session data store (No default example customers)
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

// Default staff session info
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = 'System Admin';
    $_SESSION['user_role'] = 'Counter Staff';
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Colada Laundry POS & Management System</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="logo-icon">L</div>
                <span class="logo-text">LaColada POS</span>
            </div>

            <nav class="sidebar-nav">
                <a href="<?= $base_url ?>index.php" class="<?= ($current_page === 'index.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= $base_url ?>modules/orders/create.php" class="<?= ($current_page === 'create.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Service Counter</span>
                </a>
                <a href="<?= $base_url ?>modules/orders/tracking.php" class="<?= ($current_page === 'tracking.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Order Tracking</span>
                </a>
                <a href="<?= $base_url ?>modules/customers/index.php" class="<?= (strpos($script_path, '/customers/') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-users"></i>
                    <span>Customers</span>
                </a>
                <a href="<?= $base_url ?>modules/billing/process.php" class="<?= (strpos($script_path, '/billing/') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>Billing & Receipts</span>
                </a>

                <!-- Quick Switch Link to Customer Portal -->
                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <a href="<?= $base_url ?>customer/login.php" style="color: #38bdf8; font-weight: 600;">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Customer Portal</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-user">
                <div class="avatar"><?= strtoupper(substr($_SESSION['user_name'], 0, 2)) ?></div>
                <div class="user-info">
                    <span class="name"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <span class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
                </div>
                <a href="<?= $base_url ?>login.php" title="Logout" style="color: #ef4444; margin-left: auto; text-decoration:none;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-wrapper">
            <header class="top-bar">
                <div class="page-header-info">
                    <h2>POS Terminal & Management System</h2>
                    <p>Register orders, track processing stages, and manage claims.</p>
                </div>
                <div class="terminal-status">
                    <span class="status-dot"></span> Terminal #01 Active
                </div>
            </header>
            <main class="content-area">