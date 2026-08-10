<?php
$pageTitle = 'Suppliers';
include __DIR__ . '/partials/header.php';
?>
<section class="actions-row">
    <button type="button" class="button primary">Add New Supplier</button>
</section>
<div class="card">
    <div class="card-header">
        <h2>Supplier Directory</h2>
    </div>
    <table class="table-list">
        <thead>
            <tr>
                <th>Supplier</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>KK Food Trading</td>
                <td>En. Rafi</td>
                <td>019-876 5432</td>
                <td>rafi@kkfood.my</td>
                <td>Shah Alam, Selangor</td>
            </tr>
            <tr>
                <td>FreshCare Supplies</td>
                <td>Puan Lina</td>
                <td>017-112 2334</td>
                <td>lina@freshcare.my</td>
                <td>Subang Jaya, Selangor</td>
            </tr>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
