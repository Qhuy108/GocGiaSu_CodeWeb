<?php
$pageTitle = 'Tìm Gia Sư - Góc Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">Khám phá <span class="text-primary">Gia sư chất lượng</span></h2>
        <div class="bg-primary mx-auto" style="width: 60px; height: 4px; border-radius: 2px;"></div>
    </div>

    <div class="card shadow-lg border-0 mb-5 p-4 rounded-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
        <form method="GET" action="/index.php" class="row g-3 align-items-center">
            <input type="hidden" name="page" value="tutors">
            
            <div class="col-md-5">
                <label class="small text-muted ms-3 mb-1 fw-bold">Môn học</label>
                <input type="text" name="mon_hoc" class="form-control form-control-lg rounded-pill border-0 shadow-sm" 
                       placeholder="Ví dụ: Toán, Tiếng Anh..." 
                       value="<?= htmlspecialchars($filters['mon_hoc'] ?? '') ?>">
            </div>
            <div class="col-md-5">
                <label class="small text-muted ms-3 mb-1 fw-bold">Khu vực</label>
                <input type="text" name="khu_vuc" class="form-control form-control-lg rounded-pill border-0 shadow-sm" 
                       placeholder="Ví dụ: Quận 1, Thủ Đức..." 
                       value="<?= htmlspecialchars($filters['khu_vuc'] ?? '') ?>">
            </div>
            <div class="col-md-2 mt-4 pt-1">
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold">Tìm ngay</button>
            </div>
        </form>
    </div>

    <div class="row">
        <?php foreach($tutors as $tutor): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 tutor-card transition">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; font-weight: bold;"><?= substr($tutor['Name'], 0, 1) ?></div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($tutor['Name']) ?></h5>
                            <small class="text-success"><i class="fa-solid fa-circle-check"></i> Đã xác thực</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-dark mb-3 px-3 py-2 rounded-pill border">
                        <i class="fa-solid fa-book text-primary me-1"></i> <?= htmlspecialchars($tutor['mon_hoc'] ?? '') ?>
                    </span>
                    <p class="text-muted small mb-4">⭐ <?= number_format($tutor['diem_tb'], 1) ?> (Đánh giá cao)</p>
                    <a href="/index.php?page=tutor_profile&id=<?= $tutor['Id'] ?>" 
                       class="btn btn-outline-primary rounded-pill w-100 fw-bold">Xem hồ sơ</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>