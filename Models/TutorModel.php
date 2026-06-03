<?php
/**
 * TutorModel – Thao tác với bảng tutors
 * NGƯỜI PHỤ TRÁCH: Thành viên 3
 */

require_once __DIR__ . '/../core/Connect_DataBase.php';

class TutorModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Lấy danh sách gia sư đã duyệt (cho trang tìm kiếm)
    public function getApproved(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        $where  = ["t.Status = 'approved'"];
        $params = [];

        if (!empty($filters['mon_hoc'])) {
            $where[]               = 's.Id = :subject_id';
            $params[':subject_id'] = $filters['mon_hoc'];
        }
        if (!empty($filters['khu_vuc'])) {
            $where[]            = 't.Location LIKE :location';
            $params[':location'] = '%' . $filters['khu_vuc'] . '%';
        }
        if (!empty($filters['muc_luong'])) {
            $range = explode('-', $filters['muc_luong']);
            if (count($range) == 2) {
                $where[] = 't.Hourly_rate >= :min_rate AND t.Hourly_rate <= :max_rate';
                $params[':min_rate'] = (float)$range[0];
                $params[':max_rate'] = (float)$range[1];
            }
        }

        $whereClause = implode(' AND ', $where);

        $sql = "SELECT t.*, u.Name, u.Avatar,
                       COALESCE(AVG(r.Rating), 0) AS diem_tb,
                       COUNT(r.Id) AS so_danh_gia,
                       GROUP_CONCAT(DISTINCT s.Name ORDER BY s.Name SEPARATOR ', ') AS mon_hoc,
                       CONCAT('[', GROUP_CONCAT(DISTINCT CONCAT('{\"id\":', s.Id, ',\"name\":\"', s.Name, '\"}') SEPARATOR ','), ']') AS subjects_json
                FROM tutors t
                JOIN users u ON u.Id = t.User_id
                LEFT JOIN tutor_subjects ts ON ts.Tutor_id = t.Id
                LEFT JOIN subjects s ON s.Id = ts.Subject_id
                LEFT JOIN bookings b ON b.Tutor_id = t.Id
                LEFT JOIN reviews r ON r.Booking_id = b.Id
                WHERE $whereClause
                GROUP BY t.Id
                ORDER BY diem_tb DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy chi tiết 1 gia sư theo ID
    public function findById(int $id): array|false
    {
        $sql = "SELECT t.*, u.Name, u.Email, u.Phone, u.Avatar,
                       GROUP_CONCAT(DISTINCT s.Name ORDER BY s.Name SEPARATOR ', ') AS mon_hoc,
                       CONCAT('[', GROUP_CONCAT(DISTINCT CONCAT('{\"id\":', s.Id, ',\"name\":\"', s.Name, '\"}') SEPARATOR ','), ']') AS subjects_json
                FROM tutors t
                JOIN users u ON u.Id = t.User_id
                LEFT JOIN tutor_subjects ts ON ts.Tutor_id = t.Id
                LEFT JOIN subjects s ON s.Id = ts.Subject_id
                WHERE t.Id = ?
                GROUP BY t.Id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByUserId(int $userId): array|false
{
    $sql = "SELECT * FROM tutors WHERE User_id = ? LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetch();
}
    // Tạo hồ sơ gia sư (khi đăng ký)
    public function create(array $data): int
    {
        $sql = 'INSERT INTO tutors
                    (User_id, Bio, Experience, Qualifications, Location, Hourly_rate, Status)
                VALUES
                    (:User_id, :Bio, :Experience, :Qualifications, :Location, :Hourly_rate, :Status)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':User_id'        => $data['User_id'],
            ':Bio'            => $data['Bio']            ?? '',
            ':Experience'     => $data['Experience']     ?? '',
            ':Qualifications' => $data['Qualifications'] ?? '',
            ':Location'       => $data['Location']       ?? '',
            ':Hourly_rate'    => $data['Hourly_rate']    ?? 0,
            ':Status'         => 'pending',
        ]);

        return (int)$this->db->lastInsertId();
    }

    // Cập nhật thông tin hồ sơ gia sư
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $col => $val) {
            $fields[] = "$col = :$col";
            $params[":$col"] = $val;
        }

        $sql  = 'UPDATE tutors SET ' . implode(', ', $fields) . ' WHERE Id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Lấy top N gia sư nổi bật (cho trang chủ)
    public function getFeatured(int $limit = 4): array
    {
        $sql = "SELECT t.Id, u.Name, u.Avatar,
                       COALESCE(AVG(r.Rating), 0) AS diem_tb,
                       GROUP_CONCAT(DISTINCT s.Name ORDER BY s.Name SEPARATOR ', ') AS mon_hoc,
                       CONCAT('[', GROUP_CONCAT(DISTINCT CONCAT('{\"id\":', s.Id, ',\"name\":\"', s.Name, '\"}') SEPARATOR ','), ']') AS subjects_json
                FROM tutors t
                JOIN users u ON u.Id = t.User_id
                LEFT JOIN tutor_subjects ts ON ts.Tutor_id = t.Id
                LEFT JOIN subjects s ON s.Id = ts.Subject_id
                LEFT JOIN bookings b ON b.Tutor_id = t.Id
                LEFT JOIN reviews r ON r.Booking_id = b.Id
                WHERE t.Status = 'approved'
                GROUP BY t.Id
                ORDER BY diem_tb DESC
                LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
          //Lay mon hoc
public function getSubjectsByTutorId(int $tutorId): array
{
    $sql = "SELECT s.Id, s.Name FROM subjects s
            JOIN tutor_subjects ts ON ts.Subject_id = s.Id
            WHERE ts.Tutor_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$tutorId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getSubjects(): array
{
    $sql = "SELECT Id, Name FROM subjects";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countApproved(array $filters = []): int
{
    $where  = ["t.Status = 'approved'"];
    $params = [];

    if (!empty($filters['mon_hoc'])) {
        $where[]               = 's.Id = :subject_id';
        $params[':subject_id'] = $filters['mon_hoc'];
    }

    if (!empty($filters['khu_vuc'])) {
        $where[]            = 't.Location LIKE :location';
        $params[':location'] = '%' . $filters['khu_vuc'] . '%';
    }

    if (!empty($filters['muc_luong'])) {
        $range = explode('-', $filters['muc_luong']);
        if (count($range) == 2) {
            $where[] = 't.Hourly_rate >= :min_rate AND t.Hourly_rate <= :max_rate';
            $params[':min_rate'] = (float)$range[0];
            $params[':max_rate'] = (float)$range[1];
        }
    }

    $whereClause = implode(' AND ', $where);

    $sql = "
        SELECT COUNT(DISTINCT t.Id)
        FROM tutors t
        JOIN users u ON u.Id = t.User_id
        LEFT JOIN tutor_subjects ts ON ts.Tutor_id = t.Id
        LEFT JOIN subjects s ON s.Id = ts.Subject_id
        WHERE $whereClause
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}
// Lấy danh sách lớp học của gia sư
   // Sửa trong file Models/TutorModel.php
public function getClassesByTutorId(int $tutorId): array
{
    // Giả sử bảng của bạn là 'bookings' và cột là 'Tutor_id'
    // Bạn nên kiểm tra lại trong phpMyAdmin tên cột chính xác
    $sql = "SELECT * FROM bookings WHERE Tutor_id = :tutor_id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':tutor_id' => $tutorId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

