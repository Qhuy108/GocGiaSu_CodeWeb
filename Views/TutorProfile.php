<?php
$pageTitle = 'Hồ sơ: ' . htmlspecialchars($tutor['Name']);
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="row">
<div class="col-lg-4">
    <!-- Nút quay lại đặt ngay trên thẻ profile để dễ thấy -->
    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="profile-card card border-0 shadow-lg p-4 mb-4 text-center">
        <div class="avatar-wrapper mb-3">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto border border-4 border-white shadow-sm" 
                 style="width: 150px; height: 150px; overflow: hidden; background: #e9ecef;">
                 <i class="fa-solid fa-user fs-1 text-secondary"></i>
            </div>
        </div>

        <h3 class="fw-bold text-primary mb-1"><?= htmlspecialchars($tutor['Name']) ?></h3>
        <p class="text-muted small mb-0">
            <i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tutor['Location']) ?>
        </p>
        
        <hr class="my-4 border-secondary" style="width: 60px; margin: 0 auto; border-width: 2px; opacity: 0.5;">
    </div>
</div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="mb-3 border-bottom pb-2">Thông tin chi tiết</h4>
                    
                    <div class="mb-4">
                        <strong>Môn học:</strong><br>
                        <?php foreach(explode(',', $tutor['mon_hoc'] ?? '') as $mon): ?>
                            <?php if(trim($mon) !== ''): ?>
                            <span class="badge bg-primary me-1"><?= htmlspecialchars(trim($mon)) ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-4">
                        <strong>Học phí:</strong>
                        <p class="text-success fw-bold fs-5"><?= number_format($tutor['Hourly_rate']) ?>đ / buổi</p>
                    </div>

                    <h5 class="mt-4">Giới thiệu bản thân</h5>
                    <p class="text-secondary"><?= nl2br(htmlspecialchars($tutor['Bio'])) ?></p>

                    <h5 class="mt-4">Kinh nghiệm</h5>
                    <p class="text-secondary"><?= nl2br(htmlspecialchars($tutor['Experience'])) ?></p>

                    <h5 class="mt-4">Bằng cấp</h5>
                    <p class="text-secondary"><?= nl2br(htmlspecialchars($tutor['Qualifications'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>