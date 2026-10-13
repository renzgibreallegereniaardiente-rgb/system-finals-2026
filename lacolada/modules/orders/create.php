<?php
require_once '../../includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $service = $_POST['service'];
    $weight = floatval($_POST['weight']);
    $price_per_kg = floatval($_POST['price_per_kg']);
    $total_amount = $weight * $price_per_kg;
    $tracking_number = 'ORD-' . date('Y') . '-' . rand(100, 999);

    $newOrder = [
        'id' => count($_SESSION['orders']) + 1,
        'tracking_number' => $tracking_number,
        'customer_name' => $customer_name,
        'phone' => $phone,
        'service' => $service,
        'weight' => $weight,
        'price_per_kg' => $price_per_kg,
        'total_amount' => $total_amount,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ];

    array_unshift($_SESSION['orders'], $newOrder);
    $message = "Order <strong>#{$tracking_number}</strong> registered successfully!";
}
?>

<div style="max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 10px; border: 1px solid #e2e8f0;">
    <h2>Service Counter — New Order</h2>
    <p style="color:#64748b; margin-bottom: 1.5rem;">Register laundry drop-off and auto-generate tracking stub.</p>

    <?php if ($message): ?>
        <div style="background:#dcfce7; color:#15803d; padding:0.75rem 1rem; border-radius:6px; margin-bottom:1.5rem; font-size:0.9rem;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="customer_name" placeholder="e.g. Maria Santos" required>
        </div>
        <div class="form-group">
            <label>Mobile Number</label>
            <input type="text" name="phone" placeholder="09171234567" required>
        </div>
        <div class="form-group">
            <label>Service Type</label>
            <select name="service" id="service" required onchange="updateRate()">
                <option value="Wash & Fold">Wash & Fold (₱35/kg)</option>
                <option value="Wash & Press">Wash & Press (₱40/kg)</option>
                <option value="Dry Clean">Dry Clean (₱60/kg)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Weight (kg)</label>
            <input type="number" step="0.1" name="weight" id="weight" placeholder="e.g. 5.5" required oninput="calculateTotal()">
        </div>
        <div class="form-group">
            <label>Price Rate (₱ per kg)</label>
            <input type="number" name="price_per_kg" id="rate" value="35" readonly style="background:#f1f5f9;">
        </div>
        <div class="form-group">
            <label>Calculated Total Bill</label>
            <input type="text" id="total_display" value="₱0.00" readonly style="font-weight:bold; color:#0284c7; font-size:1.1rem;">
        </div>
        <button type="submit" class="btn-submit"><i class="fa-solid fa-check"></i> Register Order</button>
    </form>
</div>

<script>
function updateRate() {
    const service = document.getElementById('service').value;
    let rate = 35;
    if (service === 'Wash & Press') rate = 40;
    if (service === 'Dry Clean') rate = 60;
    document.getElementById('rate').value = rate;
    calculateTotal();
}

function calculateTotal() {
    const weight = parseFloat(document.getElementById('weight').value) || 0;
    const rate = parseFloat(document.getElementById('rate').value) || 0;
    const total = weight * rate;
    document.getElementById('total_display').value = '₱' + total.toFixed(2);
}
</script>

<?php require_once '../../includes/footer.php'; ?>