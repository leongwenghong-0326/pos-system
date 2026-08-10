<?php
$pageTitle = 'Reports';
include __DIR__ . '/partials/header.php';
?>
<section class="dashboard-grid">
    <article class="card stats-card">
        <h2>Daily Sales</h2>
        <p class="stat-value">RM 8,542.00</p>
    </article>
    <article class="card stats-card">
        <h2>Top Product</h2>
        <p class="stat-value">Mineral Water</p>
    </article>
    <article class="card stats-card">
        <h2>Inventory Value</h2>
        <p class="stat-value">RM 28,350.00</p>
    </article>
</section>
<div class="card">
    <div class="card-header">
        <h2>Export Options</h2>
    </div>
    <div class="report-actions">
        <button class="button secondary">Export PDF</button>
        <button class="button secondary">Export Excel</button>
        <button class="button secondary">Export CSV</button>
    </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
