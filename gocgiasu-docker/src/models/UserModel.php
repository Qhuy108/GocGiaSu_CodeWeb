<?php
require_once __DIR__ . '/../config/db.php';

class UserModel {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Tìm user theo email (dùng cho đăng nhập)
    public function findByEmail(string $email): array|false {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Tìm user theo id
    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT id, name, email, phone, avatar, role, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Tạo user mới (đăng ký)
    public function create(string $name, string $email, string $password, string $role = 'student'): int {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$name, $email, $hash, $role]);
        return (int) $this->db->lastInsertId();
    }

    // Kiểm tra email đã tồn tại chưa
    public function emailExists(string $email): bool {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    // Cập nhật thông tin cá nhân
    public function update(int $id, array $data): bool {
        $allowed = ['name', 'phone', 'avatar'];
        $sets = [];
        $values = [];
        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $sets[]   = "$field = ?";
                $values[] = $data[$field];
            }
        }
        if (empty($sets)) return false;
        $values[] = $id;
        $stmt = $this->db->prepare("UPDATE users SET " . implode(', ', $sets) . " WHERE id = ?");
        return $stmt->execute($values);
    }

    // Admin: lấy danh sách tất cả user (có phân trang)
    public function getAll(int $page = 1, string $role = ''): array {
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        $where  = $role ? "WHERE role = ?" : "";
        $params = $role ? [$role, ITEMS_PER_PAGE, $offset] : [ITEMS_PER_PAGE, $offset];
        $stmt = $this->db->prepare(
            "SELECT id, name, email, role, is_active, created_at FROM users $where ORDER BY created_at DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Admin: đếm tổng user (dùng cho phân trang)
    public function countAll(string $role = ''): int {
        $where  = $role ? "WHERE role = ?" : "";
        $params = $role ? [$role] : [];
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users $where");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
}
