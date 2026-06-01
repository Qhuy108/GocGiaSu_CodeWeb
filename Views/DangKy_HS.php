<?php
$pageTitle  = 'Đăng ký Học sinh | Góc Gia Sư';
$activePage = '';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';
?>

<main class="auth-page py-5" style="min-height: calc(100vh - 130px); position: relative;">
    <i class="bi bi-pencil-fill decor-illustration" style="top: 8%; right: 4%; font-size: 10rem;"></i>
    <i class="bi bi-mortarboard decor-illustration" style="bottom: 6%; left: 4%; font-size: 8rem;"></i>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="role-card shadow-lg bg-white">
                    <div class="auth-header">
                        <h2>ĐĂNG KÝ HỌC SINH</h2>
                    </div>

                    <div class="card-body p-4 p-xl-5">
                        <p class="text-center text-muted mb-4 small"><i>Cùng Góc Gia Sư chinh phục tri thức mỗi ngày</i></p>

                        <form method="POST" action="/index.php?page=register">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger mb-4">
                                    <?php foreach ($errors as $error): ?>
                                        <div><?= htmlspecialchars($error) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="auth-input-group">
                                <i class="bi bi-person-circle"></i>
                                <input type="text" name="name" class="form-control" placeholder="Họ và tên học sinh" required value="<?= htmlspecialchars($oldData['Name'] ?? '') ?>">
                            </div>

                            <div class="auth-input-group">
                                <i class="bi bi-envelope-at-fill"></i>
                                <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= htmlspecialchars($oldData['Email'] ?? '') ?>">
                            </div>

                            <div class="auth-input-group">
                                <i class="bi bi-phone-fill"></i>
                                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại (tùy chọn)" value="<?= htmlspecialchars($oldData['Phone'] ?? '') ?>">
                            </div>

                            <div class="auth-input-group">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                            </div>

                            <div class="auth-input-group">
                                <i class="bi bi-shield-check-fill"></i>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu" required>
                            </div>

                            <div class="mb-4 form-check d-flex align-items-center justify-content-center gap-2">
                                <input type="checkbox" name="terms" class="form-check-input mt-0" id="terms" required>
                                <label class="form-check-label small text-muted" for="terms" style="cursor: pointer;">
                                    Tôi đồng ý với điều khoản của hệ thống
                                </label>
                            </div>

                            <button type="submit" class="btn-auth">ĐĂNG KÝ NGAY</button>

                            <div class="text-center mt-4">
                                <span class="small">Bạn đã có tài khoản? </span>
                                <a href="/index.php?page=login" class="text-teal fw-bold small text-decoration-none">[Đăng nhập]</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
