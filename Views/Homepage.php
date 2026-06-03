<?php
// ── Tuỳ chỉnh cho trang này ──────────────────────────────
$pageTitle  = 'Trang chủ - Góc Gia Sư';
$activePage = 'home';       // highlight menu "Trang chủ"
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';

// Nhúng header dùng chung
require_once __DIR__ . '/partials/header.php';
?>

<!-- ==================== NỘI DUNG TRANG CHỦ ==================== -->

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">

    <?php if (!$isLoggedIn): ?>
        <!-- Chưa đăng nhập: hiện BẠN LÀ? -->
        <h1 class="mb-5 fw-bold" style="color:#DBF227; font-size: 2.8rem;">BẠN LÀ?</h1>
        <div class="row justify-content-center g-4 mt-2">
            <div class="col-md-5 col-lg-4">
                <div class="card role-card p-4 h-100 d-flex flex-column">
                    <div class="mb-4 mt-2">
                        <img src="<?= $assetPath ?>student.png" alt="Học sinh" width="100">
                    </div>
                    <h3 class="text-teal fw-bold mb-3">HỌC SINH</h3>
                    <p class="text-navy mb-4 flex-grow-1">
                        Tìm kiếm gia sư uy tín, chất lượng để cải thiện thành tích học tập một cách hiệu quả nhất.
                    </p>
                    <a href="/index.php?page=tutors" class="btn btn-gocgiasu mt-auto">Tìm Gia Sư Ngay</a>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="card role-card p-4 h-100 d-flex flex-column">
                    <div class="mb-4 mt-2">
                        <img src="<?= $assetPath ?>teacher.png" alt="Gia sư" width="100">
                    </div>
                    <h3 class="text-teal fw-bold mb-3">GIA SƯ</h3>
                    <p class="text-navy mb-4 flex-grow-1">
                        Trở thành đối tác giảng dạy, linh hoạt thời gian và gia tăng thu nhập cho bản thân.
                    </p>
                    <a href="/index.php?page=register_tutor" class="btn btn-gocgiasu mt-auto">Đăng Ký Dạy</a>
                </div>
            </div>
        </div>

    <?php elseif ($userRole === 'student'): ?>
        <!-- Học sinh đã đăng nhập -->
        <h1 class="fw-bold mb-2" style="color:#DBF227; font-size:2.4rem;">
            Chào mừng trở lại, <?= htmlspecialchars($userName) ?>! 👋
        </h1>
        <p class="mb-5" style="color:#E8F0F8; font-size:1.1rem;">Hôm nay bạn muốn học gì?</p>
        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="card role-card p-4 h-100 d-flex flex-column">
                    <div class="mb-3"><img src="<?= $assetPath ?>findtutor.png" alt="" width="80"></div>
                    <h5 class="text-teal fw-bold mb-2">Tìm gia sư</h5>
                    <p class="text-navy small flex-grow-1">Khám phá hàng trăm gia sư chất lượng phù hợp với bạn.</p>
                    <a href="/index.php?page=tutors" class="btn btn-gocgiasu mt-auto">Tìm ngay</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card role-card p-4 h-100 d-flex flex-column">
                    <div class="mb-3"><img src="<?= $assetPath ?>student.png" alt="" width="80"></div>
                    <h5 class="text-teal fw-bold mb-2">Lịch học của tôi</h5>
                    <p class="text-navy small flex-grow-1">Xem và quản lý các buổi học đã đặt.</p>
                    <a href="/index.php?page=student" class="btn btn-gocgiasu mt-auto">Xem lịch</a>
                </div>
            </div>
        </div>

    <?php elseif ($userRole === 'tutor'): ?>
        <!-- Gia sư đã đăng nhập -->
        <h1 class="fw-bold mb-2" style="color:#DBF227; font-size:2.4rem;">
            Chào mừng trở lại, <?= htmlspecialchars($userName) ?>! 👋
        </h1>
        <p class="mb-5" style="color:#E8F0F8; font-size:1.1rem;">Hãy xem các yêu cầu mới từ học sinh.</p>
        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="card role-card p-4 h-100 d-flex flex-column">
                    <div class="mb-3"><img src="<?= $assetPath ?>teacher.png" alt="" width="80"></div>
                    <h5 class="text-teal fw-bold mb-2">Bảng tin</h5>
                    <p class="text-navy small flex-grow-1">Xem yêu cầu đặt lịch và quản lý lớp học.</p>
                    <a href="/index.php?page=tutor_dashboard" class="btn btn-gocgiasu mt-auto">Vào dashboard</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card role-card p-4 h-100 d-flex flex-column">
                    <div class="mb-3"><img src="<?= $assetPath ?>graduation.png" alt="" width="80"></div>
                    <h5 class="text-teal fw-bold mb-2">Lớp đã nhận</h5>
                    <p class="text-navy small flex-grow-1">Quản lý các lớp đang dạy của bạn.</p>
                    <a href="/index.php?page=my_classes" class="btn btn-gocgiasu mt-auto">Xem lớp</a>
                </div>
            </div>
        </div>

    <?php elseif ($userRole === 'admin'): ?>
        <!-- Admin đã đăng nhập -->
        <h1 class="fw-bold mb-2" style="color:#DBF227; font-size:2.4rem;">
            Xin chào Admin <?= htmlspecialchars($userName) ?>!
        </h1>
        <p class="mb-5" style="color:#E8F0F8;">Quản lý toàn bộ hệ thống Góc Gia Sư.</p>
        <a href="/index.php?page=admin" class="btn btn-gocgiasu btn-lg px-5 rounded-pill fw-bold">
            Vào Admin Panel
        </a>
    <?php endif; ?>

    </div>
</section>

<!-- Về Góc Gia Sư -->
<section id="about" class="py-5 bg-beige">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-md-6 text-center">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop"
                     alt="Về Góc Gia Sư"
                     class="img-fluid rounded-4 shadow-lg"
                     style="object-fit: cover; height: 400px; width: 100%;">
            </div>
            <div class="col-md-6">
                <h2 class="text-teal fw-bold mb-4">VỀ GÓC GIA SƯ</h2>
                <h4 class="text-navy fw-bold mb-3">Nền tảng kết nối giáo dục tận tâm</h4>
                <p class="text-navy">
                    Chúng tôi tự hào là cầu nối đáng tin cậy giữa sinh viên các trường Đại học lớn
                    và các bạn học sinh đang có nhu cầu trau dồi kiến thức. Tại Góc Gia Sư,
                    chất lượng giảng dạy và sự minh bạch luôn được đặt lên hàng đầu.
                </p>
                <ul class="list-unstyled mt-4">
                    <?php
                    $benefits = [
                        'Hồ sơ gia sư được xác thực rõ ràng.',
                        'Đa dạng môn học và cấp độ đào tạo.',
                        'Chi phí hợp lý, cam kết chất lượng.',
                    ];
                    foreach ($benefits as $b): ?>
                        <li class="mb-3 d-flex align-items-start">
                            <span class="bg-primary-custom text-navy rounded-circle d-flex justify-content-center align-items-center me-3 mt-1 fw-bold"
                                  style="width:25px;height:25px;font-size:14px;">✓</span>
                            <span class="text-navy fw-medium"><?= htmlspecialchars($b) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Gia sư nổi bật (dữ liệu sẽ do backend truyền vào $featuredTutors) -->
<section class="py-5">
    <div class="container py-4">
        <h2 class="text-teal text-center fw-bold mb-5">GIA SƯ NỔI BẬT</h2>
        <div class="row g-4">
            <?php if (!empty($featuredTutors)): ?>
                <?php foreach ($featuredTutors as $tutor): ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 rounded-4 shadow-sm p-2 h-100">
                            <img src="<?= htmlspecialchars($tutor['Avatar'] ?? $assetPath . 'avt.jpg') ?>"
                                 class="card-img-top rounded-3"
                                 style="height:200px;object-fit:cover;"
                                 alt="<?= htmlspecialchars($tutor['Name']) ?>">
                            <div class="card-body d-flex flex-column text-center p-3">
                                <h5 class="card-title text-navy fw-bold mb-1"><?= htmlspecialchars($tutor['Name']) ?></h5>
                                <p class="card-text text-teal fw-medium mb-2 small"><?= htmlspecialchars($tutor['mon_hoc'] ?? '') ?></p>
                                <div class="mb-3 small">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold"><?= number_format($tutor['diem_tb'] ?? 0, 1) ?></span>
                                    <span class="text-muted">/5</span>
                                </div>
                                <a href="/index.php?page=tutor_profile&id=<?= (int)$tutor['Id'] ?>"
                                   class="btn btn-gocgiasu mt-auto w-100 rounded-pill">Xem hồ sơ</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Placeholder khi chưa có dữ liệu từ database -->
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-people fs-1 d-block mb-3"></i>
                    <p>Chưa có gia sư nổi bật. Hãy quay lại sau!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Nhúng footer dùng chung
require_once __DIR__ . '/partials/footer.php';
?>
