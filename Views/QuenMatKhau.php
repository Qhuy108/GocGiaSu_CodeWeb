<?php
$pageTitle  = 'Quên mật khẩu | Góc Gia Sư';
$activePage = '';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';

$step = $step ?? 'email';
$validSteps = ['email', 'verify', 'reset'];
if (!in_array($step, $validSteps, true)) {
    $step = 'email';
}
$resetEmail = $_SESSION['password_reset']['email'] ?? '';
?>

<main class="auth-page py-5" style="min-height: calc(100vh - 130px); position: relative;">
    <i class="bi bi-shield-lock-fill decor-illustration" style="top: 8%; right: 4%; font-size: 10rem;"></i>
    <i class="bi bi-envelope-open-fill decor-illustration" style="bottom: 6%; left: 4%; font-size: 8rem;"></i>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="role-card shadow-lg bg-white">
                    <div class="auth-header">
                        <?php if ($step === 'verify'): ?>
                            <h2>XÁC NHẬN MÃ</h2>
                        <?php elseif ($step === 'reset'): ?>
                            <h2>ĐẶT MẬT KHẨU MỚI</h2>
                        <?php else: ?>
                            <h2>QUÊN MẬT KHẨU</h2>
                        <?php endif; ?>
                    </div>

                    <div class="card-body p-4 p-xl-5">
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success mb-4">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger mb-4">
                                <?php foreach ($errors as $error): ?>
                                    <div><?= htmlspecialchars($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <p class="text-center text-muted mb-4 small">
                            <?php if ($step === 'verify'): ?>
                                <i>Nhập mã xác nhận đã được gửi tới email của bạn.</i>
                            <?php elseif ($step === 'reset'): ?>
                                <i>Nhập mật khẩu mới và xác nhận lại.</i>
                            <?php else: ?>
                                <i>Nhập email để khôi phục tài khoản Góc Gia Sư của bạn.</i>
                            <?php endif; ?>
                        </p>

                        <form method="POST" action="/index.php?page=forgot_password">
                            <input type="hidden" name="step" value="<?= htmlspecialchars($step) ?>">

                            <?php if ($step === 'verify' || $step === 'reset'): ?>
                                <div class="auth-input-group mb-3">
                                    <i class="bi bi-envelope-at-fill"></i>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($resetEmail) ?>" readonly>
                                    <input type="hidden" name="email" value="<?= htmlspecialchars($resetEmail) ?>">
                                </div>
                            <?php endif; ?>

                            <?php if ($step === 'email'): ?>
                                <div class="auth-input-group">
                                    <i class="bi bi-envelope-at-fill"></i>
                                    <input type="email" name="email" class="form-control" placeholder="Nhập email đã đăng ký của bạn" required value="<?= htmlspecialchars($oldData['Email'] ?? '') ?>">
                                </div>
                            <?php elseif ($step === 'verify'): ?>
                                <div class="auth-input-group">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    <input type="text" name="code" class="form-control" placeholder="Nhập mã xác nhận 6 chữ số" required maxlength="6" pattern="\d{6}">
                                </div>
                            <?php else: ?>
                                <div class="auth-input-group mb-3">
                                    <i class="bi bi-lock-fill"></i>
                                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới" required>
                                </div>
                                <div class="auth-input-group">
                                    <i class="bi bi-lock-fill"></i>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu mới" required>
                                </div>
                            <?php endif; ?>

                            <button type="submit" class="btn-auth">
                                <?php if ($step === 'verify'): ?>
                                    XÁC NHẬN MÃ
                                <?php elseif ($step === 'reset'): ?>
                                    CẬP NHẬT MẬT KHẨU
                                <?php else: ?>
                                    GỬI YÊU CẦU XÁC NHẬN
                                <?php endif; ?>
                            </button>

                            <div class="text-center mt-4">
                                <span class="small">Bạn đã nhớ ra mật khẩu? </span>
                                <a href="/index.php?page=login" class="text-teal fw-bold small text-decoration-none">[Đăng nhập]</a>
                            </div>

                            <?php if ($step === 'verify'): ?>
                                <div class="text-center mt-3">
                                    <a href="/index.php?page=forgot_password&step=email" class="text-muted small text-decoration-none">Gửi lại mã / đổi email</a>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>