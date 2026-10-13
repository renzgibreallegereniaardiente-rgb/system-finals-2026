<?php
require_once '../../includes/header.php';
$orders = $_SESSION['orders'];

// Consolidate unique customer records
$customers = [];
foreach ($orders as $o) {
    $customers[$o['phone']] = [
        'name' => $o['customer_name'],
        'phone' => $o['phone'],
        'last_order' => $o['tracking_number']
    ];
}
?>

<h2>Customer Contact Directory</h2>
<p style="color:#64748b; margin-bottom: 1.5rem;">List of registered customers and mobile contact information.</p>

<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Mobile Number</th>
            <th>Latest Tracking #</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $c): ?>
            <tr>
                <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= htmlspecialchars($c['last_order']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../../includes/footer.php'; ?>