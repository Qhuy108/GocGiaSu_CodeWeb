<?php
/**
 * AdminController – Quản lý toàn bộ hệ thống
 * NGƯỜI PHỤ TRÁCH: Thành viên 6
 */

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TutorModel.php';
require_once __DIR__ . '/../Models/BookingModel.php';
require_once __DIR__ . '/../core/session.php';

class AdminController
{
    private UserModel    $userModel;
    private TutorModel   $tutorModel;
    private BookingModel $bookingModel;

    public function __construct()
    {
        requireLogin();
        requireRole('admin');

        $this->userModel    = new UserModel();
        $this->tutorModel   = new TutorModel();
        $this->bookingModel = new BookingModel();
    }

    // Trang tổng quan (dashboard)
    public function index(): void
    {
        // TODO: Thành viên 6 viết phần này
        // Thống kê: tổng học sinh (Role='student'), tổng gia sư (Role='tutor'),
        //           tổng booking, gia sư chờ duyệt (Status='pending')
        // require_once __DIR__ . '/../Views/admin/dashboard.php';
        echo '<h2 style="text-align:center;margin-top:50px;">Admin Dashboard – Đang xây dựng</h2>';
    }

    // Danh sách gia sư chờ duyệt hồ sơ
    public function pendingTutors(): void
    {
        // TODO: Thành viên 6 viết phần này
        // 1. Lấy danh sách gia sư có Status = 'pending'
        // 2. Hiển thị bảng với các nút Duyệt / Từ chối
        echo '<p>Chức năng duyệt gia sư – đang xây dựng</p>';
    }

    // Duyệt hoặc từ chối hồ sơ gia sư
    public function approveTutor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=admin&action=pendingTutors');
            exit;
        }

        $tutorId = (int)($_POST['tutor_id'] ?? 0);
        $action  = $_POST['action'] ?? '';   // 'approve' | 'reject'

        // TODO: Thành viên 6 viết phần này
        // 1. Validate tutorId và action hợp lệ
        // 2. Cập nhật Status trong bảng tutors:
        //    - 'approve' → Status = 'approved'
        //    - 'reject'  → Status = 'rejected'
        // 3. (Tuỳ chọn) Gửi email thông báo cho gia sư
        // 4. Redirect về danh sách chờ duyệt
    }

    // Quản lý tất cả người dùng
    public function users(): void
    {
        $role  = $_GET['role'] ?? '';
        $users = $this->userModel->getAll($role);

        // TODO: Thành viên 6 tạo Views/admin/users.php
        // require_once __DIR__ . '/../Views/admin/users.php';
        echo '<pre>' . print_r($users, true) . '</pre>';
    }
}
