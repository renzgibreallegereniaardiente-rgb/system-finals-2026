<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_name'] = $_POST['username'] ?: 'System Admin';
    $_SESSION['user_role'] = 'Counter Operator';
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Terminal Login - La Colada</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #0d1527; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .login-card { background: white; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 380px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .login-card h2 { color: #0f172a; margin-bottom: 0.25rem; font-size: 1.5rem; }
        .login-card p { color: #64748b; font-size: 0.85rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.85rem; color: #0f172a; }
        .form-group input { width: 100%; padding: 0.65rem 0.85rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem; }
        .btn-submit { width: 100%; padding: 0.8rem; background: #0284c7; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>La Colada POS</h2>
        <p>Terminal & Admin Access</p>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="admin" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" value="password123" required>
            </div>
            <button type="submit" class="btn-submit">Login to POS Terminal</button>
        </form>

        <div style="text-align:center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
            <a href="customer/login.php" style="color: #0284c7; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                <i class="fa-solid fa-user"></i> Go to Customer Portal Sign In
            </a>
        </div>
    </div>
</body>
</html>