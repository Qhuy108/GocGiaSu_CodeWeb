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
                 <?php if (!empty($tutor['Avatar'])): ?>
                    <img src="/assets/uploads/<?= htmlspecialchars($tutor['Avatar']) ?>" 
                         class="w-100 h-100 object-fit-cover">
                 <?php else: ?>
                    <i class="fa-solid fa-user fs-1 text-secondary"></i>
                 <?php endif; ?>
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
                    <div class="d-flex flex-wrap gap-2">
                        <?php 
                        $certs = array_filter(explode(',', $tutor['Qualifications'] ?? ''));
                        if (!empty($certs)):
                            foreach ($certs as $cert): 
                                if (str_contains($cert, 'assets/uploads/')):
                        ?>
                                    <div class="border rounded p-1 shadow-sm" style="width: 120px; height: 120px;">
                                        <img src="/<?= htmlspecialchars(trim($cert)) ?>" 
                                             class="w-100 h-100 object-fit-cover rounded" 
                                             alt="Chứng chỉ"
                                             style="cursor: pointer;"
                                             onclick="window.open(this.src, '_blank')">
                                    </div>
                        <?php   
                                endif;
                            endforeach; 
                        else:
                        ?>
                            <p class="text-secondary">Chưa có chứng chỉ nào.</p>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'student'): ?>
                    <hr class="my-4">
                    <div class="p-4 bg-light rounded-4 text-center">
                        <h5 class="fw-bold text-navy mb-2">Bạn muốn học cùng gia sư này?</h5>
                        <p class="text-muted small mb-4">Nhấn nút bên dưới để chọn môn học và thời gian phù hợp.</p>
                        <button class="btn btn-gocgiasu btn-lg rounded-pill px-5 fw-bold btn-book-tutor shadow-sm"
                                data-tutor-id="<?= (int)$tutor['Id'] ?>"
                                data-tutor-name="<?= htmlspecialchars($tutor['Name']) ?>"
                                data-subjects='<?= $tutor['subjects_json'] ?? '[]' ?>'>
                            <i class="fa-solid fa-calendar-check me-2"></i> Đặt lịch học ngay
                        </button>
                    </div>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                    <hr class="my-4">
                    <div class="text-center py-3">
                        <p class="text-muted mb-2">Đăng nhập để đặt lịch học với gia sư này</p>
                        <a href="/index.php?page=login" class="btn rounded-pill px-4 fw-bold"
                           style="background:#9FC131; color:#fff;">Đăng nhập ngay</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>