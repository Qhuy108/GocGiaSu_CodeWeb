<?php
$pageTitle = ($post['Id'] ?? 0) ? 'Sửa bài viết – Admin' : 'Viết bài mới – Admin';
$cssPath   = '../../css/style.css';
$assetPath = '../../assets/';
require_once __DIR__ . '/../partials/header.php';

$isEdit  = !empty($post['Id']);
$action  = $isEdit ? '/index.php?page=admin&action=postUpdate' : '/index.php?page=admin&action=postCreate';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="/index.php?page=admin&action=posts" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <h4 class="fw-bold mb-0" style="color:#042940;">
                    <?= $isEdit ? 'Sửa bài viết' : 'Viết bài mới' ?>
                </h4>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form method="POST" action="<?= $action ?>">
                    <?php if ($isEdit): ?>
                    <input type="hidden" name="post_id" value="<?= $post['Id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="Title" class="form-control rounded-3"
                               value="<?= htmlspecialchars($post['Title'] ?? '') ?>"
                               placeholder="Nhập tiêu đề bài viết..." required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Slug (URL) <span class="text-danger">*</span></label>
                            <input type="text" name="Slug" id="slug-input" class="form-control rounded-3"
                                   value="<?= htmlspecialchars($post['Slug'] ?? '') ?>"
                                   placeholder="vd: phuong-phap-hoc-tap" required>
                            <small class="text-muted">Chỉ dùng chữ thường, số và dấu gạch ngang</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Danh mục</label>
                            <input type="text" name="Category" class="form-control rounded-3"
                                   value="<?= htmlspecialchars($post['Category'] ?? '') ?>"
                                   placeholder="vd: Kỹ năng học tập" list="category-list">
                            <datalist id="category-list">
                                <option value="Kỹ năng học tập">
                                <option value="Tư vấn chọn gia sư">
                                <option value="Ôn thi">
                                <option value="Kỹ năng sống">
                                <option value="Tư vấn học tập">
                            </datalist>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Tóm tắt</label>
                        <textarea name="Summary" class="form-control rounded-3" rows="2"
                                  placeholder="Mô tả ngắn gọn về bài viết..."><?= htmlspecialchars($post['Summary'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Ảnh bìa (URL)</label>
                        <input type="text" name="Image" class="form-control rounded-3"
                               value="<?= htmlspecialchars($post['Image'] ?? '') ?>"
                               placeholder="https://...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="Content" class="form-control rounded-3" rows="15"
                                  placeholder="Viết nội dung bài... (hỗ trợ HTML)" required><?= htmlspecialchars($post['Content'] ?? '') ?></textarea>
                        <small class="text-muted">Hỗ trợ HTML: &lt;h4&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, &lt;img&gt;...</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Trạng thái</label>
                        <select name="Status" class="form-select rounded-3">
                            <option value="draft"     <?= ($post['Status'] ?? '') === 'draft'     ? 'selected' : '' ?>>Bản nháp</option>
                            <option value="published" <?= ($post['Status'] ?? '') === 'published' ? 'selected' : '' ?>>Đăng ngay</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn fw-bold rounded-pill py-2"
                                style="background:#9FC131;color:#042940;">
                            <i class="bi bi-floppy-disk me-2"></i>
                            <?= $isEdit ? 'Lưu thay đổi' : 'Đăng bài' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Tự động tạo slug từ tiêu đề
document.querySelector('[name="Title"]').addEventListener('input', function() {
    const slugInput = document.getElementById('slug-input');
    if (slugInput.dataset.manual) return;
    slugInput.value = this.value
        .toLowerCase()
        .normalize('NFD').replace(/[̀-ͯ]/g, '')
        .replace(/đ/g,'d').replace(/Đ/g,'d')
        .replace(/[^a-z0-9\s-]/g,'')
        .trim().replace(/\s+/g,'-');
});
document.getElementById('slug-input').addEventListener('input', function() {
    this.dataset.manual = '1';
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
