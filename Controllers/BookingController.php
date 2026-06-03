<?php
/**
 * BookingController – Quản lý đặt lịch / yêu cầu học
 * NGƯỜI PHỤ TRÁCH: Thành viên 5
 */

require_once __DIR__ . '/../Models/BookingModel.php';
require_once __DIR__ . '/../Models/TutorModel.php';
require_once __DIR__ . '/../Models/ReviewModel.php';
require_once __DIR__ . '/../core/session.php';

class BookingController
{
    private BookingModel $bookingModel;
    private TutorModel $tutorModel;
    private ReviewModel $reviewModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->tutorModel   = new TutorModel();
        $this->reviewModel  = new ReviewModel();
    }

    public function index(): void
    {
        requireLogin();
        requireRole('student');

        $user     = currentUser();
        $bookings = $this->bookingModel->getByStudent($user['id']);

        require_once __DIR__ . '/../Views/GiaoDien_HS.php';
    }

    // AJAX endpoint: trả về HTML chứa danh sách thẻ gia sư theo filter
    public function filter_tutors(): void
    {
        requireLogin();
        requireRole('student');

        $filters = [
            'mon_hoc'   => $_GET['mon_hoc'] ?? null,
            'khu_vuc'   => $_GET['khu_vuc'] ?? null,
            'muc_luong' => $_GET['muc_luong'] ?? null,
        ];

        $limit = 12;
        $tutors = $this->tutorModel->getApproved($filters, $limit, 0);

        // Trả về chỉ phần HTML card (partial)
        require_once __DIR__ . '/../Views/partials/tutor_cards.php';
        exit;
    }

    public function create(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=tutors');
            exit;
        }

        $user      = currentUser();
        $tutorId   = (int)($_POST['tutor_id'] ?? 0);
        $subjectId = (int)($_POST['subject_id'] ?? 0);
        $date      = trim($_POST['date'] ?? '');
        $time      = trim($_POST['time'] ?? '');
        $note      = trim($_POST['note'] ?? '');

        if ($tutorId <= 0 || $subjectId <= 0 || $date === '') {
            header('Location: /index.php?page=tutors&error=missing_booking_info');
            exit;
        }

        $this->bookingModel->create([
            'Student_id' => $user['id'],
            'Tutor_id'   => $tutorId,
            'Subject_id' => $subjectId,
            'Date'       => $date,
            'Time'       => $time,
            'Note'       => $note,
        ]);

        header('Location: /index.php?page=student&success=booking_created');
        exit;
    }

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

        $allowedStatuses = ['confirmed', 'cancelled', 'done'];
        if ($bookingId <= 0 || !in_array($status, $allowedStatuses, true)) {
            header('Location: /index.php?page=tutor_dashboard&error=invalid_status');
            exit;
        }

        $this->bookingModel->updateStatus($bookingId, $status);

        header('Location: /index.php?page=tutor_dashboard&success=status_updated');
        exit;
    }

    public function cancel(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=student');
            exit;
        }

        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $user      = currentUser();
        $booking   = $this->bookingModel->findById($bookingId);

        if (!$booking || (int)$booking['Student_id'] !== (int)$user['id']) {
            header('Location: /index.php?page=student&error=booking_not_found');
            exit;
        }

        if ($booking['Status'] !== 'pending') {
            header('Location: /index.php?page=student&error=cannot_cancel');
            exit;
        }

        $this->bookingModel->updateStatus($bookingId, 'cancelled');

        header('Location: /index.php?page=student&success=booking_cancelled');
        exit;
    }

    public function review(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=student');
            exit;
        }

        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $rating    = (int)($_POST['rating'] ?? 0);
        $comment   = trim($_POST['comment'] ?? '');
        $user      = currentUser();

        $booking = $this->bookingModel->findById($bookingId);

        if (!$booking || (int)$booking['Student_id'] !== (int)$user['id']) {
            header('Location: /index.php?page=student&error=booking_not_found');
            exit;
        }

        if ($booking['Status'] !== 'done') {
            header('Location: /index.php?page=student&error=booking_not_done');
            exit;
        }

        if ($rating < 1 || $rating > 5) {
            header('Location: /index.php?page=student&error=invalid_rating');
            exit;
        }

        $this->reviewModel->create([
            'Booking_id' => $bookingId,
            'Rating'     => $rating,
            'Comment'    => $comment,
        ]);

        header('Location: /index.php?page=student&success=review_created');
        exit;
    }
}