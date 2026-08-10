<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$pageTitle = 'Dashboard';
$user = $_SESSION['user'];
$role = $user['role'] ?? 'cashier';
include __DIR__ . '/partials/header.php';
?>

            <section class="dashboard-grid">
                <article class="card stats-card info-card">
                    <h2>Admin Login Demo</h2>
                    <p class="stat-value">admin / admin123</p>
                    <p class="card-note">Admin role with full access for dashboard, product, inventory, and reports.</p>
                </article>
                <article class="card stats-card">
                    <h2>Today's Sales</h2>
                    <p class="stat-value">RM 2,150.00</p>
                </article>
                <article class="card stats-card">
                    <h2>Weekly Sales</h2>
                    <p class="stat-value">RM 14,780.00</p>
                </article>
                <article class="card stats-card">
                    <h2>Monthly Revenue</h2>
                    <p class="stat-value">RM 52,320.00</p>
                </article>
                <article class="card stats-card">
                    <h2>Total Orders</h2>
                    <p class="stat-value">214</p>
                </article>
                <article class="card stats-card">
                    <h2>Total Products</h2>
                    <p class="stat-value">1,248</p>
                </article>
                <article class="card stats-card low-stock">
                    <h2>Low Stock Alerts</h2>
                    <p>8 items need restock</p>
                </article>
            </section>

            <section class="charts-section">
                <div class="card chart-card">
                    <div class="card-header">
                        <h2>Sales Trend</h2>
                        <span>Last 7 days</span>
                    </div>
                    <div class="chart-placeholder">[Chart Placeholder]</div>
                </div>
                <div class="card chart-card">
                    <div class="card-header">
                        <h2>Top Selling Products</h2>
                        <span>Last 30 days</span>
                    </div>
                    <ul class="top-products-list">
                        <li>1. 500ml Mineral Water</li>
                        <li>2. Coffee 3-in-1</li>
                        <li>3. Rice 5kg</li>
                        <li>4. Instant Noodles</li>
                        <li>5. Bread</li>
                    </ul>
                </div>
            </section>

            <section class="recent-section">
                <div class="card">
                    <div class="card-header">
                        <h2>Recent Transactions</h2>
                        <a class="link-button" href="sales.php">View All</a>
                    </div>
                    <table class="table-list">
                        <thead>
                            <tr>
                                <th>Receipt</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#POS-2356</td>
                                <td>Walk-in</td>
                                <td>RM 28.90</td>
                                <td>Cash</td>
                                <td><span class="status success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>#POS-2355</td>
                                <td>Ahmad</td>
                                <td>RM 62.50</td>
                                <td>DuitNow QR</td>
                                <td><span class="status success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>#POS-2354</td>
                                <td>Walk-in</td>
                                <td>RM 15.20</td>
                                <td>Boost</td>
                                <td><span class="status success">Paid</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

<?php include __DIR__ . '/partials/footer.php';
