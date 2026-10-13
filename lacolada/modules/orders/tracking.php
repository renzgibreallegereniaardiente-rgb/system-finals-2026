<?php
require_once '../../includes/header.php';

$alertMessage = '';

// Handle Re-weigh Action (Update estimated weight to actual weight)
if (isset($_POST['action_reweigh'])) {
    $tracking = $_POST['tracking_number'];
    $new_weight = floatval($_POST['new_weight']);

    foreach ($_SESSION['orders'] as &$order) {
        if ($order['tracking_number'] === $tracking) {
            $order['weight'] = $new_weight;
            $order['total_amount'] = $new_weight * $order['price_per_kg'];
            $alertMessage = "Weight verified for <strong>#{$tracking}</strong>! New weight: <strong>{$new_weight} kg</strong> (Recalculated Total: ₱" . number_format($order['total_amount'], 2) . ")";
            break;
        }
    }
}

// Handle Pipeline Stage Update
if (isset($_POST['action_update'])) {
    $tracking = $_POST['tracking_number'];
    $new_status = $_POST['new_status'];

    foreach ($_SESSION['orders'] as &$order) {
        if ($order['tracking_number'] === $tracking) {
            $order['status'] = $new_status;
            if ($new_status === 'completed') {
                $order['payment_status'] = 'Paid';
                $alertMessage = "Order <strong>#{$tracking}</strong> completed and archived from active tracking.";
            } else {
                $alertMessage = "Status for <strong>#{$tracking}</strong> updated to " . strtoupper(str_replace('_', ' ', $new_status)) . ".";
            }
            break;
        }
    }
}

// Filter out COMPLETED orders so tracking ONLY displays active pipeline queue
$activeOrders = array_filter($_SESSION['orders'], function($o) {
    return ($o['status'] ?? '') !== 'completed';
});
?>

<h2 style="margin-bottom: 0.5rem;">Active Order Tracking & Pipeline</h2>
<p style="color:#64748b; margin-bottom: 1.5rem;">Re-weigh online bookings and update active processing stages.</p>

<?php if ($alertMessage): ?>
    <div style="background:#dcfce7; color:#15803d; padding:0.75rem 1rem; border-radius:6px; margin-bottom:1.5rem; font-size:0.9rem;">
        <i class="fa-solid fa-circle-check"></i> <?= $alertMessage ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Tracking #</th>
            <th>Customer Info</th>
            <th>Service</th>
            <th>Weight Verification</th>
            <th>Total Bill</th>
            <th>Current Stage</th>
            <th>Update Stage</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($activeOrders)): ?>
            <tr><td colspan="7" style="text-align:center; padding: 2rem; color:#64748b;">No active orders in tracking queue.</td></tr>
        <?php else: ?>
            <?php foreach ($activeOrders as $o): ?>
                <tr>
                    <td><strong><?= $o['tracking_number'] ?></strong></td>
                    <td>
                        <strong><?= htmlspecialchars($o['customer_name']) ?></strong><br>
                        <small style="color:#64748b;"><?= htmlspecialchars($o['phone']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($o['service']) ?></td>
                    <td>
                        <!-- Re-weigh Form -->
                        <form method="POST" style="display:flex; align-items:center; gap:0.35rem;">
                            <input type="hidden" name="tracking_number" value="<?= $o['tracking_number'] ?>">
                            <input type="number" step="0.1" name="new_weight" value="<?= $o['weight'] ?>" style="width:70px; padding:0.3rem; border:1px solid #cbd5e1; border-radius:4px; font-size:0.85rem;" required>
                            <span style="font-size:0.85rem;">kg</span>
                            <button type="submit" name="action_reweigh" title="Verify Actual Weight" style="background:#0f172a; color:white; border:none; padding:0.35rem 0.6rem; border-radius:4px; font-size:0.75rem; cursor:pointer;">
                                <i class="fa-solid fa-scale-balanced"></i> Weigh
                            </button>
                        </form>
                    </td>
                    <td><strong style="color:#0284c7;">₱<?= number_format($o['total_amount'], 2) ?></strong></td>
                    <td><span class="badge <?= $o['status'] ?>"><?= strtoupper(str_replace('_', ' ', $o['status'])) ?></span></td>
                    <td>
                        <form method="POST" style="display:flex; gap:0.4rem; align-items:center;">
                            <input type="hidden" name="tracking_number" value="<?= $o['tracking_number'] ?>">
                            <select name="new_status" style="padding:0.35rem; font-size:0.85rem; border-radius:4px;">
                                <option value="pending" <?= $o['status']==='pending'?'selected':'' ?>>Pending</option>
                                <option value="washing" <?= $o['status']==='washing'?'selected':'' ?>>Washing In Progress</option>
                                <option value="ready" <?= $o['status']==='ready'?'selected':'' ?>>Ready for Pickup</option>
                                <option value="completed" <?= $o['status']==='completed'?'selected':'' ?>>Completed / Claimed</option>
                            </select>
                            <button type="submit" name="action_update" style="background:#0284c7; color:white; border:none; padding:0.35rem 0.75rem; border-radius:4px; font-weight:600; cursor:pointer; font-size:0.85rem;">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../../includes/footer.php'; ?>