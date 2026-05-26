<?php
require_once __DIR__ . '/../config/db.php';

class BookingModel {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO bookings (student_id, tutor_id, subject_id, schedule_date, schedule_time, duration, note)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['student_id'],
            $data['tutor_id'],
            $data['subject_id'],
            $data['schedule_date'],
            $data['schedule_time'],
            $data['duration'] ?? 90,
            $data['note'] ?? '',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT b.*, u_s.name AS student_name, u_t.name AS tutor_name, s.name AS subject_name
             FROM bookings b
             JOIN users u_s ON b.student_id = u_s.id
             JOIN tutors t  ON b.tutor_id = t.id
             JOIN users u_t ON t.user_id = u_t.id
             JOIN subjects s ON b.subject_id = s.id
             WHERE b.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateStatus(int $id, string $status, ?string $cancelledBy = null, ?string $reason = null): bool {
        $stmt = $this->db->prepare(
            "UPDATE bookings SET status = ?, cancelled_by = ?, cancel_reason = ? WHERE id = ?"
        );
        return $stmt->execute([$status, $cancelledBy, $reason, $id]);
    }

    // Lịch sử booking của học sinh
    public function getByStudent(int $studentId, int $page = 1): array {
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        $stmt = $this->db->prepare(
            "SELECT b.*, u.name AS tutor_name, s.name AS subject_name
             FROM bookings b
             JOIN tutors t  ON b.tutor_id = t.id
             JOIN users u   ON t.user_id = u.id
             JOIN subjects s ON b.subject_id = s.id
             WHERE b.student_id = ?
             ORDER BY b.created_at DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute([$studentId, ITEMS_PER_PAGE, $offset]);
        return $stmt->fetchAll();
    }

    // Danh sách booking của gia sư
    public function getByTutor(int $tutorId, int $page = 1): array {
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        $stmt = $this->db->prepare(
            "SELECT b.*, u.name AS student_name, s.name AS subject_name
             FROM bookings b
             JOIN users u    ON b.student_id = u.id
             JOIN subjects s ON b.subject_id = s.id
             WHERE b.tutor_id = ?
             ORDER BY b.schedule_date ASC LIMIT ? OFFSET ?"
        );
        $stmt->execute([$tutorId, ITEMS_PER_PAGE, $offset]);
        return $stmt->fetchAll();
    }

    // Admin: thống kê tổng số booking theo trạng thái
    public function getStats(): array {
        $stmt = $this->db->query(
            "SELECT status, COUNT(*) AS total FROM bookings GROUP BY status"
        );
        return $stmt->fetchAll();
    }
}
