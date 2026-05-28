<?php
/**
 * UserModel – Thao tác CRUD với bảng users
 * NGƯỜI PHỤ TRÁCH: Thành viên 2
 */

require_once __DIR__ . '/../core/Connect_DataBase.php';

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Tìm user theo email (dùng khi đăng nhập)
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE Email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Tìm user theo ID
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE Id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Tạo tài khoản mới – trả về ID vừa tạo
    public function create(array $data): int
    {
        $sql = 'INSERT INTO users (Name, Email, Password, Phone, Role)
                VALUES (:Name, :Email, :Password, :Phone, :Role)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':Name'     => $data['Name'],
            ':Email'    => $data['Email'],
            ':Password' => $data['Password'],   // đã hash bằng password_hash()
            ':Phone'    => $data['Phone'] ?? null,
            ':Role'     => $data['Role'],        // 'student' | 'tutor' | 'admin'
        ]);

        return (int)$this->db->lastInsertId();
    }

    // Cập nhật thông tin user
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $col => $val) {
            $fields[] = "$col = :$col";
            $params[":$col"] = $val;
        }

        $sql  = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE Id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Lấy danh sách tất cả user (dành cho Admin)
    public function getAll(string $role = ''): array
    {
        if ($role) {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE Role = ? ORDER BY Created_at DESC');
            $stmt->execute([$role]);
        } else {
            $stmt = $this->db->query('SELECT * FROM users ORDER BY Created_at DESC');
        }
        return $stmt->fetchAll();
    }
}
