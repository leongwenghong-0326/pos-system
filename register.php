<?php
session_start();
$showError = isset($_GET['error']);
$success = isset($_GET['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MiniMarket POS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <div class="auth-logo">Register Account</div>
            <p class="auth-subtitle">Create your cashier account for MiniMarket POS.</p>
        </div>

        <?php if ($showError): ?>
            <div class="auth-alert"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="auth-alert" style="background:#d1fae5;color:#115e59;">Registration successful. You may login now.</div>
        <?php endif; ?>

        <form class="auth-form" action="register-action.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="email@example.com" required>
            </div>
            <div class="form-group password-group">
                <label for="password">Password</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" placeholder="Create password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">Show</button>
                </div>
            </div>
            <button class="button primary full" type="submit">Register</button>
        </form>

        <div class="auth-footer">
            <a class="link-button" href="login.php">Back to Login</a>
        </div>
    </div>

    <script src="assets/js/auth.js"></script>
</body>
</html>
