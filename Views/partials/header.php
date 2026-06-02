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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Navbar chuyên nghiệp với gradient */
        .navbar-professional {
            background: linear-gradient(135deg, #042940 0%, #005C53 100%);
            box-shadow: 0 4px 20px rgba(4, 41, 64, 0.15);
            padding: 12px 0 !important;
        }

        /* Brand name nổi bật */
        .brand-professional {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #DBF227 !important;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .brand-professional:hover {
            color: #E8FF00 !important;
            text-shadow: 0 2px 12px rgba(219, 242, 39, 0.4);
        }

        /* Logo với border chuyên nghiệp */
        .logo-professional {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #9FC131 0%, #DBF227 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(159, 193, 49, 0.3);
            transition: all 0.3s ease;
        }

        .logo-professional:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 16px rgba(159, 193, 49, 0.4);
        }

        .logo-professional img {
            width: 32px;
            height: 32px;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
        }

        /* Navigation links màu nhạt cho contrast tốt */
        .nav-link-professional {
            color: #E8F0F8 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-professional:hover,
        .nav-link-professional.active {
            color: #DBF227 !important;
        }

        .nav-link-professional.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 3px;
            background: #DBF227;
            border-radius: 2px;
        }

        /* Dropdown menu nâng cao */
        .dropdown-menu-professional {
            background: linear-gradient(135deg, #f8fafb 0%, #f0f3f7 100%);
            border: 1px solid #e0e7f1;
            box-shadow: 0 8px 24px rgba(4, 41, 64, 0.12);
        }

        .dropdown-menu-professional .dropdown-item {
            color: #042940;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            padding-left: 12px;
        }

        .dropdown-menu-professional .dropdown-item:hover {
            background-color: #E8F0F8;
            border-left-color: #9FC131;
            color: #005C53;
        }

        /* Hamburger menu color */
        .navbar-toggler {
            border-color: #DBF227 !important;
        }

        .navbar-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23DBF227' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 991px) {
            .brand-professional {
                font-size: 1.2rem;
            }

            .navbar-collapse {
                background: rgba(4, 41, 64, 0.95);
                padding: 16px;
                margin-top: 12px;
                border-radius: 12px;
            }

            .nav-item {
                margin: 8px 0 !important;
            }
        }
    </style>
</head>
<body>

<!-- ===== HEADER / NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-professional sticky-top">
    <div class="container">

        <!-- Logo + Brand Name -->
        <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="/index.php">
            <div class="logo-professional">
                <img src="<?= htmlspecialchars($assetPath) ?>graduation.png" alt="Logo Góc Gia Sư">
            </div>
            <span class="brand-professional">Góc Gia Sư</span>
        </a>

        <!-- Hamburger Menu -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu chính -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto fw-medium align-items-center gap-2">

                <li class="nav-item">
                    <a class="nav-link nav-link-professional <?= $activePage === 'home' ? 'active' : '' ?>"
                       href="/index.php">Trang chủ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-professional <?= $activePage === 'about' ? 'active' : '' ?>"
                       href="/index.php?page=about">Giới thiệu</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-professional <?= $activePage === 'tutors' ? 'active' : '' ?>"
                       href="/index.php?page=tutors">Tìm gia sư</a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <!-- Đã đăng nhập: dropdown user -->
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link nav-link-professional dropdown-toggle d-flex align-items-center gap-2"
                           href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($userName) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-professional"
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
                                <a class="dropdown-item text-danger" href="/index.php?page=logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Chưa đăng nhập: nút Đăng nhập -->
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-gocgiasu rounded-pill px-4 fw-bold"
                           href="/index.php?page=login">Đăng nhập</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<!-- ===== KẾT THÚC HEADER ===== -->

