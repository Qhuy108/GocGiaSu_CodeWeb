<?php
$pageTitle  = 'Cài đặt tài khoản – Góc Gia Sư';
$cssPath    = '/css/style.css';
$assetPath  = '/assets/';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="d-flex align-items-center mb-4 gap-3">
                <a href="/index.php?page=tutor_dashboard" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                </a>
                <h4 class="fw-bold mb-0" style="color:#042940;">Chỉnh sửa hồ sơ</h4>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3">
                <i class="fa-solid fa-check-circle me-2"></i> Cập nhật hồ sơ thành công!
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form method="POST" action="/index.php?page=tutor_update" enctype="multipart/form-data">

                    <!-- Ảnh đại diện -->
                    <div class="mb-4 text-center">
                        <div class="mb-3">
                            <?php $avatar = $tutor['Avatar'] ?? null; ?>
                            <img src="<?= $avatar ? '/assets/uploads/' . htmlspecialchars($avatar) : '/assets/avt.jpg' ?>"
                                 id="preview-avatar"
                                 class="rounded-circle border shadow-sm"
                                 style="width:120px; height:120px; object-fit:cover;">
                        </div>
                        <label class="form-label fw-medium d-block">Ảnh đại diện</label>
                        <input type="file" name="avatar" id="avatar-input"
                               class="form-control rounded-3"
                               accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">Cho phép: JPG, PNG, WEBP. Tối đa 2MB.</small>
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
                        <label class="form-label fw-medium">Bằng cấp / Chứng chỉ</label>
                        <div class="mb-2 d-flex flex-wrap gap-2">
                            <?php 
                            $certs = array_filter(explode(',', $tutor['Qualifications'] ?? ''));
                            if (!empty($certs)):
                                foreach ($certs as $cert): 
                                    if (str_contains($cert, 'assets/uploads/')):
                            ?>
                                        <div class="border rounded p-1 shadow-sm" style="width: 100px; height: 100px;">
                                            <img src="/<?= htmlspecialchars(trim($cert)) ?>" class="w-100 h-100 object-fit-cover rounded">
                                        </div>
                            <?php   
                                    endif;
                                endforeach; 
                            else:
                            ?>
                                <p class="text-muted small w-100 mb-0">Chưa có chứng chỉ nào.</p>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="certificates[]" class="form-control rounded-3" multiple accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">Chọn nhiều ảnh để bổ sung thêm chứng chỉ. Các ảnh cũ sẽ được giữ nguyên.</small>
                    </div>

                    <div class="row g-3 mb-3">
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

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn fw-bold rounded-pill py-2"
                                style="background:#9FC131; color:#fff;">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('avatar-input').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('preview-avatar').src = e.target.result;
        reader.readAsDataURL(file);
    }
});
</script>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
