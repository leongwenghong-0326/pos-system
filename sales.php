<?php
$pageTitle = 'Sales Management';
include __DIR__ . '/partials/header.php';
?>
<section class="dashboard-grid">
    <article class="card stats-card">
        <h2>Total Sales Today</h2>
        <p class="stat-value">RM 8,542.00</p>
    </article>
    <article class="card stats-card">
        <h2>Pending Orders</h2>
        <p class="stat-value">12</p>
    </article>
    <article class="card stats-card">
        <h2>Average Transaction</h2>
        <p class="stat-value">RM 39.20</p>
    </article>
</section>
<div class="card">
    <div class="card-header">
        <h2>Recent Sales</h2>
    </div>
    <table class="table-list">
        <thead>
            <tr>
                <th>Receipt</th>
                <th>Cashier</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#POS-2402</td>
                <td>Rina</td>
                <td>Walk-in</td>
                <td>RM 45.00</td>
                <td><span class="status success">Paid</span></td>
            </tr>
            <tr>
                <td>#POS-2401</td>
                <td>Rina</td>
                <td>Ahmad</td>
                <td>RM 84.50</td>
                <td><span class="status success">Paid</span></td>
            </tr>
            <tr>
                <td>#POS-2400</td>
                <td>Rina</td>
                <td>Walk-in</td>
                <td>RM 15.20</td>
                <td><span class="status success">Paid</span></td>
            </tr>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
