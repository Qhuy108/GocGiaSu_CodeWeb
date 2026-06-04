<?php
require_once __DIR__ . '/../Models/StudentPostModel.php';
require_once __DIR__ . '/../core/session.php';

class StudentPostController
{
    private StudentPostModel $model;

    public function __construct()
    {
        $this->model = new StudentPostModel();
    }

    // Học sinh đăng tin tìm gia sư
    public function create(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=student');
            exit;
        }

        $subject  = trim($_POST['subject'] ?? '');
        $grade    = trim($_POST['grade'] ?? '');
        $goal     = trim($_POST['goal'] ?? '');
        $budget   = (int)($_POST['budget'] ?? 200000);
        $days     = trim($_POST['days'] ?? '');
        $schedule = trim($_POST['schedule'] ?? '');

        if ($subject === '' || $grade === '') {
            header('Location: /index.php?page=student&error=missing_fields');
            exit;
        }

        $user = currentUser();
        $this->model->create([
            'Student_id' => $user['id'],
            'Subject'    => $subject,
            'Grade'      => $grade,
            'Goal'       => $goal,
            'Budget'     => $budget,
            'Days'       => $days,
            'Schedule'   => $schedule,
        ]);

        header('Location: /index.php?page=student&success=post_created');
        exit;
    }

    // Gia sư xem danh sách bài đăng của học sinh
    public function index(): void
    {
        requireLogin();
        requireRole('tutor');

        $limit     = 10;
        $trang     = max(1, (int)($_GET['trang'] ?? 1));
        $offset    = ($trang - 1) * $limit;
        $posts     = $this->model->getAll($limit, $offset);
        $tongBai   = $this->model->countAll();
        $tongTrang = (int)ceil($tongBai / $limit);

        require_once __DIR__ . '/../Views/StudentPosts.php';
    }

    // Học sinh đóng bài đăng của mình
    public function close(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=student');
            exit;
        }

        $user = currentUser();
        $id   = (int)($_POST['post_id'] ?? 0);
        if ($id > 0) {
            $this->model->close($id, $user['id']);
        }

        header('Location: /index.php?page=student&success=post_closed');
        exit;
    }
}
