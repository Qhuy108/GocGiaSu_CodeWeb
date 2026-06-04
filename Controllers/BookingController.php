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
        $sessions  = (int)($_POST['total_sessions'] ?? 1);

        if ($tutorId <= 0 || $subjectId <= 0 || $date === '' || $sessions <= 0) {
            header('Location: /index.php?page=tutors&error=missing_booking_info');
            exit;
        }

        $tutor = $this->tutorModel->findById($tutorId);
        if (!$tutor) {
            header('Location: /index.php?page=tutors&error=tutor_not_found');
            exit;
        }

        // Lấy tên môn học để hiển thị
        $subjectName = '';
        $subjects = $this->tutorModel->getSubjectsByTutorId($tutorId);
        foreach ($subjects as $s) {
            if ((int)$s['Id'] === $subjectId) {
                $subjectName = $s['Name'];
                break;
            }
        }

        // Lưu vào session để sang bước thanh toán
        $_SESSION['pending_booking'] = [
            'Student_id'     => $user['id'],
            'Tutor_id'       => $tutorId,
            'Tutor_name'     => $tutor['Name'],
            'Subject_id'     => $subjectId,
            'Subject_name'   => $subjectName,
            'Date'           => $date,
            'Time'           => $time,
            'Note'           => $note,
            'Total_sessions' => $sessions,
            'Hourly_rate'    => (float)$tutor['Hourly_rate'],
            'Total_price'    => (float)$tutor['Hourly_rate'] * $sessions,
        ];

        header('Location: /index.php?page=payment');
        exit;
    }

    public function payment(): void
    {
        requireLogin();
        requireRole('student');

        if (!isset($_SESSION['pending_booking'])) {
            header('Location: /index.php?page=tutors');
            exit;
        }

        $booking = $_SESSION['pending_booking'];
        require_once __DIR__ . '/../Views/Payment.php';
    }

    public function processPayment(): void
    {
        requireLogin();
        requireRole('student');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['pending_booking'])) {
            header('Location: /index.php?page=tutors');
            exit;
        }

        $bookingData = $_SESSION['pending_booking'];
        $receiptPath = null;

        if (isset($_FILES['payment_receipt']) && $_FILES['payment_receipt']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['payment_receipt'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
                $uploadDir = __DIR__ . '/../assets/uploads/payments';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'pay_' . $bookingData['Student_id'] . '_' . time() . '.' . $ext;
                $dest = $uploadDir . '/' . $filename;

                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $receiptPath = 'assets/uploads/payments/' . $filename;
                }
            }
        }

        if (!$receiptPath) {
            header('Location: /index.php?page=payment&error=upload_failed');
            exit;
        }

        // Lưu vào database
        $bookingData['Payment_receipt'] = $receiptPath;
        $bookingData['Payment_status']  = 'pending_approval';

        $this->bookingModel->create($bookingData);

        // Xóa session
        unset($_SESSION['pending_booking']);

        header('Location: /index.php?page=student&success=payment_submitted');
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

        $mailSent = true;
        if ($status === 'confirmed') {
            require_once __DIR__ . '/../core/MailService.php';
            $mailService = new MailService();
            $details = $this->bookingModel->getBookingDetailsWithUsers($bookingId);
            
            if ($details) {
                $mailSent = $mailService->sendTutorConfirmedEmail(
                    $details['StudentEmail'],
                    $details['StudentName'],
                    $details['TutorName'],
                    $details['TutorEmail'],
                    $details['TutorPhone'],
                    $details['SubjectName'],
                    $details['Date'],
                    $details['Time']
                );
            }
        }

        $errorQuery = !$mailSent ? '&error=mail_failed' : '';
        header('Location: /index.php?page=tutor_dashboard&success=status_updated' . $errorQuery);
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

        if ($this->reviewModel->existsForBooking($bookingId)) {
            header('Location: /index.php?page=student&error=already_reviewed');
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