<?php
$pageTitle = 'Sales History';
include __DIR__ . '/partials/header.php';
?>
<div class="card">
    <div class="card-header">
        <h2>My Transactions</h2>
    </div>
    <table class="table-list">
        <thead>
            <tr>
                <th>Receipt</th>
                <th>Date</th>
                <th>Total</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#POS-2399</td>
                <td>23 Jul 2026</td>
                <td>RM 45.00</td>
                <td>Cash</td>
            </tr>
            <tr>
                <td>#POS-2398</td>
                <td>23 Jul 2026</td>
                <td>RM 28.90</td>
                <td>Boost</td>
            </tr>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
