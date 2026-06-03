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

    $user  = currentUser();
    $tutor = $this->tutorModel->findByUserId($user['id']);

    require_once __DIR__ . '/../Models/BookingModel.php';
    $bookingModel    = new BookingModel();
    $pendingBookings = $tutor ? $bookingModel->getByTutor((int)$tutor['Id'], 'pending') : [];

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

    $tutorSubjects = $this->tutorModel->getSubjectsByTutorId((int)$tutor['Id']);

    require_once __DIR__ . '/../Views/TutorProfile.php';
}
public function editProfile(): void
{
    $user  = currentUser();
    $tutor = $this->tutorModel->findByUserId($user['id']);
    if (!$tutor) die('Không tìm thấy hồ sơ gia sư.');
    require_once __DIR__ . '/../Views/TutorEditProfile.php';
}

public function updateProfile(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /index.php?page=tutor_edit');
        exit;
    }
    $user  = currentUser();
    $tutor = $this->tutorModel->findByUserId($user['id']);
    if (!$tutor) die('Không tìm thấy hồ sơ gia sư.');

    $data = [
        'Bio'            => trim($_POST['Bio']            ?? ''),
        'Experience'     => trim($_POST['Experience']     ?? ''),
        'Qualifications' => trim($_POST['Qualifications'] ?? ''),
        'Location'       => trim($_POST['Location']       ?? ''),
        'Hourly_rate'    => (float)($_POST['Hourly_rate'] ?? 0),
    ];

    $this->tutorModel->update((int)$tutor['Id'], $data);

    // Xử lý upload ảnh
    if (!empty($_FILES['avatar']['name'])) {
        $file     = $_FILES['avatar'];
        $allowed  = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize  = 2 * 1024 * 1024; // 2MB

        if (in_array($file['type'], $allowed) && $file['size'] <= $maxSize && $file['error'] === 0) {
            $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'tutor_' . $user['id'] . '_' . time() . '.' . $ext;
            $dest     = __DIR__ . '/../assets/uploads/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $db = getDB();
                $db->prepare("UPDATE users SET Avatar = ? WHERE Id = ?")
                   ->execute([$filename, $user['id']]);
            }
        }
    }

    header('Location: /index.php?page=tutor_edit&success=1');
    exit;
}

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
