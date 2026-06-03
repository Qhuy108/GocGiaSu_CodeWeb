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

    $tutors = $this->tutorModel->getApproved(
        $filters,
        $limit,
        $offset
    );

    $tongTrang = ceil(
        $this->tutorModel->countApproved($filters)
        / $limit
    );

    require_once __DIR__ . '/../Views/TutorList.php';
}

    // Dashboard của gia sư (cần đăng nhập)
   // Trong Controllers/TutorController.php
public function dashboard(): void
{
    requireLogin();
    requireRole('tutor');

    $user = currentUser();
    // Lấy thông tin gia sư từ database dựa trên User_id của người đang đăng nhập
    $tutor = $this->tutorModel->findByUserId($user['id']);

    // Truyền biến $tutor này sang view GiaoDien_GS.php
    require_once __DIR__ . '/../Views/GiaoDien_GS.php';
}

    // Trong TutorController.php
public function contact()
{
    http_response_code(404);
    echo "Not used";
    exit;
}

public function profile(): void
{
    $id = (int)($_GET['id'] ?? 0);

    $tutor = $this->tutorModel->findById($id);

    if (!$tutor) {
        die('Không tìm thấy gia sư');
    }

    require_once __DIR__ . '/../Views/TutorProfile.php';
}
// Trong TutorController.php
// Trong Controllers/TutorController.php

public function myClasses(): void
{
    requireLogin();
    requireRole('tutor');

    $user   = currentUser();
    $tutor  = $this->tutorModel->findByUserId($user['id']);

    require_once __DIR__ . '/../Models/BookingModel.php';
    $bookingModel = new BookingModel();
    $classes = $tutor ? $bookingModel->getByTutor((int)$tutor['Id'], 'confirmed') : [];

    require_once __DIR__ . '/../Views/lop-da-nhan.php';
}
}
