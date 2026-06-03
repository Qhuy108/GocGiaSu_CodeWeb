<?php
$pageTitle  = 'Hồ sơ của tôi – Góc Gia Sư';
$cssPath    = '/css/style.css';
$assetPath  = '/assets/';
require_once __DIR__ . '/partials/header.php';

$editMode = isset($_GET['edit']);
$avatar   = $tutor['Avatar'] ?? null;
$avatarSrc = $avatar ? '/assets/uploads/' . htmlspecialchars($avatar) : '/assets/avt.jpg';

// Lấy môn học của gia sư
$tutorSubjects = $tutorSubjects ?? [];
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="/index.php?page=tutor_dashboard" class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                    </a>
                    <h4 class="fw-bold mb-0" style="color:#042940;">Hồ sơ của tôi</h4>
                </div>
                <?php if (!$editMode): ?>
                <a href="/index.php?page=tutor_edit&edit=1"
                   class="btn rounded-pill px-4 fw-bold"
                   style="background:#9FC131; color:#042940;">
                    <i class="fa-solid fa-pen me-2"></i> Chỉnh sửa
                </a>
                <?php else: ?>
                <a href="/index.php?page=tutor_edit"
                   class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-solid fa-xmark me-2"></i> Hủy
                </a>
                <?php endif; ?>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3">
                <i class="fa-solid fa-check-circle me-2"></i> Cập nhật hồ sơ thành công!
            </div>
            <?php endif; ?>

            <?php if (!$editMode): ?>
            <!-- ===== CHẾ ĐỘ XEM ===== -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <!-- Banner + Avatar -->
                <div style="height:100px; background:linear-gradient(135deg,#042940,#005C53);"></div>
                <div class="px-4 pb-4">
                    <div class="d-flex align-items-end justify-content-between" style="margin-top:-50px;">
                        <img src="<?= $avatarSrc ?>"
                             class="rounded-circle border border-4 border-white shadow"
                             style="width:90px; height:90px; object-fit:cover;">
                        <span class="badge rounded-pill px-3 py-2 mb-2"
                              style="background:<?= $tutor['Status']==='approved' ? '#E8F5E9' : '#FFF3E0' ?>;
                                     color:<?= $tutor['Status']==='approved' ? '#2E7D32' : '#E65100' ?>;">
                            <?= $tutor['Status'] === 'approved' ? '✔ Đã duyệt' : '⏳ Chờ duyệt' ?>
                        </span>
                    </div>

                    <h4 class="fw-bold mt-2 mb-0" style="color:#042940;">
                        <?= htmlspecialchars($_SESSION['name'] ?? '') ?>
                    </h4>
                    <p class="text-muted small mb-3">
                        <i class="fa-solid fa-location-dot me-1"></i>
                        <?= htmlspecialchars($tutor['Location'] ?? 'Chưa cập nhật') ?>
                    </p>

                    <!-- Môn học -->
                    <?php if (!empty($tutorSubjects)): ?>
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <?php foreach ($tutorSubjects as $s): ?>
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:#E3F2FD; color:#1565C0; font-size:0.8rem;">
                            <?= htmlspecialchars($s['Name']) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <!-- Học phí -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#F8F9FA;">
                                <div class="text-muted small mb-1"><i class="fa-solid fa-money-bill me-1"></i>Học phí</div>
                                <div class="fw-bold" style="color:#005C53;">
                                    <?= number_format($tutor['Hourly_rate'] ?? 0) ?>đ / buổi
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#F8F9FA;">
                                <div class="text-muted small mb-1"><i class="fa-solid fa-star me-1"></i>Đánh giá</div>
                                <div class="fw-bold" style="color:#005C53;">
                                    ⭐ <?= number_format($tutor['Avg_rating'] ?? 0, 1) ?> / 5
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Giới thiệu -->
                    <div class="mb-3">
                        <h6 class="fw-bold" style="color:#042940;">Giới thiệu bản thân</h6>
                        <p class="text-muted mb-0" style="line-height:1.7;">
                            <?= nl2br(htmlspecialchars($tutor['Bio'] ?? 'Chưa cập nhật.')) ?>
                        </p>
                    </div>

                    <!-- Kinh nghiệm -->
                    <div class="mb-3">
                        <h6 class="fw-bold" style="color:#042940;">Kinh nghiệm</h6>
                        <p class="text-muted mb-0" style="line-height:1.7;">
                            <?= nl2br(htmlspecialchars($tutor['Experience'] ?? 'Chưa cập nhật.')) ?>
                        </p>
                    </div>

                    <!-- Bằng cấp -->
                    <div>
                        <h6 class="fw-bold" style="color:#042940;">Bằng cấp / Chứng chỉ</h6>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <?php 
                            $certs = array_filter(explode(',', $tutor['Qualifications'] ?? ''));
                            if (!empty($certs)):
                                foreach ($certs as $cert): 
                                    $cert = trim($cert);
                                    if (str_contains($cert, 'assets/uploads/')):
                            ?>
                                        <div class="border rounded p-1 shadow-sm bg-white" style="width: 100px; height: 100px;">
                                            <img src="/<?= htmlspecialchars($cert) ?>" 
                                                 class="w-100 h-100 object-fit-cover rounded" 
                                                 alt="Chứng chỉ"
                                                 style="cursor: pointer;"
                                                 onclick="window.open(this.src, '_blank')">
                                        </div>
                            <?php   
                                    else:
                                        echo '<p class="text-muted mb-0">' . nl2br(htmlspecialchars($cert)) . '</p>';
                                    endif;
                                endforeach; 
                            else:
                            ?>
                                <p class="text-muted mb-0">Chưa cập nhật.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php else: ?>
            <!-- ===== CHẾ ĐỘ CHỈNH SỬA ===== -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form method="POST" action="/index.php?page=tutor_update" enctype="multipart/form-data">

                    <!-- Ảnh đại diện -->
                    <div class="mb-4 text-center">
                        <div class="position-relative d-inline-block">
                            <img src="<?= $avatarSrc ?>"
                                 id="preview-avatar"
                                 class="rounded-circle border border-4 border-white shadow-sm mb-2"
                                 style="width:120px; height:120px; object-fit:cover;">
                            <label for="avatar-input" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                                   style="width: 32px; height: 32px; cursor: pointer; margin-bottom: 10px; margin-right: 5px;">
                                <i class="fa-solid fa-camera small"></i>
                            </label>
                        </div>
                        <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/jpeg,image/png,image/webp">
                        <h6 class="fw-bold mb-0">Ảnh đại diện</h6>
                        <small class="text-muted">Nhấp vào icon máy ảnh để thay đổi</small>
                    </div>
                    <hr class="mb-4">

                    <div class="mb-3">
                        <label class="form-label fw-medium">Giới thiệu bản thân</label>
                        <textarea name="Bio" class="form-control rounded-3" rows="4"
                                  placeholder="Mô tả về bản thân, phương pháp dạy..."><?= htmlspecialchars($tutor['Bio'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Kinh nghiệm</label>
                        <textarea name="Experience" class="form-control rounded-3" rows="3"
                                  placeholder="Số năm kinh nghiệm, nơi đã dạy..."><?= htmlspecialchars($tutor['Experience'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Bằng cấp / Chứng chỉ (Văn bản)</label>
                        <textarea name="Qualifications" class="form-control rounded-3" rows="2"
                                  placeholder="Vd: Cử nhân Sư phạm Toán, Chứng chỉ IELTS 7.0..."><?= htmlspecialchars($tutor['Qualifications'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Tải lên chứng chỉ mới (Ảnh)</label>
                        <input type="file" name="certificates[]" class="form-control rounded-3" multiple accept="image/*">
                        <small class="text-muted">Bạn có thể chọn nhiều ảnh cùng lúc</small>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Khu vực dạy</label>
                            <input type="text" name="Location" class="form-control rounded-3"
                                   placeholder="Ví dụ: Quận 1, TP.HCM"
                                   value="<?= htmlspecialchars($tutor['Location'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Học phí (đ/buổi)</label>
                            <input type="number" name="Hourly_rate" class="form-control rounded-3"
                                   min="0" step="10000"
                                   value="<?= (int)($tutor['Hourly_rate'] ?? 0) ?>">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn fw-bold rounded-pill py-2"
                                style="background:#9FC131; color:#042940;">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
const avatarInput = document.getElementById('avatar-input');
if (avatarInput) {
    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('preview-avatar').src = e.target.result;
            reader.readAsDataURL(file);
        }
    });
}
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
