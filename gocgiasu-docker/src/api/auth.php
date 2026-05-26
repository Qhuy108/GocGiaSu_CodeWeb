<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../controllers/AuthController.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$ctrl   = new AuthController();

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']); exit;
        }
        $result = $ctrl->login($_POST);
        if ($result['success']) {
            $redirect = match($result['role']) {
                'admin'  => '/views/admin/dashboard.php',
                'tutor'  => '/views/tutor/dashboard.php',
                default  => '/views/tutor/search.php',
            };
            $result['redirect'] = $redirect;
        }
        echo json_encode($result);
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']); exit;
        }
        $result = $ctrl->register($_POST);
        if ($result['success']) {
            $result['redirect'] = $result['role'] === 'tutor'
                ? '/views/tutor/register-profile.php'
                : '/views/tutor/search.php';
        }
        echo json_encode($result);
        break;

    case 'logout':
        $ctrl->logout();
        echo json_encode(['success' => true, 'redirect' => '/views/auth/login.php']);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
}
