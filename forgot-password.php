<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | MiniMarket POS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <div class="auth-logo">Forgot Password</div>
            <p class="auth-subtitle">Enter registered email to receive reset code.</p>
        </div>

        <form class="auth-form" action="send-reset.php" method="post">
            <div class="form-group">
                <label for="email">Registered Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
            </div>
            <button class="button primary full" type="submit">Send Reset Code</button>
        </form>

        <div class="auth-footer">
            <a class="link-button" href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
