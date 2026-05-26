<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../includes/session.php';

class AuthController {
    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Xử lý đăng nhập
    public function login(array $post): array {
        $email    = trim($post['email']    ?? '');
        $password = trim($post['password'] ?? '');

        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Email không hợp lệ'];
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
        }

        // Lưu vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user']    = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];

        return ['success' => true, 'role' => $user['role']];
    }

    // Xử lý đăng ký
    public function register(array $post): array {
        $name     = trim($post['name']     ?? '');
        $email    = trim($post['email']    ?? '');
        $password = trim($post['password'] ?? '');
        $confirm  = trim($post['confirm']  ?? '');
        $role     = in_array($post['role'] ?? '', ['student','tutor']) ? $post['role'] : 'student';

        // Validate
        if (empty($name) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Email không hợp lệ'];
        }
        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Mật khẩu tối thiểu 6 ký tự'];
        }
        if ($password !== $confirm) {
            return ['success' => false, 'message' => 'Mật khẩu xác nhận không khớp'];
        }
        if ($this->userModel->emailExists($email)) {
            return ['success' => false, 'message' => 'Email đã được sử dụng'];
        }

        $userId = $this->userModel->create($name, $email, $password, $role);

        // Tự động đăng nhập sau khi đăng ký
        $_SESSION['user_id'] = $userId;
        $_SESSION['user']    = ['id' => $userId, 'name' => $name, 'email' => $email, 'role' => $role];

        return ['success' => true, 'role' => $role];
    }

    // Đăng xuất
    public function logout(): void {
        session_destroy();
    }
}
