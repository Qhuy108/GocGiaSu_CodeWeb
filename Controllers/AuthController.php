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

    // ── Hiển thị form đăng nhập / xử lý POST ────────────────────────────

    public function login(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = trim($_POST['email']    ?? '');
            $password   = trim($_POST['password'] ?? '');

            if ($identifier === '' || $password === '') {
                $errors[] = 'Email/số điện thoại và mật khẩu không được để trống.';
            }

            if (!$errors) {
                $user = $this->userModel->findByEmail($identifier);

                if (!$user || !password_verify($password, $user['Password'])) {
                    $errors[] = 'Email/số điện thoại hoặc mật khẩu không đúng.';
                } else {
                    setUserSession($user);

                    switch ($user['Role']) {
                        case 'student':
                            header('Location: /index.php?page=student');
                            break;
                        case 'tutor':
                            header('Location: /index.php?page=tutor_dashboard');
                            break;
                        case 'admin':
                            header('Location: /index.php?page=admin');
                            break;
                        default:
                            header('Location: /index.php?page=home');
                    }
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../Views/DangNhap.php';
    }

    // ── Đăng ký Học sinh ─────────────────────────────────────────────────────
        // ── Đăng ký Học sinh ─────────────────────────────────────────────────────
    public function registerStudent(): void
    {
        $errors  = [];
        $oldData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldData['Name']         = trim($_POST['name']             ?? '');
            $oldData['Email']        = trim($_POST['email']            ?? '');
            $oldData['Phone']        = trim($_POST['phone']            ?? '');
            $password                = trim($_POST['password']         ?? '');
            $confirmPassword         = trim($_POST['confirm_password'] ?? '');
            $acceptedTerms           = isset($_POST['terms']);

            if ($oldData['Name'] === '' || $oldData['Email'] === '' || $password === '' || $confirmPassword === '') {
                $errors[] = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
            }

            if ($oldData['Email'] !== '' && !filter_var($oldData['Email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không đúng định dạng.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Mật khẩu và xác nhận mật khẩu phải giống nhau.';
            }

            if (!$acceptedTerms) {
                $errors[] = 'Bạn phải đồng ý với điều khoản sử dụng.';
            }

            if (!$errors && $this->userModel->findByEmail($oldData['Email'])) {
                $errors[] = 'Email này đã được đăng ký. Vui lòng sử dụng email khác.';
            }

            if (!$errors) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $this->userModel->create([
                    'Name'     => $oldData['Name'],
                    'Email'    => $oldData['Email'],
                    'Password' => $hashedPassword,
                    'Phone'    => $oldData['Phone'] ?: null,
                    'Role'     => 'student',
                ]);

                header('Location: /index.php?page=login&registered=1');
                exit;
            }
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
        header('Location: /index.php');
        exit;
    }
}
