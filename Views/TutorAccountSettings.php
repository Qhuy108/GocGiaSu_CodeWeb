<?php
$pageTitle = 'Cài đặt tài khoản – Góc Gia Sư';
$cssPath   = '/css/style.css';
$assetPath = '/assets/';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="d-flex align-items-center mb-4 gap-3">
                <a href="/index.php?page=tutor_dashboard" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                </a>
                <h4 class="fw-bold mb-0" style="color:#042940;">Cài đặt tài khoản</h4>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3">
                <i class="fa-solid fa-check-circle me-2"></i>
                <?= $_GET['success'] === 'info' ? 'Cập nhật thông tin thành công!' : 'Đổi mật khẩu thành công!' ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger rounded-3">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <?php
                $errors = [
                    'wrong_password'    => 'Mật khẩu hiện tại không đúng.',
                    'password_mismatch' => 'Mật khẩu mới không khớp.',
                    'password_short'    => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
                    'email_exists'      => 'Email này đã được sử dụng.',
                ];
                echo $errors[$_GET['error']] ?? 'Có lỗi xảy ra, vui lòng thử lại.';
                ?>
            </div>
            <?php endif; ?>

            <!-- Thông tin cá nhân -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4" style="color:#005C53;">
                    <i class="fa-solid fa-user me-2"></i> Thông tin cá nhân
                </h5>
                <form method="POST" action="/index.php?page=tutor_settings_update&type=info">

                    <div class="mb-3">
                        <label class="form-label fw-medium">Họ và tên</label>
                        <input type="text" name="Name" class="form-control rounded-3"
                               value="<?= htmlspecialchars($user['Name'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control rounded-3 bg-light"
                               value="<?= htmlspecialchars($user['Email'] ?? '') ?>" disabled>
                        <small class="text-muted">Email không thể thay đổi.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Số điện thoại</label>
                        <input type="text" name="Phone" class="form-control rounded-3"
                               value="<?= htmlspecialchars($user['Phone'] ?? '') ?>"
                               placeholder="Ví dụ: 0901234567">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn fw-bold rounded-pill py-2"
                                style="background:#9FC131; color:#fff;">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thông tin
                        </button>
                    </div>
                </form>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4" style="color:#005C53;">
                    <i class="fa-solid fa-lock me-2"></i> Đổi mật khẩu
                </h5>
                <form method="POST" action="/index.php?page=tutor_settings_update&type=password">

                    <div class="mb-3">
                        <label class="form-label fw-medium">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control rounded-3"
                               placeholder="Nhập mật khẩu hiện tại" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control rounded-3"
                               placeholder="Ít nhất 6 ký tự" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" class="form-control rounded-3"
                               placeholder="Nhập lại mật khẩu mới" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-outline-danger fw-bold rounded-pill py-2">
                            <i class="fa-solid fa-key me-2"></i> Đổi mật khẩu
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
