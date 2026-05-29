<?php
/**
 * Header dùng chung cho các trang công khai (trang chủ, giới thiệu, v.v.)
 *
 * Cách dùng trong View:
 *   <?php
 *     $pageTitle = "Tên trang - Góc Gia Sư";   // tuỳ chỉnh tiêu đề tab
 *     $activePage = "home";                     // "home" | "about" | "" để highlight menu
 *     require_once __DIR__ . '/../partials/header.php';
 *   ?>
 *
 * Biến nhận vào:
 *   $pageTitle  (string) – tiêu đề <title>, mặc định "Góc Gia Sư"
 *   $activePage (string) – trang hiện tại để highlight nav-link
 *   $cssPath    (string) – đường dẫn tới style.css (mặc định "css/style.css")
 *   $assetPath  (string) – đường dẫn tới thư mục assets  (mặc định "assets/")
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle  = $pageTitle  ?? 'Góc Gia Sư';
$activePage = $activePage ?? '';
$cssPath    = $cssPath    ?? '../css/style.css';
$assetPath  = $assetPath  ?? '../assets/';

$isLoggedIn = isset($_SESSION['user_id']);
$userName   = $_SESSION['name'] ?? '';
$userRole   = $_SESSION['role'] ?? ''; // 'student' | 'tutor' | 'admin'

// Xác định link dashboard tuỳ vai trò
$dashboardLink = '#';
if ($userRole === 'tutor')       $dashboardLink = '/index.php?page=tutor_dashboard';
elseif ($userRole === 'student') $dashboardLink = '/index.php?page=student';
elseif ($userRole === 'admin')   $dashboardLink = '/index.php?page=admin';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS chính của nhóm -->
    <link rel="stylesheet" href="<?= htmlspecialchars($cssPath) ?>">
</head>
<body>

<!-- ===== HEADER / NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom bg-white sticky-top py-3">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-teal" href="/index.php">
            <img src="<?= htmlspecialchars($assetPath) ?>graduation.png" width="44" height="44" alt="Logo Góc Gia Sư">
            Góc Gia Sư
        </a>

        <!-- Nút hamburger (mobile) -->
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu chính -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto fw-medium align-items-center">

                <li class="nav-item mx-2">
                    <a class="nav-link text-navy <?= $activePage === 'home' ? 'active fw-bold' : '' ?>"
                       href="/index.php">Trang chủ</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link text-navy <?= $activePage === 'about' ? 'active fw-bold' : '' ?>"
                       href="/index.php?page=about">Giới thiệu</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link text-navy <?= $activePage === 'tutors' ? 'active fw-bold' : '' ?>"
                       href="/index.php?page=tutors">Tìm gia sư</a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <!-- Đã đăng nhập: hiển thị dropdown tên + avatar -->
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-navy fw-bold"
                           href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                            <?= htmlspecialchars($userName) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3"
                            aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= htmlspecialchars($dashboardLink) ?>">
                                    <i class="bi bi-speedometer2 me-2 text-teal"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/index.php?page=profile">
                                    <i class="bi bi-person me-2 text-teal"></i>Hồ sơ của tôi
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="/index.php?action=logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Chưa đăng nhập: nút Đăng nhập + Đăng ký -->
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-outline-success rounded-pill px-4 fw-bold me-2"
                           href="/Views/DangNhap.php">Đăng nhập</a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-gocgiasu rounded-pill px-4"
                           href="/index.php?page=register">Đăng ký</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<!-- ===== KẾT THÚC HEADER ===== -->

