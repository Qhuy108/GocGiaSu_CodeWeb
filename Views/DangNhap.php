<?php
$pageTitle  = 'Đăng nhập | Góc Gia Sư';
$activePage = 'login';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';
?>

<style>
    .auth-page {
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
                            
                            <div class="auth-input-group">
                                <i class="bi bi-person-circle"></i>
                                <input type="text" name="email" class="form-control" placeholder="Email hoặc Số điện thoại" required>
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
                                <a href="#" class="text-teal small text-decoration-none fw-bold">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" class="btn-auth">ĐĂNG NHẬP NGAY</button>
                         
                            <div class="text-center pt-2 mt-4 border-top">
                                <span class="small text-muted">Chưa có tài khoản? Đăng ký làm:</span>
                                <div class="d-flex justify-content-center gap-3 mt-2">
                                    <a href="/index.php?page=register" class="text-teal fw-bold small text-decoration-none">[Học sinh]</a>
                                    <span class="text-muted">|</span>
                                    <a href="/Views/DangKy_GS.php" class="text-teal fw-bold small text-decoration-none">[Gia sư]</a>
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