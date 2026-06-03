<?php
/**
 * AdminController – Quản lý toàn bộ hệ thống
 * NGƯỜI PHỤ TRÁCH: Thành viên 6
 */

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TutorModel.php';
require_once __DIR__ . '/../Models/BookingModel.php';
require_once __DIR__ . '/../Models/PostModel.php';
require_once __DIR__ . '/../core/session.php';

class AdminController
{
    private UserModel    $userModel;
    private TutorModel   $tutorModel;
    private BookingModel $bookingModel;

    public function __construct()
    {
        requireLogin();
        requireRole('admin');

        $this->userModel    = new UserModel();
        $this->tutorModel   = new TutorModel();
        $this->bookingModel = new BookingModel();
    }

    // Trang tổng quan (dashboard)
    public function index(): void
    {
        $db    = getDB();
        $stats = [
            'tong_hoc_sinh' => (int)$db->query("SELECT COUNT(*) FROM users WHERE Role='student'")->fetchColumn(),
            'tong_gia_su'   => (int)$db->query("SELECT COUNT(*) FROM users WHERE Role='tutor'")->fetchColumn(),
            'tong_booking'  => (int)$db->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
            'cho_duyet'     => (int)$db->query("SELECT COUNT(*) FROM tutors WHERE Status='pending'")->fetchColumn(),
            'da_duyet'      => (int)$db->query("SELECT COUNT(*) FROM tutors WHERE Status='approved'")->fetchColumn(),
            'doanh_thu'     => (float)$db->query("SELECT COALESCE(SUM(Total_price),0) FROM bookings WHERE Status='done' AND Payment_status='paid'")->fetchColumn(),
        ];
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    // Danh sách gia sư chờ duyệt hồ sơ
    public function pendingTutors(): void
    {
        $db   = getDB();
        $stmt = $db->query("
            SELECT t.Id, t.Bio, t.Experience, t.Qualifications,
                   t.Location, t.Hourly_rate, t.Status,
                   u.Name, u.Email, u.Phone, u.Avatar, u.Created_at
            FROM tutors t
            JOIN users u ON u.Id = t.User_id
            WHERE t.Status = 'pending'
            ORDER BY u.Created_at DESC
        ");
        $pendingTutors = $stmt->fetchAll();
        require_once __DIR__ . '/../Views/admin/pending_tutors.php';
    }

    // Duyệt hoặc từ chối hồ sơ gia sư
    public function approveTutor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=admin&action=pendingTutors');
            exit;
        }

        $tutorId = (int)($_POST['tutor_id'] ?? 0);
        $action  = $_POST['action'] ?? '';   // 'approve' | 'reject'

        if ($tutorId > 0 && in_array($action, ['approve', 'reject'])) {
            $status = $action === 'approve' ? 'approved' : 'rejected';
            $db     = getDB();
            $db->prepare("UPDATE tutors SET Status = ? WHERE Id = ?")->execute([$status, $tutorId]);
        }

        header('Location: /index.php?page=admin&action=pendingTutors');
        exit;
    }

    // Quản lý tất cả người dùng
    public function users(): void
    {
        $role  = $_GET['role'] ?? '';
        $users = $this->userModel->getAll($role);
        require_once __DIR__ . '/../Views/admin/users.php';
    }

    // Xóa người dùng
    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=admin&action=users');
            exit;
        }

        $userId  = (int)($_POST['user_id'] ?? 0);
        $current = currentUser();

        // Không cho xóa chính mình
        if ($userId > 0 && $userId !== (int)$current['id']) {
            $db = getDB();
            $db->prepare("DELETE FROM users WHERE Id = ?")->execute([$userId]);
        }

        header('Location: /index.php?page=admin&action=users');
        exit;
    }

    // Trang báo cáo thống kê
    public function report(): void
    {
        $db = getDB();

        // Booking theo tháng (6 tháng gần nhất)
        $bookingByMonth = $db->query("
            SELECT DATE_FORMAT(Date, '%Y-%m') AS thang,
                   COUNT(*) AS so_booking,
                   COALESCE(SUM(Total_price), 0) AS doanh_thu
            FROM bookings
            WHERE Date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY thang
            ORDER BY thang ASC
        ")->fetchAll();

        // Top 5 gia sư có nhiều booking nhất
        $topTutors = $db->query("
            SELECT u.Name, COUNT(b.Id) AS so_booking,
                   COALESCE(AVG(r.Rating), 0) AS diem_tb
            FROM bookings b
            JOIN tutors t ON t.Id = b.Tutor_id
            JOIN users u ON u.Id = t.User_id
            LEFT JOIN reviews r ON r.Booking_id = b.Id
            GROUP BY t.Id
            ORDER BY so_booking DESC
            LIMIT 5
        ")->fetchAll();

        // Thống kê booking theo trạng thái
        $bookingStatus = $db->query("
            SELECT Status, COUNT(*) AS so_luong
            FROM bookings
            GROUP BY Status
        ")->fetchAll();

        require_once __DIR__ . '/../Views/admin/report.php';
    }

    public function posts(): void
    {
        $postModel = new PostModel();
        $posts     = $postModel->getAll();
        require_once __DIR__ . '/../Views/admin/posts.php';
    }

    public function postCreate(): void
    {
        $postModel = new PostModel();
        $post      = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = currentUser();
            $slug = trim($_POST['Slug'] ?? '');

            if ($postModel->slugExists($slug)) {
                $slug .= '-' . time();
            }

            $postModel->create([
                ':Title'     => trim($_POST['Title']    ?? ''),
                ':Slug'      => $slug,
                ':Summary'   => trim($_POST['Summary']  ?? ''),
                ':Content'   => $_POST['Content']       ?? '',
                ':Category'  => trim($_POST['Category'] ?? ''),
                ':Image'     => trim($_POST['Image']    ?? ''),
                ':Author_id' => $user['id'],
                ':Status'    => $_POST['Status']        ?? 'draft',
            ]);

            header('Location: /index.php?page=admin&action=posts&success=created');
            exit;
        }

        require_once __DIR__ . '/../Views/admin/post_form.php';
    }

    public function postEdit(): void
    {
        $postModel = new PostModel();
        $post      = $postModel->findById((int)($_GET['id'] ?? 0));

        if (!$post) {
            header('Location: /index.php?page=admin&action=posts');
            exit;
        }

        require_once __DIR__ . '/../Views/admin/post_form.php';
    }

    public function postUpdate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=admin&action=posts');
            exit;
        }

        $postModel = new PostModel();
        $id        = (int)($_POST['post_id'] ?? 0);
        $slug      = trim($_POST['Slug'] ?? '');

        if ($postModel->slugExists($slug, $id)) {
            $slug .= '-' . time();
        }

        $postModel->update($id, [
            'Title'    => trim($_POST['Title']    ?? ''),
            'Slug'     => $slug,
            'Summary'  => trim($_POST['Summary']  ?? ''),
            'Content'  => $_POST['Content']       ?? '',
            'Category' => trim($_POST['Category'] ?? ''),
            'Image'    => trim($_POST['Image']    ?? ''),
            'Status'   => $_POST['Status']        ?? 'draft',
        ]);

        header('Location: /index.php?page=admin&action=posts&success=updated');
        exit;
    }

    public function postDelete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postModel = new PostModel();
            $postModel->delete((int)($_POST['post_id'] ?? 0));
        }
        header('Location: /index.php?page=admin&action=posts&success=deleted');
        exit;
    }
}
