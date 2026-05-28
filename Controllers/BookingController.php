<?php
/**
 * BookingController – Quản lý đặt lịch / yêu cầu học
 * NGƯỜI PHỤ TRÁCH: Thành viên 5
 */

require_once __DIR__ . '/../Models/BookingModel.php';
require_once __DIR__ . '/../Models/TutorModel.php';
require_once __DIR__ . '/../core/session.php';

class BookingController
{
    private BookingModel $bookingModel;
    private TutorModel   $tutorModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->tutorModel   = new TutorModel();
    }

    // Trang dashboard học sinh – xem lịch sử đặt lớp
    public function index(): void
    {
        requireLogin();
        requireRole('student');

        $user     = currentUser();
        $bookings = $this->bookingModel->getByStudent($user['id']);

        require_once __DIR__ . '/../Views/giao_dien_hoc_sinh.php';
    }

    // Học sinh gửi yêu cầu đặt gia sư
    public function create(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=tutors');
            exit;
        }

        $user    = currentUser();
        $tutorId = (int)($_POST['tutor_id'] ?? 0);

        // TODO: Thành viên 5 viết phần này
        // 1. Validate: Tutor_id tồn tại và Status = 'approved'
        // 2. Lấy thông tin từ $_POST (Date, Time, Subject_id, Note)
        // 3. Gọi $this->bookingModel->create([...])
        // 4. Redirect về dashboard học sinh với thông báo thành công
    }

    // Gia sư chấp nhận / từ chối yêu cầu
    public function updateStatus(): void
    {
        requireLogin();
        requireRole('tutor');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=tutor_dashboard');
            exit;
        }

        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $status    = $_POST['status'] ?? '';

        // Chỉ cho phép các trạng thái hợp lệ
        $allowedStatuses = ['confirmed', 'cancelled', 'done'];
        if (!in_array($status, $allowedStatuses, true)) {
            die('Trạng thái không hợp lệ.');
        }

        // $this->bookingModel->updateStatus($bookingId, $status);
        // header('Location: /index.php?page=tutor_dashboard');
    }

    // Học sinh huỷ yêu cầu (chỉ khi còn đang chờ)
    public function cancel(): void
    {
        requireLogin();
        requireRole('student');

        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $user      = currentUser();

        // TODO: Thành viên 5 viết phần này
        // 1. Kiểm tra booking thuộc về học sinh này
        // 2. Kiểm tra Status = 'pending' mới cho huỷ
        // 3. $this->bookingModel->updateStatus($bookingId, 'cancelled')
        // 4. Redirect về dashboard
    }
}
