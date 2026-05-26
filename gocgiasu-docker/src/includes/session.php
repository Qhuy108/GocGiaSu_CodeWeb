<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đã đăng nhập chưa
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

// Lấy thông tin user hiện tại từ session
function getCurrentUser(): array {
    return $_SESSION['user'] ?? [];
}

// Lấy role của user
function getUserRole(): string {
    return $_SESSION['user']['role'] ?? '';
}

// Bắt buộc đăng nhập - nếu chưa thì redirect về login
function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /views/auth/login.php');
        exit;
    }
}

// Bắt buộc là admin
function requireAdmin(): void {
    requireLogin();
    if (getUserRole() !== 'admin') {
        http_response_code(403);
        die('Bạn không có quyền truy cập trang này.');
    }
}

// Bắt buộc là tutor
function requireTutor(): void {
    requireLogin();
    if (getUserRole() !== 'tutor') {
        header('Location: /views/tutor/register.php');
        exit;
    }
}

// Chống XSS: luôn dùng hàm này khi echo dữ liệu ra HTML
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
