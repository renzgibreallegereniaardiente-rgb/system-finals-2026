<?php
require_once '../../includes/header.php';

// Handle Transaction Confirmation Action
$alertMessage = '';
if (isset($_POST['action_confirm_payment'])) {
    $tracking = $_POST['tracking_number'];
    
    foreach ($_SESSION['orders'] as &$order) {
        if ($order['tracking_number'] === $tracking) {
            $order['payment_status'] = 'Paid';
            $order['status'] = 'completed';
            $alertMessage = "Transaction for order <strong>#{$tracking}</strong> confirmed! Marked as PAID & RELEASED.";
            break;
        }
    }
}

$orders = $_SESSION['orders'];
?>

<h2>Billing & Payment Confirmation</h2>
<p style="color:#64748b; margin-bottom: 1.5rem;">Confirm cash payment collection, issue digital receipts, and release orders.</p>

<?php if ($alertMessage): ?>
    <div style="background:#dcfce7; color:#15803d; padding:0.75rem 1rem; border-radius:6px; margin-bottom:1.5rem; font-size:0.9rem;">
        <i class="fa-solid fa-circle-check"></i> <?= $alertMessage ?>
    </div>
<?php endif; ?>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
    <?php if (empty($orders)): ?>
        <div style="grid-column: 1 / -1; background:white; padding:2rem; border-radius:10px; text-align:center; color:#64748b; border:1px solid #e2e8f0;">
            No active transactions to bill. Register an order from the Service Counter first.
        </div>
    <?php else: ?>
        <?php foreach ($orders as $o): 
            $paymentStatus = $o['payment_status'] ?? 'Unpaid';
            $isCompleted = ($o['status'] === 'completed' || $paymentStatus === 'Paid');
        ?>
            <div style="background:white; border: 1px <?= $isCompleted ? 'solid #cbd5e1' : 'dashed #0284c7' ?>; border-radius:10px; padding:1.5rem; display:flex; flex-direction:column; justify-content:space-between;">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid #e2e8f0; padding-bottom:0.75rem; margin-bottom:0.75rem;">
                        <h3 style="color:#0f172a; margin:0;"><?= $o['tracking_number'] ?></h3>
                        <span class="badge <?= $isCompleted ? 'ready' : 'pending' ?>">
                            <?= $isCompleted ? 'PAID & RELEASED' : 'PAYMENT PENDING' ?>
                        </span>
                    </div>
                    <p style="margin-bottom:0.4rem;"><strong>Customer:</strong> <?= htmlspecialchars($o['customer_name']) ?></p>
                    <p style="margin-bottom:0.4rem;"><strong>Mobile #:</strong> <?= htmlspecialchars($o['phone']) ?></p>
                    <p style="margin-bottom:0.4rem;"><strong>Service:</strong> <?= htmlspecialchars($o['service']) ?></p>
                    <p style="margin-bottom:0.4rem;"><strong>Weight:</strong> <?= $o['weight'] ?> kg @ ₱<?= $o['price_per_kg'] ?>/kg</p>
                    <p style="margin-bottom:0.4rem;"><strong>Current Stage:</strong> <span class="badge <?= $o['status'] ?>"><?= strtoupper(str_replace('_', ' ', $o['status'])) ?></span></p>
                </div>

                <div style="margin-top:1rem; padding-top:0.75rem; border-top: 1px solid #e2e8f0;">
                    <div style="display:flex; justify-content:space-between; font-weight:bold; margin-bottom:1rem;">
                        <span>Total Amount Due:</span>
                        <span style="color:#0284c7; font-size:1.15rem;">₱<?= number_format($o['total_amount'], 2) ?></span>
                    </div>

                    <?php if (!$isCompleted): ?>
                        <form method="POST">
                            <input type="hidden" name="tracking_number" value="<?= $o['tracking_number'] ?>">
                            <button type="submit" name="action_confirm_payment" style="width:100%; background:#16a34a; color:white; border:none; padding:0.65rem; border-radius:6px; font-weight:600; cursor:pointer; font-size:0.9rem;" onclick="return confirm('Confirm payment collection of ₱<?= number_format($o['total_amount'], 2) ?> and mark as released?');">
                                <i class="fa-solid fa-circle-check"></i> Confirm Payment & Release
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="text-align:center; background:#f1f5f9; color:#475569; padding:0.5rem; border-radius:6px; font-size:0.85rem; font-weight:600;">
                            <i class="fa-solid fa-receipt"></i> Transaction Finalized
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>