<?php
/**
 * Các hàm tiện ích kiểm tra session & phân quyền.
 * Được require từ index.php sau khi session_start().
 */

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /index.php?page=login');
        exit;
    }
}

function requireRole(string $role): void
{
    if (($_SESSION['role'] ?? '') !== $role) {
        http_response_code(403);
        die('Bạn không có quyền truy cập trang này.');
    }
}

function currentUser(): array
{
    return [
        'id'    => $_SESSION['user_id'] ?? null,
        'name'  => $_SESSION['name']    ?? '',
        'role'  => $_SESSION['role']    ?? '',
        'email' => $_SESSION['email']   ?? '',
    ];
}

function setUserSession(array $user): void
{
    $_SESSION['user_id'] = $user['Id'];
    $_SESSION['name']    = $user['Name'];
    $_SESSION['role']    = $user['Role'];
    $_SESSION['email']   = $user['Email'];
}

function destroySession(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
