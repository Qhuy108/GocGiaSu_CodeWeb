<?php
/**
 * ReviewModel – Thao tác với bảng reviews
 * NGƯỜI PHỤ TRÁCH: Thành viên 5
 */

require_once __DIR__ . '/../core/Connect_DataBase.php';

class ReviewModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Lấy tất cả đánh giá của 1 gia sư
    public function getByTutor(int $tutorId): array
    {
        $sql = "SELECT r.*, u.Name AS ten_hoc_sinh
                FROM reviews r
                JOIN bookings b ON b.Id = r.Booking_id
                JOIN users u ON u.Id = b.Student_id
                WHERE b.Tutor_id = ?
                ORDER BY r.Created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tutorId]);
        return $stmt->fetchAll();
    }

    // Tạo đánh giá mới
    public function create(array $data): int
    {
        // TODO: Thành viên 5 kiểm tra booking Status = 'done' trước khi đánh giá
        $sql = 'INSERT INTO reviews (Booking_id, Rating, Comment)
                VALUES (:Booking_id, :Rating, :Comment)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':Booking_id' => $data['Booking_id'],
            ':Rating'     => max(1, min(5, (int)$data['Rating'])),
            ':Comment'    => $data['Comment'] ?? '',
        ]);

        return (int)$this->db->lastInsertId();
    }

    // Tính điểm trung bình của gia sư
    public function getAverage(int $tutorId): float
    {
        $sql = "SELECT AVG(r.Rating)
                FROM reviews r
                JOIN bookings b ON b.Id = r.Booking_id
                WHERE b.Tutor_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tutorId]);
        return round((float)$stmt->fetchColumn(), 1);
    }
}
