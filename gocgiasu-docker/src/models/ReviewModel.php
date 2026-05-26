<?php
require_once __DIR__ . '/../config/db.php';

class ReviewModel {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function create(int $bookingId, int $studentId, int $tutorId, int $rating, string $comment): int {
        $stmt = $this->db->prepare(
            "INSERT INTO reviews (booking_id, student_id, tutor_id, rating, comment) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$bookingId, $studentId, $tutorId, $rating, $comment]);
        return (int) $this->db->lastInsertId();
    }

    public function getByTutor(int $tutorId, int $page = 1): array {
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        $stmt = $this->db->prepare(
            "SELECT r.*, u.name AS student_name FROM reviews r
             JOIN users u ON r.student_id = u.id
             WHERE r.tutor_id = ? ORDER BY r.created_at DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute([$tutorId, ITEMS_PER_PAGE, $offset]);
        return $stmt->fetchAll();
    }

    public function existsForBooking(int $bookingId): bool {
        $stmt = $this->db->prepare("SELECT id FROM reviews WHERE booking_id = ? LIMIT 1");
        $stmt->execute([$bookingId]);
        return (bool) $stmt->fetch();
    }
}
