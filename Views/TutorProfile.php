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

                    <?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'student'): ?>
                    <hr class="my-4">
                    <h5 class="mt-4 fw-bold" style="color:#042940;">Đặt lịch học</h5>
                    <form method="POST" action="/index.php?page=student&action=create">
                        <input type="hidden" name="tutor_id" value="<?= (int)$tutor['Id'] ?>">

                        <div class="mb-3">
                            <label class="form-label fw-medium">Môn học</label>
                            <select name="subject_id" class="form-select rounded-3" required>
                                <option value="">-- Chọn môn --</option>
                                <?php foreach ($tutorSubjects as $subject): ?>
                                    <option value="<?= (int)$subject['Id'] ?>">
                                        <?= htmlspecialchars($subject['Name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Ngày học</label>
                                <input type="date" name="date" class="form-control rounded-3"
                                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Giờ học</label>
                                <input type="time" name="time" class="form-control rounded-3" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Ghi chú</label>
                            <textarea name="note" class="form-control rounded-3" rows="3"
                                      placeholder="Ví dụ: Tôi muốn ôn tập chương..."></textarea>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold rounded-pill py-2"
                                style="background:#9FC131; color:#fff;">
                            Gửi yêu cầu đặt lịch
                        </button>
                    </form>
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