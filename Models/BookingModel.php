<?php
/**
 * BookingModel – Thao tác với bảng bookings
 * NGƯỜI PHỤ TRÁCH: Thành viên 5
 */

require_once __DIR__ . '/../core/Connect_DataBase.php';

class BookingModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Tạo yêu cầu đặt lịch mới
    public function create(array $data): int
    {
        $sql = 'INSERT INTO bookings
                    (Student_id, Tutor_id, Subject_id, Date, Time, Note, Total_sessions, Total_price, Payment_status, Payment_receipt, Status)
                VALUES
                    (:Student_id, :Tutor_id, :Subject_id, :Date, :Time, :Note, :Total_sessions, :Total_price, :Payment_status, :Payment_receipt, :Status)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':Student_id'     => $data['Student_id'],
            ':Tutor_id'       => $data['Tutor_id'],
            ':Subject_id'     => $data['Subject_id'],
            ':Date'           => $data['Date'],
            ':Time'           => $data['Time'] ?? '',
            ':Note'           => $data['Note'] ?? '',
            ':Total_sessions' => $data['Total_sessions'] ?? 1,
            ':Total_price'    => $data['Total_price'] ?? 0,
            ':Payment_status' => $data['Payment_status'] ?? 'unpaid',
            ':Payment_receipt' => $data['Payment_receipt'] ?? null,
            ':Status'         => 'pending',
        ]);

        return (int)$this->db->lastInsertId();
    }

    // Lấy danh sách đặt lịch của 1 học sinh
    public function getByStudent(int $studentId): array
    {
        $sql = "SELECT b.*, s.Name AS subject_name, u.Name AS ten_gia_su,
                       IF(r.Id IS NOT NULL, 1, 0) AS da_danh_gia
                FROM bookings b
                JOIN tutors t ON t.Id = b.Tutor_id
                JOIN users u ON u.Id = t.User_id
                LEFT JOIN subjects s ON s.Id = b.Subject_id
                LEFT JOIN reviews r ON r.Booking_id = b.Id
                WHERE b.Student_id = ?
                ORDER BY b.Date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    // Lấy danh sách yêu cầu gửi đến 1 gia sư
    public function getByTutor(int $tutorId, string $status = ''): array
    {
        $sql    = "SELECT b.*, u.Name AS ten_hoc_sinh, u.Phone, s.Name AS subject_name
                   FROM bookings b
                   JOIN users u ON u.Id = b.Student_id
                   LEFT JOIN subjects s ON s.Id = b.Subject_id
                   WHERE b.Tutor_id = ?";
        $params = [$tutorId];

        if ($status) {
            $sql     .= ' AND b.Status = ?';
            $params[] = $status;
        }

        $sql .= ' ORDER BY b.Date DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Cập nhật trạng thái booking
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE bookings SET Status = ? WHERE Id = ?');
        return $stmt->execute([$status, $id]);
    }

    /**
     * Lấy thông tin chi tiết booking kèm email/tên của học sinh và gia sư
     */
    public function getBookingDetailsWithUsers(int $bookingId): array|false
    {
        $sql = "SELECT 
                    b.*, 
                    s.Name as SubjectName,
                    u_student.Name as StudentName, 
                    u_student.Email as StudentEmail,
                    u_tutor.Name as TutorName, 
                    u_tutor.Email as TutorEmail,
                    u_tutor.Phone as TutorPhone
                FROM bookings b
                JOIN subjects s ON b.Subject_id = s.Id
                JOIN users u_student ON b.Student_id = u_student.Id
                JOIN tutors t ON b.Tutor_id = t.Id
                JOIN users u_tutor ON t.User_id = u_tutor.Id
                WHERE b.Id = ?
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bookingId]);
        return $stmt->fetch();
    }

    // Tìm 1 booking theo ID (để kiểm tra quyền)
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM bookings WHERE Id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
