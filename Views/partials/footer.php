<?php
/**
 * Footer dùng chung cho tất cả trang.
 *
 * Cách dùng:
 *   <?php require_once __DIR__ . '/../partials/footer.php'; ?>
 *
 * Đặt ở cuối <body>, ngay trước </body></html>
 */
?>

<!-- ===== FOOTER ===== -->
<footer class="footer-section pt-5 pb-3 mt-5" style="background-color: #042940; color: #D6D58E;">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="row g-4">

            <!-- Cột 1: Thương hiệu + mô tả -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="/assets/graduation.png" width="40" alt="Logo">
                    <span class="fw-bold fs-5" style="color: #9FC131;">Góc Gia Sư</span>
                </div>
                <p class="small" style="color: #D6D58E;">
                    Nền tảng kết nối học sinh và gia sư uy tín. Chúng tôi giúp bạn
                    tìm đúng gia sư, đúng môn học, đúng thời điểm.
                </p>
                <!-- Mạng xã hội -->
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-decoration-none" style="color: #9FC131;" aria-label="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-decoration-none" style="color: #9FC131;" aria-label="Zalo">
                        <i class="bi bi-chat-dots fs-5"></i>
                    </a>
                    <a href="#" class="text-decoration-none" style="color: #9FC131;" aria-label="YouTube">
                        <i class="bi bi-youtube fs-5"></i>
                    </a>
                </div>
            </div>

            <!-- Cột 2: Liên kết nhanh -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="color: #9FC131; letter-spacing: 1px;">Liên kết</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="/index.php" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/index.php?page=about" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Giới thiệu
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/index.php?page=tutors" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Tìm gia sư
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/Views/DangNhap.php" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Đăng nhập
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/index.php?page=register" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Đăng ký dạy
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Cột 3: Hỗ trợ -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="color: #9FC131; letter-spacing: 1px;">Hỗ trợ</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Câu hỏi thường gặp
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Chính sách bảo mật
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Điều khoản dịch vụ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Cột 4: Liên hệ -->
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="color: #9FC131; letter-spacing: 1px;">Liên hệ</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill mt-1" style="color: #9FC131;"></i>
                        <span>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill" style="color: #9FC131;"></i>
                        <a href="tel:0901234567" class="text-decoration-none footer-link">0901 234 567</a>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill" style="color: #9FC131;"></i>
                        <a href="mailto:lienhe@gocgiasu.vn" class="text-decoration-none footer-link">lienhe@gocgiasu.vn</a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Đường kẻ ngang -->
        <hr style="border-color: rgba(214, 213, 142, 0.3); margin-top: 2rem;">

        <!-- Copyright -->
        <div class="text-center small" style="color: #D6D58E; opacity: 0.7;">
            &copy; <?= date('Y') ?> Góc Gia Sư. Tất cả các quyền được bảo lưu.
        </div>
    </div>
</footer>

<!-- CSS riêng cho footer (đặt trong thẻ này để không ảnh hưởng style.css chính) -->
<style>
.footer-link {
    color: #D6D58E;
    transition: color 0.2s ease;
}
.footer-link:hover {
    color: #9FC131;
}
@media (min-width: 1400px) {
    .footer-section { font-size: 0.95rem; }
    .footer-section h6 { font-size: 1rem; }
}
@media (min-width: 1920px) {
    .footer-section { font-size: 1rem; }
    .footer-section h6 { font-size: 1.1rem; }
    .footer-section .fs-5 { font-size: 1.4rem !important; }
}
</style>

<!-- Bootstrap JS (Bundle gồm Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<!-- ===== KẾT THÚC FOOTER ===== -->
