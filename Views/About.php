<?php
$pageTitle  = 'Giới Thiệu – Góc Gia Sư';
$activePage = 'about';
$cssPath    = 'css/style.css';
$assetPath  = 'assets/';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1 class="fw-bold mb-4" style="color:#042940;">Giới thiệu về Góc Gia Sư</h1>

            <p class="lead mb-4">
                <strong>Góc Gia Sư</strong> là nền tảng kết nối học sinh với gia sư chất lượng cao,
                giúp việc tìm kiếm và đặt lịch học trở nên dễ dàng, nhanh chóng và hiệu quả.
            </p>

            <h4 class="fw-bold mt-5 mb-3" style="color:#005C53;">Sứ mệnh</h4>
            <p>
                Chúng tôi tin rằng mỗi học sinh đều xứng đáng được học với người thầy phù hợp nhất.
                Góc Gia Sư ra đời để xóa bỏ rào cản tìm kiếm, giúp học sinh và gia sư dễ dàng kết nối với nhau.
            </p>

            <h4 class="fw-bold mt-5 mb-3" style="color:#005C53;">Tại sao chọn Góc Gia Sư?</h4>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gia sư được kiểm duyệt kỹ càng</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Đa dạng môn học và khu vực</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Đặt lịch học trực tuyến tiện lợi</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Hệ thống đánh giá minh bạch</li>
            </ul>

            <div class="text-center mt-5">
                <a href="/index.php?page=tutors" class="btn btn-lg px-5 fw-bold rounded-pill"
                   style="background:#9FC131; color:#fff;">
                    Tìm gia sư ngay
                </a>
            </div>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
