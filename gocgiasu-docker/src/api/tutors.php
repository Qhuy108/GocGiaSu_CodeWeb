<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../models/TutorModel.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';
$model  = new TutorModel();

switch ($action) {
    case 'search':
        $filters = [
            'subject_id' => $_GET['subject_id'] ?? '',
            'location'   => $_GET['location']   ?? '',
            'max_rate'   => $_GET['max_rate']    ?? '',
        ];
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $tutors  = $model->search($filters, $page);
        $total   = $model->countSearch($filters);
        $pages   = ceil($total / ITEMS_PER_PAGE);

        echo json_encode([
            'success' => true,
            'tutors'  => $tutors,
            'total'   => $total,
            'page'    => $page,
            'pages'   => $pages,
        ]);
        break;

    case 'detail':
        $id    = (int)($_GET['id'] ?? 0);
        $tutor = $model->findById($id);
        if (!$tutor) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy gia sư']);
        } else {
            echo json_encode(['success' => true, 'tutor' => $tutor]);
        }
        break;

    case 'approve':
    case 'reject':
        requireAdmin();
        $id     = (int)($_POST['id'] ?? 0);
        $status = $action === 'approve' ? 'approved' : 'rejected';
        $ok     = $model->updateStatus($id, $status);
        echo json_encode(['success' => $ok]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
}
