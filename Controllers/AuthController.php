<?php
/**
 * AuthController – Xử lý Đăng ký / Đăng nhập / Đăng xuất
 * NGƯỜI PHỤ TRÁCH: Thành viên 2
 */

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TutorModel.php';
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../core/MailService.php';

class AuthController
{
    private UserModel $userModel;
    private TutorModel $tutorModel;
    private MailService $mailService;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->tutorModel  = new TutorModel();
        $this->mailService = new MailService();
    }

    // ── Hiển thị form đăng nhập / xử lý POST ────────────────────────────

    public function login(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = trim($_POST['email']    ?? '');
            $password   = trim($_POST['password'] ?? '');

            if ($identifier === '' || $password === '') {
                $errors[] = 'Email/số điện thoại và mật khẩu không được để trống.';
            }

            if (!$errors) {
                $user = $this->userModel->findByEmail($identifier);
if (!$user) {
    $errors[] = 'Email/số điện thoại không tồn tại.';
} else {

    // Tài khoản test bỏ qua mật khẩu
    if (
        $user['Email'] !== 'giasu@gmail.com' &&
        !password_verify($password, $user['Password'])
    ) {
        $errors[] = 'Email/số điện thoại hoặc mật khẩu không đúng.';
    }

    if (!$errors && $user['is_verified'] == 0) {
        $errors[] = 'Tài khoản của bạn chưa được xác thực email. <a href="/index.php?page=verify_email&email=' . urlencode($user['Email']) . '">Xác thực ngay</a>';
    }

    if (!$errors && $user['Role'] === 'tutor') {
                        $tutor = $this->tutorModel->findByUserId((int)$user['Id']);
                        if (!$tutor) {
                            $errors[] = 'Hồ sơ gia sư chưa tồn tại. Vui lòng hoàn tất đăng ký.';
                        } elseif ($tutor['Status'] === 'pending') {
                            $errors[] = 'Tài khoản của bạn đang chờ Admin duyệt.';
                        } elseif ($tutor['Status'] === 'rejected') {
                            $errors[] = 'Hồ sơ của bạn đã bị từ chối.';
                        }
                    }
                }

                if (!$errors) {
                    setUserSession($user);

                    switch ($user['Role']) {
                        case 'student':
                            header('Location: /index.php?page=student');
                            break;
                        case 'tutor':
                            header('Location: /index.php?page=tutor_dashboard');
                            break;
                        case 'admin':
                            header('Location: /index.php?page=admin');
                            break;
                        default:
                            header('Location: /index.php?page=home');
                    }
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../Views/DangNhap.php';
    }

    // ── Quên mật khẩu / reset password ──────────────────────────────────────
    public function forgotPassword(): void
    {
        $errors   = [];
        $success  = '';
        $oldData  = [];
        $step     = $_POST['step'] ?? $_GET['step'] ?? 'email';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($step === 'email') {
                $email = trim($_POST['email'] ?? '');
                $oldData['Email'] = $email;

                if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Vui lòng nhập email hợp lệ.';
                }

                if (!$errors) {
                    $user = $this->userModel->findByEmail($email);
                    if (!$user) {
                        $errors[] = 'Email này chưa được đăng ký trên hệ thống.';
                    }
                }

                if (!$errors) {
                    $code = (string)random_int(100000, 999999);

                    $_SESSION['password_reset'] = [
                        'email'      => $email,
                        'code'       => $code,
                        'expires_at' => time() + 900,
                        'verified'   => false,
                    ];

                    $step    = 'verify';
                    $success = 'Mã xác nhận đã được tạo. Vui lòng kiểm tra email và nhập mã 6 chữ số.';
                    
                    // Gửi mail xác nhận quên mật khẩu
                    $this->mailService->sendOTP($email, $code, 'forgot_password');
                }
            } elseif ($step === 'verify') {
                if (!$this->hasValidPasswordResetSession()) {
                    $errors[] = 'Phiên xác nhận đã hết hạn. Vui lòng thử lại.';
                    $this->clearPasswordResetSession();
                    $step = 'email';
                } else {
                    $code = trim($_POST['code'] ?? '');

                    if ($code === '') {
                        $errors[] = 'Vui lòng nhập mã xác nhận.';
                    } elseif ($code !== $_SESSION['password_reset']['code']) {
                        $errors[] = 'Mã xác nhận không đúng. Vui lòng thử lại.';
                    }

                    if (!$errors) {
                        $_SESSION['password_reset']['verified'] = true;
                        $step = 'reset';
                        $success = 'Mã xác nhận hợp lệ. Vui lòng thiết lập mật khẩu mới.';
                    }
                }
            } elseif ($step === 'reset') {
                if (!$this->hasValidPasswordResetSession() || empty($_SESSION['password_reset']['verified'])) {
                    $errors[] = 'Bạn cần xác nhận mã trước khi đổi mật khẩu.';
                    $this->clearPasswordResetSession();
                    $step = 'email';
                } else {
                    $password = trim($_POST['password'] ?? '');
                    $confirm  = trim($_POST['confirm_password'] ?? '');

                    if ($password === '' || $confirm === '') {
                        $errors[] = 'Vui lòng nhập mật khẩu mới và xác nhận mật khẩu.';
                    } elseif ($password !== $confirm) {
                        $errors[] = 'Mật khẩu mới và xác nhận phải giống nhau.';
                    } elseif (strlen($password) < 8) {
                        $errors[] = 'Mật khẩu phải ít nhất 8 ký tự.';
                    }

                    if (!$errors) {
                        $user = $this->userModel->findByEmail($_SESSION['password_reset']['email']);

                        if (!$user) {
                            $errors[] = 'Không tìm thấy tài khoản. Vui lòng thử lại.';
                        }
                    }

                    if (!$errors) {
                        $this->userModel->update($user['Id'], [
                            'Password' => password_hash($password, PASSWORD_DEFAULT),
                        ]);
                        $this->clearPasswordResetSession();
                        header('Location: /index.php?page=login&reset=1');
                        exit;
                    }
                }
            }
        }

        require_once __DIR__ . '/../Views/QuenMatKhau.php';
    }

    private function hasValidPasswordResetSession(): bool
    {
        return isset($_SESSION['password_reset']['email'], $_SESSION['password_reset']['code'], $_SESSION['password_reset']['expires_at'])
            && time() <= $_SESSION['password_reset']['expires_at'];
    }

    private function clearPasswordResetSession(): void
    {
        unset($_SESSION['password_reset']);
    }

    // ── Đăng ký Học sinh ─────────────────────────────────────────────────────
        // ── Đăng ký Học sinh ─────────────────────────────────────────────────────
    public function registerStudent(): void
    {
        $errors  = [];
        $oldData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldData['Name']         = trim($_POST['name']             ?? '');
            $oldData['Email']        = trim($_POST['email']            ?? '');
            $oldData['Phone']        = trim($_POST['phone']            ?? '');
            $password                = trim($_POST['password']         ?? '');
            $confirmPassword         = trim($_POST['confirm_password'] ?? '');
            $acceptedTerms           = isset($_POST['terms']);

            if ($oldData['Name'] === '' || $oldData['Email'] === '' || $password === '' || $confirmPassword === '') {
                $errors[] = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
            }

            if ($oldData['Email'] !== '' && !filter_var($oldData['Email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không đúng định dạng.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Mật khẩu và xác nhận mật khẩu phải giống nhau.';
            }

            if (!$acceptedTerms) {
                $errors[] = 'Bạn phải đồng ý với điều khoản sử dụng.';
            }

            if (!$errors && $this->userModel->findByEmail($oldData['Email'])) {
                $errors[] = 'Email này đã được đăng ký. Vui lòng sử dụng email khác.';
            }

            if (!$errors) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userId = $this->userModel->create([
                    'Name'     => $oldData['Name'],
                    'Email'    => $oldData['Email'],
                    'Password' => $hashedPassword,
                    'Phone'    => $oldData['Phone'] ?: null,
                    'Role'     => 'student',
                ]);

                // Tạo OTP và gửi mail xác thực
                $otp = (string)random_int(100000, 999999);
                $expiresAt = date('Y-m-d H:i:s', time() + 900); // 15 phút
                $this->userModel->setVerificationCode($userId, $otp, $expiresAt);
                
                if ($this->mailService->sendOTP($oldData['Email'], $otp, 'register')) {
                    header('Location: /index.php?page=verify_email&email=' . urlencode($oldData['Email']));
                    exit;
                } else {
                    $errors[] = 'Tài khoản đã tạo nhưng không thể gửi email xác thực. Vui lòng bấm "Gửi lại mã" ở trang xác thực hoặc kiểm tra cấu hình SMTP.';
                    header('Location: /index.php?page=verify_email&email=' . urlencode($oldData['Email']) . '&error=1');
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../Views/DangKy_HS.php';
    }

    // ── Đăng ký Gia sư ───────────────────────────────────────────────────────
    public function registerTutor(): void
    {
        $errors  = [];
        $oldData = [];
        $isAjax  = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldData['name']         = trim($_POST['name'] ?? '');
            $oldData['email']        = trim($_POST['email'] ?? '');
            $oldData['phone']        = trim($_POST['phone'] ?? '');
            $oldData['password']     = trim($_POST['password'] ?? '');
            $oldData['location']     = trim($_POST['location'] ?? '');
            $oldData['bio']          = trim($_POST['bio'] ?? '');
            $oldData['experience']   = trim($_POST['experience'] ?? '');
            $oldData['hourly_rate']  = trim($_POST['hourly_rate'] ?? '');
            $oldData['subjects']     = $_POST['subjects'] ?? [];

            if (!is_array($oldData['subjects'])) {
                $oldData['subjects'] = [];
            }
            $selectedSubjectIds = array_values(array_filter(array_map('intval', $oldData['subjects']), fn($id) => $id > 0));
            $oldData['subjects'] = $selectedSubjectIds;

            if ($oldData['name'] === '' || $oldData['email'] === '' || $oldData['phone'] === '' || $oldData['password'] === '') {
                $errors[] = 'Vui lòng điền đầy đủ thông tin bắt buộc ở bước 1.';
            }
            if ($oldData['location'] === '' || $oldData['bio'] === '' || $oldData['experience'] === '' || $oldData['hourly_rate'] === '') {
                $errors[] = 'Vui lòng điền đầy đủ thông tin ở bước 2 và bước 3.';
            }
            if (!filter_var($oldData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không đúng định dạng.';
            }
            if (!is_numeric($oldData['hourly_rate']) || (float)$oldData['hourly_rate'] <= 0) {
                $errors[] = 'Học phí phải là một số dương.';
            }
            if (empty($oldData['subjects']) || !is_array($oldData['subjects'])) {
                $errors[] = 'Vui lòng chọn ít nhất một môn học.';
            }

            if (!$errors) {
                $pdo = getDB();
                if (count($oldData['subjects']) > 0) {
                    $placeholders = implode(',', array_fill(0, count($oldData['subjects']), '?'));
                    $stmt = $pdo->prepare("SELECT Id FROM subjects WHERE Id IN ($placeholders)");
                    $stmt->execute($oldData['subjects']);
                    $foundSubjects = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    $missing = array_diff($oldData['subjects'], array_map('intval', $foundSubjects));

                    if ($missing) {
                        $errors[] = 'Một hoặc nhiều môn học lựa chọn không hợp lệ.';
                    }
                }
            }

            if ($this->userModel->findByEmail($oldData['email'])) {
                $errors[] = 'Email này đã được đăng ký. Vui lòng sử dụng email khác.';
            }

            $qualificationPath = null;
            if (!isset($_FILES['certificateFile']) || $_FILES['certificateFile']['error'] === UPLOAD_ERR_NO_FILE) {
                $errors[] = 'Vui lòng tải lên ảnh chứng chỉ / bằng cấp hoặc thẻ sinh viên.';
            } else {
                $file = $_FILES['certificateFile'];
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $errors[] = 'Lỗi tải file chứng chỉ. Vui lòng thử lại.';
                } else {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                    if (!in_array($file['type'], $allowedTypes, true)) {
                        $errors[] = 'Chỉ cho phép tập tin ảnh JPG, PNG, WEBP.';
                    }
                    if ($file['size'] > 5 * 1024 * 1024) {
                        $errors[] = 'File chứng chỉ không được lớn hơn 5MB.';
                    }
                }
            }

            if (empty($errors)) {
                $pdo = getDB();
                $pdo->beginTransaction();

                try {
                    $hashedPassword = password_hash($oldData['password'], PASSWORD_DEFAULT);

                    $userId = $this->userModel->create([
                        'Name'     => $oldData['name'],
                        'Email'    => $oldData['email'],
                        'Password' => $hashedPassword,
                        'Phone'    => $oldData['phone'],
                        'Role'     => 'tutor',
                    ]);

                    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../assets/uploads/certificates';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $safeName  = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
                        $targetFile = sprintf('%s/%s_%s.%s', $uploadDir, $safeName, uniqid(), strtolower($extension));

                        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                            throw new RuntimeException('Không thể lưu file chứng chỉ.');
                        }

                        $qualificationPath = 'assets/uploads/certificates/' . basename($targetFile);
                    }

                    $tutorId = $this->tutorModel->create([
                        'User_id'        => $userId,
                        'Bio'            => $oldData['bio'],
                        'Experience'     => $oldData['experience'],
                        'Qualifications' => $qualificationPath,
                        'Location'       => $oldData['location'],
                        'Hourly_rate'    => (float)$oldData['hourly_rate'],
                    ]);

                    $stmtSubject = $pdo->prepare('INSERT INTO tutor_subjects (Tutor_id, Subject_id) VALUES (?, ?)');
                    foreach ($oldData['subjects'] as $subjectId) {
                        $stmtSubject->execute([$tutorId, (int)$subjectId]);
                    }

                    $pdo->commit();

                    // Tạo OTP và gửi mail xác thực
                    $otp = (string)random_int(100000, 999999);
                    $expiresAt = date('Y-m-d H:i:s', time() + 900); // 15 phút
                    $this->userModel->setVerificationCode($userId, $otp, $expiresAt);
                    $this->mailService->sendOTP($oldData['email'], $otp, 'register');

                    if ($isAjax) {
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(['status' => 'success', 'redirect' => '/index.php?page=verify_email&email=' . urlencode($oldData['email'])]);
                        exit;
                    }

                    header('Location: /index.php?page=verify_email&email=' . urlencode($oldData['email']));
                    exit;
                } catch (Exception $e) {
                    $pdo->rollBack();
                    error_log('Tutor registration error: ' . $e->getMessage());

                    if ($isAjax) {
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Đăng ký gia sư thất bại. Vui lòng thử lại sau.',
                            'detail'  => $e->getMessage(),
                        ]);
                        exit;
                    }

                    $errors[] = 'Đăng ký gia sư thất bại. Vui lòng thử lại sau.';
                }
            }

            if ($isAjax && !empty($errors)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'error', 'message' => implode(' ', $errors)]);
                exit;
            }
        }

        require_once __DIR__ . '/../Views/DangKy_GS.php';
    }

    // ── Đăng xuất ────────────────────────────────────────────────────────────
    public function logout(): void
    {
        destroySession();
        header('Location: /index.php');
        exit;
    }

    // ── Xác thực Email (Registration OTP) ────────────────────────────────────
    public function verifyEmail(): void
    {
        $errors  = [];
        $success = '';
        $email   = trim($_GET['email'] ?? $_POST['email'] ?? '');

        if ($email === '') {
            header('Location: /index.php?page=login');
            exit;
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            header('Location: /index.php?page=login');
            exit;
        }

        if ($user['is_verified'] == 1) {
            header('Location: /index.php?page=login&verified=1');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'verify';

            if ($action === 'verify') {
                $code = trim($_POST['code'] ?? '');

                if ($code === '') {
                    $errors[] = 'Vui lòng nhập mã xác thực.';
                } elseif ($code !== $user['verification_code']) {
                    $errors[] = 'Mã xác thực không đúng.';
                } elseif (strtotime($user['verification_expires_at']) < time()) {
                    $errors[] = 'Mã xác thực đã hết hạn. Vui lòng bấm gửi lại mã.';
                }

                if (!$errors) {
                    $this->userModel->verifyUser($user['Id']);
                    header('Location: /index.php?page=login&verified=1');
                    exit;
                }
            } elseif ($action === 'resend') {
                $otp = (string)random_int(100000, 999999);
                $expiresAt = date('Y-m-d H:i:s', time() + 900);
                $this->userModel->setVerificationCode($user['Id'], $otp, $expiresAt);
                $this->mailService->sendOTP($email, $otp, 'register');
                $success = 'Mã xác thực mới đã được gửi tới email của bạn.';
            }
        }

        require_once __DIR__ . '/../Views/XacThucEmail.php';
    }
}
