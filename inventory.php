<?php
$pageTitle = 'Inventory';
include __DIR__ . '/partials/header.php';
?>
<section class="dashboard-grid">
    <article class="card stats-card">
        <h2>Current Stock Value</h2>
        <p class="stat-value">RM 28,350.00</p>
    </article>
    <article class="card stats-card">
        <h2>Stock In Today</h2>
        <p class="stat-value">RM 2,320.00</p>
    </article>
    <article class="card stats-card low-stock">
        <h2>Low Stock Items</h2>
        <p>5 products below reorder level</p>
    </article>
</section>
<div class="card">
    <div class="card-header">
        <h2>Stock Movement</h2>
    </div>
    <table class="table-list">
        <thead>
            <tr>
                <th>Product</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Reference</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rice 5kg</td>
                <td>Stock In</td>
                <td>50</td>
                <td>PO-1099</td>
                <td>23 Jul 2026</td>
            </tr>
            <tr>
                <td>Instant Noodles</td>
                <td>Stock Out</td>
                <td>20</td>
                <td>POS-2398</td>
                <td>23 Jul 2026</td>
            </tr>
            <tr>
                <td>Hand Soap</td>
                <td>Adjustment</td>
                <td>5</td>
                <td>Audit</td>
                <td>22 Jul 2026</td>
            </tr>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
