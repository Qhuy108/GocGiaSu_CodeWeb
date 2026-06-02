<?php
/**
 * TutorController – Trang gia sư: danh sách, profile, dashboard
 * NGƯỜI PHỤ TRÁCH: Thành viên 3
 */

require_once __DIR__ . '/../Models/TutorModel.php';
require_once __DIR__ . '/../core/session.php';

class TutorController
{
    private TutorModel $tutorModel;

    public function __construct()
    {
        $this->tutorModel = new TutorModel();
    }

    // Trang chủ: lấy gia sư nổi bật rồi render Homepage.php
    public function home(): void
    {
        $featuredTutors = $this->tutorModel->getFeatured(4);
        require_once __DIR__ . '/../Views/Homepage.php';
    }

    // Trang danh sách gia sư + bộ lọc tìm kiếm
    public function index(): void
    {
        $filters = [
            'mon_hoc' => $_GET['mon_hoc'] ?? '',
            'khu_vuc' => $_GET['khu_vuc'] ?? '',
        ];

        $limit  = 12;
        $trang  = max(1, (int)($_GET['trang'] ?? 1));
        $offset = ($trang - 1) * $limit;

        $tutors = $this->tutorModel->getApproved($filters, $limit, $offset);

        // TODO: Thành viên 3 tạo file Views/TutorList.php
        require_once __DIR__ . '/../Views/TutorList.php';
    }

    // Trang chi tiết profile 1 gia sư
    public function profile(int $id): void
    {
        $tutor = $this->tutorModel->findById($id);

        if (!$tutor) {
            http_response_code(404);
            die('Không tìm thấy gia sư.');
        }

        // TODO: Thành viên 3 tạo Views/TutorProfile.php
        require_once __DIR__ . '/../Views/TutorProfile.php';
    }

    // Dashboard của gia sư (cần đăng nhập)
    public function dashboard(): void
    {
        requireLogin();
        requireRole('tutor');

        $user  = currentUser();
        $tutor = $this->tutorModel->findByUserId($user['id']);

        // TODO: Thành viên 3 render GiaoDien_GS.php
        require_once __DIR__ . '/../Views/GiaoDien_GS.php';
    }
    // Trong TutorController.php
public function contact() {
    $id = $_GET['id']; // Nhận ID từ URL
    
    // Gọi Model để lấy thông tin đúng người đó
    $tutorModel = new TutorModel(); 
    $student = $tutorModel->getTutorById($id);
    
    // Đẩy dữ liệu qua View
    require_once 'Views/GiaoDien_GS.php'; 
}
}
