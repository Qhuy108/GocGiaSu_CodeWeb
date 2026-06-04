<?php
require_once __DIR__ . '/../core/Connect_DataBase.php';

class StudentPostModel
{
    private PDO $db;
    public const EXPIRE_DAYS = 30;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Tự đóng các bài đăng quá hạn, gọi trước khi query danh sách
    public function closeExpired(): void
    {
        $this->db->prepare("
            UPDATE student_posts
            SET Status = 'closed'
            WHERE Status = 'open'
              AND Created_at < NOW() - INTERVAL " . self::EXPIRE_DAYS . " DAY
        ")->execute();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO student_posts (Student_id, Subject, Grade, Goal, Budget, Days, Schedule)
            VALUES (:student_id, :subject, :grade, :goal, :budget, :days, :schedule)
        ");
        $stmt->execute([
            ':student_id' => $data['Student_id'],
            ':subject'    => $data['Subject'],
            ':grade'      => $data['Grade'],
            ':goal'       => $data['Goal'],
            ':budget'     => $data['Budget'],
            ':days'       => $data['Days'],
            ':schedule'   => $data['Schedule'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function getAll(int $limit = 10, int $offset = 0): array
    {
        $stmt = $this->db->prepare("
            SELECT sp.*, u.Name AS student_name, u.Avatar AS student_avatar, u.Phone AS student_phone
            FROM student_posts sp
            JOIN users u ON u.Id = sp.Student_id
            WHERE sp.Status = 'open'
            ORDER BY sp.Created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM student_posts WHERE Status = 'open'")->fetchColumn();
    }

    public function getByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM student_posts WHERE Student_id = ? ORDER BY Created_at DESC
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function close(int $id, int $studentId): void
    {
        $stmt = $this->db->prepare("UPDATE student_posts SET Status='closed' WHERE Id=? AND Student_id=?");
        $stmt->execute([$id, $studentId]);
    }
}
