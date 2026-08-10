<?php
$pageTitle = 'Users';
include __DIR__ . '/partials/header.php';
?>
<section class="actions-row">
    <button type="button" class="button primary">Add New User</button>
</section>
<div class="card">
    <div class="card-header">
        <h2>User Accounts</h2>
    </div>
    <table class="table-list">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Admin User</td>
                <td>admin</td>
                <td>Admin</td>
                <td><span class="status success">Active</span></td>
            </tr>
            <tr>
                <td>Cashier Rina</td>
                <td>rina</td>
                <td>Cashier</td>
                <td><span class="status success">Active</span></td>
            </tr>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
