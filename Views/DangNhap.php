<?php
$pageTitle  = 'Đăng nhập | Góc Gia Sư';
$activePage = 'login';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';
?>

<style>
    .auth-page {
        background: linear-gradient(135deg, rgba(4, 41, 64, 0.02) 0%, rgba(0, 92, 83, 0.02) 100%);
        padding-top: 80px !important; 
        padding-bottom: 60px !important;
    }

    .decor-illustration {
        position: absolute;
        color: #005C53;
        opacity: 0.05;
        pointer-events: none;
        z-index: 0;
    }

    /* Auth card header gradient */
    .auth-header {
        background: linear-gradient(135deg, #042940 0%, #005C53 100%);
        padding: 28px 24px !important;
        color: #DBF227;
        text-align: center;
        border-radius: 24px 24px 0 0;
    }

    .auth-header h2 {
        color: #DBF227;
        font-weight: 800;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        margin: 0;
    }

    /* Auth input group styling */
    .auth-input-group {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }

    .auth-input-group i {
        position: absolute;
        left: 14px;
        color: #005C53;
        font-size: 1.1rem;
        z-index: 10;
    }

    .auth-input-group .form-control {
        padding-left: 44px;
        border: 2px solid #E0E7F1;
        border-radius: 12px;
        height: 48px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #FAFBFC;
    }

    .auth-input-group .form-control:focus {
        border-color: #9FC131;
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(159, 193, 49, 0.1);
        outline: none;
    }

    .auth-input-group .form-control::placeholder {
        color: #9ca3af;
    }

    /* Submit button */
    .btn-auth {
        width: 100%;
        background: linear-gradient(135deg, #9FC131 0%, #DBF227 100%);
        color: #042940;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(159, 193, 49, 0.2);
        margin-top: 8px;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(159, 193, 49, 0.3);
        background: linear-gradient(135deg, #DBF227 0%, #E8FF00 100%);
    }

    .btn-auth:active {
        transform: translateY(0);
    }

    /* Link styling */
    .text-teal-link {
        color: #005C53 !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .text-teal-link:hover {
        color: #9FC131 !important;
    }

    /* Alert styling */
    .alert {
        border-radius: 12px;
        border: none;
    }

    .alert-success {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .alert-danger {
        background-color: #FEE2E2;
        color: #991B1B;
    }

    /* Form check styling */
    .form-check-input {
        border: 2px solid #D1D5DB;
        border-radius: 6px;
        width: 20px;
        height: 20px;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: #9FC131;
        border-color: #9FC131;
    }

    .form-check-input:focus {
        border-color: #9FC131;
        box-shadow: 0 0 0 3px rgba(159, 193, 49, 0.1);
    }
</style>

<main class="auth-page py-5" style="min-height: calc(100vh - 130px); position: relative;">
    <i class="bi bi-shield-lock-fill decor-illustration" style="top: 8%; right: 4%; font-size: 10rem;"></i>
    <i class="bi bi-mortarboard decor-illustration" style="bottom: 6%; left: 4%; font-size: 8rem;"></i>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            
            <div class="col-lg-6 col-md-8">
                <div class="role-card shadow-lg bg-white">
                    
                    <div class="auth-header">
                        <h2>ĐĂNG NHẬP</h2>
                    </div>

                    <div class="card-body p-4 p-xl-5">
                        <p class="text-center text-muted mb-4 small"><i>Chào mừng bạn quay trở lại với Góc Gia Sư</i></p>

                        <form method="POST" action="/index.php?page=login">
                            <?php if (!empty($_GET['registered']) && $_GET['registered'] === '1'): ?>
                                <div class="alert alert-success mb-4">
                                    Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($_GET['reset']) && $_GET['reset'] === '1'): ?>
                                <div class="alert alert-success mb-4">
                                    Mật khẩu mới đã được cập nhật. Vui lòng đăng nhập lại.
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger mb-4">
                                    <?php foreach ($errors as $error): ?>
                                        <div><?= htmlspecialchars($error) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="auth-input-group">
                                <i class="bi bi-person-circle"></i>
                                <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="form-control" placeholder="Email hoặc Số điện thoại" required>
                            </div>

                            <div class="auth-input-group">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" class="form-check-input mt-0" id="rememberMe" style="cursor: pointer;">
                                    <label class="form-check-label small text-muted" for="rememberMe" style="cursor: pointer; user-select: none;">Ghi nhớ</label>
                                </div>
                                <a href="/index.php?page=forgot_password" class="text-teal-link small text-decoration-none fw-bold">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" class="btn-auth">ĐĂNG NHẬP NGAY</button>
                         
                            <div class="text-center pt-2 mt-4 border-top">
                                <span class="small text-muted">Chưa có tài khoản? Đăng ký làm:</span>
                                <div class="d-flex justify-content-center gap-3 mt-2">
                                    <a href="/index.php?page=register" class="text-teal-link fw-bold small text-decoration-none">[Học sinh]</a>
                                    <span class="text-muted">|</span>
                                    <a href="/index.php?page=register_tutor" class="text-teal-link fw-bold small text-decoration-none">[Gia sư]</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>