<?php
session_start();
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

$bookingSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_order'])) {
    $cust_name = trim($_POST['cust_name']);
    $cust_phone = trim($_POST['cust_phone']);
    $service = $_POST['service'];
    $est_weight = floatval($_POST['est_weight']);
    $tracking_number = 'ORD-' . date('Y') . '-' . rand(100, 999);

    $rate = ($service === 'Wash & Press') ? 40 : (($service === 'Dry Clean') ? 60 : 35);
    $total = $est_weight * $rate;

    $newOrder = [
        'id' => count($_SESSION['orders']) + 1,
        'tracking_number' => $tracking_number,
        'customer_name' => $cust_name,
        'phone' => $cust_phone,
        'service' => $service,
        'weight' => $est_weight,
        'price_per_kg' => $rate,
        'total_amount' => $total,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ];

    array_unshift($_SESSION['orders'], $newOrder);
    $bookingSuccess = "Booking submitted! Your tracking code is <strong>#{$tracking_number}</strong>.";
}

$customerName = $_SESSION['customer_name'] ?? 'Maria Santos';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard - La Colada</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background:#f8fafc; padding:2rem; margin:0;">
    <div style="max-width: 900px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
            <div>
                <h2 style="color:#0f172a; margin:0 0 0.25rem 0;">Welcome, <?= htmlspecialchars($customerName) ?>!</h2>
                <p style="color:#64748b; margin:0;">Track your laundry order status or book a new drop-off online.</p>
            </div>
            
            <div style="display:flex; gap:0.5rem; align-items:center;">
                <a href="../index.php" style="padding:0.5rem 1rem; background:#0f172a; color:white; border-radius:6px; text-decoration:none; font-weight:600; font-size:0.85rem;">
                    <i class="fa-solid fa-desktop"></i> Switch to Staff POS
                </a>
                <a href="login.php" style="padding:0.5rem 1rem; background:#ef4444; color:white; border-radius:6px; text-decoration:none; font-weight:600; font-size:0.85rem;">Logout</a>
            </div>
        </div>

        <?php if ($bookingSuccess): ?>
            <div style="background:#dcfce7; color:#15803d; padding:1rem; border-radius:8px; margin-bottom:1.5rem;">
                <?= $bookingSuccess ?>
            </div>
        <?php endif; ?>

        <!-- Online Booking Card -->
        <div style="background:white; padding:1.5rem; border-radius:10px; border:1px solid #e2e8f0; margin-bottom:2rem;">
            <h3 style="color:#0f172a; margin-bottom:1rem;"><i class="fa-solid fa-calendar-plus" style="color:#0284c7;"></i> Book Online Laundry Order</h3>
            <form method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:1rem;">
                <input type="hidden" name="cust_name" value="<?= htmlspecialchars($customerName) ?>">
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.3rem;">Mobile Number</label>
                    <input type="text" name="cust_phone" value="09171234567" required style="width:100%; padding:0.5rem; border:1px solid #e2e8f0; border-radius:6px;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.3rem;">Service Type</label>
                    <select name="service" required style="width:100%; padding:0.5rem; border:1px solid #e2e8f0; border-radius:6px;">
                        <option value="Wash & Fold">Wash & Fold</option>
                        <option value="Wash & Press">Wash & Press</option>
                        <option value="Dry Clean">Dry Clean</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.3rem;">Estimated Weight (kg)</label>
                    <input type="number" step="0.5" name="est_weight" value="5.0" required style="width:100%; padding:0.5rem; border:1px solid #e2e8f0; border-radius:6px;">
                </div>
                <div style="grid-column: 1 / -1;">
                    <button type="submit" name="book_order" style="background:#0284c7; color:white; border:none; padding:0.65rem 1.25rem; border-radius:6px; font-weight:600; cursor:pointer;">
                        Submit Online Order Booking
                    </button>
                </div>
            </form>
        </div>

        <h3 style="color:#0f172a; margin-bottom:1rem;">My Active & Past Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Tracking #</th>
                    <th>Service</th>
                    <th>Weight</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['orders'] as $o): ?>
                    <tr>
                        <td><strong><?= $o['tracking_number'] ?></strong></td>
                        <td><?= htmlspecialchars($o['service']) ?></td>
                        <td><?= $o['weight'] ?> kg</td>
                        <td>₱<?= number_format($o['total_amount'], 2) ?></td>
                        <td><span class="badge <?= $o['status'] ?>"><?= strtoupper($o['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>