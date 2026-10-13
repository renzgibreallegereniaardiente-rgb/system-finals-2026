<?php
require_once 'includes/header.php';

$orders = $_SESSION['orders'];
$totalSales = 0;
$pendingCount = 0;
$readyCount = 0;

foreach ($orders as $o) {
    $totalSales += $o['total_amount'];
    if ($o['status'] === 'pending' || $o['status'] === 'washing') $pendingCount++;
    if ($o['status'] === 'ready') $readyCount++;
}
?>

<div class="card-grid">
    <div class="card">
        <h3>Total Gross Revenue</h3>
        <div class="stat">₱<?= number_format($totalSales, 2) ?></div>
    </div>
    <div class="card">
        <h3>In-Progress Queue</h3>
        <div class="stat"><?= $pendingCount ?></div>
    </div>
    <div class="card">
        <h3>Ready for Pickup</h3>
        <div class="stat"><?= $readyCount ?></div>
    </div>
    <div class="card">
        <h3>Total Orders</h3>
        <div class="stat"><?= count($orders) ?></div>
    </div>
</div>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
    <h2>Recent Laundry Transactions</h2>
    <a href="modules/orders/create.php" style="background:#0284c7; color:white; padding:0.5rem 1rem; border-radius:6px; text-decoration:none; font-weight:600; font-size:0.85rem;">
        <i class="fa-solid fa-plus"></i> New Transaction
    </a>
</div>

<table>
    <thead>
        <tr>
            <th>Tracking #</th>
            <th>Customer Name</th>
            <th>Contact Number</th>
            <th>Service</th>
            <th>Weight</th>
            <th>Total Bill</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $o): ?>
            <tr>
                <td><strong><?= $o['tracking_number'] ?></strong></td>
                <td><?= htmlspecialchars($o['customer_name']) ?></td>
                <td><?= htmlspecialchars($o['phone']) ?></td>
                <td><?= htmlspecialchars($o['service']) ?></td>
                <td><?= $o['weight'] ?> kg</td>
                <td>₱<?= number_format($o['total_amount'], 2) ?></td>
                <td><span class="badge <?= $o['status'] ?>"><?= strtoupper(str_replace('_', ' ', $o['status'])) ?></span></td>
                <td><?= date('M d, g:i A', strtotime($o['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'includes/footer.php'; ?>