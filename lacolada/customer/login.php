<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['customer_name'] = 'Maria Santos';
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login - La Colada Laundry</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #0d1527; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .auth-card { background: white; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .auth-card h2 { margin-bottom: 0.5rem; font-size: 1.5rem; color: #0f172a; }
        .auth-card p { color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.85rem; color: #0f172a; }
        .form-group input { width: 100%; padding: 0.65rem 0.85rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem; }
        .btn-submit { width: 100%; padding: 0.8rem; background: #0284c7; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2>Customer Sign In</h2>
        <p>Access your laundry status and transaction records.</p>

        <form method="POST">
            <div class="form-group">
                <label>Email or Mobile Number</label>
                <input type="text" name="email" value="09171234567" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" value="password123" required>
            </div>
            <button type="submit" class="btn-submit">Sign In</button>
        </form>

        <div style="text-align:center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
            <a href="../login.php" style="color: #475569; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
                <i class="fa-solid fa-lock"></i> Are you Staff? Go to Staff POS Login
            </a>
        </div>
    </div>
</body>
</html>