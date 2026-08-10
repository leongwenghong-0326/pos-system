<?php
session_start();
$showError = isset($_GET['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MiniMarket POS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <div class="auth-logo">MiniMarket POS</div>
            <p class="auth-subtitle">Retail POS for convenience store & mini market</p>
        </div>

        <?php if ($showError): ?>
            <div class="auth-alert">Login failed. Please check credentials.</div>
        <?php endif; ?>

        <form class="auth-form" action="authenticate.php" method="post">
            <div class="form-group">
                <label for="userIdentifier">Username or Email</label>
                <input type="text" id="userIdentifier" name="userIdentifier" placeholder="username@example.com" required>
            </div>
            <div class="form-group password-group">
                <label for="password">Password</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">Show</button>
                </div>
            </div>
            <div class="form-row split">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a class="link-button" href="forgot-password.php">Forgot password?</a>
            </div>
            <button class="button primary full" type="submit">Login</button>
        </form>
        <div class="auth-footer">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>

        <div class="auth-footer">
            <p>Built for Malaysian retail, RM currency, DuitNow, eWallet-ready.</p>
        </div>
    </div>

    <script src="assets/js/auth.js"></script>
</body>
</html>
