<?php
$pageTitle = 'Customers';
include __DIR__ . '/partials/header.php';
?>
<section class="actions-row">
    <button type="button" class="button primary">Add New Customer</button>
</section>
<div class="card">
    <div class="card-header">
        <h2>Customer List</h2>
    </div>
    <table class="table-list">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Membership</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ahmad Hassan</td>
                <td>012-345 6789</td>
                <td>ahmad@mail.com</td>
                <td>MM-0001</td>
                <td>120</td>
            </tr>
            <tr>
                <td>Siti Aisyah</td>
                <td>013-987 6543</td>
                <td>siti@mail.com</td>
                <td>MM-0002</td>
                <td>85</td>
            </tr>
            <tr>
                <td>Walk-in</td>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td>0</td>
            </tr>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
