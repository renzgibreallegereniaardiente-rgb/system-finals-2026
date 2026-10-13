<?php
require_once '../../includes/header.php';
$orders = $_SESSION['orders'];
?>

<h2>Billing & Digital Claim Stubs</h2>
<p style="color:#64748b; margin-bottom: 1.5rem;">View electronic claim stubs and breakdown of customer fees.</p>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    <?php foreach ($orders as $o): ?>
        <div style="background:white; border: 1px dashed #0284c7; border-radius:10px; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid #e2e8f0; padding-bottom:0.75rem; margin-bottom:0.75rem;">
                <h3 style="color:#0f172a; margin:0;"><?= $o['tracking_number'] ?></h3>
                <span class="badge <?= $o['status'] ?>"><?= strtoupper($o['status']) ?></span>
            </div>
            <p><strong>Customer:</strong> <?= htmlspecialchars($o['customer_name']) ?></p>
            <p><strong>Mobile #:</strong> <?= htmlspecialchars($o['phone']) ?></p>
            <p><strong>Service:</strong> <?= htmlspecialchars($o['service']) ?></p>
            <p><strong>Weight:</strong> <?= $o['weight'] ?> kg</p>
            <div style="margin-top:1rem; padding-top:0.75rem; border-top: 1px solid #e2e8f0; display:flex; justify-content:space-between; font-weight:bold;">
                <span>Total Due:</span>
                <span style="color:#0284c7; font-size:1.1rem;">₱<?= number_format($o['total_amount'], 2) ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>