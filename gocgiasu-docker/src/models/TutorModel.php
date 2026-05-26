<?php
require_once __DIR__ . '/../config/db.php';

class TutorModel {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Tìm kiếm gia sư với lọc + phân trang (chức năng cốt lõi)
    public function search(array $filters = [], int $page = 1): array {
        $where  = ["t.status = 'approved'"];
        $params = [];

        if (!empty($filters['subject_id'])) {
            $where[]  = "EXISTS (SELECT 1 FROM tutor_subjects ts WHERE ts.tutor_id = t.id AND ts.subject_id = ?)";
            $params[] = (int) $filters['subject_id'];
        }
        if (!empty($filters['location'])) {
            $where[]  = "t.location LIKE ?";
            $params[] = '%' . $filters['location'] . '%';
        }
        if (!empty($filters['max_rate'])) {
            $where[]  = "t.hourly_rate <= ?";
            $params[] = (int) $filters['max_rate'];
        }

        $whereSQL = implode(' AND ', $where);
        $offset   = ($page - 1) * ITEMS_PER_PAGE;

        $sql = "SELECT t.*, u.name, u.avatar, u.email
                FROM tutors t
                JOIN users u ON t.user_id = u.id
                WHERE $whereSQL
                ORDER BY t.avg_rating DESC, t.created_at DESC
                LIMIT ? OFFSET ?";

        $params[] = ITEMS_PER_PAGE;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Đếm tổng kết quả tìm kiếm (dùng cho phân trang)
    public function countSearch(array $filters = []): int {
        $where  = ["t.status = 'approved'"];
        $params = [];

        if (!empty($filters['subject_id'])) {
            $where[]  = "EXISTS (SELECT 1 FROM tutor_subjects ts WHERE ts.tutor_id = t.id AND ts.subject_id = ?)";
            $params[] = (int) $filters['subject_id'];
        }
        if (!empty($filters['location'])) {
            $where[]  = "t.location LIKE ?";
            $params[] = '%' . $filters['location'] . '%';
        }
        if (!empty($filters['max_rate'])) {
            $where[]  = "t.hourly_rate <= ?";
            $params[] = (int) $filters['max_rate'];
        }

        $whereSQL = implode(' AND ', $where);
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tutors t WHERE $whereSQL");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    // Xem hồ sơ chi tiết 1 gia sư
    public function findById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT t.*, u.name, u.avatar, u.email, u.phone
             FROM tutors t JOIN users u ON t.user_id = u.id
             WHERE t.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $tutor = $stmt->fetch();
        if ($tutor) {
            $tutor['subjects'] = $this->getSubjects($id);
        }
        return $tutor;
    }

    // Tìm hồ sơ gia sư theo user_id
    public function findByUserId(int $userId): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tutors WHERE user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    // Tạo hồ sơ gia sư mới
    public function create(int $userId, array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO tutors (user_id, bio, education, experience_years, location, hourly_rate, cccd_path, cert_path)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $userId,
            $data['bio']              ?? '',
            $data['education']        ?? '',
            $data['experience_years'] ?? 0,
            $data['location']         ?? '',
            $data['hourly_rate']      ?? 0,
            $data['cccd_path']        ?? null,
            $data['cert_path']        ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    // Cập nhật hồ sơ gia sư
    public function update(int $id, array $data): bool {
        $allowed = ['bio','education','experience_years','location','hourly_rate','cccd_path','cert_path'];
        $sets = []; $values = [];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $sets[]   = "$field = ?";
                $values[] = $data[$field];
            }
        }
        if (empty($sets)) return false;
        $values[] = $id;
        $stmt = $this->db->prepare("UPDATE tutors SET " . implode(', ', $sets) . " WHERE id = ?");
        return $stmt->execute($values);
    }

    // Admin: cập nhật trạng thái duyệt hồ sơ
    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->db->prepare("UPDATE tutors SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Lấy danh sách môn học của gia sư
    public function getSubjects(int $tutorId): array {
        $stmt = $this->db->prepare(
            "SELECT s.id, s.name FROM subjects s
             JOIN tutor_subjects ts ON s.id = ts.subject_id
             WHERE ts.tutor_id = ?"
        );
        $stmt->execute([$tutorId]);
        return $stmt->fetchAll();
    }

    // Gắn môn học cho gia sư
    public function setSubjects(int $tutorId, array $subjectIds): void {
        $this->db->prepare("DELETE FROM tutor_subjects WHERE tutor_id = ?")->execute([$tutorId]);
        $stmt = $this->db->prepare("INSERT INTO tutor_subjects (tutor_id, subject_id) VALUES (?, ?)");
        foreach ($subjectIds as $sid) {
            $stmt->execute([$tutorId, (int)$sid]);
        }
    }

    // Cập nhật rating sau khi có review mới
    public function refreshRating(int $tutorId): void {
        $stmt = $this->db->prepare(
            "UPDATE tutors SET
                avg_rating    = (SELECT AVG(rating) FROM reviews WHERE tutor_id = ?),
                total_reviews = (SELECT COUNT(*) FROM reviews WHERE tutor_id = ?)
             WHERE id = ?"
        );
        $stmt->execute([$tutorId, $tutorId, $tutorId]);
    }

    // Admin: lấy danh sách gia sư pending
    public function getPending(): array {
        $stmt = $this->db->prepare(
            "SELECT t.*, u.name, u.email FROM tutors t JOIN users u ON t.user_id = u.id
             WHERE t.status = 'pending' ORDER BY t.created_at ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
