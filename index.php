<?php
/**
 * Front Controller – điểm vào duy nhất của ứng dụng.
 * Mọi request đều đi qua đây: index.php?page=xxx&action=yyy
 */

session_start();

require_once __DIR__ . '/core/Connect_DataBase.php';
require_once __DIR__ . '/core/session.php';

// ── Autoload controller theo tên ─────────────────────────────────────────────
function loadController(string $name): void
{
    $file = __DIR__ . '/Controllers/' . $name . 'Controller.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        http_response_code(404);
        die('Trang không tồn tại.');
    }
}

// ── Router đơn giản ───────────────────────────────────────────────────────────
$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($page) {

    // ── Trang công khai ──────────────────────────────────────────────────────
    case 'home':
        loadController('Tutor');
        $controller = new TutorController();
        $controller->home();          // Lấy gia sư nổi bật → render Homepage.php
        break;

    case 'about':
        require_once __DIR__ . '/Views/About.php';
        break;

    case 'tutors':
        loadController('Tutor');
        $controller = new TutorController();
        $controller->index();         // Trang danh sách gia sư + tìm kiếm
        break;

    case 'tutor_profile':
    loadController('Tutor');
    $controller = new TutorController();
    $controller->profile(); // Bỏ (int)($_GET['id'] ?? 0) đi
    break;

    // ── Xác thực (Auth) ──────────────────────────────────────────────────────
    case 'login':
        loadController('Auth');
        $controller = new AuthController();
        $controller->login();
        break;

    case 'forgot_password':
        loadController('Auth');
        $controller = new AuthController();
        $controller->forgotPassword();
        break;

    case 'register':
        loadController('Auth');
        $controller = new AuthController();
        $controller->registerStudent();
        break;

    case 'register_tutor':
        loadController('Auth');
        $controller = new AuthController();
        $controller->registerTutor();
        break;

    case 'logout':
        loadController('Auth');
        $controller = new AuthController();
        $controller->logout();
        break;

    // ── Dashboard Học sinh ───────────────────────────────────────────────────
    case 'student':
        requireLogin();
        requireRole('student');
        loadController('Booking');
        $controller = new BookingController();
        $controller->$action();
        break;

    // ── Dashboard Gia sư ─────────────────────────────────────────────────────
    case 'tutor_dashboard':
        requireLogin();
        requireRole('tutor');
        loadController('Tutor');
        $controller = new TutorController();
        $controller->dashboard();
        break;

    // ── Admin Panel ──────────────────────────────────────────────────────────
    case 'admin':
        requireLogin();
        requireRole('admin');
        loadController('Admin');
        $controller = new AdminController();
        $controller->$action();
        break;

    // ── 404 ──────────────────────────────────────────────────────────────────
    default:
        http_response_code(404);
        echo '<h1 style="text-align:center;margin-top:100px;">404 – Trang không tồn tại</h1>';
        break;
}
