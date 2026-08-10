<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
$role = $user['role'] ?? 'cashier';
function navItem($href, $label, $show = true) {
    if (!$show) return;
    $hrefEsc = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
    $labelEsc = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $isActive = basename($_SERVER['PHP_SELF']) === $href;
    $active = $isActive ? 'active' : '';
    $aria = $isActive ? ' aria-current="page"' : '';
    echo "<a class=\"nav-item $active\" href=\"$hrefEsc\"$aria>$labelEsc</a>\n";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniMarket POS</title>
    <script>
        (function() {
            try {
                const theme = localStorage.getItem('posTheme');
                if (theme === 'dark') {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            } catch (e) {
                console.warn('Theme init failed', e);
            }
        })();
    </script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-logo">MiniMarket POS</div>
                <div class="brand-subtitle">Retail & Convenience</div>
            </div>
            <nav class="nav-menu" role="navigation" aria-label="Main navigation">
                <?php navItem('index.php', 'Dashboard'); ?>
                <?php navItem('sales.php', 'Sales Management', $role === 'admin'); ?>
                <?php navItem('products.php', 'Product Management', $role === 'admin'); ?>
                <?php navItem('inventory.php', 'Inventory', $role === 'admin'); ?>
                <?php navItem('customers.php', 'Customers', $role === 'admin'); ?>
                <?php navItem('suppliers.php', 'Suppliers', $role === 'admin'); ?>
                <?php navItem('reports.php', 'Reports', $role === 'admin'); ?>
                <?php navItem('users.php', 'Users', $role === 'admin'); ?>
                <?php navItem('settings.php', 'Settings', $role === 'admin'); ?>
                <?php if ($role !== 'admin'): ?>
                    <?php navItem('pos.php', 'POS Counter'); ?>
                    <?php navItem('history.php', 'Sales History'); ?>
                <?php endif; ?>
            </nav>
            <div class="sidebar-footer">
                <div class="profile-card">
                    <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="profile-role"><?php echo ucfirst(htmlspecialchars($role)); ?></div>
                </div>
                <a class="button secondary" href="logout.php">Logout</a>
            </div>
        </aside>
        <main id="main" class="main-content">
            <header class="topbar">
                <h1><?php echo htmlspecialchars($pageTitle ?? 'Dashboard'); ?></h1>
                <div class="topbar-actions">
                    <button class="button icon-button" onclick="toggleTheme()">Toggle Theme</button>
                </div>
            </header>
