<?php
// Basic authentication API endpoints for MiniMarket POS.

function getUserFilePath() {
    return __DIR__ . '/../data/users.json';
}

function ensureUserStore() {
    $path = getUserFilePath();
    if (!file_exists($path)) {
        $defaultUsers = [
            [
                'id' => 1,
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@minimarket.local',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'locked' => false,
                'failed_attempts' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Cashier Rina',
                'username' => 'rina',
                'email' => 'rina@minimarket.local',
                'password_hash' => password_hash('cashier123', PASSWORD_DEFAULT),
                'role' => 'cashier',
                'locked' => false,
                'failed_attempts' => 0,
            ],
        ];
        file_put_contents($path, json_encode($defaultUsers, JSON_PRETTY_PRINT), LOCK_EX);
    }
}

function readUsers() {
    ensureUserStore();
    $path = getUserFilePath();
    $json = file_get_contents($path);
    $users = json_decode($json, true);
    if (!is_array($users)) {
        // If the file was corrupted, reset to empty list to avoid warnings
        return [];
    }
    return $users;
}

function saveUsers(array $users) {
    $path = getUserFilePath();
    file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT), LOCK_EX);
}

function findUser($identifier) {
    $id = strtolower(trim($identifier));
    foreach (readUsers() as $user) {
        if (strtolower($user['username']) === $id || strtolower($user['email']) === $id) {
            return $user;
        }
    }
    return null;
}

function findUserIndex($identifier) {
    foreach (readUsers() as $index => $user) {
        if ($user['username'] === $identifier || $user['email'] === $identifier) {
            return $index;
        }
    }
    return null;
}

function recordFailedAttempt(&$user) {
    $user['failed_attempts']++;
    if ($user['failed_attempts'] >= 5) {
        $user['locked'] = true;
    }
    return $user;
}

function authenticateUser($identifier, $password) {
    $user = findUser($identifier);
    if (!$user) {
        return null;
    }

    if ($user['locked']) {
        return ['error' => 'Account locked. Please contact administrator.'];
    }

    if (!password_verify($password, $user['password_hash'])) {
        $user = recordFailedAttempt($user);
        $users = readUsers();
        $idx = findUserIndex($identifier);
        if ($idx !== null) {
            $users[$idx] = $user;
            saveUsers($users);
        }
        return ['error' => 'Invalid credentials.'];
    }

    return $user;
}

function usernameExists($username) {
    foreach (readUsers() as $user) {
        if ($user['username'] === $username) {
            return true;
        }
    }
    return false;
}

function emailExists($email) {
    foreach (readUsers() as $user) {
        if ($user['email'] === $email) {
            return true;
        }
    }
    return false;
}

function registerUser($name, $username, $email, $password) {
    $name = trim($name);
    $username = strtolower(trim($username));
    $email = strtolower(trim($email));

    if (usernameExists($username) || emailExists($email)) {
        return ['error' => 'Username or email already registered.'];
    }

    $users = readUsers();
    $nextId = count($users) ? max(array_column($users, 'id')) + 1 : 1;
    $newUser = [
        'id' => $nextId,
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'cashier',
        'locked' => false,
        'failed_attempts' => 0,
    ];
    $users[] = $newUser;
    saveUsers($users);
    return $newUser;
}
