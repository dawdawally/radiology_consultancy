<?php

declare(strict_types=1);

function isLoggedIn(): bool
{
    return !empty($_SESSION['admin_id']);
}

function currentUserId(): ?int
{
    return isset($_SESSION['admin_id']) ? (int) $_SESSION['admin_id'] : null;
}

function currentUser(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }
    static $user = null;
    if ($user === null) {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT id, username, email, full_name FROM admin_users WHERE id = ?');
        $stmt->execute([currentUserId()]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        redirect(url('admin/login.php'));
    }
}

function attemptLogin(string $username, string $password): bool
{
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM admin_users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        logActivity('login', 'admin_users', (int) $user['id'], 'Admin logged in');
        return true;
    }
    return false;
}

function logout(): void
{
    if (isLoggedIn()) {
        logActivity('logout', 'admin_users', currentUserId(), 'Admin logged out');
    }
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function changePassword(int $userId, string $currentPassword, string $newPassword): bool
{
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
        return false;
    }

    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $update = $db->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?');
    $update->execute([$hash, $userId]);
    logActivity('update', 'admin_users', $userId, 'Password changed');
    return true;
}
