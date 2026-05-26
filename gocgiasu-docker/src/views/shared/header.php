<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../includes/session.php';
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Góc Gia Sư') ?></title>
    <!-- Link CSS frontend của nhóm vào đây -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
</head>
<body>
<nav>
    <a href="<?= BASE_URL ?>"><strong>Góc Gia Sư</strong></a>
    <a href="<?= BASE_URL ?>/views/tutor/search.php">Tìm gia sư</a>
    <?php if (isLoggedIn()): ?>
        <span>Xin chào, <?= e($user['name']) ?></span>
        <?php if ($user['role'] === 'admin'): ?>
            <a href="<?= BASE_URL ?>/views/admin/dashboard.php">Admin</a>
        <?php elseif ($user['role'] === 'tutor'): ?>
            <a href="<?= BASE_URL ?>/views/tutor/dashboard.php">Dashboard</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/views/booking/my-bookings.php">Lịch học của tôi</a>
        <?php endif; ?>
        <a href="#" onclick="logout()">Đăng xuất</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>/views/auth/login.php">Đăng nhập</a>
        <a href="<?= BASE_URL ?>/views/auth/register.php">Đăng ký</a>
    <?php endif; ?>
</nav>
