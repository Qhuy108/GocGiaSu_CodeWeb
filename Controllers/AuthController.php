<?php
/**
 * AuthController – Xử lý Đăng ký / Đăng nhập / Đăng xuất
 * NGƯỜI PHỤ TRÁCH: Thành viên 2
 */

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../core/session.php';

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ── Hiển thị form đăng nhập / xử lý POST ─────────────────────────────────
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');

            // TODO: Thành viên 2 viết phần này
            // 1. Validate email, password không rỗng
            // 2. Gọi $this->userModel->findByEmail($email)
            // 3. Dùng password_verify($password, $user['Password']) để so sánh
            // 4. Nếu đúng → setUserSession($user) → redirect theo $user['Role']:
            //      'student' → trang học sinh
            //      'tutor'   → trang gia sư
            //      'admin'   → trang admin
            // 5. Nếu sai → báo lỗi ra view
        }

        require_once __DIR__ . '/../Views/DangNhap.php';
    }

    // ── Đăng ký Học sinh ─────────────────────────────────────────────────────
    public function registerStudent(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Thành viên 2 viết phần này
            // 1. Lấy dữ liệu từ $_POST (Name, Email, Password, xac_nhan_mat_khau)
            // 2. Validate: không rỗng, email đúng định dạng, 2 mật khẩu khớp
            // 3. Kiểm tra email chưa tồn tại: $this->userModel->findByEmail($email)
            // 4. Hash mật khẩu: password_hash($password, PASSWORD_DEFAULT)
            // 5. Gọi $this->userModel->create([...]) với Role = 'student'
            // 6. Redirect đến trang đăng nhập với thông báo thành công
        }

        require_once __DIR__ . '/../Views/DangKy_HS.php';
    }

    // ── Đăng ký Gia sư ───────────────────────────────────────────────────────
    public function registerTutor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Thành viên 2 viết phần này
            // 1. Lấy dữ liệu từ $_POST + $_FILES
            // 2. Validate dữ liệu
            // 3. Tạo user với Role = 'tutor'
            // 4. Lưu thông tin vào bảng tutors với Status = 'pending'
            // 5. Redirect về trang thông báo chờ admin duyệt
        }

        require_once __DIR__ . '/../Views/DangKy_GS.php';
    }

    // ── Đăng xuất ────────────────────────────────────────────────────────────
    public function logout(): void
    {
        destroySession();
        header('Location: /index.php?page=login');
        exit;
    }
}
