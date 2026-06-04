<?php
$pageTitle  = 'Xác thực Email | Góc Gia Sư';
$activePage = '';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';

$email = $email ?? '';
?>

<main class="auth-page py-5" style="min-height: calc(100vh - 130px); position: relative;">
    <i class="bi bi-shield-check-fill decor-illustration" style="top: 8%; right: 4%; font-size: 10rem;"></i>
    <i class="bi bi-envelope-check-fill decor-illustration" style="bottom: 6%; left: 4%; font-size: 8rem;"></i>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="role-card shadow-lg bg-white">
                    <div class="auth-header">
                        <h2>XÁC THỰC EMAIL</h2>
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
                                    <div><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <p class="text-center text-muted mb-4 small">
                            <i>Nhập mã xác thực 6 chữ số đã được gửi tới email: <strong><?= htmlspecialchars($email) ?></strong></i>
                        </p>

                        <form method="POST" action="/index.php?page=verify_email">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                            <input type="hidden" name="action" value="verify">

                            <div class="auth-input-group mb-4">
                                <i class="bi bi-shield-lock-fill"></i>
                                <input type="text" name="code" class="form-control" placeholder="Mã xác thực 6 chữ số" required maxlength="6" pattern="\d{6}">
                            </div>

                            <button type="submit" class="btn-auth">
                                XÁC THỰC NGAY
                            </button>
                        </form>

                        <form method="POST" action="/index.php?page=verify_email" class="mt-3">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                            <input type="hidden" name="action" value="resend">
                            <div class="text-center">
                                <span class="small text-muted">Không nhận được mã? </span>
                                <button type="submit" class="btn btn-link p-0 text-teal fw-bold small text-decoration-none">Gửi lại mã</button>
                            </div>
                        </form>

                        <div class="text-center mt-4 border-top pt-3">
                            <a href="/index.php?page=login" class="text-muted small text-decoration-none">Quay lại Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
