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
public function editProfile(): void
{
    $user = currentUser();
    $tutor = $this->tutorModel->findByUserId($user['id']);

    if (!$tutor) {
        die('Không tìm thấy hồ sơ gia sư.');
    }

    require_once __DIR__ . '/../Views/TutorEditProfile.php';
}

public function updateProfile(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=tutor_dashboard');
        exit;
    }

    $user = currentUser();
    $tutor = $this->tutorModel->findByUserId($user['id']);

    if (!$tutor) {
        die('Không tìm thấy hồ sơ gia sư.');
    }

    $this->tutorModel->update((int)$tutor['Id'], [
        'Bio' => trim($_POST['Bio'] ?? ''),
        'Experience' => trim($_POST['Experience'] ?? ''),
        'Qualifications' => trim($_POST['Qualifications'] ?? ''),
        'Location' => trim($_POST['Location'] ?? ''),
        'Hourly_rate' => (float)($_POST['Hourly_rate'] ?? 0),
    ]);

    header('Location: index.php?page=tutor_profile&id=' . (int)$tutor['Id']);
    exit;
}

public function deleteProfile(): void
{
    $user = currentUser();
    $tutor = $this->tutorModel->findByUserId($user['id']);

    if (!$tutor) {
        die('Không tìm thấy hồ sơ gia sư.');
    }

    $this->tutorModel->delete((int)$tutor['Id']);

    header('Location: index.php?page=logout');
    exit;
}
}
