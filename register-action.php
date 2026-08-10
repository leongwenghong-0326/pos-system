<?php
session_start();
require_once __DIR__ . '/api/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$name || !$username || !$email || !$password) {
    header('Location: register.php?error=' . urlencode('All fields are required.'));
    exit;
}

// Basic validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: register.php?error=' . urlencode('Please enter a valid email address.'));
    exit;
}
if (strlen($password) < 6) {
    header('Location: register.php?error=' . urlencode('Password must be at least 6 characters.'));
    exit;
}

$result = registerUser($name, $username, $email, $password);
if (isset($result['error'])) {
    header('Location: register.php?error=' . urlencode($result['error']));
    exit;
}

header('Location: register.php?success=1');
exit;
